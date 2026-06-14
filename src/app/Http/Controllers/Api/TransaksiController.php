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
            $transactions = $this->transaksiService->checkout($request->user());
            return $this->successResponse(['transaksi' => $transactions], 'Checkout berhasil dilakukan. Silakan lanjutkan ke pembayaran.', 201);
        } catch (\Exception $e) {
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
}
