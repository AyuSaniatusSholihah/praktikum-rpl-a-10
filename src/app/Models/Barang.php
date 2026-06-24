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
        'additional_information',
        'harga_sewa',
        'harga_jaminan',
        'harga_denda_perjam',
        'stok',
        'lokasi',
        'whatsapp',
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
        return $this->status === 'tersedia' ? 'AVAILABLE' : 'ACTIVE RENTAL';
    }

    public function statusBadgeClass(): string {
        return match($this->status) {
            'tersedia'    => 'badge badge-available',
            default       => 'badge badge-active-rental',
        };
    }

    /**
     * Formatted display ID: I + huruf pertama kategori + 3-digit ID
     * Contoh: IT001 (Tools), IV001 (Vehicles), IP001 (Photography)
     */
    public function formattedId(): string
    {
        $catLetter = $this->kategori ? strtoupper(substr($this->kategori->nama_kategori, 0, 1)) : 'X';
        return 'I' . $catLetter . str_pad($this->id, 3, '0', STR_PAD_LEFT);
    }

    public function getShortLocationAttribute(): string
    {
        if (!$this->lokasi) {
            return '';
        }
        // Split by commas and get the last segment (typically city/kabupaten)
        $parts = explode(',', $this->lokasi);
        $cityPart = trim(end($parts));
        // Remove common prefixes like 'kab', 'kota', case-insensitive
        $cityPart = preg_replace('/^(kab|kota)\s+/i', '', $cityPart);
        // Also remove any leading words like 'kelurahan', 'kecamatan' if present
        $cityPart = preg_replace('/^(kelurahan|kecamatan)\s+/i', '', $cityPart);
        // Trim again and return capitalized (first letter upper)
        $cityPart = trim($cityPart);
        return ucfirst(strtolower($cityPart));
    }
}
