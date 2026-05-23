# User Stories

---

## 👤 User (Penyewa)

### 🟢 US-01 – Registrasi Akun
**User Story**  
As a user, I want mendaftarkan akun dengan nama, email, no telp, dan password, so that saya dapat mengakses website dan menggunakan fiturnya  

**Acceptance Criteria**
- Given saya sudah mengisi data dengan benar, When klik "register", Then akun berhasil dibuat  
- Given email sudah terdaftar, When klik "register", Then muncul pesan bahwa akun sudah terdaftar  

---

### 🟢 US-02 – Login & Lupa Password
**User Story**  
As a user, I want login menggunakan email dan password serta reset password melalui OTP, so that saya dapat mengakses akun dengan aman  

**Acceptance Criteria**
- Given data login benar, When klik "login", Then masuk ke dashboard  
- Given data login salah, When klik "login", Then muncul pesan error  
- Given lupa password, When klik "lupa password", Then OTP dikirim ke email  

---

### 🟢 US-03 – Pencarian & Filter Barang
**User Story**  
As a user, I want mencari barang berdasarkan kata kunci dan filter harga/lokasi, so that saya dapat menemukan barang dengan cepat  

**Acceptance Criteria**
- Given saya memasukkan kata kunci, When klik "cari", Then hasil sesuai filter ditampilkan  

---

### 🟢 US-04 – Menyewa Barang & Pembayaran
**User Story**  
As a user, I want memilih barang, menentukan jumlah dan tanggal sewa, serta melakukan pembayaran, so that saya dapat menyewa barang  

**Acceptance Criteria**
- Given saya memilih barang, When membuka detail, Then muncul informasi barang  
- Given saya sudah memilih jumlah & tanggal, When melakukan pembayaran, Then status menjadi status menjadi aktif sewa / upcoming  

---

### 🟢 US-05 – Pengembalian Barang
**User Story**  
As a user, I want mengembalikan barang ke pemilik toko tepat waktu, so that saya terhindar dari denda akibat keterlambatan pengembalian.  

**Acceptance Criteria**
- Given saya mengembalikan barang sebelum atau tepat pada tanggal jatuh tempo, When saya klik 'Pengembalian Barang', Then sistem menampilkan konfirmasi pengembalian tanpa denda, dan status peminjaman berubah menjadi "Selesai".
- Given saya terlambat mengembalikan barang melewati tanggal jatuh tempo, When saya klik 'Pengembalian Barang', Then sistem menampilkan rincian denda yang harus dibayar (jumlah hari terlambat & total denda), dan user harus menyelesaikan pembayaran denda sebelum status berubah menjadi "Selesai".
 

---

### 🟢 US-06 – Riwayat Sewa
**User Story**  
As a user, I want melihat riwayat sewa dan status transaksi, so that saya dapat memantau aktivitas saya  

**Acceptance Criteria**
- Given halaman riwayat, Then semua transaksi ditampilkan  

---

### 🟢 US-07 – Review Barang
**User Story**  
As a user, I want memberikan review setelah menyewa, so that saya dapat memberikan feedback  

**Acceptance Criteria**
- Given transaksi selesai, When isi review, Then review tersimpan  

---

## 👤 User (Owner)

### 🔵 US-08 – Mengelola Katalog Barang
**User Story**  
As a user (owner), I want menambahkan, mengedit, dan menghapus barang, so that barang dapat disewakan  

**Acceptance Criteria**
- Given saya menambahkan barang, When simpan, Then barang tampil di katalog  
- Given saya edit/hapus barang, Then data diperbarui  

---

### 🔵 US-09 – Konfirmasi Pengembalian & Pengelolaan Denda
**User Story**  
As a user (pemilik barang), I want mengkonfirmasi pengembalian barang dan memverifikasi denda keterlambatan, so that transaksi dapat ditutup dengan benar dan saya mendapat haknya jika ada keterlambatan.  

**Acceptance Criteria**
- Given penyewa mengajukan pengembalian, When saya membuka notifikasi, Then muncul detail pengembalian: nama penyewa, barang, tanggal jatuh tempo, dan tanggal pengembalian aktual. 
- Given pengembalian tepat waktu, When saya klik 'Konfirmasi Pengembalian', Then status transaksi berubah menjadi Selesai, stok bertambah kembali, dan penyewa mendapat notifikasi. 
- Given penyewa terlambat mengembalikan, When saya membuka detail transaksi, Then sistem otomatis menampilkan total denda (tarif denda × jumlah hari terlambat) yang harus dibayar penyewa. Given denda sudah dibayar penyewa, When saya mengkonfirmasi pelunasan denda, Then status transaksi berubah menjadi Selesai dan stok bertambah.

---

### 🔵 US-10 – Melihat Transaksi & Saldo
**User Story**  
As a user (owner), I want melihat transaksi dan saldo, so that saya dapat memantau pendapatan  

**Acceptance Criteria**
- Given data transaksi, Then daftar transaksi dan total saldo ditampilkan  

---

## 🛡️ Admin (Monitoring & Moderasi)

### 🔴 US-11 – Monitoring Platform
**User Story**  
As an admin, I want memantau aktivitas platform, so that sistem berjalan dengan baik  

**Acceptance Criteria**
- Given admin login, When membuka dashboard, Then tampil ringkasan data platform  

---

### 🔴 US-12 – Melihat Detail User
**User Story**  
As an admin, I want melihat detail user, so that saya dapat memantau aktivitas pengguna  

**Acceptance Criteria**
- Given admin memilih user, When membuka detail, Then tampil profil, barang, dan histori transaksi  

---

### 🔴 US-13 – Freeze / Ban Account
**User Story**  
As an admin, I want membekukan akun user yang memiliki review buruk atau laporan negatif, so that saya dapat menjaga kualitas platform  

**Acceptance Criteria**
- Given terdapat review buruk atau laporan, When admin melakukan pengecekan, Then akun dapat dibekukan  
- Given akun dibekukan, When user login, Then akses ditolak  

---
