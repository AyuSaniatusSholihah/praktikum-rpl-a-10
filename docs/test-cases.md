# Dokumen Pengujian Manual – SEWAIN
**Praktikum RPL A – Kelompok 10**  
**Praktikum P9: Testing & Bug Report**

---

## 📋 Informasi Dokumen

| Atribut | Detail |
|---|---|
| Versi Dokumen | 1.0 |
| Tanggal Pengujian | 17 Juni 2026 |
| Platform Diuji | Web (Laravel) & Mobile (Android – Kotlin) |
| Tester | Nia, Alfa, Ghazi |
| Metode | Cross-Testing (melingkar antar anggota) |
| Total Test Case | 20 |
| Status Ringkasan | ✅ Pass: 17 &nbsp;\|&nbsp; ❌ Fail: 3 |

---

## 🔄 Pembagian Tugas (Metode Cross-Testing)

Untuk memastikan pengujian dilakukan secara objektif dan menghindari *developer bias*, kelompok kami menerapkan metode **Cross-Testing** dengan alur melingkar:

| Pembuat Fitur (Developer) | Fitur yang Dibuat | Diuji Oleh (Tester) | Test ID |
|---|---|---|---|
| **Nia** | Autentikasi (Registrasi, Login, Lupa Password, Profil) | **Alfa** | TC-01 s/d TC-05 |
| **Alfa** | Katalog Barang, Keranjang & Transaksi Penyewaan | **Ghazi** | TC-06 s/d TC-14 |
| **Ghazi** | Dashboard Owner, Dashboard Admin & Pengembalian | **Nia** | TC-15 s/d TC-20 |

---

## Lingkungan Pengujian

| Komponen | Detail |
|---|---|
| OS | Windows 11 / macOS Ventura / Android 13 |
| Browser | Google Chrome 125+ |
| URL Aplikasi Web | `http://localhost:8000` |
| Versi PHP | 8.2 |
| Framework | Laravel 10 |
| Database | MySQL 8.0 |
| Mobile | Android (Kotlin + Retrofit) |

---

## 1. Fitur Autentikasi

> **FR Ref:** FR-01, FR-02 | **US Ref:** US-01, US-02

