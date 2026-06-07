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
            'nama_kategori' => 'Photography',
            'deskripsi' => 'Semua jenis kamera video, DSLR, Mirrorless, Drone, dan stabilizer.',
        ]);

        \App\Models\Kategori::create([
            'nama_kategori' => 'Electronics',
            'deskripsi' => 'Speaker, microphone, mixer, sound card, dan perangkat audio lainnya.',
        ]);

        \App\Models\Kategori::create([
            'nama_kategori' => 'Tools',
            'deskripsi' => 'Vacuum cleaner, microwave, air fryer, blender, dan kebutuhan rumah tangga.',
        ]);

        \App\Models\Kategori::create([
            'nama_kategori' => 'Camping',
            'deskripsi' => 'Tenda, tas carrier, sleeping bag, kompor camp, dan peralatan mendaki.',
        ]);

        \App\Models\Kategori::create([
            'nama_kategori' => 'Vehicles',
            'deskripsi' => 'Penyewaan mobil, motor, sepeda, dan aksesoris kendaraan.',
        ]);

        \App\Models\Kategori::create([
            'nama_kategori' => 'Fashion',
            'deskripsi' => 'Gaun pesta, jas formal, pakaian adat, kostum, dan aksesoris fashion.',
        ]);

    }
}
