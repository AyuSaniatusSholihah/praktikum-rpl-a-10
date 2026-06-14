# Data Dictionary – Sistem Penyewaan Barang

---

## Tabel: users

Menyimpan data semua pengguna sistem, termasuk autentikasi Google OAuth dan OTP.

| Kolom | Tipe Data | Constraint | Keterangan |
|-------|-----------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | ID unik pengguna |
| google_id | VARCHAR | NULL | ID akun Google (OAuth) |
| google_token | TEXT | NULL | Token akses Google OAuth |
| google_refresh_token | TEXT | NULL | Refresh token Google OAuth |
| name | VARCHAR | NOT NULL | Nama lengkap pengguna |
| username | VARCHAR | UNIQUE, NOT NULL | Username pengguna |
| email | VARCHAR | UNIQUE, NOT NULL | Email login |
| phone_number | VARCHAR | NOT NULL | Nomor telepon |
| alamat | VARCHAR | NOT NULL | Alamat pengguna |
| tanggal_lahir | VARCHAR | NULL | Tanggal lahir pengguna |
| jenis_kelamin | VARCHAR | NULL | Jenis kelamin pengguna |
| saldo | DECIMAL | DEFAULT 0 | Saldo simulasi pembayaran |
| foto_profil | VARCHAR | NULL | Foto profil pengguna |
| is_banned | BOOLEAN | DEFAULT FALSE | Status banned akun |
| role | ENUM | DEFAULT 'user' | Role: user / admin |
| otp_code | VARCHAR | NULL | Kode OTP verifikasi email |
| otp_expires_at | TIMESTAMP | NULL | Waktu kadaluarsa OTP |
| email_verified_at | TIMESTAMP | NULL | Waktu verifikasi email |
| password | VARCHAR | NULL | Password (hash bcrypt); NULL jika login via Google |
| remember_token | VARCHAR | NULL | Token remember me (session) |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu registrasi |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu update terakhir |

---

## Tabel: kategoris

Menyimpan kategori barang yang tersedia untuk disewakan.

| Kolom | Tipe Data | Constraint | Keterangan |
|-------|-----------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | ID unik kategori |
| nama_kategori | VARCHAR | NOT NULL | Nama kategori barang |
| deskripsi | TEXT | NULL | Deskripsi kategori |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu data dibuat |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu update terakhir |

---

## Tabel: barangs

Menyimpan data barang yang ditawarkan untuk disewakan oleh pengguna (pemilik).

| Kolom | Tipe Data | Constraint | Keterangan |
|-------|-----------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | ID unik barang |
| user_id | BIGINT | FK → users.id, NOT NULL | ID pemilik barang |
| kategori_id | BIGINT | FK → kategoris.id, NOT NULL | ID kategori barang |
| nama_barang | VARCHAR | NOT NULL | Nama barang |
| deskripsi | TEXT | NOT NULL | Deskripsi detail barang |
| harga_sewa | DECIMAL | NOT NULL | Harga sewa per periode |
| harga_jaminan | DECIMAL | NOT NULL | Uang jaminan yang dibebankan |
| harga_denda_perjam | DECIMAL | NOT NULL | Denda keterlambatan per jam |
| stok | INT | DEFAULT 1 | Jumlah stok tersedia |
| lokasi | VARCHAR | NOT NULL | Lokasi barang (kota) |
| foto_barang | VARCHAR | NOT NULL | Path foto barang |
| status | ENUM | DEFAULT 'tersedia' | Status barang (tersedia/disewa/dll) |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu data dibuat |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu update terakhir |

---

## Tabel: keranjangs

Menyimpan data keranjang sewa pengguna sebelum transaksi dikonfirmasi. Tabel ini merupakan tambahan baru yang tidak ada di versi sebelumnya.

| Kolom | Tipe Data | Constraint | Keterangan |
|-------|-----------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | ID unik keranjang |
| user_id | BIGINT | FK → users.id, NOT NULL | ID pengguna penyewa |
| barang_id | BIGINT | FK → barangs.id, NOT NULL | ID barang yang dimasukkan |
| jumlah | INT | NOT NULL | Jumlah barang yang disewa |
| tanggal_sewa | DATE | NOT NULL | Tanggal mulai sewa yang direncanakan |
| tanggal_kembali_rencana | DATE | NOT NULL | Tanggal rencana pengembalian |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu data dibuat |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu update terakhir |

---

## Tabel: pembayarans

Menyimpan data pembayaran atas transaksi penyewaan.

| Kolom | Tipe Data | Constraint | Keterangan |
|-------|-----------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | ID unik pembayaran |
| metode | ENUM | NOT NULL | Metode: transfer / e-wallet / QRIS |
| detail_metode | VARCHAR | NULL | Detail metode (BCA, OVO, dll) |
| tanggal_bayar | TIMESTAMP | NULL | Waktu pembayaran dilakukan |
| jumlah_bayar | DECIMAL | NOT NULL | Nominal total pembayaran |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu data dicatat |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu update terakhir |

---

## Tabel: transaksi_penyewaans

Menyimpan data transaksi penyewaan barang. Tabel ini berelasi ke pembayarans melalui FK `pembayaran_id`, sehingga pembayaran dibuat lebih dahulu sebelum transaksi dikonfirmasi.

