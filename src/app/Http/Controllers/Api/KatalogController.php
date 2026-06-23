<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $barangs = $request->user()->barangs()->with('kategori')->get();
        return response()->json([
            'status' => 'success',
            'data' => $barangs
        ]);
    }

    public function katalogPublik(Request $request)
    {
        $query = Barang::where('status', 'tersedia')
            ->where('stok', '>', 0)
            ->with('kategori');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        if ($request->has('kategori_id') && !empty($request->kategori_id)) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->has('lokasi') && !empty($request->lokasi)) {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
        }

        if ($request->has('min_harga') && is_numeric($request->min_harga)) {
            $query->where('harga_sewa', '>=', (float) $request->min_harga);
        }

        if ($request->has('max_harga') && is_numeric($request->max_harga)) {
            $query->where('harga_sewa', '<=', (float) $request->max_harga);
        }

        $barangs = $query->get();

        return response()->json([
            'status' => 'success',
            'data' => $barangs
        ]);
    }

    public function showPublicDetail($id)
    {
        $barang = Barang::with(['kategori', 'user'])->find($id);

        if (!$barang) {
            return response()->json([
                'status' => 'error',
                'message' => 'Barang tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $barang
        ]);
    }

    public function getKategori()
    {
        $kategoris = \App\Models\Kategori::select('id', 'nama_kategori')->get();
        return response()->json([
            'status' => 'success',
            'data' => $kategoris
        ]);
    }

    // --- FIX STORE: Tambahkan field lengkap ---
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_barang' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'additional_information' => 'nullable|string',
            'harga_sewa' => 'required|numeric|min:0',
            'harga_jaminan' => 'required|numeric|min:0',
            'harga_denda_perjam' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'lokasi' => 'required|string|max:100',
            'whatsapp' => 'nullable|string',
            'tanggal_item_mulai' => 'nullable|date',
            'tanggal_item_tidak_tersedia' => 'nullable|date',
            'foto_barang' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'fotoproduk1' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'fotoproduk2' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'fotoproduk3' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'fotoproduk4' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'nullable|in:tersedia,tidak_tersedia'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        // Handle Foto Utama
        if ($request->hasFile('foto_barang')) {
            $validated['foto_barang'] = $request->file('foto_barang')->store('katalog_images', 'public');
        }

        if (!isset($validated['whatsapp']) || empty($validated['whatsapp'])) {
            $validated['whatsapp'] = $request->user()->phone_number; 
        }

        // Handle Foto Angle 1-4
        foreach (['fotoproduk1', 'fotoproduk2', 'fotoproduk3', 'fotoproduk4'] as $field) {
            if ($request->hasFile($field)) {
                $validated[$field] = $request->file($field)->store('katalog_images', 'public');
            }
        }

        $barang = $request->user()->barangs()->create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Barang berhasil ditambahkan',
            'data' => $barang
        ], 201);
    }

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

    // --- FIX UPDATE: Tambahkan field lengkap ---
    public function update(Request $request, $id)
    {
        $barang = $request->user()->barangs()->find($id);

        if (!$barang) {
            return response()->json([
                'status' => 'error',
                'message' => 'Barang tidak ditemukan atau bukan milik Anda'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'kategori_id' => 'sometimes|exists:kategoris,id',
            'nama_barang' => 'sometimes|string|max:100',
            'deskripsi' => 'nullable|string',
            'additional_information' => 'nullable|string',
            'harga_sewa' => 'sometimes|numeric|min:0',
            'harga_jaminan' => 'sometimes|numeric|min:0',
            'harga_denda_perjam' => 'sometimes|numeric|min:0',
            'stok' => 'sometimes|integer|min:0',
            'lokasi' => 'sometimes|string|max:100',
            'whatsapp' => 'nullable|string',
            'tanggal_item_mulai' => 'nullable|date',
            'tanggal_item_tidak_tersedia' => 'nullable|date',
            'foto_barang' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'fotoproduk1' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'fotoproduk2' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'fotoproduk3' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'fotoproduk4' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'sometimes|in:tersedia,tidak_tersedia'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        // Handle Foto Utama
        if ($request->hasFile('foto_barang')) {
            if ($barang->foto_barang) Storage::disk('public')->delete($barang->foto_barang);
            $validated['foto_barang'] = $request->file('foto_barang')->store('katalog_images', 'public');
        }

        // Handle Foto Angle 1-4
        foreach (['fotoproduk1', 'fotoproduk2', 'fotoproduk3', 'fotoproduk4'] as $field) {
            if ($request->hasFile($field)) {
                if ($barang->$field) Storage::disk('public')->delete($barang->$field);
                $validated[$field] = $request->file($field)->store('katalog_images', 'public');
            }
        }

        $barang->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Barang berhasil diperbarui',
            'data' => $barang
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $barang = $request->user()->barangs()->find($id);

        if (!$barang) {
            return response()->json(['status' => 'error', 'message' => 'Barang tidak ditemukan'], 404);
        }

        // Hapus semua foto fisik
        foreach (['foto_barang', 'fotoproduk1', 'fotoproduk2', 'fotoproduk3', 'fotoproduk4'] as $field) {
            if ($barang->$field) Storage::disk('public')->delete($barang->$field);
        }

        $barang->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Barang berhasil dihapus'
        ]);
    }
}