<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Models\TransaksiPenyewaan;
use App\Models\Barang;
use App\Services\TransaksiService;
use App\Http\Requests\Transaksi\VerifikasiPengembalianRequest;

class OwnerTransaksiController extends Controller
{
    use ApiResponseTrait;

    protected $transaksiService;

    public function __construct(TransaksiService $transaksiService)
    {
        $this->transaksiService = $transaksiService;
    }

    /**
     * Menampilkan dashboard owner
     */
    public function dashboard(Request $request)
    {
        $user = $request->user();
        $barangIds = Barang::where('user_id', $user->id)->pluck('id');

        $transaksis = TransaksiPenyewaan::whereIn('barang_id', $barangIds)
            ->with(['barang', 'user', 'pembayaran'])
            ->latest()
            ->get();

        $totalPendapatan = (float) TransaksiPenyewaan::whereIn('barang_id', $barangIds)
            ->whereNotNull('pembayaran_id')
            ->sum('total_harga');

        $totalDenda = (float) TransaksiPenyewaan::whereIn('barang_id', $barangIds)
            ->whereNotNull('pembayaran_id')
            ->sum('total_denda');

        return $this->successResponse([
            'owner_name' => $user->name,
            'saldo_user' => (float) $user->saldo,
            'total_saldo_pendapatan' => $totalPendapatan + $totalDenda,
            'total_barang' => count($barangIds),
            'daftar_transaksi' => $transaksis
        ]);
    }

    /**
     * Menampilkan detail transaksi owner
     */
    public function transaksiDetail(Request $request, $id)
    {
        $transaksi = TransaksiPenyewaan::with(['barang', 'user', 'pembayaran', 'review'])->find($id);

        if (!$transaksi) {
            return $this->errorResponse('Transaksi tidak ditemukan.', 404);
        }

        if ($transaksi->barang->user_id !== $request->user()->id) {
            return $this->errorResponse('Anda tidak memiliki akses untuk melihat detail transaksi ini.', 403);
        }

        return $this->successResponse($transaksi);
    }

    /**
     * Menampilkan daftar transaksi penyewaan yang menunggu verifikasi
     */
    public function listPengembalian(Request $request)
    {
        $user = $request->user();

        $transaksis = TransaksiPenyewaan::where('status', 'tunggu verifikasi pengembalian')
            ->whereHas('barang', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with(['barang', 'user'])
            ->get();

        return $this->successResponse($transaksis);
    }

    /**
     * Verifikasi pengembalian barang oleh owner
     */
    public function verifikasiPengembalian(VerifikasiPengembalianRequest $request, $id)
    {
        try {
            $result = $this->transaksiService->verifikasiPengembalian($request->user(), $id, $request->validated());
            return $this->successResponse(['transaksi' => $result['transaksi']], $result['message']);
        } catch (\Exception $e) {
            $code = $e->getCode() ?: 400;
            return $this->errorResponse($e->getMessage(), $code == 0 ? 400 : $code);
        }
    }
}
