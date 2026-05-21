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

        $createdTransactions = [];

        foreach ($cartItems as $item) {
            $barang = $item->barang;

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

            $createdTransactions[] = $transaksi->load('barang');

            // Hapus item dari keranjang
            $item->delete();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Checkout berhasil dilakukan. Silakan lanjutkan ke pembayaran.',
            'data' => [
                'transaksi' => $createdTransactions
            ]
        ], 201);
    }

    /**
     * Melakukan simulasi pembayaran untuk sebuah transaksi.
     */
    public function bayar(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'metode' => 'required|in:transfer bank,e-wallet,qris',
            'detail_metode' => 'required|string|max:50', // Contoh: BCA, Mandiri, ShopeePay, Gopay
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Cari transaksi milik user aktif
        $transaksi = $request->user()->transaksiPenyewaan()->find($id);

        // Jika transaksi tidak ditemukan di relasi user langsung, cari global untuk cek ownership
        if (!$transaksi) {
            $transaksi = TransaksiPenyewaan::find($id);
            if (!$transaksi || $transaksi->user_id !== $request->user()->id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Transaksi tidak ditemukan atau Anda tidak memiliki akses.'
                ], 404);
            }
        }

        // Cek apakah transaksi sudah memiliki pembayaran
        if ($transaksi->pembayaran()->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaksi ini sudah dibayar sebelumnya.'
            ], 400);
        }

        // Simpan pembayaran
        $pembayaran = Pembayaran::create([
            'transaksi_id' => $transaksi->id,
            'metode' => $request->metode,
            'detail_metode' => $request->detail_metode,
            'tanggal_bayar' => now(),
            'jumlah_bayar' => $transaksi->total_harga,
        ]);

        // Setelah dibayar, status sewa dapat bergeser ke 'upcoming' atau 'aktif' tergantung tanggal sewa
        // Pada simulasi ini kita pertahankan status 'upcoming' sampai tanggal sewa dimulai

        return response()->json([
            'status' => 'success',
            'message' => 'Pembayaran berhasil diproses.',
            'data' => [
                'pembayaran' => $pembayaran,
                'transaksi' => $transaksi->load('barang')
            ]
        ], 200);
    }
}
