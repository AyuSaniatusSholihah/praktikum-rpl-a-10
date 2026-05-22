<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone_number',
        'alamat',
        'saldo',
        'foto_profil',
        'is_banned',
        'role',
        'otp_code',
        'otp_expires_at',
        'google_id',
        'google_token',
        'google_refresh_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_banned' => 'boolean',
            'saldo' => 'decimal:2',
        ];
    }

    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class);
    }

    public function transaksiPenyewaan()
    {
        return $this->hasMany(TransaksiPenyewaan::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
