<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Keranjang;
use App\Models\TransaksiPenyewaan;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    /**
     * Checkout seluruh barang di keranjang menjadi transaksi penyewaan.
     */
    public function checkout(Request $request)
    {
        $user = $request->user();
        
        // Ambil semua item keranjang beserta relasi barangnya
        $cartItems = $user->keranjang()->with('barang')->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Keranjang belanja Anda kosong, tidak ada yang bisa di-checkout.'
            ], 400);
        }

        try {
            $createdTransactions = \Illuminate\Support\Facades\DB::transaction(function () use ($user, $cartItems) {
                $transactions = [];

                foreach ($cartItems as $item) {
                    $barang = $item->barang;

                    // Validasi stok barang sebelum checkout
                    if ($barang->stok < $item->jumlah) {
                        throw new \Exception("Stok barang '{$barang->nama_barang}' tidak mencukupi. Stok tersedia: {$barang->stok}.");
                    }

                    // Hitung durasi sewa dalam hari (minimal 1 hari)
                    $tanggalSewa = Carbon::parse($item->tanggal_sewa);
                    $tanggalKembali = Carbon::parse($item->tanggal_kembali_rencana);
                    $durasiHari = $tanggalSewa->diffInDays($tanggalKembali);
                    
                    if ($durasiHari <= 0) {
                        $durasiHari = 1;
                    }

                    // Total harga = harga sewa per hari * jumlah unit * durasi hari
                    $totalHarga = (float) $barang->harga_sewa * $item->jumlah * $durasiHari;

                    // Buat transaksi penyewaan
                    $transaksi = TransaksiPenyewaan::create([
                        'user_id' => $user->id,
                        'barang_id' => $item->barang_id,
                        'jumlah' => $item->jumlah,
                        'tanggal_sewa' => $item->tanggal_sewa,
                        'tanggal_kembali_rencana' => $item->tanggal_kembali_rencana,
                        'status' => 'upcoming', // Status default sebelum aktif
                        'total_harga' => $totalHarga,
                        'jam_terlambat' => 0,
                        'total_denda' => 0,
                    ]);

                    $transactions[] = $transaksi->load('barang');

                    // Hapus item dari keranjang
                    $item->delete();
                }

                return $transactions;
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Checkout berhasil dilakukan. Silakan lanjutkan ke pembayaran.',
                'data' => [
                    'transaksi' => $createdTransactions
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Melakukan simulasi pembayaran massal untuk beberapa transaksi sekaligus.
     */
    public function bayarMassal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaksi_ids' => 'required|array',
            'transaksi_ids.*' => 'integer|exists:transaksi_penyewaans,id',
            'metode' => 'required|in:transfer bank,e-wallet,qris',
            'detail_metode' => 'required|string|max:50', // Contoh: BCA, Mandiri, ShopeePay, Gopay
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $transaksiIds = $request->transaksi_ids;
        $user = $request->user();

        // Ambil semua transaksi milik user aktif yang sesuai dengan ID yang dikirimkan
        $transaksis = TransaksiPenyewaan::whereIn('id', $transaksiIds)
            ->where('user_id', $user->id)
            ->with('barang')
            ->get();

        // Validasi apakah jumlah transaksi yang ditemukan cocok dengan input
        if ($transaksis->count() !== count(array_unique($transaksiIds))) {
            return response()->json([
                'status' => 'error',
                'message' => 'Satu atau lebih transaksi tidak ditemukan atau Anda tidak memiliki akses.'
            ], 404);
        }

        // Cek apakah ada transaksi yang sudah dibayar sebelumnya
        foreach ($transaksis as $transaksi) {
            if ($transaksi->pembayaran_id !== null) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Transaksi dengan ID {$transaksi->id} sudah dibayar sebelumnya."
                ], 400);
            }
        }

        // Hitung total bayar untuk semua transaksi ini
        $totalBayar = $transaksis->sum('total_harga');

        try {
            $result = \Illuminate\Support\Facades\DB::transaction(function () use ($transaksis, $request, $totalBayar) {
                // Simpan pembayaran tunggal
                $pembayaran = Pembayaran::create([
                    'metode' => $request->metode,
                    'detail_metode' => $request->detail_metode,
                    'tanggal_bayar' => now(),
                    'jumlah_bayar' => $totalBayar,
                ]);

                foreach ($transaksis as $transaksi) {
                    // Kunci baris barang untuk mencegah race condition
                    $barang = \App\Models\Barang::lockForUpdate()->find($transaksi->barang_id);

                    if (!$barang) {
                        throw new \Exception("Barang untuk transaksi ID {$transaksi->id} tidak ditemukan.");
                    }

                    // Cek apakah stok mencukupi
                    if ($barang->stok < $transaksi->jumlah) {
                        throw new \Exception("Stok barang '{$barang->nama_barang}' tidak mencukupi untuk melakukan pembayaran. Stok saat ini: {$barang->stok}.");
                    }

                    // Kurangi stok barang
                    $barang->stok -= $transaksi->jumlah;
                    
                    // Update status ke 'tidak_tersedia' jika stok habis
                    if ($barang->stok <= 0) {
                        $barang->status = 'tidak_tersedia';
                    }
                    
                    $barang->save();

                    // Hubungkan transaksi ini ke pembayaran baru
                    $transaksi->pembayaran_id = $pembayaran->id;
                    $transaksi->save();
                }

                return $pembayaran;
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Pembayaran massal berhasil diproses dan stok barang telah diperbarui.',
                'data' => [
                    'pembayaran' => $result,
                    'transaksi' => $transaksis->load('barang')
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
