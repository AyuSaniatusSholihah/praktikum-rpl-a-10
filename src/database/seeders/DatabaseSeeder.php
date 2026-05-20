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

        // 2. Buat Kategori Dummy
        \App\Models\Kategori::create([
            'nama_kategori' => 'Alat Fotografi',
            'deskripsi' => 'Kamera, Lensa, Tripod, Lighting, dll.'
        ]);

        \App\Models\Kategori::create([
            'nama_kategori' => 'Alat Gunung',
            'deskripsi' => 'Tenda, Carrier, Sepatu Gunung, Sleeping Bag, dll.'
        ]);
        
        \App\Models\Kategori::create([
            'nama_kategori' => 'Elektronik & Gadget',
            'deskripsi' => 'Laptop, Proyektor, Konsol Game, dll.'
        ]);
    }
}
