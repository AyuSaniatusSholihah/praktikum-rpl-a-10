<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kategori_id',
        'nama_barang',
        'deskripsi',
        'harga_sewa',
        'harga_jaminan',
        'harga_denda_perjam',
        'stok',
        'lokasi',
        'foto_barang',
        'fotoproduk1',
        'fotoproduk2',
        'fotoproduk3',
        'fotoproduk4',
        'status',
        'tanggal_item_mulai',
        'tanggal_item_tidak_tersedia',
    ];

    protected $casts = [
        'tanggal_item_mulai' => 'date',
        'tanggal_item_tidak_tersedia' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Daftar foto produk (utama + angle 1-4) yang benar-benar terisi.
     *
     * @return array<int, string> path relatif di storage publik
     */
    public function semuaFoto(): array
    {
        return array_values(array_filter([
            $this->foto_barang,
            $this->fotoproduk1,
            $this->fotoproduk2,
            $this->fotoproduk3,
            $this->fotoproduk4,
        ]));
    }

    public function statusLabel(): string
    {
        return $this->status === 'tersedia' ? 'Tersedia' : 'Tidak Tersedia';
    }

    public function statusBadgeClass(): string
    {
        return $this->status === 'tersedia' ? 'badge-active' : 'badge-cancelled';
    }
}
