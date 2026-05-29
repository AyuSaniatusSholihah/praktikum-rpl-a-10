<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;

class KatalogUploadController extends Controller
{
    public function create()
    {
        // For simplicity, we just fetch all categories.
        $kategoris = Kategori::all();
        return view('katalog.AddItemPage', compact('kategoris'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'deskripsi' => 'required|string',
            'harga_sewa' => 'required|numeric',
            'harga_jaminan' => 'required|numeric',
            'harga_denda_perjam' => 'required|numeric',
            'stok' => 'required|integer',
            'lokasi' => 'required|string|max:255',
            'foto_barang' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('foto_barang')) {
            // Upload file ke storage/app/public/katalog_images
            $imagePath = $request->file('foto_barang')->store('katalog_images', 'public');
        }

        // Simpan ke database
        Barang::create([
            'user_id' => auth()->id() ?? 1, // Fallback to 1 if not logged in for testing
            'kategori_id' => $request->kategori_id,
            'nama_barang' => $request->nama_barang,
            'deskripsi' => $request->deskripsi,
            'harga_sewa' => $request->harga_sewa,
            'harga_jaminan' => $request->harga_jaminan,
            'harga_denda_perjam' => $request->harga_denda_perjam,
            'stok' => $request->stok,
            'lokasi' => $request->lokasi,
            'foto_barang' => $imagePath,
            'status' => 'tersedia',
        ]);

        return redirect()->route('katalog.add-item')->with('success', 'Barang berhasil diunggah!');
    }
}
