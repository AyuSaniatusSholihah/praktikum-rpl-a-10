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
}
