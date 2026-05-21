<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KeranjangController extends Controller
{
    public function index(Request $request)
    {
        $items = $request->user()
            ->keranjang()
            ->with('barang.kategori')
            ->get()
            ->map(function (Keranjang $item) {
                $subtotal = (float) $item->jumlah * (float) $item->barang->harga_sewa;

                return [
                    'id' => $item->id,
                    'barang' => $item->barang,
                    'jumlah' => $item->jumlah,
                    'tanggal_sewa' => optional($item->tanggal_sewa)->toDateString(),
                    'tanggal_kembali_rencana' => optional($item->tanggal_kembali_rencana)->toDateString(),
                    'subtotal' => $subtotal,
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => [
                'items' => $items,
                'total_estimasi' => $items->sum('subtotal'),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_sewa' => 'required|date',
            'tanggal_kembali_rencana' => 'required|date|after_or_equal:tanggal_sewa',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        $item = Keranjang::firstOrNew([
            'user_id' => $request->user()->id,
            'barang_id' => $validated['barang_id'],
            'tanggal_sewa' => $validated['tanggal_sewa'],
            'tanggal_kembali_rencana' => $validated['tanggal_kembali_rencana'],
        ]);

        $item->jumlah = ($item->exists ? $item->jumlah : 0) + $validated['jumlah'];
        $item->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Barang berhasil ditambahkan ke keranjang',
            'data' => $item->load('barang.kategori'),
        ], 201);
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'jumlah' => 'sometimes|integer|min:1',
            'tanggal_sewa' => 'sometimes|date',
            'tanggal_kembali_rencana' => 'sometimes|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $item = $request->user()->keranjang()->find($id);

        if (!$item) {
            return response()->json([
                'status' => 'error',
                'message' => 'Item keranjang tidak ditemukan',
            ], 404);
        }

        $validated = $validator->validated();

        if (array_key_exists('tanggal_sewa', $validated) && array_key_exists('tanggal_kembali_rencana', $validated)) {
            if ($validated['tanggal_kembali_rencana'] < $validated['tanggal_sewa']) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tanggal kembali rencana harus sama atau setelah tanggal sewa',
                ], 422);
            }
        } elseif (array_key_exists('tanggal_sewa', $validated) && $validated['tanggal_kembali_rencana'] ?? false) {
            if ($validated['tanggal_kembali_rencana'] < $validated['tanggal_sewa']) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tanggal kembali rencana harus sama atau setelah tanggal sewa',
                ], 422);
            }
        }

        $item->fill($validated);
        $item->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Item keranjang berhasil diperbarui',
            'data' => $item->load('barang.kategori'),
        ]);
    }

    public function destroy(Request $request, int $id)
    {
        $item = $request->user()->keranjang()->find($id);

        if (!$item) {
            return response()->json([
                'status' => 'error',
                'message' => 'Item keranjang tidak ditemukan',
            ], 404);
        }

        $item->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Item keranjang berhasil dihapus',
        ]);
    }

    public function clear(Request $request)
    {
        $request->user()->keranjang()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Keranjang berhasil dikosongkan',
        ]);
    }
}