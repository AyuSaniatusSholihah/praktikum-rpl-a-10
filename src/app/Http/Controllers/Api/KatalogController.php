<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    // Get all items owned by the authenticated user
    public function index(Request $request)
    {
        $barangs = $request->user()->barangs()->with('kategori')->get();
        return response()->json([
            'status' => 'success',
            'data' => $barangs
        ]);
    }

    // Add a new item to the user's catalog
    public function store(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_barang' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'harga_sewa' => 'required|numeric|min:0',
            'harga_jaminan' => 'required|numeric|min:0',
            'harga_denda_perjam' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'lokasi' => 'required|string|max:100',
            'foto_barang' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'nullable|in:tersedia,tidak_tersedia'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        // Handle File Upload
        if ($request->hasFile('foto_barang')) {
            // Simpan gambar ke folder storage/app/public/katalog
            $path = $request->file('foto_barang')->store('katalog', 'public');
            $validated['foto_barang'] = $path;
        }

        $barang = $request->user()->barangs()->create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Barang berhasil ditambahkan',
            'data' => $barang
        ], 201);
    }

    // Get specific item (must belong to user)
    public function show(Request $request, $id)
    {
        $barang = $request->user()->barangs()->with('kategori')->find($id);

        if (!$barang) {
            return response()->json([
                'status' => 'error',
                'message' => 'Barang tidak ditemukan atau bukan milik Anda'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $barang
        ]);
    }

    // Update item
    public function update(Request $request, $id)
    {
        $barang = $request->user()->barangs()->find($id);

        if (!$barang) {
            return response()->json([
                'status' => 'error',
                'message' => 'Barang tidak ditemukan atau bukan milik Anda'
            ], 404);
        }

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'kategori_id' => 'sometimes|exists:kategoris,id',
            'nama_barang' => 'sometimes|string|max:100',
            'deskripsi' => 'nullable|string',
            'harga_sewa' => 'sometimes|numeric|min:0',
            'harga_jaminan' => 'sometimes|numeric|min:0',
            'harga_denda_perjam' => 'sometimes|numeric|min:0',
            'stok' => 'sometimes|integer|min:0',
            'lokasi' => 'sometimes|string|max:100',
            'foto_barang' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'sometimes|in:tersedia,tidak_tersedia'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        // Handle File Upload
        if ($request->hasFile('foto_barang')) {
            // Hapus gambar lama jika ada
            if ($barang->foto_barang) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($barang->foto_barang);
            }
            // Simpan gambar baru
            $path = $request->file('foto_barang')->store('katalog', 'public');
            $validated['foto_barang'] = $path;
        }

        $barang->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Barang berhasil diperbarui',
            'data' => $barang
        ]);
    }

    // Delete item
    public function destroy(Request $request, $id)
    {
        $barang = $request->user()->barangs()->find($id);

        if (!$barang) {
            return response()->json([
                'status' => 'error',
                'message' => 'Barang tidak ditemukan atau bukan milik Anda'
            ], 404);
        }

        // Hapus gambar fisik dari storage jika ada
        if ($barang->foto_barang) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($barang->foto_barang);
        }

        $barang->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Barang berhasil dihapus'
        ]);
    }
}
