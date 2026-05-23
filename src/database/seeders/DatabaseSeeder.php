<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun Admin Dummy
        User::create([
            'name' => 'Admin Sewain',
            'username' => 'admin_utama',
            'email' => 'admin@sewain.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'phone_number' => '080000000000',
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // 2. Buat User Dummy (Sudah Terverifikasi)
        User::create([
            'name' => 'Owner Sewain',
            'username' => 'owner123',
            'email' => 'owner@sewain.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'phone_number' => '081234567890',
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // 3. Buat Kategori Dummy
        \App\Models\Kategori::create([
            'nama_kategori' => 'Kamera',
            'deskripsi' => 'Semua jenis kamera (DSLR, Mirrorless, Analog, dll.)',
        ]);

        \App\Models\Kategori::create([
            'nama_kategori' => 'Lensa',
            'deskripsi' => 'Berbagai lensa kamera (Prime, Zoom, Wide, dll.)',
        ]);

        \App\Models\Kategori::create([
            'nama_kategori' => 'Aksesoris',
            'deskripsi' => 'Aksesoris pendukung (Tripod, Lighting, Memory Card, dll.)',
        ]);
    }
}
