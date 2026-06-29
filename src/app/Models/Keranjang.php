<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'barang_id',
        'jumlah',
        'tanggal_sewa',
        'tanggal_kembali_rencana',
        'waktu_sewa',
        'waktu_kembali_rencana',
    ];

    protected $casts = [
        'tanggal_sewa' => 'date',
        'tanggal_kembali_rencana' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}