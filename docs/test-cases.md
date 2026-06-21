# Dokumen Pengujian Manual – SEWAIN
**Praktikum RPL A – Kelompok 09**  
**Praktikum P9: Testing & Bug Report**

---

## 📋 Informasi Dokumen

| Atribut | Detail |
|---|---|
| Versi Dokumen | 1.0 |
| Tanggal Pengujian | 21 Juni 2026 |
| Platform Diuji | Web Application (Laravel, MySQL) |
| Tester | Nia, Alfa, Ghazi |
| Metode | Cross-Testing (Melingkar antar anggota tim) |
| Total Test Case | 18 |
| Status Ringkasan | ✅ Pass: 15 &nbsp;\|&nbsp; ❌ Fail: 3 |

---

## 🔄 Pembagian Tugas (Metode Cross-Testing)

Untuk memastikan pengujian dilakukan secara objektif dan menghindari *developer bias*, kelompok kami menerapkan metode **Cross-Testing** dengan alur pengujian silang antar anggota tim:

| Pembuat Fitur (Developer) | Fitur yang Dibuat | Diuji Oleh (Tester) | Test ID |
|---|---|---|---|
| **Nia** | Autentikasi & Manajemen Profil | **Alfa** | TC-01 s/d TC-05, TC-10 |
| **Alfa** | Katalog Barang & Transaksi Penyewaan | **Ghazi** | TC-06 s/d TC-09, TC-11, TC-12 |
| **Ghazi** | Pengembalian, Denda & Dashboard Admin | **Nia** | TC-13 s/d TC-18 |

---

## 💻 Lingkungan Pengujian

| Komponen | Detail |
|---|---|
| OS | Windows 11 / Linux / macOS |
| Browser | Google Chrome / Mozilla Firefox (Versi Terbaru) |
| URL Aplikasi Web | `http://localhost:8000` |
| Database | MySQL & phpMyAdmin |
| Version Control | Git & GitHub |
| Environment File | `.env` Configuration |

---

## 🔐 1. Fitur Autentikasi & Profil

> **Skenario:** Pengujian alur registrasi, login, dan pengubahan profil pengguna.

