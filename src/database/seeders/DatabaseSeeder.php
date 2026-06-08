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
        User::firstOrCreate(
            ['email' => 'admin@sewain.com'],
            [
                'name' => 'Admin Sewain',
                'username' => 'admin_utama',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'phone_number' => '080000000000',
                'saldo' => 1000000,
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // 2. Buat User Dummy (Sudah Terverifikasi)
        User::firstOrCreate(
            ['email' => 'owner@sewain.com'],
            [
                'name' => 'Owner Sewain',
                'username' => 'owner123',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'phone_number' => '081234567890',
                'saldo' => 1000000,
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );

        // 3. Buat Kategori Dummy
        \App\Models\Kategori::firstOrCreate(
            ['nama_kategori' => 'Photography'],
            ['deskripsi' => 'Semua jenis kamera video, DSLR, Mirrorless, Drone, dan stabilizer.']
        );

        \App\Models\Kategori::firstOrCreate(
            ['nama_kategori' => 'Electronics'],
            ['deskripsi' => 'Speaker, microphone, mixer, sound card, dan perangkat audio lainnya.']
        );

        \App\Models\Kategori::firstOrCreate(
            ['nama_kategori' => 'Tools'],
            ['deskripsi' => 'Vacuum cleaner, microwave, air fryer, blender, dan kebutuhan rumah tangga.']
        );

        \App\Models\Kategori::firstOrCreate(
            ['nama_kategori' => 'Camping'],
            ['deskripsi' => 'Tenda, tas carrier, sleeping bag, kompor camp, dan peralatan mendaki.']
        );

        \App\Models\Kategori::firstOrCreate(
            ['nama_kategori' => 'Vehicles'],
            ['deskripsi' => 'Penyewaan mobil, motor, sepeda, dan aksesoris kendaraan.']
        );

        \App\Models\Kategori::firstOrCreate(
            ['nama_kategori' => 'Fashion'],
            ['deskripsi' => 'Gaun pesta, jas formal, pakaian adat, kostum, dan aksesoris fashion.']
        );

    }
}
