# Data Dictionary – Sistem Penyewaan Barang

## Tabel: Pengguna

| Kolom | Tipe Data | Constraint | Keterangan |
|------|----------|-----------|-----------|
| User_id | INT | PK, AUTO_INCREMENT | ID unik pengguna |
| username | VARCHAR(100) | NOT NULL | Username pengguna |
| password | VARCHAR(255) | NOT NULL | Password (hash bcrypt) |
| nama_lengkap | VARCHAR(100) | NOT NULL | Nama lengkap |
| email | VARCHAR(100) | UNIQUE, NOT NULL | Email login |
| no_telp | VARCHAR(25) | NOT NULL | Nomor telepon |
| alamat | VARCHAR(255) | NOT NULL | Alamat pengguna |
| saldo | DECIMAL(10,2) | DEFAULT 0 | Saldo simulasi |
| foto_profil | VARCHAR(255) | NULL | Foto profil |
| is_banned | BOOLEAN | DEFAULT FALSE | Status banned akun user |
| role | ENUM | DEFAULT 'user' | Role user/admin |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu registrasi |

---

## Tabel: Kategori

| Kolom | Tipe Data | Constraint | Keterangan |
|------|----------|-----------|-----------|
| Kategori_id | INT | PK, AUTO_INCREMENT | ID kategori |
| nama_kategori | VARCHAR(50) | NOT NULL | Nama kategori |
| deskripsi | TEXT | NULL | Deskripsi |

---

## Tabel: Barang

| Kolom | Tipe Data | Constraint | Keterangan |
|------|----------|-----------|-----------|
| Barang_id | INT | PK, AUTO_INCREMENT | ID barang |
| User_id | INT | FK, NOT NULL | Pemilik barang |
| Kategori_id | INT | FK, NOT NULL | Kategori barang |
| nama_barang | VARCHAR(100) | NOT NULL | Nama barang |
| deskripsi | TEXT | NOT NULL | Deskripsi |
| harga_sewa | DECIMAL(10,2) | NOT NULL | Harga sewa |
| harga_jaminan | DECIMAL(10,2) | NOT NULL | Uang jaminan |
| harga_denda_perjam | DECIMAL(10,2) | NOT NULL | Denda per jam |
| stok | INT | DEFAULT 1 | Jumlah stok |
| lokasi | VARCHAR(100) | NOT NULL | Lokasi (kota) |
| foto_barang | VARCHAR(255) | NOT NULL | Foto barang |
| status | ENUM | DEFAULT 'tersedia' | Status barang |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu input |

---

## Tabel: Transaksi_Penyewaan

| Kolom | Tipe Data | Constraint | Keterangan |
|------|----------|-----------|-----------|
| Transaksi_id | INT | PK, AUTO_INCREMENT | ID transaksi |
| User_id | INT | FK, NOT NULL | Penyewa |
| Barang_id | INT | FK, NOT NULL | Barang |
| Jumlah | INT | NOT NULL | Jumlah disewa |
| tanggal_sewa | DATE | NOT NULL | Tanggal mulai |
| tanggal_kembali_rencana | DATE | NOT NULL | Rencana kembali |
| tanggal_kembali_aktual | DATE | NULL | Tanggal kembali aktual |
| status | ENUM | NOT NULL | Status transaksi |
| foto_buktipengembalian | VARCHAR(255) | NULL | Bukti pengembalian |
| tanggal_verifikasipengembalian | TIMESTAMP | NULL | Waktu verifikasi owner |
| total_harga | DECIMAL(10,2) | NOT NULL | Total biaya sewa |
| jam_terlambat | INT | DEFAULT 0 | Lama keterlambatan |
| total_denda | DECIMAL(10,2) | DEFAULT 0 | Total denda |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu transaksi |

---

## Tabel: Pembayaran

| Kolom | Tipe Data | Constraint | Keterangan |
|------|----------|-----------|-----------|
| Pembayaran_id | INT | PK, AUTO_INCREMENT | ID pembayaran |
| Transaksi_id | INT | FK, UNIQUE, NOT NULL | Relasi ke transaksi |
| metode | ENUM | NOT NULL | Metode (transfer, e-wallet, QRIS) |
| detail_metode | VARCHAR(50) | NULL | Detail (BCA, OVO, dll) |
| tanggal_bayar | TIMESTAMP | NULL | Waktu pembayaran |
| jumlah_bayar | DECIMAL(10,2) | NOT NULL | Nominal pembayaran |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu pencatatan |

---

## Tabel: Review

| Kolom | Tipe Data | Constraint | Keterangan |
|------|----------|-----------|-----------|
| Review_id | INT | PK, AUTO_INCREMENT | ID review |
| Transaksi_id | INT | FK, UNIQUE, NOT NULL | Relasi ke transaksi |
| User_id | INT | FK, NOT NULL | Pengguna |
| Barang_id | INT | FK, NOT NULL | Barang |
| rating | INT | CHECK (1–5), NOT NULL | Nilai rating |
| komentar | TEXT | NULL | Ulasan |
| foto_review | VARCHAR(255) | NULL | Foto review |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu review |

---

## Tabel: OTP

| Kolom | Tipe Data | Constraint | Keterangan |
|------|----------|-----------|-----------|
| OTP_id | INT | PK, AUTO_INCREMENT | ID OTP |
| User_id | INT | FK, NOT NULL | Relasi ke user |
| kode_OTP | VARCHAR(10) | NOT NULL | Kode OTP |
| expired_at | TIMESTAMP | NOT NULL | Waktu kadaluarsa |
| is_used | BOOLEAN | DEFAULT FALSE | Status penggunaan OTP |

---

## Relasi Utama

- Pengguna → Barang (1 : N)
- Pengguna → Transaksi_Penyewaan (1 : N)
- Barang → Transaksi_Penyewaan (1 : N)
- Kategori → Barang (1 : N)
- Pengguna → OTP(1 : N)
- Transaksi_Penyewaan → Pembayaran (1 : 1)
- Transaksi_Penyewaan → Review (1 : 1)