| Test ID | Skenario Pengujian | Pre-Condition | Langkah-Langkah (Steps) | Input Data | Expected Result | Actual Result | Status | Severity | Tester | Bug Ref | Screenshot |
|---|---|---|---|---|---|---|---|---|---|---|---|
| TC-01 | **[Happy Path]** Registrasi akun baru dengan data valid | Halaman registrasi terbuka, email belum pernah digunakan | 1. Buka halaman `/register`<br>2. Isi data lengkap form registrasi<br>3. Klik tombol **Daftar** | nama: `Nia Sania`<br>email: `nia.test@mail.com` | Akun berhasil dibuat, sistem mengirim OTP ke email, dan pengguna diarahkan ke verifikasi. | Akun berhasil dibuat, OTP terkirim, dan diarahkan ke verifikasi. | ✅ Pass | - | Alfa | - | `[Screenshot TC-01]` |
| TC-02 | **[Unhappy Path]** Registrasi dengan email duplikat | Email `nia.test@mail.com` sudah terdaftar di database | 1. Buka halaman `/register`<br>2. Isi form dengan email yang sudah ada<br>3. Klik **Daftar** | email: `nia.test@mail.com` (duplikat) | Mencegah pendaftaran ulang menggunakan email yang sama dengan memberikan pesan peringatan. | Sistem menolak registrasi dan menampilkan pesan "Akun ini telah terdaftar". | ✅ Pass | - | Alfa | - | `[Screenshot TC-02]` |
| TC-03 | **[Happy Path]** Login dengan kredensial valid | Akun pengguna dan admin sudah terdaftar di sistem | 1. Buka halaman `/login`<br>2. Masukkan email & password yang benar<br>3. Klik **Masuk** | **User:** `nia.test@mail.com`<br>**Admin:** `admin@sewain.com` | Pengguna/Admin berhasil masuk ke sistem dan diarahkan ke dashboard sesuai hak akses (role). | Berhasil login dan diarahkan ke dashboard masing-masing role secara akurat. | ✅ Pass | - | Alfa | - | `[Screenshot TC-03]` |
| TC-04 | **[Unhappy Path]** Login dengan password salah | Akun target sudah terdaftar di database | 1. Buka halaman `/login`<br>2. Masukkan email benar, isi password salah<br>3. Klik **Masuk** | email: `nia.test@mail.com`<br>password: `salah123` | Mencegah login masuk ke sistem dan memunculkan notifikasi kesalahan kredensial. | Akses ditolak sistem dan muncul pesan peringatan "Email atau password salah". | ✅ Pass | - | Alfa | - | `[Screenshot TC-04]` |
| TC-05 | **[Happy Path]** Edit profil pengguna | Pengguna sudah dalam posisi login | 1. Masuk ke halaman profil<br>2. Ubah data nama & nomor telepon<br>3. Klik tombol **Simpan** | nama: `Nia Sania S.`<br>phone: `0812345678` | Pengubahan data berhasil disimpan dan langsung ter-refresh secara konsisten di seluruh halaman aplikasi. | Perubahan berhasil disimpan dan langsung ter-refresh di seluruh halaman informasi profil. | ✅ Pass | - | Alfa | - | `[Screenshot TC-05]` |
| TC-10 | **[Unhappy Path]** Verifikasi OTP kadaluarsa saat registrasi akun baru | Pengguna selesai mendaftar, kode OTP sudah terkirim ke email | 1. Selesaikan form registrasi<br>2. Tunggu > 10 menit (OTP kadaluarsa)<br>3. Masukkan OTP usang tersebut<br>4. Klik **Verifikasi** | otp: *(kode kadaluarsa > 10 menit)* | Sistem menolak kode OTP usang tersebut, mengunci aktivasi akun, dan meminta kirim ulang kode baru. | **[BUG-01]** Sistem meloloskan registrasi dan akun bisa langsung login tanpa perlu verifikasi OTP yang valid. | ❌ Fail | 🔴 High | Alfa | [BUG-01](#bug-01-otp-verifikasi-akun-tidak-memvalidasi-waktu-kadaluarsa) | `[Screenshot TC-10]` |

---

## 📦 2. Fitur Katalog Barang (Owner & Penyewa)

> **Skenario:** Pengujian penambahan produk, manajemen produk oleh Owner, serta pencarian produk oleh Penyewa.

| Test ID | Skenario Pengujian | Pre-Condition | Langkah-Langkah (Steps) | Input Data | Expected Result | Actual Result | Status | Severity | Tester | Bug Ref | Screenshot |
|---|---|---|---|---|---|---|---|---|---|---|---|
| TC-06 | **[Happy Path]** Menambah barang baru dengan data lengkap | Login sebagai Owner platform | 1. Masuk menu tambah barang<br>2. Isi seluruh field data produk secara lengkap<br>3. Klik **Simpan** | produk: `Tenda Camping Coleman`<br>stok: `3` | Produk baru tersimpan di database dan langsung tayang di katalog umum dengan status Aktif. | Barang tersimpan di database dan muncul di katalog dengan status Aktif. | ✅ Pass | - | Ghazi | - | `[Screenshot TC-06]` |
| TC-07 | **[Unhappy Path]** Tambah barang tanpa mengunggah foto | Login sebagai Owner platform | 1. Masuk menu tambah barang<br>2. Isi semua field data **kecuali** foto produk<br>3. Klik **Simpan** | foto: *(dikosongkan)* | Validasi field wajib terpenuhi; sistem menolak submit form dan mengeluarkan pesan kesalahan. | Sistem menolak submit dan memunculkan error "Foto barang wajib diisi". | ✅ Pass | - | Ghazi | - | `[Screenshot TC-07]` |
| TC-08 | **[Happy Path]** Mengedit nominal harga sewa barang | Login sebagai Owner, barang sudah terbit | 1. Pilih barang di katalog<br>2. Klik Edit → Ubah nominal harga sewa<br>3. Klik **Simpan** | harga_baru: `Rp 80.000` | Harga sewa baru tersimpan dan langsung berubah di katalog publik & halaman owner. | Harga baru berhasil disimpan dan ter-update di katalog publik & owner. | ✅ Pass | - | Ghazi | - | `[Screenshot TC-08]` |
| TC-09 | **[Happy Path]** Menghapus barang dari daftar katalog | Login sebagai Owner, barang tidak dalam transaksi | 1. Buka katalog Owner<br>2. Klik tombol **Hapus** pada produk target<br>3. Konfirmasi hapus | produk: `Tenda Camping Coleman` | Produk terhapus secara permanen dari database dan menghilang dari seluruh list katalog. | Barang berhasil dihapus dan hilang dari semua daftar tampilan produk. | ✅ Pass | - | Ghazi | - | `[Screenshot TC-09]` |
| TC-11 | **[Happy Path]** Cari barang dengan kata kunci cocok | Minimal ada 1 produk mengandung kata terkait | 1. Login sebagai Penyewa<br>2. Ketik kata kunci di kolom pencarian<br>3. Tekan Enter / Cari | kata_kunci: `"Tenda"` | Sistem memfilter halaman dan menampilkan seluruh barang yang namanya mengandung kata pencarian. | Halaman menampilkan seluruh barang yang namanya mengandung kata "Tenda". | ✅ Pass | - | Ghazi | - | `[Screenshot TC-11]` |

---

## 🛒 3. Fitur Keranjang & Transaksi Penyewaan

> **Skenario:** Pengujian alur transaksi mulai dari memilih barang hingga checkout pembayaran.

| Test ID | Skenario Pengujian | Pre-Condition | Langkah-Langkah (Steps) | Input Data | Expected Result | Actual Result | Status | Severity | Tester | Bug Ref | Screenshot |
|---|---|---|---|---|---|---|---|---|---|---|---|
| TC-12 | **[Happy Path]** Menambah barang ke dalam keranjang | Login sebagai Penyewa, stok barang tersedia | 1. Buka detail barang<br>2. Pilih tanggal sewa & isi kuantitas<br>3. Klik **Tambah ke Keranjang** | kuantitas: `1` | Barang sukses masuk ke keranjang sewa, total biaya sewa terhitung otomatis. | Barang masuk keranjang dan estimasi total biaya otomatis terhitung oleh sistem. | ✅ Pass | - | Ghazi | - | `[Screenshot TC-12]` |
| TC-13 | **[Unhappy Path]** Proteksi/Validasi overlap tanggal sewa (Double Booking) | Barang target sudah dibooking penyewa lain pada tanggal terpilih | 1. Login sebagai Penyewa lain<br>2. Pilih barang yang sama<br>3. Set tanggal sewa yang bertabrakan<br>4. Klik **Checkout** | tanggal: `03-05 Juli 2026` (overlap) | Sistem mendeteksi tabrakan tanggal, mengeluarkan error validasi, dan memblokir order. | **[BUG-02]** Sistem menerima transaksi tanpa validasi overlap tanggal, memicu double booking barang. | ❌ Fail | 🔴 High | Nia | [BUG-02](#bug-02-tidak-ada-validasi-overlap-tanggal-sewa-menyebabkan-double-booking) | `[Screenshot TC-13]` |
| TC-14 | **[Happy Path]** Checkout dan simulasi pembayaran | Ada barang mengendap di dalam keranjang belanja | 1. Buka halaman keranjang<br>2. Klik tombol **Checkout**<br>3. Lakukan pembayaran via QRIS | metode: `QRIS` | Transaksi invoice berhasil di-generate di database dengan status awal "Aktif Sewa". | Transaksi berhasil dibuat dengan status awal "Aktif Sewa". | ✅ Pass | - | Nia | - | `[Screenshot TC-14]` |

---

## ↩️ 4. Fitur Pengembalian Barang, Denda & Admin

> **Skenario:** Pengujian pasca-penyewaan, kalkulasi denda, pemulihan stok, serta dashboard monitoring admin.

| Test ID | Skenario Pengujian | Pre-Condition | Langkah-Langkah (Steps) | Input Data | Expected Result | Actual Result | Status | Severity | Tester | Bug Ref | Screenshot |
|---|---|---|---|---|---|---|---|---|---|---|---|
| TC-15 | **[Happy Path]** Pengembalian barang tepat waktu | Transaksi aktif, waktu pengembalian belum jatuh tempo | 1. Masuk menu transaksi aktif<br>2. Klik kembalikan, unggah foto bukti fisik produk<br>3. Kirim data | bukti_foto: `image.png` | Transaksi bertukar status menjadi "Menunggu Konfirmasi Owner" tanpa beban denda. | Status berubah menjadi "Menunggu Konfirmasi Owner" tanpa denda. | ✅ Pass | - | Nia | - | `[Screenshot TC-15]` |
| TC-16 | **[Happy Path]** Konfirmasi pengembalian barang oleh Owner | Penyewa sudah mengajukan pengembalian barang | 1. Login sebagai Owner<br>2. Buka menu pengembalian barang<br>3. Klik **Accept Pengembalian** | status: `Accept` | Status transaksi berubah jadi 'Selesai' dan kuantitas jumlah stok barang bertambah kembali (+1). | **[BUG-03]** Transaksi sukses berubah jadi 'Selesai', tetapi stok barang tertahan (tidak bertambah). | ❌ Fail | 🔴 High | Nia | [BUG-03](#bug-03-stok-barang-tidak-bertambah-kembali-setelah-owner-konfirmasi-pengembalian) | `[Screenshot TC-16]` |
| TC-17 | **[Happy Path]** Pengembalian terlambat (Denda Otomatis) | Tanggal pengembalian aktual melewati batas jatuh tempo rencana | 1. Lakukan pengembalian barang yang telat hari<br>2. Amati kalkulasi denda | keterlambatan: `> waktu tempo` | Nilai nominal denda keterlambatan muncul otomatis pada rincian transaksi secara akurat. | Kalkulasi denda muncul di detail transaksi secara akurat sesuai rumus. | ✅ Pass | - | Nia | - | `[Screenshot TC-17]` |
| TC-18 | **[Happy Path]** Admin memantau ringkasan data platform | Akun yang digunakan memiliki hak akses Admin | 1. Login sebagai Admin<br>2. Buka visualisasi ringkasan dashboard | rincian: `total users, item, dll` | Dashboard menyajikan informasi total data riil pengguna, barang, transaksi, & total omset. | Semua data ringkasan tampil sesuai dengan kondisi riil database. | ✅ Pass | - | Nia | - | `[Screenshot TC-18]` |
| TC-19 | **[Happy Path]** Admin memblokir (Ban) akun bermasalah | Ada akun pengguna terindikasi melanggar aturan | 1. Masuk menu Monitoring Users<br>2. Cari target akun → Klik tombol **Ban** | user_id: *(target user)* | Status akun berganti menjadi Banned, sistem menolak hak akses login pengguna tersebut. | Status user berubah jadi Banned dan sistem menolak akses login mereka selanjutnya. | ✅ Pass | - | Nia | - | `[Screenshot TC-19]` |

---

## 🐞 Bug Report (GitHub Issues)

Daftar bug krusial yang ditemukan selama rangkaian eksekusi praktikum pengujian manual aplikasi SEWAIN:

### BUG-01: OTP Verifikasi Akun tidak memvalidasi waktu kadaluarsa
* **Label:** `bug`, `severity: high`, `component: authentication`
* **Assigned To:** Nia
* **Ditemukan pada:** TC-10
* **Deskripsi:** Sistem tidak memeriksa batas waktu masa aktif kode OTP. Akibatnya, pengguna yang memasukkan OTP yang sudah usang/expired (> 10 menit) tetap lolos verifikasi dan akun langsung aktif tanpa hambatan keamanan. Bahkan, pengguna bisa langsung melakukan bypass login tanpa memasukkan kode verifikasi sama sekali.
* **Langkah Reproduksi:**
  1. Buka halaman registrasi, lakukan pendaftaran.
  2. Tunggu lebih dari 10 menit agar masa aktif OTP habis/kedaluwarsa.
  3. Masukkan kode OTP usang tersebut ke form verifikasi lalu klik *Verifikasi* (atau langsung coba bypass akses login).
* **Expected Result:** Sistem memblokir request, mengeluarkan pesan error kedaluwarsa, dan meminta kirim ulang kode baru.
* **Actual Result:** Akun yang terdaftar bisa langsung melakukan login melewati alur verifikasi OTP secara bebas.

### BUG-02: Tidak ada validasi overlap tanggal sewa menyebabkan double booking
* **Label:** `bug`, `severity: high`, `component: transaction-backend`
* **Assigned To:** Alfa
* **Ditemukan pada:** TC-13
* **Deskripsi:** Kerusakan logika pada backend sistem transaksi. Aplikasi mengurangi stok secara instan/permanen di database tanpa validasi berbasis rentang tanggal (schedule-based). Hal ini memicu dua masalah besar:
  1. **Double Booking:** Jika barang memiliki Stok = 2, lalu Penyewa A menyewa 1 unit (1-5 Juli) dan Penyewa B menyewa 1 unit (3-7 Juli - overlap), sistem membiarkan ini karena stok di DB masih sisa 1. Namun jika Penyewa C ingin menyewa 1 unit di tanggal 2-4 Juli (yang seharusnya masih ada 1 unit fisik tersisa karena Penyewa B belum pakai), Penyewa C akan ditolak dengan error "Stok Habis" karena stok global di DB sudah 0 akibat terkurangi transaksi Penyewa B di tanggal 10.
  2. **Salah Blokir Tanggal Aman:** Jika barang memiliki Stok = 1, sewa di tanggal 1-5 Juli akan membuat stok menjadi 0. Penyewa lain yang ingin menyewa di tanggal 10-15 Juli (tidak bentrok) akan langsung ditolak karena stok di database saat itu berstatus 0 (habis).
* **Langkah Reproduksi:**
  1. Penyewa A menyewa Tenda X untuk tanggal 1–5 Juli 2026 dan menyelesaikan pembayaran.
  2. Penyewa B masuk menggunakan akun lain, membuka produk Tenda X, lalu memilih tanggal sewa yang tabrakan yaitu 3–6 Juli 2026.
  3. Penyewa B klik Tambah ke Keranjang dan melakukan checkout.
* **Expected Result:** Sistem memvalidasi ketersediaan barang berdasarkan rentang tanggal yang dipilih dan menolak transaksi jika jumlah unit yang dipesan melebihi stok yang tersedia pada tanggal tersebut.
* **Actual Result:** Sistem mengizinkan checkout overlap (Double Booking) dan di sisi lain memblokir penyewaan di tanggal aman yang tidak overlap karena pengurangan stok dilakukan secara global seketika.

### BUG-03: Stok barang tidak bertambah kembali setelah owner konfirmasi pengembalian
* **Label:** `bug`, `severity: high`, `component: backend-logic`, `status: fixed`
* **Assigned To:** Nia
* **Ditemukan pada:** TC-16
* **Deskripsi:** Kesalahan logika backend pada fungsi `acceptPengembalian()` di `ProfileController.php`. Saat owner menyetujui pengembalian, sistem hanya mengubah status barang menjadi `'tersedia'`, tetapi lupa menambah kembali kuantitas stok barang berdasarkan jumlah unit yang disewa (`$trx->jumlah`). Akibatnya, stok berkurang secara permanen.
* **Langkah Reproduksi:**
  1. Periksa stok awal Barang X (misal: stok = 3).
  2. Terima pengembalian barang dari transaksi Penyewa yang meminjam 1 unit Barang X dengan mengklik tombol *Accept Pengembalian*.
  3. Periksa kembali jumlah fisik stok. Status berubah tersedia, namun kuantitas tidak kembali bertambah menjadi 3 (tetap tertahan di angka 2).
* **Expected Result:** Stok barang kembali bertambah secara otomatis sesuai jumlah unit yang dikembalikan.
* **Status Perbaikan:** **FIXED** (Telah diperbaiki di branch bug dengan mengintegrasikan fungsi increment stok kembali di backend controller).

---

## 📌 Template GitHub Issue: `[SUBMISSION] P9 Evidence`

```markdown
**Judul:** [SUBMISSION] P9 – Testing & Bug Report Evidence - Kelompok 09 Kelas A

## 🔗 Link ke Dokumen Test Case
- [docs/test-cases.md](link-ke-file-di-repositori-kamu)

## 📊 Ringkasan Pengujian
| Kategori | Jumlah |
|---|---|
| Total Test Case | 19 |
| ✅ Pass | 16 |
| ❌ Fail | 3 |

## 🐞 Daftar Bug yang Ditemukan
| Bug ID | Judul | Severity | Issue Link |
|---|---|---|---|
| BUG-01 | OTP Verifikasi Akun tidak memvalidasi waktu kadaluarsa | 🔴 High | #KeLinkIssue1 |
| BUG-02 | Tidak ada validasi overlap tanggal sewa (Double Booking) | 🔴 High | #KeLinkIssue2 |
| BUG-03 | Stok barang tidak bertambah setelah owner konfirmasi (FIXED) | 🔴 High | #KeLinkIssue3 |

## 👥 Pembagian Tugas Pengujian (Cross-Testing)
- **Alfa** -> Menguji Fitur Autentikasi & Manajemen Profil (TC-01 s/d TC-05, TC-10) yang dikembangkan oleh Nia.
- **Ghazi** -> Menguji Fitur Katalog Barang & Pencarian (TC-06 s/d TC-09, TC-11, TC-12) yang dikembangkan oleh Alfa.
- **Nia** -> Menguji Fitur Transaksi, Pengembalian & Dashboard Admin (TC-13 s/d TC-18) yang dikembangkan oleh Ghazi.

## ✅ Checklist Kelengkapan P9
- [x] Laporan Praktikum Bab 1 s/d Bab 3 lengkap terstruktur
- [x] Dokumen markdown test case manual hasil eksekusi (19 Test Case)
- [x] Pencatatan minimal 3 Bug Report tingkat keparahan High pada GitHub Issues
- [x] Perbaikan bug (Bug Fixing) terdokumentasikan (BUG-03 FIXED)
- [x] Bukti screenshot dilampirkan pada masing-masing lembar dokumen kerja