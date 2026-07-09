# SEWAIN — Platform Penyewaan Barang 

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-MariaDB-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4.x-06B6D4?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-8.x-646CFF?style=for-the-badge&logo=vite&logoColor=white)
![PHPUnit](https://img.shields.io/badge/PHPUnit-12.x-3C7FBB?style=for-the-badge&logo=php&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

**Platform Penyewaan Barang dengan Sistem Manajemen Transaksi Terintegrasi**

*Proyek Mata Kuliah Rekayasa Perangkat Lunak (RPL) — Kelompok A-10*

</div>

---

## Anggota Kelompok

| No | Nama | NIM |
|----|-----------------------------------|-----------|
| 1  | APRILIA ALFA GUSASTI CIPTANINGTYAS | L0124003  |
| 2  | AYU SANIATUS SHOLIHAH              | L0124005  |
| 3  | GHAZI FAHMI RAMADHAN               | L0124130  |

---

## Tentang Proyek

**SEWAIN** adalah platform digital yang menghubungkan penyewa dan pemilik barang dalam satu ekosistem yang terstruktur dan transparan. Permasalahan utama yang diangkat adalah proses sewa yang masih manual, kurang transparan, dan rentan miskomunikasi.

Sistem dirancang untuk:
- Mempertemukan penyewa dan pemilik barang dalam satu platform
- Menyediakan informasi barang, harga, dan ketersediaan secara jelas dan real-time
- Mendukung proses transaksi penyewaan yang terstruktur (checkout, pembayaran, pengembalian)
- Meningkatkan kepercayaan pengguna melalui sistem review dan moderasi admin

---

## Fitur Utama

### Must Have (Semua Selesai)

| Fitur | Deskripsi |
|-------|-----------|
| **Registrasi & Login** | Pembuatan akun, verifikasi email, dan masuk ke sistem |
| **Penyewaan Barang** | Menyewa barang dengan memilih tanggal, durasi, dan jumlah |
| **Katalog Barang (Owner)** | Menambahkan, mengedit, dan mengelola barang sewaan |
| **Profil User** | Menampilkan dan mengelola informasi pengguna |
| **Pembayaran & Denda** | Simulasi pembayaran dan perhitungan denda otomatis |
| **Pengembalian Barang** | Pengembalian barang dengan verifikasi status oleh Owner |
| **Dashboard Admin** | Monitor pengguna, barang aktif, transaksi, dan wallet |
| **Filter Pencarian** | Filter barang berdasarkan harga, kategori, dan lokasi |

### Should Have (Semua Selesai)

| Fitur | Deskripsi |
|-------|-----------|
| **Review & Rating** | Memberikan ulasan dan bintang setelah menyewa barang |
| **Lupa Password (OTP)** | Mereset password menggunakan OTP via email |
| **Approval Sewa (Owner)** | Owner menyetujui permintaan sewa (otomatis) |
| **Konfirmasi Pengembalian** | Owner memverifikasi pengembalian barang dan denda |
| **Moderasi Barang (Admin)** | Admin moderasi barang sebelum tampil di katalog |
| **Keranjang Sewa (Cart)** | Memilih dan mengumpulkan barang sebelum checkout |

### Could Have

| Fitur | Deskripsi | Status |
|-------|-----------|--------|
| **History Sewa** | Menampilkan riwayat penyewaan pengguna | Selesai |
| **Review Website** | Testimonial platform di halaman utama | Selesai |
| **Aktivitas Log** | Sistem mencatat aktivitas krusial pengguna | Selesai |
| **Login Google (OAuth)** | Login mudah menggunakan akun Google | Selesai |
| **AI Chatbot** | Chatbot untuk membantu pengguna | Belum |

### Won't Have (Sesuai Backlog)

| Fitur | Keterangan |
|-------|------------|
| **Notifikasi Push/SMS** | Notifikasi realtime status transaksi |
| **Pembayaran QRIS/E-Wallet Real** | Integrasi gateway pembayaran asli |
| **Lokasi Spesifik (GPS)** | Filter radius lokasi dengan koordinat GPS |

---

## Screenshot Aplikasi

<details>
<summary><b>Autentikasi (Register, Login, Lupa Password)</b></summary>

**Register — Back End & Front End**
<br>
<img width="49%" alt="Register BE" src="https://github.com/user-attachments/assets/6509dfe2-8bf3-42a6-ab4d-7871014eb6df" /> <img width="49%" alt="Register FE" src="https://github.com/user-attachments/assets/76324e02-1351-422e-9d3b-9f9cefe2f7c6" />
<img width="49%" alt="Register FE 2" src="https://github.com/user-attachments/assets/bdfd36b7-35ec-4a55-bd24-bffdadd1d195" /> <img width="49%" alt="Register FE 3" src="https://github.com/user-attachments/assets/7d58b8bd-84a8-4409-b69a-18635f606b5a" />
<br><br>

**Login — Back End & Front End**
<br>
<img width="100%" alt="Login" src="https://github.com/user-attachments/assets/4450aacb-6c04-412a-a014-26376093bd32" />
<br><br>

**Lupa Password & Reset Password**
<br>
<img width="49%" alt="Forgot Password 1" src="https://github.com/user-attachments/assets/e9229006-a516-4c2e-90b7-9742627a4e1b" /> <img width="49%" alt="Forgot Password 2" src="https://github.com/user-attachments/assets/a30f3461-c701-4458-af52-b11424fbaa57" />
<img width="49%" alt="Reset Password 1" src="https://github.com/user-attachments/assets/de7a324e-1a31-46da-bb7a-156582cecba9" /> <img width="49%" alt="Reset Password 2" src="https://github.com/user-attachments/assets/1fe1b81b-3314-4dcd-b4a7-5bec40bfb75b" />
<br><br>

**Verifikasi Email**
<br>
<img width="100%" alt="Verify Email" src="https://github.com/user-attachments/assets/a5625853-ed13-4cb5-adb3-bb039c9ed3d4" />
</details>

<details>
<summary><b>Homepage</b></summary>

<img width="100%" alt="Homepage" src="https://github.com/user-attachments/assets/30fa6559-b7d6-4000-8a77-e7cd6adc2a71" />
</details>

<details>
<summary><b>User — Penyewa</b></summary>

**Pencarian dan Filter Barang**
<br>
<img width="100%" alt="Pencarian Barang" src="https://github.com/user-attachments/assets/c7e7f215-c2ef-4f87-8c39-d65ce9dad98c" />
<br><br>

**Menyewa Barang dan Pembayaran**
<br>
<img width="49%" alt="Sewa 1" src="https://github.com/user-attachments/assets/97a6a82d-4995-44fa-8bd0-20f53087b791" /> <img width="49%" alt="Sewa 2" src="https://github.com/user-attachments/assets/4f8b6964-3d25-4a8c-8b11-4d85ff02dce5" />
<img width="49%" alt="Sewa 3" src="https://github.com/user-attachments/assets/208e030f-4310-497e-8477-48aa374768a4" /> <img width="49%" alt="Sewa 4" src="https://github.com/user-attachments/assets/da0f45b0-3bbb-4e1a-8940-09fcc41dee68" />
<img width="49%" alt="Sewa 5" src="https://github.com/user-attachments/assets/ad90adaf-9f7b-487a-b985-ca57adfb4f92" /> <img width="49%" alt="Sewa 6" src="https://github.com/user-attachments/assets/172b1f83-46dc-46fa-bc0e-71805873c7d9" />
<img width="100%" alt="Pembayaran" src="https://github.com/user-attachments/assets/b12268b6-21e7-4f52-ada5-31ec48c31acf" />
<br><br>

**Riwayat Sewa**
<br>
<img width="49%" alt="Riwayat 1" src="https://github.com/user-attachments/assets/2c4721da-5f6d-4ce6-974c-9f58eb024b6c" /> <img width="49%" alt="Riwayat 2" src="https://github.com/user-attachments/assets/b5675c2a-749e-4135-b7ff-4db8e5bb60df" />
<img width="100%" alt="Riwayat 3" src="https://github.com/user-attachments/assets/08ca3284-78cf-4087-bc96-2f9df71b21d4" />
<br><br>

**Review Barang**
<br>
<img width="49%" alt="Review 1" src="https://github.com/user-attachments/assets/629bf987-d6e3-4591-9e4f-0850dc589404" /> <img width="49%" alt="Review 2" src="https://github.com/user-attachments/assets/eb233d6c-6d10-4b60-822c-ec4985cc5c8e" />
<img width="49%" alt="Review 3" src="https://github.com/user-attachments/assets/ffa00e63-1869-40c2-8173-0f042405d71a" /> <img width="49%" alt="Review 4" src="https://github.com/user-attachments/assets/3b614ee1-0c2b-492a-8d1c-242a4035da8a" />
</details>

<details>
<summary><b>User — Owner</b></summary>

**Mengelola Katalog Barang**
<br>
<img width="49%" alt="Katalog 1" src="https://github.com/user-attachments/assets/56da55f1-95a8-4519-a2ef-a40d081558cb" /> <img width="49%" alt="Katalog 2" src="https://github.com/user-attachments/assets/65220620-f53e-4bbb-aaed-2a54ae0bad9e" />
<img width="49%" alt="Katalog 3" src="https://github.com/user-attachments/assets/31df9e3f-d1be-4f08-963c-0bd9762cad0e" /> <img width="49%" alt="Katalog 4" src="https://github.com/user-attachments/assets/6510e48a-05e3-4643-afae-f422070dc213" />
<img width="49%" alt="Katalog 5" src="https://github.com/user-attachments/assets/5e5b872b-3eec-4916-ae35-6e3ae7257f52" /> <img width="49%" alt="Katalog 6" src="https://github.com/user-attachments/assets/26cbddc8-1925-408d-89c0-be97ebe603c8" />
<br><br>

**Konfirmasi Pengembalian & Pengelolaan Denda**
<br>
<img width="49%" alt="Pengembalian 1" src="https://github.com/user-attachments/assets/26e9c329-5dfc-4127-8ac2-bf8cb8fc7108" /> <img width="49%" alt="Pengembalian 2" src="https://github.com/user-attachments/assets/93f4e7d5-8a5b-41cc-9bb5-7b7c64c60528" />
<img width="100%" alt="Pengembalian 3" src="https://github.com/user-attachments/assets/8a5adc67-ee5b-4681-8036-71fa69fa8520" />
<br><br>

**Melihat Transaksi & Saldo**
<br>
<img width="100%" alt="Transaksi Saldo" src="https://github.com/user-attachments/assets/393a55a8-cb8f-4a94-b441-d24d66791901" />
</details>

<details>
<summary><b>Admin</b></summary>

**Login Admin**
<br>
<img width="100%" alt="Login Admin" src="https://github.com/user-attachments/assets/c569e53e-167e-47c9-a11d-4d029e3d471a" />
<br><br>

**Dashboard Admin & Scroll**
<br>
<img width="49%" alt="Dashboard 1" src="https://github.com/user-attachments/assets/c8c68d0f-1f24-46cc-836b-86d7e4d352eb" /> <img width="49%" alt="Dashboard 2" src="https://github.com/user-attachments/assets/807d2dc1-a550-4a5c-a3a3-dea388336033" />
<img width="100%" alt="Dashboard 3" src="https://github.com/user-attachments/assets/0588f113-b13c-4706-ac01-023d240a7eaf" />
<br><br>

**Monitoring Financial Wallet**
<br>
<img width="100%" alt="Financial" src="https://github.com/user-attachments/assets/814f8463-6546-4272-a2af-038fe1934dd7" />
<br><br>

**Monitoring Users & Ban Akun**
<br>
<img width="49%" alt="Users 1" src="https://github.com/user-attachments/assets/55bda17d-7c58-4ef9-8a67-5871ef2b44b5" /> <img width="49%" alt="Users 2" src="https://github.com/user-attachments/assets/af3f1a7d-3dab-440a-95a1-c1e364deee50" />
<img width="49%" alt="Users 3" src="https://github.com/user-attachments/assets/5259f1c1-18f5-4d85-a88b-9f51913cdf5f" /> <img width="49%" alt="Users 4" src="https://github.com/user-attachments/assets/b4e80301-8691-4278-9b9b-7421dd3bf37f" />
<br><br>

**Monitoring Items & Transactions**
<br>
<img width="49%" alt="Items 1" src="https://github.com/user-attachments/assets/52121961-26fa-4886-868a-f870b71208ad" /> <img width="49%" alt="Items 2" src="https://github.com/user-attachments/assets/d7a976bb-6a89-4df0-8cf8-bad2f49f12c8" />
<img width="49%" alt="Trans 1" src="https://github.com/user-attachments/assets/43830186-4b58-46b9-a0c7-db7ba157b2fb" /> <img width="49%" alt="Trans 2" src="https://github.com/user-attachments/assets/01f9fc41-825a-417c-b661-0746865d740b" />
<br><br>

**Profil Admin**
<br>
<img width="100%" alt="Profil Admin" src="https://github.com/user-attachments/assets/0d5a2a67-5a67-4f05-bf6f-27e94517eeb7" />
</details>

---

## 🏗️ Teknologi yang Digunakan

| Layer | Teknologi |
|-------|-----------|
| **Backend** | Laravel 13 (PHP 8.3+) |
| **Frontend** | Blade Templating, Tailwind CSS v4, Vanilla JS |
| **Bundler** | Vite 8 |
| **Database** | MySQL / MariaDB dengan Eloquent ORM |
| **Auth** | Laravel Session Auth + Laravel Socialite (Google OAuth) |
| **API** | Laravel Sanctum (Token-based) |
| **Storage** | Laravel Storage (lokal, symlink ke `/public/storage`) |
| **Email** | Laravel Mail (SMTP) untuk OTP & reset password |
| **Testing** | PHPUnit 12 (Unit & Feature Tests) |
| **Mobile API Client** | Kotlin + Retrofit2 (Android) |

---

## Struktur Proyek

```
praktikum-rpl-a-10/
├── README.md
├── ApiService.kt                     ← Kotlin API client (Android)
├── docs/
│   ├── backlog.md                    ← Product Backlog
│   ├── data-dictionary.md            ← Kamus Data & Struktur DB
│   ├── erd.md                        ← Entity Relationship Diagram
│   ├── srs.md                        ← Software Requirements Specification
│   ├── user-stories.md               ← User Stories Detail
│   ├── user-manual.md                ← Panduan Pengguna
│   ├── test-cases.md                 ← Rencana Test Case
│   ├── laporan-proyek.md             ← Laporan Akhir Proyek
│   └── uml/                          ← Diagram UML
└── src/                              ← Root Aplikasi Laravel
    ├── app/
    │   ├── Http/Controllers/         ← Controller Web & API
    │   ├── Models/                   ← Eloquent Models
    │   ├── Services/                 ← Business Logic Layer
    │   └── Helpers/                  ← Helper Functions
    ├── database/
    │   ├── migrations/               ← Migrasi Database
    │   └── seeders/                  ← Data Seeder
    ├── public/
    │   └── assets/                   ← CSS, JS, Images
    ├── resources/views/              ← Blade Templates (UI)
    ├── routes/
    │   ├── web.php                   ← Route Web
    │   └── api.php                   ← Route API
    └── tests/
        ├── Unit/                     ← Unit Tests (PHPUnit AAA)
        └── Feature/                  ← Feature/Integration Tests
```

---

## 🧪 Unit Testing

Proyek ini dilengkapi dengan **unit test dan feature test** menggunakan PHPUnit 12 dengan pola **AAA (Arrange–Act–Assert)**.

### Test Suites

| Suite | File | Deskripsi |
|-------|------|-----------|
| **Unit** | `BarangMethodTest.php` | Test method-method pada Model Barang |
| **Unit** | `TransaksiCalculatorTest.php` | Test kalkulasi biaya, denda, dan durasi sewa |
| **Unit** | `TransaksiPenyewaanMethodTest.php` | Test method status & validasi transaksi |
| **Feature** | `KatalogApiTest.php` | Test API endpoint katalog barang |
| **Feature** | `AdminManagementTest.php` | Test flow manajemen admin |
| **Feature** | `OwnerDashboardTest.php` | Test dashboard owner |
| **Feature** | `RenterTransactionTest.php` | Test alur transaksi penyewa |

### Menjalankan Test

```bash
# Masuk ke direktori src terlebih dahulu
cd src

# Jalankan semua test
php artisan test

# Jalankan hanya unit test
php artisan test --testsuite=Unit

# Jalankan hanya feature test
php artisan test --testsuite=Feature

# Jalankan dengan output verbose
php artisan test --verbose
```

---

## 🚀 Panduan Instalasi

### Prasyarat

Pastikan perangkat Anda sudah terinstal semua tools berikut:

| Tools | Versi Minimum | Cek Versi |
|-------|--------------|-----------|
| **PHP** | 8.3+ | `php -v` |
| **Composer** | 2.x | `composer -V` |
| **Node.js** | 18+ | `node -v` |
| **npm** | 9+ | `npm -v` |
| **MySQL / MariaDB** | 8.0+ / 10.x+ | `mysql --version` |
| **Git** | Terbaru | `git --version` |

> **Belum punya tools di atas?**
> - PHP & Composer → https://laravel.com/docs/installation#installing-php
> - Node.js & npm → https://nodejs.org
> - MySQL → https://dev.mysql.com/downloads/ atau gunakan XAMPP (https://www.apachefriends.org/)

---

### Langkah-Langkah Instalasi

#### 1. Clone Repositori

```bash
git clone https://github.com/AyuSaniatusSholihah/praktikum-rpl-a-10.git
cd praktikum-rpl-a-10
```

#### 2. Masuk ke Direktori Aplikasi Laravel

```bash
cd src
```

#### 3. Install Dependensi PHP

```bash
composer install
```

> Proses ini membutuhkan koneksi internet dan mungkin memakan waktu beberapa menit.

#### 4. Install Dependensi Node.js

```bash
npm install
```

#### 5. Salin File Konfigurasi Environment

```bash
# Linux / macOS
cp .env.example .env

# Windows (Command Prompt)
copy .env.example .env

# Windows (PowerShell)
Copy-Item .env.example .env
```

#### 6. Konfigurasi File `.env`

Buka file `.env` dengan teks editor dan sesuaikan nilai-nilai berikut:

```env
# ── Nama Aplikasi ───────────────────────────────
APP_NAME="SEWAIN"
APP_URL=http://localhost

# ── Konfigurasi Database (MySQL) ────────────────
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sewain_db       # nama database yang akan dibuat
DB_USERNAME=root             # username MySQL Anda
DB_PASSWORD=                 # password MySQL Anda (kosongkan jika tidak ada)

# ── Konfigurasi Email (untuk OTP & Reset Password) ──
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=emailanda@gmail.com
MAIL_PASSWORD=app_password_anda
MAIL_FROM_ADDRESS="noreply@sewain.com"
MAIL_FROM_NAME="SEWAIN"

# ── Google OAuth (untuk Login dengan Google) ─────
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URL=http://localhost:8000/auth/google/callback
```

> 💡 **Tips Email**: Untuk testing lokal, ubah `MAIL_MAILER=log` agar email ditulis ke file log saja, tidak perlu konfigurasi SMTP.
>
> 💡 **Tips Google OAuth**: Fitur login Google bersifat opsional. Lewati bagian ini jika tidak diperlukan.

#### 7. Buat Database MySQL

Buat database baru di MySQL sesuai nama `DB_DATABASE` yang kamu isi di `.env`:

```sql
-- Jalankan di MySQL client / phpMyAdmin / TablePlus
CREATE DATABASE sewain_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### 8. Generate Application Key

```bash
php artisan key:generate
```

#### 9. Jalankan Migrasi dan Seeder

```bash
php artisan migrate:fresh --seed
```

> ⚠️ Perintah ini akan **menghapus semua data yang ada** dan membuat ulang tabel dari awal beserta data dummy. Cocok untuk setup pertama kali.

#### 10. Buat Symlink Storage

```bash
php artisan storage:link
```

> Langkah ini diperlukan agar foto profil dan foto barang bisa diakses dari browser.

---

### Menjalankan Aplikasi

Buka **dua terminal** di dalam folder `src/`, lalu jalankan masing-masing:

**Terminal 1 — Laravel Development Server:**
```bash
php artisan serve
```

**Terminal 2 — Vite Asset Bundler (Hot Reload):**
```bash
npm run dev
```

> ✅ Atau jalankan keduanya sekaligus dengan satu perintah:
> ```bash
> composer run dev
> ```

Buka browser dan akses: **http://127.0.0.1:8000**

---

### Akun Default (Setelah Seeder)

Setelah menjalankan `php artisan migrate:fresh --seed`, cek file `database/seeders/` untuk daftar akun yang tersedia.

| Role | Dibuat Oleh |
|------|-------------|
| **Admin** | `AdminSeeder.php` |
| **Owner** | `UserSeeder.php` |
| **Penyewa** | `UserSeeder.php` |

---

## Dokumentasi Proyek

| Dokumen | Deskripsi |
|---------|-----------|
| [`docs/srs.md`](docs/srs.md) | Software Requirements Specification |
| [`docs/backlog.md`](docs/backlog.md) | Product Backlog |
| [`docs/user-stories.md`](docs/user-stories.md) | User Stories Detail |
| [`docs/erd.md`](docs/erd.md) | Entity Relationship Diagram |
| [`docs/data-dictionary.md`](docs/data-dictionary.md) | Kamus Data & Struktur Database |
| [`docs/user-manual.md`](docs/user-manual.md) | Panduan Penggunaan Aplikasi |
| [`docs/test-cases.md`](docs/test-cases.md) | Rencana Test Case |
| [`docs/laporan-proyek.md`](docs/laporan-proyek.md) | Laporan Akhir Proyek |

---

## Alur Kontribusi

1. Buat branch baru dari branch `dev`.
2. Lakukan perubahan kecil dan terfokus.
3. Tulis pesan commit yang jelas dengan prefix standar:
   - `feat:` — penambahan fitur baru
   - `fix:` — perbaikan bug
   - `refactor:` — perubahan kode tanpa mengubah fungsionalitas
   - `docs:` — perubahan dokumentasi
   - `test:` — penambahan atau perubahan test
4. Ajukan Pull Request ke `dev` untuk direview sebelum merge.

---

## Troubleshooting

<details>
<summary><b>Error: Class not found / Autoload error</b></summary>

```bash
composer dump-autoload
```
</details>

<details>
<summary><b>Error: cache path / config error</b></summary>

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```
</details>

<details>
<summary><b>Foto tidak muncul / storage error</b></summary>

```bash
php artisan storage:link
```

Pastikan folder `storage/app/public` ada dan dapat ditulis.
</details>

<details>
<summary><b>Error saat migrate (database connection refused)</b></summary>

Pastikan:
1. MySQL / MariaDB sudah berjalan
2. Nama database, username, dan password di `.env` sudah benar
3. Database sudah dibuat secara manual di MySQL

```bash
php artisan config:clear
php artisan migrate:fresh --seed
```
</details>

<details>
<summary><b>Halaman tidak ada style (Vite assets tidak load)</b></summary>

Pastikan `npm run dev` sedang berjalan di terminal terpisah. Atau build terlebih dahulu:

```bash
npm run build
```
</details>

---

<div align="center">
  <sub>Dibuat oleh Kelompok RPL A-10 · Universitas Sebelas Maret · 2025/2026</sub>
</div>
