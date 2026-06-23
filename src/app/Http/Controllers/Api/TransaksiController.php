<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Models\TransaksiPenyewaan;
use App\Services\TransaksiService;
use App\Http\Requests\Transaksi\BayarMassalRequest;
use App\Http\Requests\Transaksi\KembalikanBarangRequest;

class TransaksiController extends Controller
{
    use ApiResponseTrait;

    protected $transaksiService;

    public function __construct(TransaksiService $transaksiService)
    {
        $this->transaksiService = $transaksiService;
    }

    /**
     * Menampilkan riwayat transaksi penyewaan milik penyewa aktif.
     */
    public function index(Request $request)
    {
        $transaksis = TransaksiPenyewaan::where('user_id', $request->user()->id)
            ->with(['barang', 'pembayaran', 'review'])
            ->latest()
            ->get();

        return $this->successResponse($transaksis);
    }

    /**
     * Menampilkan detail lengkap transaksi penyewaan milik penyewa aktif.
     */
    public function show(Request $request, $id)
    {
        $transaksi = TransaksiPenyewaan::where('user_id', $request->user()->id)
            ->with(['barang.user', 'pembayaran', 'review'])
            ->find($id);

        if (!$transaksi) {
            return $this->errorResponse('Transaksi tidak ditemukan atau Anda tidak memiliki akses.', 404);
        }

        return $this->successResponse($transaksi);
    }

    /**
     * Checkout seluruh barang di keranjang menjadi transaksi penyewaan.
     */
    public function checkout(Request $request)
    {
        try {
            $keranjangIds = $request->input('keranjang_ids');
            $transactions = $this->transaksiService->checkout($request->user(), $keranjangIds);
            return $this->successResponse(['transaksi' => $transactions], 'Checkout berhasil dilakukan. Silakan lanjutkan ke pembayaran.', 201);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Checkout API Error: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Melakukan pembayaran massal
     */
    public function bayarMassal(BayarMassalRequest $request)
    {
        try {
            $result = $this->transaksiService->bayarMassal($request->user(), $request->transaksi_ids, $request->validated());
            return $this->successResponse($result, 'Pembayaran massal berhasil diproses dan stok barang telah diperbarui.');
        } catch (\Exception $e) {
            $code = $e->getCode() ?: 400;
            return $this->errorResponse($e->getMessage(), $code == 0 ? 400 : $code);
        }
    }

    /**
     * Mengembalikan barang sekaligus mengisi ulasan
     */
    public function kembalikanBarang(KembalikanBarangRequest $request, $id)
    {
        try {
            $result = $this->transaksiService->kembalikanBarang(
                $request->user(), 
                $id, 
                $request->validated(), 
                $request->file('foto_buktipengembalian')
            );
            return $this->successResponse($result, 'Pengembalian barang dan ulasan berhasil dikirim. Menunggu verifikasi owner.');
        } catch (\Exception $e) {
            $code = $e->getCode() ?: 400;
            return $this->errorResponse($e->getMessage(), $code == 0 ? 400 : $code);
        }
    }

    public function cancel(Request $request, $id)
    {
        $user = $request->user();
        
        // Cari transaksi milik user ini (penyewa)
        $trx = TransaksiPenyewaan::where('user_id', $user->id)
            ->with('barang.user')
            ->find($id);

        if (!$trx) {
            return $this->errorResponse('Transaksi tidak ditemukan.', 404);
        }

        // Hanya status 'upcoming' yang bisa dibatalkan (Sesuai logika Web)
        if ($trx->status !== 'upcoming') {
            return $this->errorResponse('Hanya penyewaan dengan status upcoming yang dapat dibatalkan.', 400);
        }

        // --- LOGIKA REFUND (SAMA DENGAN WEB) ---
        $days = \Carbon\Carbon::parse($trx->tanggal_sewa)->diffInDays(\Carbon\Carbon::parse($trx->tanggal_kembali_rencana));
        if ($days == 0) $days = 1;

        $harga_kali_jumlah = $trx->total_harga / $days;
        $jaminan = (int) round($harga_kali_jumlah / 2);
        $shipping = 20000;

        $refund_user = $trx->total_harga + $jaminan + $shipping;

        // 1. Refund ke saldo penyewa (user aktif)
        $user->saldo += $refund_user;
        $user->save();

        // 2. Kurangi dari saldo owner
        $owner = $trx->barang->user;
        if ($owner) {
            $owner->saldo -= $trx->total_harga;
            $owner->save();
        }

        // 3. Update status transaksi jadi dibatalkan
        $trx->update(['status' => 'dibatalkan']);

        // 4. Kembalikan stok & status barang
        if ($trx->barang) {
            $trx->barang->stok += $trx->jumlah;
            $trx->barang->status = 'tersedia';
            $trx->barang->save();
        }

        return $this->successResponse(null, 'Penyewaan berhasil dibatalkan. Saldo telah dikembalikan ke akun Anda.');
    }

}
