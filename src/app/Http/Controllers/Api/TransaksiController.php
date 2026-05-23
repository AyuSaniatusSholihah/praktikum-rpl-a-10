<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Keranjang;
use App\Models\TransaksiPenyewaan;
use App\Models\Pembayaran;
use App\Models\Review;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    /**
     * Menampilkan riwayat transaksi penyewaan milik penyewa aktif.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $transaksis = TransaksiPenyewaan::where('user_id', $user->id)
            ->with(['barang', 'pembayaran', 'review'])
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $transaksis
        ], 200);
    }

    /**
     * Menampilkan detail lengkap transaksi penyewaan milik penyewa aktif.
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();
        $transaksi = TransaksiPenyewaan::where('user_id', $user->id)
            ->with(['barang.user', 'pembayaran', 'review'])
            ->find($id);

        if (!$transaksi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaksi tidak ditemukan atau Anda tidak memiliki akses.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $transaksi
        ], 200);
    }

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
                    $transaksi->status = 'aktif';
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

    /**
     * Mengembalikan barang sekaligus mengisi ulasan (review) oleh penyewa.
     */
    public function kembalikanBarang(Request $request, $id)
    {
        $user = $request->user();
        
        $transaksi = TransaksiPenyewaan::where('id', $id)
            ->where('user_id', $user->id)
            ->with('barang')
            ->first();

        if (!$transaksi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaksi tidak ditemukan atau Anda tidak memiliki akses.'
            ], 404);
        }

        if ($transaksi->status !== 'aktif') {
            return response()->json([
                'status' => 'error',
                'message' => 'Hanya transaksi sewa aktif yang dapat dikembalikan.'
            ], 400);
        }

        // Validasi input: bukti pengembalian dan review
        $validator = Validator::make($request->all(), [
            'foto_buktipengembalian' => 'required|image|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $result = \Illuminate\Support\Facades\DB::transaction(function () use ($transaksi, $request, $user) {
                // Hitung Keterlambatan & Denda
                $now = now();
                $rencanaKembali = Carbon::parse($transaksi->tanggal_kembali_rencana)->endOfDay();
                $jamTerlambat = 0;
                $totalDenda = 0;

                if ($now->greaterThan($rencanaKembali)) {
                    // Bulatkan ke atas selisih jam
                    $jamTerlambat = (int) ceil($rencanaKembali->diffInHours($now));
                    $totalDenda = $jamTerlambat * (float) $transaksi->barang->harga_denda_perjam;
                }

                // Upload Bukti Pengembalian
                $path = $request->file('foto_buktipengembalian')->store('bukti_pengembalian', 'public');

                // Update Transaksi
                $transaksi->update([
                    'tanggal_kembali_aktual' => $now->toDateString(),
                    'status' => 'tunggu verifikasi pengembalian',
                    'jam_terlambat' => $jamTerlambat,
                    'total_denda' => $totalDenda,
                    'foto_buktipengembalian' => $path,
                ]);

                // Simpan Review
                $review = Review::create([
                    'transaksi_id' => $transaksi->id,
                    'user_id' => $user->id,
                    'barang_id' => $transaksi->barang_id,
                    'rating' => $request->rating,
                    'komentar' => $request->komentar,
                ]);

                return [
                    'transaksi' => $transaksi,
                    'review' => $review
                ];
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Pengembalian barang dan ulasan berhasil dikirim. Menunggu verifikasi owner.',
                'data' => $result
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Verifikasi pengembalian barang oleh owner produk.
     */
    /**
     * Menampilkan daftar transaksi penyewaan yang menunggu verifikasi pengembalian (untuk Owner).
     */
    public function listPengembalian(Request $request)
    {
        $user = $request->user();

        // Ambil semua transaksi yang statusnya 'tunggu verifikasi pengembalian'
        // dan barangnya milik owner yang sedang login
        $transaksis = TransaksiPenyewaan::where('status', 'tunggu verifikasi pengembalian')
            ->whereHas('barang', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with(['barang', 'user'])
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $transaksis
        ], 200);
    }

    /**
     * Verifikasi pengembalian barang oleh owner produk.
     */
    public function verifikasiPengembalian(Request $request, $id)
    {
        $user = $request->user();

        $transaksi = TransaksiPenyewaan::where('id', $id)
            ->with('barang')
            ->first();

        if (!$transaksi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaksi tidak ditemukan.'
            ], 404);
        }

        if ($transaksi->status !== 'tunggu verifikasi pengembalian') {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaksi tidak sedang menunggu verifikasi pengembalian.'
            ], 400);
        }

        // Verifikasi bahwa user yang login adalah pemilik barang (owner)
        if ($transaksi->barang->user_id !== $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki akses untuk memverifikasi transaksi ini karena Anda bukan pemilik barang.'
            ], 403);
        }

        // Validasi input konfirmasi dari owner
        $validator = Validator::make($request->all(), [
            'status_kondisi' => 'required|in:ok,tolak',
            'denda_kerusakan' => 'required_if:status_kondisi,tolak|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $isTolak = $request->status_kondisi === 'tolak';
            $dendaKerusakan = $isTolak ? (float) $request->denda_kerusakan : 0;

            \Illuminate\Support\Facades\DB::transaction(function () use ($transaksi, $isTolak, $dendaKerusakan) {
                // Update Transaksi
                $transaksi->update([
                    'status' => 'selesai',
                    'tanggal_verifikasipengembalian' => now(),
                    'total_denda' => $transaksi->total_denda + $dendaKerusakan
                ]);

                // Jika kondisinya OK, kembalikan stok barang ke katalog
                // Jika ditolak (rusak), stok TIDAK bertambah kembali karena barang rusak
                if (!$isTolak) {
                    $barang = $transaksi->barang;
                    $barang->stok += $transaksi->jumlah;
                    if ($barang->status === 'tidak_tersedia') {
                        $barang->status = 'tersedia';
                    }
                    $barang->save();
                }
            });

            $message = $isTolak 
                ? 'Pengembalian barang ditolak (Rusak). Transaksi diselesaikan dengan penambahan denda kerusakan.'
                : 'Pengembalian barang berhasil diverifikasi (Kondisi OK). Transaksi selesai.';

            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => [
                    'transaksi' => $transaksi->fresh(['barang', 'review'])
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Menampilkan dashboard owner yang memuat total saldo/pendapatan dan daftar transaksi barang miliknya.
     */
    public function ownerDashboard(Request $request)
    {
        $user = $request->user();

        // 1. Dapatkan daftar barang milik owner
        $barangIds = \App\Models\Barang::where('user_id', $user->id)->pluck('id');

        // 2. Dapatkan transaksi terkait barang-barang tersebut
        $transaksis = TransaksiPenyewaan::whereIn('barang_id', $barangIds)
            ->with(['barang', 'user', 'pembayaran'])
            ->latest()
            ->get();

        // 3. Hitung total saldo (total pendapatan dari penyewaan barang yang sudah dibayar)
        $totalPendapatan = (float) TransaksiPenyewaan::whereIn('barang_id', $barangIds)
            ->whereNotNull('pembayaran_id')
            ->sum('total_harga');

        $totalDenda = (float) TransaksiPenyewaan::whereIn('barang_id', $barangIds)
            ->whereNotNull('pembayaran_id')
            ->sum('total_denda');

        $totalSaldo = $totalPendapatan + $totalDenda;

        return response()->json([
            'status' => 'success',
            'data' => [
                'owner_name' => $user->name,
                'saldo_user' => (float) $user->saldo,
                'total_saldo_pendapatan' => $totalSaldo,
                'total_barang' => count($barangIds),
                'daftar_transaksi' => $transaksis
            ]
        ], 200);
    }

    /**
     * Menampilkan detail lengkap suatu transaksi barang milik owner.
     */
    public function ownerTransaksiDetail(Request $request, $id)
    {
        $user = $request->user();

        $transaksi = TransaksiPenyewaan::with(['barang', 'user', 'pembayaran', 'review'])->find($id);

        if (!$transaksi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaksi tidak ditemukan.'
            ], 404);
        }

        // Verifikasi bahwa user yang login adalah pemilik barang (owner)
        if ($transaksi->barang->user_id !== $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki akses untuk melihat detail transaksi ini.'
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'data' => $transaksi
        ], 200);
    }
}
