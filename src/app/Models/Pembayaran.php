<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'metode',
        'detail_metode',
        'tanggal_bayar',
        'jumlah_bayar',
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
    ];

    public function transaksiPenyewaans()
    {
        return $this->hasMany(TransaksiPenyewaan::class, 'pembayaran_id');
    }
}
