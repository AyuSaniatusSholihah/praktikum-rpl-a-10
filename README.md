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
|   |-- problem-statement.md
|   |-- srs.md
|   |-- team-contract.md
|   `-- user-stories.md
|-- src/
|   `-- regist.js
`-- tests/
		`-- halo.php
```

## Dokumentasi

Dokumen utama proyek berada di folder `docs`:

- `docs/problem-statement.md`: masalah yang ingin diselesaikan.
- `docs/user-stories.md`: kebutuhan pengguna dalam bentuk user story.
- `docs/backlog.md`: daftar pekerjaan pengembangan.
- `docs/srs.md`: spesifikasi kebutuhan perangkat lunak.
- `docs/team-contract.md`: aturan kerja tim.

## Status Proyek

Saat ini proyek berada pada tahap perancangan dan inisialisasi repositori.

- Dokumen analisis kebutuhan sudah mulai disusun.
- Implementasi kode pada folder `src` masih tahap awal.

## Cara Menjalankan

Belum ada aplikasi yang siap dijalankan pada tahap ini.

Langkah sementara:

1. Baca dokumen kebutuhan di folder `docs`.
2. Lanjutkan pengembangan fitur pada folder `src`.
3. Tambahkan pengujian bertahap di folder `tests`.

## Kontribusi

Untuk kontribusi dari anggota tim:

1. Buat branch fitur dari branch pengembangan.
2. Lakukan perubahan kecil dan terfokus.
3. Tulis pesan commit yang jelas.
4. Ajukan pull request untuk direview.

## Catatan

README ini akan diperbarui seiring progres implementasi fitur dan penambahan detail teknis (stack, setup, dan deployment).


