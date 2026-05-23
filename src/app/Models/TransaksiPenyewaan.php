<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPenyewaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'barang_id',
        'pembayaran_id',
        'jumlah',
        'tanggal_sewa',
        'tanggal_kembali_rencana',
        'tanggal_kembali_aktual',
        'status',
        'foto_buktipengembalian',
        'tanggal_verifikasipengembalian',
        'total_harga',
        'jam_terlambat',
        'total_denda'
    ];

    protected $casts = [
        'tanggal_sewa' => 'date',
        'tanggal_kembali_rencana' => 'date',
        'tanggal_kembali_aktual' => 'date',
        'tanggal_verifikasipengembalian' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class, 'pembayaran_id');
    }
}
