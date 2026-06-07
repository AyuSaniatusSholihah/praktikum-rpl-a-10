<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;

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
            'tanggal_item_mulai' => 'required|date|after_or_equal:today',
            'tanggal_item_tidak_tersedia' => 'required|date|after_or_equal:tanggal_item_mulai',
            'foto_barang' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'fotoproduk1' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'fotoproduk2' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'fotoproduk3' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'fotoproduk4' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Foto utama (wajib) -> disimpan di storage publik
        $imagePath = null;
        if ($request->hasFile('foto_barang')) {
            // Upload file ke storage/app/public/katalog_images
            $imagePath = $request->file('foto_barang')->store('katalog_images', 'public');
        }

        // Foto produk tambahan (angle 1-4, opsional) -> disimpan di storage publik
        $fotoProduk = [];
        foreach (['fotoproduk1', 'fotoproduk2', 'fotoproduk3', 'fotoproduk4'] as $field) {
            $fotoProduk[$field] = $request->hasFile($field)
                ? $request->file($field)->store('katalog_images', 'public')
                : null;
        }

        // Simpan ke database
        Barang::create([
            'user_id' => Auth::id() ?? 1,
            'kategori_id' => $request->kategori_id,
            'nama_barang' => $request->nama_barang,
            'deskripsi' => $request->deskripsi,
            'harga_sewa' => $request->harga_sewa,
            'harga_jaminan' => $request->harga_jaminan,
            'harga_denda_perjam' => $request->harga_denda_perjam,
            'stok' => $request->stok,
            'lokasi' => $request->lokasi,
            'foto_barang' => $imagePath,
            'fotoproduk1' => $fotoProduk['fotoproduk1'],
            'fotoproduk2' => $fotoProduk['fotoproduk2'],
            'fotoproduk3' => $fotoProduk['fotoproduk3'],
            'fotoproduk4' => $fotoProduk['fotoproduk4'],
            'status' => 'tersedia',
            'tanggal_item_mulai' => $request->tanggal_item_mulai,
            'tanggal_item_tidak_tersedia' => $request->tanggal_item_tidak_tersedia,
        ]);

        return redirect()->route('katalog')->with('success', 'Barang berhasil diunggah!');
    }

    public function edit($id)
    {
        $product = Barang::findOrFail($id);
        $kategoris = Kategori::all();
        return view('katalog.EditItemPage', compact('product', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'deskripsi' => 'required|string',
            'harga_sewa' => 'required|numeric',
            'harga_jaminan' => 'required|numeric',
            'harga_denda_perjam' => 'required|numeric',
            'stok' => 'required|integer',
            'lokasi' => 'required|string|max:255',
            'tanggal_item_mulai' => 'required|date',
            'tanggal_item_tidak_tersedia' => 'required|date|after_or_equal:tanggal_item_mulai',
            'foto_barang' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $product = Barang::findOrFail($id);

        $data = [
            'kategori_id' => $request->kategori_id,
            'nama_barang' => $request->nama_barang,
            'deskripsi' => $request->deskripsi,
            'harga_sewa' => $request->harga_sewa,
            'harga_jaminan' => $request->harga_jaminan,
            'harga_denda_perjam' => $request->harga_denda_perjam,
            'stok' => $request->stok,
            'lokasi' => $request->lokasi,
            'tanggal_item_mulai' => $request->tanggal_item_mulai,
            'tanggal_item_tidak_tersedia' => $request->tanggal_item_tidak_tersedia,
        ];

        if ($request->hasFile('foto_barang')) {
            $data['foto_barang'] = $request->file('foto_barang')->store('katalog_images', 'public');
        }

        $product->update($data);

        return redirect()->route('katalog')->with('success', 'Barang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $product = Barang::findOrFail($id);
        $product->delete();
        return redirect()->route('katalog')->with('success', 'Barang berhasil dihapus!');
    }
}
