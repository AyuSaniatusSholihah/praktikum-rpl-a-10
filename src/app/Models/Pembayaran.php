<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaksi_id',
        'metode',
        'detail_metode',
        'tanggal_bayar',
        'jumlah_bayar',
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
    ];

    public function transaksi()
    {
        return $this->belongsTo(TransaksiPenyewaan::class, 'transaksi_id');
    }
}