| Kolom | Tipe Data | Constraint | Keterangan |
|-------|-----------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | ID unik transaksi |
| user_id | BIGINT | FK → users.id, NOT NULL | ID penyewa |
| barang_id | BIGINT | FK → barangs.id, NOT NULL | ID barang yang disewa |
| pembayaran_id | BIGINT | FK → pembayarans.id, NOT NULL | ID pembayaran terkait |
| jumlah | INT | NOT NULL | Jumlah barang yang disewa |
| tanggal_sewa | DATE | NOT NULL | Tanggal mulai sewa |
| tanggal_kembali_rencana | DATE | NOT NULL | Rencana tanggal kembali |
| tanggal_kembali_aktual | DATE | NULL | Tanggal aktual pengembalian |
| status | ENUM | NOT NULL | Status transaksi (proses/selesai/dll) |
| foto_buktipengembalian | VARCHAR | NULL | Foto bukti pengembalian barang |
| tanggal_verifikasipengembalian | TIMESTAMP | NULL | Waktu verifikasi pengembalian oleh owner |
| total_harga | DECIMAL | NOT NULL | Total biaya sewa |
| jam_terlambat | INT | DEFAULT 0 | Jumlah jam keterlambatan |
| total_denda | DECIMAL | DEFAULT 0 | Total denda keterlambatan |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu transaksi dibuat |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu update terakhir |

---

## Tabel: reviews

Menyimpan ulasan dan rating dari penyewa setelah transaksi selesai.

| Kolom | Tipe Data | Constraint | Keterangan |
|-------|-----------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | ID unik review |
| transaksi_id | BIGINT | FK → transaksi_penyewaans.id | ID transaksi yang diulas |
| user_id | BIGINT | FK → users.id, NOT NULL | ID pengguna pemberi review |
| barang_id | BIGINT | FK → barangs.id, NOT NULL | ID barang yang diulas |
| rating | INT | CHECK (1–5), NOT NULL | Nilai rating (1–5 bintang) |
| komentar | TEXT | NULL | Komentar / ulasan teks |
| foto_review | VARCHAR | NULL | Foto pendukung ulasan |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu review dibuat |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu update terakhir |

---

## Tabel: web_reviews

Menyimpan ulasan pengguna terkait platform SEWAIN.

| Kolom | Tipe Data | Constraint | Keterangan |
|-------|-----------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | ID unik review platform |
| user_id | BIGINT | FK → users.id, NOT NULL | ID pengguna |
| rating | TINYINT | CHECK (1–5), NOT NULL | Rating (1–5) |
| ulasan | TEXT | NULL | Ulasan tertulis pengguna |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu data dibuat |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu update terakhir |

---

## Tabel: activity_logs

Menyimpan catatan riwayat aktivitas pengguna.

| Kolom | Tipe Data | Constraint | Keterangan |
|-------|-----------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | ID log aktivitas |
| user_id | BIGINT | FK → users.id, NOT NULL | ID pengguna terkait |
| action | VARCHAR | NOT NULL | Jenis aktivitas (contoh: login) |
| description | TEXT | NULL | Detail deskripsi aktivitas |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu aktivitas dicatat |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu update terakhir |

---

## Tabel: orders

Menyimpan data ringkasan order ketika checkout, sebelum pembayaran lunas/transaksi selesai dibuat.

| Kolom | Tipe Data | Constraint | Keterangan |
|-------|-----------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | ID unik order |
| user_id | BIGINT | FK → users.id, NULL | ID pengguna pembuat order |
| first_name | VARCHAR | NOT NULL | Nama depan pemesan |
| last_name | VARCHAR | NOT NULL | Nama belakang pemesan |
| email | VARCHAR | NOT NULL | Email pemesan |
| phone | VARCHAR | NOT NULL | Nomor telepon pemesan |
| address | TEXT | NULL | Alamat pengiriman |
| city | VARCHAR | NULL | Kota pengiriman |
| kode_pos | VARCHAR | NULL | Kode pos |
| shipping_method | VARCHAR | NULL | Metode pengiriman/pengambilan |
| cart_json | TEXT | NULL | Data keranjang dalam format JSON |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu order dibuat |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu update terakhir |

---

## Relasi Antar Tabel

| Relasi | Kardinalitas | Keterangan |
|--------|-------------|------------|
| users → barangs | 1 : N | Satu pengguna dapat memiliki banyak barang |
| users → keranjangs | 1 : N | Satu pengguna dapat memiliki banyak item keranjang |
| users → transaksi_penyewaans | 1 : N | Satu pengguna dapat melakukan banyak transaksi sewa |
| users → reviews | 1 : N | Satu pengguna dapat memberikan banyak review |
| users → web_reviews | 1 : N | Satu pengguna dapat memberikan banyak ulasan platform |
| users → activity_logs | 1 : N | Satu pengguna dapat memiliki banyak catatan aktivitas |
| users → orders | 1 : N | Satu pengguna dapat membuat banyak order checkout |
| kategoris → barangs | 1 : N | Satu kategori memiliki banyak barang |
| barangs → keranjangs | 1 : N | Satu barang dapat masuk ke banyak keranjang |
| barangs → transaksi_penyewaans | 1 : N | Satu barang dapat disewa dalam banyak transaksi |
| barangs → reviews | 1 : N | Satu barang dapat memiliki banyak review |
| pembayarans → transaksi_penyewaans | 1 : N | 1 pembayaran dapat mencakup banyak transaksi multi-barang |
| transaksi_penyewaans → reviews | 1 : 1 | Satu transaksi hanya memiliki satu review |

---

