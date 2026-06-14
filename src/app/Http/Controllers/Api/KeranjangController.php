<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Services\KeranjangService;
use App\Http\Requests\Keranjang\StoreKeranjangRequest;
use App\Http\Requests\Keranjang\UpdateKeranjangRequest;

class KeranjangController extends Controller
{
    use ApiResponseTrait;

    protected $keranjangService;

    public function __construct(KeranjangService $keranjangService)
    {
        $this->keranjangService = $keranjangService;
    }

    public function index(Request $request)
    {
        $data = $this->keranjangService->getItems($request->user());
        return $this->successResponse($data);
    }

    public function store(StoreKeranjangRequest $request)
    {
        try {
            $item = $this->keranjangService->addItem($request->user(), $request->validated());
            return $this->successResponse($item, 'Barang berhasil ditambahkan ke keranjang', 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    public function update(UpdateKeranjangRequest $request, int $id)
    {
        try {
            $item = $this->keranjangService->updateItem($request->user(), $id, $request->validated());
            return $this->successResponse($item, 'Item keranjang berhasil diperbarui');
        } catch (\Exception $e) {
            $code = $e->getCode() ?: 400;
            // Handle specific cases
            if (strpos($e->getMessage(), 'Tanggal kembali rencana harus') !== false) {
                $code = 422;
            }
            return $this->errorResponse($e->getMessage(), $code == 0 ? 400 : $code);
        }
    }

    public function destroy(Request $request, int $id)
    {
        try {
            $this->keranjangService->removeItem($request->user(), $id);
            return $this->successResponse(null, 'Item keranjang berhasil dihapus');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    public function clear(Request $request)
    {
        $this->keranjangService->clearCart($request->user());
        return $this->successResponse(null, 'Keranjang berhasil dikosongkan');
    }
}