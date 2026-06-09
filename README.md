# Praktikum RPL A-10

Repositori ini digunakan untuk pengembangan proyek mata kuliah Rekayasa Perangkat Lunak (RPL) kelompok A-10.

## Anggota Kelompok

| No | Nama                               | NIM      |
|----|------------------------------------|----------|
| 1  | APRILIA ALFA GUSASTI CIPTANINGTYAS | L0124003 |
| 2  | AYU SANIATUS SHOLIHAH              | L0124005 |
| 3  | GHAZI FAHMI RAMADHAN               | L0124130 |

## Latar Belakang

Proyek ini berfokus pada solusi digital untuk proses penyewaan barang. Permasalahan utama yang diangkat adalah proses sewa yang masih manual, kurang transparan, dan rentan miskomunikasi.

Sistem yang dirancang bertujuan untuk:

- Mempertemukan penyewa dan pemilik barang dalam satu platform.
- Menyediakan informasi barang, harga, dan ketersediaan secara jelas.
- Mendukung proses transaksi penyewaan yang lebih terstruktur.
- Meningkatkan kepercayaan pengguna melalui riwayat transaksi dan moderasi.

## Ruang Lingkup Fitur

Berikut ringkasan fitur berdasarkan user stories:

- Penyewa:
	- Registrasi akun.
	- Login dan lupa password (OTP).
	- Pencarian dan filter barang.
	- Proses sewa, pembayaran, pengembalian, dan riwayat sewa.
	- Review barang.
- Owner:
	- Kelola katalog barang (tambah, ubah, hapus).
	- Persetujuan atau penolakan permintaan sewa.
	- Melihat transaksi dan saldo.
- Admin:
	- Monitoring aktivitas platform.
	- Melihat detail pengguna.
	- Freeze/ban akun bermasalah.

## Struktur Proyek

```text
praktikum-rpl-a-10/
|-- README.md
|-- docs/
|   |-- backlog.md
|   |-- data-dictionary.md
|   |-- problem-statement.md
|   |-- srs.md
|   |-- team-contract.md
|   |-- user-stories.md
|   |-- wireframe.md
|   `-- uml/
|-- src/
|   |-- app/           (Laravel Backend & Controllers)
|   |-- database/      (Migrations & Seeders)
|   |-- public/        (Assets: CSS, Images, JS)
|   |-- resources/     (Blade Views & UI Components)
|   |-- routes/        (Web & API Routes)
|   `-- package.json & composer.json
`-- tests/
```

## Dokumentasi

Dokumen utama proyek berada di folder `docs`:

- `docs/problem-statement.md`: masalah yang ingin diselesaikan.
- `docs/user-stories.md`: kebutuhan pengguna dalam bentuk user story.
- `docs/backlog.md`: daftar pekerjaan pengembangan.
- `docs/srs.md`: spesifikasi kebutuhan perangkat lunak.
- `docs/team-contract.md`: aturan kerja tim.
- `docs/data-dictionary.md`: kamus data dan definisi atribut.
- `docs/wireframe.md`: desain antarmuka pengguna.
- `docs/uml/`: diagram UML sistem (use case, class diagram, sequence diagram, dll).

## Status Proyek

Proyek saat ini sudah memasuki tahap **Implementasi Backend & Frontend**.

**Progress yang sudah selesai:**
- Dokumen analisis kebutuhan (problem statement, user stories, backlog)
- Spesifikasi perangkat lunak (SRS)
- Data dictionary dan wireframe desain UI
- Diagram UML sistem
- Kontrak kerja tim
- **Implementasi Fitur Utama (Laravel):**
  - Autentikasi Pengguna (Login, Register dengan OTP, Google Login)
  - Dashboard Admin (Data User, Manajemen Transaksi, Manajemen Barang)
  - Profil Pengguna & Dompet / Saldo (My Wallet)
  - Penambahan & Manajemen Katalog Barang Sewa
  - Proses Checkout Sewa Barang (Keranjang, Data Pengiriman, Pembayaran)
  - Database Migration & Seeding (Akun Dummy, Kategori)

**Progress yang sedang dikerjakan:**
- Penyempurnaan UI/UX agar responsif dan konsisten.
- Integrasi lanjutan untuk notifikasi transaksi & review barang.

**Progress yang akan dikerjakan:**
- Pengujian menyeluruh (Unit test & Integration test)
- Persiapan Deployment (Hosting)

## Cara Menjalankan

Aplikasi ini dibangun menggunakan kerangka kerja **Laravel** dan **Vanilla CSS/JS**.

**Prasyarat:**
- PHP >= 8.2
- Composer
- Node.js & npm
- MySQL / MariaDB

**Langkah Instalasi:**
1. Clone repositori ini.
2. Masuk ke direktori utama aplikasi: `cd src`
3. Install dependensi PHP: `composer install`
4. Install dependensi Node.js: `npm install`
5. Salin file environment: `cp .env.example .env`
6. Atur konfigurasi database di dalam file `.env`.
7. Buat *application key*: `php artisan key:generate`
8. Jalankan migrasi dan seeder database: `php artisan migrate:fresh --seed`
9. Jalankan server backend: `php artisan serve`
10. Jalankan asset bundler (di terminal terpisah): `npm run dev`
11. Akses aplikasi melalui browser di: `http://127.0.0.1:8000`

## Kontribusi

Untuk kontribusi dari anggota tim:

1. Buat branch fitur dari branch pengembangan.
2. Lakukan perubahan kecil dan terfokus.
3. Tulis pesan commit yang jelas.
4. Ajukan pull request untuk direview.

## Catatan

README ini akan terus diperbarui seiring progres implementasi fitur. Stack teknologi dan instruksi setup akan ditambahkan pada tahap pengembangan lebih lanjut.