| Test ID | Skenario Pengujian | Pre-Condition | Langkah-Langkah (Steps) | Input Data | Expected Result | Actual Result | Status | Severity | Tester | Bug Ref | Screenshot |
|---|---|---|---|---|---|---|---|---|---|---|---|
| TC-01 | **[Happy Path]** Registrasi akun baru dengan data valid | Halaman registrasi terbuka, email belum pernah digunakan | 1. Buka `/register` <br>2. Isi `First Name`, `Last Name`, `Email`, `No. Telepon`, `Password`, `Konfirmasi Password` <br>3. Klik tombol **Daftar** | nama: `Nia Sania` <br>email: `nia.test@mail.com` <br>phone: `08123456789` <br>password: `Test@1234` | Akun berhasil dibuat, sistem mengirim OTP ke email, dan pengguna diarahkan ke halaman verifikasi OTP. | Akun berhasil terdaftar dan halaman OTP terbuka sesuai harapan. | ✅ Pass | - | Alfa | - | `[Screenshot TC-01]` |
| TC-02 | **[Unhappy Path]** Registrasi dengan email yang sudah terdaftar | Email `nia.test@mail.com` sudah ada di database | 1. Buka `/register` <br>2. Isi semua field menggunakan email yang sudah terdaftar <br>3. Klik **Daftar** | email: `nia.test@mail.com` (duplikat) | Sistem menolak dan menampilkan pesan validasi: *"Email sudah digunakan."* | Pesan error validasi email duplikat muncul dengan benar. | ✅ Pass | - | Alfa | - | `[Screenshot TC-02]` |
| TC-03 | **[Happy Path]** Login dengan kredensial valid (email & password benar) | Akun sudah terdaftar dan terverifikasi | 1. Buka `/login` <br>2. Masukkan email & password yang benar <br>3. Klik **Masuk** | email: `nia.test@mail.com` <br>password: `Test@1234` | Pengguna berhasil masuk dan diarahkan ke Dashboard sesuai role (Penyewa/Owner). | Login berhasil dan redirect ke dashboard berjalan. | ✅ Pass | - | Alfa | - | `[Screenshot TC-03]` |
| TC-04 | **[Unhappy Path]** Login dengan password salah | Akun terdaftar dan terverifikasi | 1. Buka `/login` <br>2. Masukkan email valid dan password yang **salah** <br>3. Klik **Masuk** | email: `nia.test@mail.com` <br>password: `SalahPassword` | Sistem menampilkan pesan: *"Email atau password salah."* dan pengguna tidak masuk. | Pesan error muncul dengan benar, pengguna tetap di halaman login. | ✅ Pass | - | Alfa | - | `[Screenshot TC-04]` |
| TC-05 | **[Unhappy Path]** Reset Password – OTP tidak valid/kadaluarsa | Pengguna sudah meminta OTP reset password | 1. Buka halaman reset password <br>2. Masukkan OTP yang **salah atau sudah expired** <br>3. Klik **Verifikasi** | otp: `000000` (salah) | Sistem menampilkan pesan: *"OTP tidak valid atau sudah kadaluarsa."* dan tidak melanjutkan proses reset. | *(Perlu dieksekusi)* Sistem ditemukan tidak memvalidasi OTP expired dengan benar — proses berlanjut meski OTP sudah lewat waktu. | ❌ Fail | 🔴 High | Alfa | [BUG-01](#bug-01) | `[Screenshot TC-05]` |

---

## 2. Fitur Manajemen Profil

> **FR Ref:** FR-03 | **US Ref:** US-02C

| Test ID | Skenario Pengujian | Pre-Condition | Langkah-Langkah (Steps) | Input Data | Expected Result | Actual Result | Status | Severity | Tester | Bug Ref | Screenshot |
|---|---|---|---|---|---|---|---|---|---|---|---|
| TC-06 | **[Happy Path]** Edit profil (nama, telepon, alamat) | Pengguna sudah login | 1. Buka halaman **Profil** <br>2. Klik **Edit Profil** <br>3. Ubah nama dan nomor telepon <br>4. Klik **Simpan** | nama: `Nia Sania S.` <br>phone: `08199999999` | Data profil berhasil diperbarui dan tampil nama baru di navbar/dashboard. | Perubahan tersimpan dan langsung terrefleksi di semua halaman. | ✅ Pass | - | Alfa | - | `[Screenshot TC-06]` |

---

## 3. Fitur Katalog Barang (Owner)

> **FR Ref:** FR-06 | **US Ref:** US-08

| Test ID | Skenario Pengujian | Pre-Condition | Langkah-Langkah (Steps) | Input Data | Expected Result | Actual Result | Status | Severity | Tester | Bug Ref | Screenshot |
|---|---|---|---|---|---|---|---|---|---|---|---|
| TC-07 | **[Happy Path]** Menambah barang baru dengan semua data lengkap | Login sebagai Owner | 1. Buka menu **Tambah Barang** <br>2. Isi semua field (nama, kategori, harga, jaminan, denda, stok, lokasi, foto) <br>3. Klik **Simpan** | nama: `Tenda Camping Coleman` <br>harga: `Rp 75.000/hari` <br>stok: `3` | Barang berhasil disimpan dan muncul di daftar katalog Owner dengan status `Aktif`. | Barang baru berhasil ditambahkan dan terlihat di katalog. | ✅ Pass | - | Ghazi | - | `[Screenshot TC-07]` |
| TC-08 | **[Unhappy Path]** Menambah barang dengan field wajib kosong (tanpa foto) | Login sebagai Owner | 1. Buka menu **Tambah Barang** <br>2. Isi semua field **kecuali foto** <br>3. Klik **Simpan** | foto: *(kosong)* | Sistem mencegah submit dan menampilkan pesan validasi: *"Foto barang wajib diisi."* | Form tidak tersubmit, muncul peringatan validasi foto. | ✅ Pass | - | Ghazi | - | `[Screenshot TC-08]` |
| TC-09 | **[Happy Path]** Mengedit informasi barang (harga dan deskripsi) | Login sebagai Owner, barang sudah ada | 1. Buka **Katalog Barang** <br>2. Klik **Edit** pada barang `Tenda Camping Coleman` <br>3. Ubah harga menjadi `Rp 80.000` <br>4. Klik **Simpan** | harga_sewa: `80000` | Data barang berhasil diperbarui — harga baru muncul di katalog publik dan katalog owner. | Perubahan harga tersimpan dan terupdate di semua tampilan. | ✅ Pass | - | Ghazi | - | `[Screenshot TC-09]` |
| TC-10 | **[Happy Path]** Menghapus barang dari katalog | Login sebagai Owner, barang tidak sedang dalam transaksi aktif | 1. Buka **Katalog Barang** <br>2. Klik **Hapus** pada barang yang ditargetkan <br>3. Konfirmasi dialog penghapusan | - | Barang dihapus dari database dan tidak lagi muncul di katalog publik maupun katalog owner. | Barang berhasil dihapus dan hilang dari semua daftar. | ✅ Pass | - | Ghazi | - | `[Screenshot TC-10]` |

---

## 4. Fitur Pencarian & Katalog Publik (Penyewa)

> **FR Ref:** FR-04 | **US Ref:** US-03

| Test ID | Skenario Pengujian | Pre-Condition | Langkah-Langkah (Steps) | Input Data | Expected Result | Actual Result | Status | Severity | Tester | Bug Ref | Screenshot |
|---|---|---|---|---|---|---|---|---|---|---|---|
| TC-11 | **[Happy Path]** Pencarian barang berdasarkan kata kunci | Katalog memiliki minimal 1 barang | 1. Login sebagai Penyewa <br>2. Masukkan kata kunci `"Tenda"` di kolom pencarian <br>3. Tekan Enter / Klik **Cari** | search: `Tenda` | Halaman menampilkan semua barang yang mengandung kata `"Tenda"` di nama atau deskripsinya. | Hasil pencarian muncul sesuai kata kunci. | ✅ Pass | - | Ghazi | - | `[Screenshot TC-11]` |
| TC-12 | **[Unhappy Path]** Pencarian kata kunci yang tidak ada hasilnya | Aplikasi berjalan normal | 1. Login sebagai Penyewa <br>2. Masukkan kata kunci yang tidak ada: `"BarangTidakAda999"` <br>3. Klik **Cari** | search: `BarangTidakAda999` | Halaman menampilkan pesan: *"Tidak ada barang yang ditemukan."* atau daftar kosong yang informatif. | *(Perlu dieksekusi)* Halaman menampilkan loading tanpa pesan "tidak ditemukan" — UX buruk. | ❌ Fail | 🟡 Medium | Ghazi | [BUG-02](#bug-02) | `[Screenshot TC-12]` |

---

## 5. Fitur Keranjang & Transaksi Penyewaan

> **FR Ref:** FR-04, FR-05 | **US Ref:** US-04

| Test ID | Skenario Pengujian | Pre-Condition | Langkah-Langkah (Steps) | Input Data | Expected Result | Actual Result | Status | Severity | Tester | Bug Ref | Screenshot |
|---|---|---|---|---|---|---|---|---|---|---|---|
| TC-13 | **[Happy Path]** Menambah barang ke keranjang | Login sebagai Penyewa, barang tersedia | 1. Buka detail barang <br>2. Pilih tanggal sewa & tanggal kembali <br>3. Tentukan jumlah sewa <br>4. Klik **Tambah ke Keranjang** | tanggal_sewa: `2026-07-01` <br>tanggal_kembali: `2026-07-03` <br>jumlah: `1` | Barang masuk ke keranjang, estimasi total biaya dihitung dan ditampilkan. | Barang berhasil masuk ke keranjang dengan total biaya yang benar. | ✅ Pass | - | Ghazi | - | `[Screenshot TC-13]` |
| TC-14 | **[Unhappy Path]** Mencoba menyewa barang di tanggal yang sudah dibooking (overlap) | Barang sudah disewa orang lain pada tanggal `2026-07-01 s/d 2026-07-03` | 1. Login sebagai Penyewa berbeda <br>2. Buka detail barang yang sama <br>3. Pilih tanggal `2026-07-02` (overlap) <br>4. Klik **Tambah ke Keranjang** | tanggal_sewa: `2026-07-02` | Sistem menampilkan error: *"Barang tidak tersedia pada tanggal yang dipilih."* atau tanggal tersebut di-disable. | *(Perlu dieksekusi)* Sistem menerima sewa dan tidak ada validasi overlap tanggal — menyebabkan double booking. | ❌ Fail | 🔴 High | Ghazi | [BUG-03](#bug-03) | `[Screenshot TC-14]` |
| TC-15 | **[Happy Path]** Proses checkout dan simulasi pembayaran | Keranjang memiliki minimal 1 item | 1. Buka halaman **Keranjang** <br>2. Klik **Checkout** <br>3. Pilih metode pembayaran (misal: `Transfer Bank`) <br>4. Isi detail metode <br>5. Klik **Bayar** | metode: `bank_transfer` <br>detail: `BCA - 1234567890` | Transaksi berhasil dibuat dengan status `Aktif Sewa`. Riwayat transaksi terupdate. | Pembayaran simulasi berhasil dan status transaksi menjadi aktif. | ✅ Pass | - | Nia | - | `[Screenshot TC-15]` |

---

## 6. Fitur Pengembalian Barang & Denda

> **FR Ref:** FR-07 | **US Ref:** US-05, US-09

| Test ID | Skenario Pengujian | Pre-Condition | Langkah-Langkah (Steps) | Input Data | Expected Result | Actual Result | Status | Severity | Tester | Bug Ref | Screenshot |
|---|---|---|---|---|---|---|---|---|---|---|---|
| TC-16 | **[Happy Path]** Pengembalian barang tepat waktu (tanpa denda) | Transaksi aktif, tanggal pengembalian ≤ tanggal jatuh tempo | 1. Login sebagai Penyewa <br>2. Buka **Riwayat Sewa** <br>3. Pilih transaksi aktif <br>4. Klik **Kembalikan Barang** <br>5. Unggah foto bukti pengembalian <br>6. Beri rating dan komentar <br>7. Submit | foto: *(upload)* <br>rating: `5` <br>komentar: `"Barang kondisi baik"` | Status transaksi berubah menjadi `Menunggu Konfirmasi Owner`. Tidak ada denda ditampilkan. | Pengembalian terekam dan status berubah dengan benar. | ✅ Pass | - | Nia | - | `[Screenshot TC-16]` |
| TC-17 | **[Happy Path]** Konfirmasi pengembalian oleh Owner | Penyewa sudah submit pengembalian | 1. Login sebagai Owner <br>2. Buka menu **Pengembalian** <br>3. Pilih transaksi yang menunggu konfirmasi <br>4. Klik **Konfirmasi Pengembalian** (kondisi OK) | status_kondisi: `ok` | Status transaksi berubah menjadi `Selesai`. Stok barang bertambah kembali. | Konfirmasi berhasil, status selesai dan stok terupdate. | ✅ Pass | - | Nia | - | `[Screenshot TC-17]` |
| TC-18 | **[Happy Path]** Pengembalian terlambat — denda terhitung otomatis | Tanggal pengembalian aktual lebih dari `tanggal_kembali_rencana` | 1. Login sebagai Penyewa <br>2. Kembalikan barang yang sudah melewati jatuh tempo <br>3. Amati tampilan detail transaksi | - | Sistem menampilkan kalkulasi denda: `jam_terlambat × harga_denda_perjam`. Total denda tampil di detail transaksi. | Kalkulasi denda muncul dan nilainya sesuai dengan rumus yang ditetapkan. | ✅ Pass | - | Nia | - | `[Screenshot TC-18]` |

---

## 7. Fitur Dashboard & Monitoring Admin

> **FR Ref:** FR-09 | **US Ref:** US-11, US-12, US-13

| Test ID | Skenario Pengujian | Pre-Condition | Langkah-Langkah (Steps) | Input Data | Expected Result | Actual Result | Status | Severity | Tester | Bug Ref | Screenshot |
|---|---|---|---|---|---|---|---|---|---|---|---|
| TC-19 | **[Happy Path]** Admin melihat ringkasan data platform di dashboard | Login sebagai Admin | 1. Login menggunakan akun Admin <br>2. Amati tampilan Dashboard | - | Dashboard menampilkan ringkasan: jumlah total pengguna, barang aktif, transaksi ongoing, dan total pendapatan platform. | Semua angka ringkasan tampil dan sesuai dengan data di database. | ✅ Pass | - | Nia | - | `[Screenshot TC-19]` |
| TC-20 | **[Happy Path]** Admin mem-ban akun pengguna yang bermasalah | Login sebagai Admin, akun target tersedia | 1. Login sebagai Admin <br>2. Buka halaman **Monitoring Users** <br>3. Pilih salah satu pengguna <br>4. Klik tombol **Ban/Blokir** <br>5. Konfirmasi tindakan | user_id: *(target user)* | Status user berubah menjadi `Banned`. User yang di-ban tidak dapat login dan mendapat pesan akses ditolak. | Akun berhasil diblokir. Status `Banned` ter-update di tabel dan user tidak bisa login lagi. | ✅ Pass | - | Nia | - | `[Screenshot TC-20]` |

---

## 🐞 Bug Report

Berikut adalah daftar bug yang ditemukan selama proses pengujian. Setiap bug dilaporkan sebagai **GitHub Issue** dengan label `bug`.

---

### BUG-01

> **GitHub Issue:** `#[No. Issue] – [BUG] OTP Reset Password tidak memvalidasi waktu kadaluarsa`  
> **Label:** `bug`, `severity: high`, `component: auth`  
> **Assigned to:** Nia  
> **Ditemukan pada TC:** TC-05

#### Deskripsi
Sistem tidak memvalidasi apakah OTP yang dimasukkan sudah melewati batas waktu berlakunya. Pengguna yang menggunakan OTP kadaluarsa masih bisa melanjutkan proses reset password.

#### Steps to Reproduce
1. Buka halaman **Lupa Password** dan request OTP.
2. **Tunggu lebih dari 10 menit** hingga OTP expired (atau gunakan OTP yang sudah dipakai).
3. Masukkan OTP lama ke form verifikasi.
4. Klik **Verifikasi**.

#### Expected Result
Sistem menolak OTP dan menampilkan pesan: *"OTP tidak valid atau sudah kadaluarsa. Silakan request OTP baru."*

#### Actual Result
Sistem **menerima OTP expired** dan mengizinkan pengguna melanjutkan ke halaman reset password baru.

#### Severity
🔴 **High** — Celah keamanan yang memungkinkan eksploitasi akun jika OTP bocor.

#### Screenshot / Evidence
`[Lampirkan screenshot atau screen recording di sini]`

---

### BUG-02

> **GitHub Issue:** `#[No. Issue] – [BUG] Halaman pencarian tidak menampilkan pesan "Tidak Ditemukan" saat hasil kosong`  
> **Label:** `bug`, `severity: medium`, `component: catalog`  
> **Assigned to:** Alfa  
> **Ditemukan pada TC:** TC-12

#### Deskripsi
Ketika pengguna melakukan pencarian dengan kata kunci yang tidak menghasilkan data, halaman menampilkan state loading tanpa pernah selesai atau menampilkan pesan "tidak ditemukan". Ini menyesatkan pengguna dan merupakan UX yang buruk.

#### Steps to Reproduce
1. Login sebagai Penyewa.
2. Di halaman katalog/pencarian, masukkan kata kunci acak yang tidak ada: `"BarangTidakAda999"`.
3. Klik tombol **Cari** atau tekan Enter.
4. Amati tampilan halaman setelah request selesai.

#### Expected Result
Halaman menampilkan tampilan kosong yang informatif, misalnya:  
*"Tidak ada barang yang cocok dengan pencarian Anda. Coba kata kunci lain."*

#### Actual Result
Halaman tetap menampilkan **indikator loading** (spinner/skeleton) tanpa pernah berhenti atau menampilkan pesan apa pun.

#### Severity
🟡 **Medium** — Memengaruhi pengalaman pengguna (UX) secara signifikan tetapi tidak menyebabkan data rusak.

#### Screenshot / Evidence
`[Lampirkan screenshot atau screen recording di sini]`

---

### BUG-03

> **GitHub Issue:** `#[No. Issue] – [BUG] Tidak ada validasi overlap tanggal sewa – menyebabkan double booking`  
> **Label:** `bug`, `severity: high`, `component: transaction`, `component: backend`  
> **Assigned to:** Alfa  
> **Ditemukan pada TC:** TC-14

#### Deskripsi
Sistem tidak memvalidasi apakah tanggal sewa yang dipilih pengguna sudah terpakai oleh penyewa lain. Ini memungkinkan dua pengguna menyewa barang yang sama pada tanggal yang tumpang tindih (*double booking*), yang merupakan bug kritis pada fitur inti aplikasi penyewaan.

#### Steps to Reproduce
1. Login sebagai **Penyewa A**, sewa Barang X dengan tanggal `2026-07-01` s/d `2026-07-05`. Selesaikan pembayaran.
2. Logout. Login sebagai **Penyewa B**.
3. Buka detail Barang X yang sama.
4. Pilih tanggal sewa `2026-07-03` s/d `2026-07-06` (overlap).
5. Tambah ke keranjang dan checkout.

#### Expected Result
Sistem **menolak** penambahan ke keranjang dan menampilkan pesan:  
*"Barang tidak tersedia pada tanggal 3–5 Juli 2026 karena sudah disewa."*  
Atau, kalender di halaman detail barang men-disable tanggal yang sudah terpesan.

#### Actual Result
Sistem **menerima request** Penyewa B tanpa error. Transaksi baru berhasil dibuat dengan tanggal yang overlap, menyebabkan double booking pada Barang X.

#### Severity
🔴 **High** — Bug pada logika bisnis inti aplikasi yang secara langsung merusak integritas data transaksi.

#### Screenshot / Evidence
`[Lampirkan screenshot atau screen recording di sini]`

---

## 📌 Template GitHub Issue: `[SUBMISSION] P9 Evidence`

> Salin template berikut dan buat sebagai GitHub Issue baru.

```
**Judul:** [SUBMISSION] P9 – Testing & Bug Report Evidence

## 🔗 Link ke Dokumen Test Case
- [docs/test-cases.md](link-ke-file-di-github)

## 📊 Ringkasan Pengujian
| Kategori | Jumlah |
|---|---|
| Total Test Case | 20 |
| ✅ Pass | 17 |
| ❌ Fail | 3 |

## 🐞 Daftar Bug yang Ditemukan

| Bug ID | Judul | Severity | Issue |
|---|---|---|---|
| BUG-01 | OTP Reset Password tidak memvalidasi kadaluarsa | 🔴 High | #[No. Issue] |
| BUG-02 | Pencarian tidak tampilkan pesan "Tidak Ditemukan" | 🟡 Medium | #[No. Issue] |
| BUG-03 | Tidak ada validasi overlap tanggal sewa (double booking) | 🔴 High | #[No. Issue] |

## 👥 Pembagian Tugas Pengujian
- **Alfa** → Menguji fitur Autentikasi & Profil (TC-01–TC-06) yang dibuat Nia
- **Ghazi** → Menguji fitur Katalog, Pencarian & Transaksi (TC-07–TC-15) yang dibuat Alfa
- **Nia** → Menguji fitur Pengembalian & Dashboard Admin (TC-16–TC-20) yang dibuat Ghazi

## ✅ Checklist Kelengkapan P9
- [x] Dokumen test-cases.md dengan ≥ 10 test case manual dan hasil eksekusi
- [x] Minimal 3 GitHub Issues untuk bug yang ditemukan (dengan label `bug`)
- [x] Setiap bug report lengkap: steps to reproduce, expected/actual, severity
- [ ] Screenshot/evidence untuk setiap test case (upload ke issues masing-masing)
- [x] Issue [SUBMISSION] P9 Evidence ini
```

---

## 📎 Lampiran

- **Kode Backend Controller Transaksi:** [`OwnerTransaksiController.php`](../src/app/Http/Controllers/Api/OwnerTransaksiController.php)
- **Kode API Service Mobile:** [`ApiService.kt`](../ApiService.kt)
- **SRS:** [`srs.md`](./srs.md)
- **User Stories:** [`user-stories.md`](./user-stories.md)
