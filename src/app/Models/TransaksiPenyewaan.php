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
        'waktu_sewa',
        'waktu_kembali_rencana',
        'status',
        'foto_buktipengembalian',
        'tanggal_verifikasipengembalian',
        'total_harga',
        'jam_terlambat',
        'total_denda',
    ];

    protected $casts = [
        'tanggal_sewa' => 'date',
        'tanggal_kembali_rencana' => 'date',
        'tanggal_kembali_aktual' => 'datetime',
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

    public function review()
    {
        return $this->hasOne(Review::class, 'transaksi_id');
    }

    /**
     * Label status untuk ditampilkan (dipakai di halaman admin & profil).
     */
    public function statusLabel(): string
    {
        return [
            'upcoming'                        => 'UpComing Rent',
            'aktif'                           => 'Active Rent',
            'selesai'                         => 'Completed Rent',
            'tunggu verifikasi pengembalian'  => 'Return Rent',
            'dibatalkan'                      => 'Cancelled Rent',
        ][$this->status] ?? ucfirst((string) $this->status);
    }

    /**
     * Formatted display ID: T + huruf pertama kategori barang + 4-digit ID
     * Contoh: TT0001 (Tools), TV0001 (Vehicles)
     */
    public function formattedId(): string
    {
        $catLetter = ($this->barang && $this->barang->kategori)
            ? strtoupper(substr($this->barang->kategori->nama_kategori, 0, 1))
            : 'X';
        return 'T' . $catLetter . str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Class badge CSS yang cocok dengan status.
     */
    public function statusBadgeClass(): string
    {
        return [
            'upcoming'                        => 'badge-upcoming',
            'aktif'                           => 'badge-active',
            'selesai'                         => 'badge-completed',
            'tunggu verifikasi pengembalian'  => 'badge-return',
            'dibatalkan'                      => 'badge-cancelled',
        ][$this->status] ?? 'badge-upcoming';
    }
}
