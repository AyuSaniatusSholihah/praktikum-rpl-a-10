# 🏪 SEWAIN — Platform Penyewaan Barang Digital

Repositori ini digunakan untuk pengembangan proyek mata kuliah **Rekayasa Perangkat Lunak (RPL)** kelompok A-10.

## 👥 Anggota Kelompok

| No | Nama                               | NIM       |
|----|------------------------------------|-----------|
| 1  | APRILIA ALFA GUSASTI CIPTANINGTYAS | L0124003  |
| 2  | AYU SANIATUS SHOLIHAH              | L0124005  |
| 3  | GHAZI FAHMI RAMADHAN               | L0124130  |

---

## 📌 Latar Belakang

**SEWAIN** adalah platform digital yang menghubungkan penyewa dan pemilik barang dalam satu ekosistem yang terstruktur dan transparan. Permasalahan utama yang diangkat adalah proses sewa yang masih manual, kurang transparan, dan rentan miskomunikasi.

Sistem yang dirancang bertujuan untuk:
- Mempertemukan penyewa dan pemilik barang dalam satu platform.
- Menyediakan informasi barang, harga, dan ketersediaan secara jelas dan real-time.
- Mendukung proses transaksi penyewaan yang terstruktur (checkout, pembayaran, pengembalian).
- Meningkatkan kepercayaan pengguna melalui sistem review dan moderasi admin.

---

## ✅ Status Implementasi Fitur (Sesuai Product Backlog)

Seluruh fitur inti dari product backlog telah diimplementasikan. Berikut adalah status fitur berdasarkan prioritasnya di *Product Backlog*:

### 🟢 Must Have

| Fitur | Keterangan | Status |
|-------|------------|--------|
| **Registrasi & Login** | Pembuatan akun dan masuk ke sistem | ✅ Selesai |
| **Penyewaan Barang** | Menyewa barang dengan memilih tanggal dan jumlah | ✅ Selesai |
| **Katalog Barang (Owner)** | Menambahkan dan mengelola barang sewaan | ✅ Selesai |
| **Profil User** | Menampilkan dan mengelola informasi pengguna | ✅ Selesai |
| **Pembayaran & Denda** | Mendukung pembayaran simulasi dan denda otomatis | ✅ Selesai |
| **Pengembalian Barang** | Mengembalikan barang & verifikasi status | ✅ Selesai |
| **Dashboard Admin** | Monitor pengguna, barang aktif, transaksi | ✅ Selesai |
| **Filter Pencarian** | Filter barang berdasarkan harga dan lokasi | ✅ Selesai |

### 🔵 Should Have

| Fitur | Keterangan | Status |
|-------|------------|--------|
| **Review & Rating** | Memberikan ulasan setelah menyewa barang | ✅ Selesai |
| **Lupa Password (OTP)** | Mereset password menggunakan OTP | ✅ Selesai |
| **Approval Sewa (Owner)** | Owner menyetujui permintaan sewa | ✅ Selesai (Automated) |
| **Konfirmasi Pengembalian**| Owner memverifikasi pengembalian dan denda | ✅ Selesai |
| **Approval Barang (Admin)**| Admin moderasi barang sebelum tampil di katalog | ✅ Selesai (Moderasi via Ban/Delete) |
| **Keranjang Sewa (Cart)** | Memilih dan mengumpulkan barang sebelum checkout | ✅ Selesai |

### 🟣 Could Have

| Fitur | Keterangan | Status |
|-------|------------|--------|
| **AI Chatbot** | Chatbot untuk membantu pengguna | ❌ Belum Diimplementasikan |
| **History Sewa** | Menampilkan riwayat penyewaan pengguna | ✅ Selesai |
| **Review Website SEWAIN** | Testimonial platform untuk ditampilkan di halaman utama | ✅ Selesai |
| **Aktivitas Log** | Sistem mencatat aktivitas krusial pengguna | ✅ Selesai |
| **Login Google (OAuth)** | Login mudah menggunakan akun Google | ✅ Selesai |

### ⚪ Won't Have

| Fitur | Keterangan | Status |
|-------|------------|--------|
| **Notifikasi Push/SMS** | Memberikan notifikasi realtime status transaksi | ❌ Sesuai Backlog |
| **Pembayaran QRIS/E-Wallet Real** | Integrasi gateway pembayaran asli | ❌ Hanya Simulasi |
| **Lokasi Spesifik (GPS)** | Filter radius lokasi menggunakan koordinat GPS asli | ❌ Hanya Wilayah Umum |

---

## 🏗️ Arsitektur & Teknologi

| Layer | Teknologi |
|-------|-----------|
| **Backend** | Laravel 12 (PHP 8.2+) |
| **Frontend** | Blade Templating, Vanilla CSS, Vanilla JS |
| **Database** | MySQL/MariaDB dengan Eloquent ORM |
| **Auth** | Laravel Session Auth + Laravel Socialite (Google OAuth) |
| **Storage** | Laravel Storage (lokal, symlink ke `/public/storage`) |
| **Email** | Laravel Mail (SMTP) untuk OTP registrasi & reset password |

---

## 📁 Struktur Proyek

```text
praktikum-rpl-a-10/
├── README.md
├── docs/
│   ├── backlog.md                    ← Product Backlog
│   ├── data-dictionary.md            ← Kamus Data & Struktur DB
│   ├── erd.md                        ← Entity Relationship Diagram
│   ├── problem-statement.md          ← Rumusan Masalah
│   ├── srs.md                        ← Software Requirements Specification
│   ├── team-contract.md              ← Aturan Tim
│   ├── user-stories.md               ← User Stories Detail
│   ├── wireframe.md                  ← Desain Antarmuka
│   └── uml/
│       ├── class-diagram.md          ← Class Diagram MVC
│       ├── use-case-diagram.png      
│       └── activity-diagram.png      
├── src/                              ← Root Aplikasi Laravel
│   ├── app/                          ← Model & Controller
│   ├── database/                     ← Migrasi & Seeder
│   ├── public/                       ← Assets, CSS, JS
│   ├── resources/views/              ← Blade UI
│   └── routes/                       ← Routing Web & API
└── tests/
```

---

## 🚀 Cara Menjalankan

**Prasyarat:**
- PHP >= 8.2
- Composer
- Node.js & npm
- MySQL / MariaDB

**Langkah Instalasi:**

```bash
# 1. Clone repositori
git clone <url-repo>

# 2. Masuk ke direktori aplikasi
cd src

# 3. Install dependensi PHP
composer install

# 4. Install dependensi Node.js
npm install

# 5. Salin file environment
cp .env.example .env

# 6. Konfigurasi database & mail di dalam file .env 
# (Isi DB_DATABASE, DB_USERNAME, MAIL_*, GOOGLE_CLIENT_*)

# 7. Generate application key
php artisan key:generate

# 8. Jalankan migrasi dan seeder
php artisan migrate:fresh --seed

# 9. Buat symlink storage untuk foto profil & barang
php artisan storage:link

# 10. Jalankan server backend dan asset bundler (di terminal terpisah)
php artisan serve
npm run dev

# 11. Buka di browser
# http://127.0.0.1:8000
```

---

## 🔀 Alur Kontribusi

1. Buat branch dari branch utama.
2. Lakukan perubahan kecil dan terfokus.
3. Tulis pesan commit yang jelas dengan prefix standar (`feat:`, `fix:`, `refactor:`, `docs:`).
4. Ajukan pull request untuk direview sebelum merge.
