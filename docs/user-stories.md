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
- Given saya sudah memilih jumlah & tanggal, When melakukan pembayaran, Then status menjadi **menunggu persetujuan owner**  

---

### 🟢 US-05 – Pengembalian Barang
**User Story**  
As a user, I want mengembalikan barang, so that transaksi selesai  

**Acceptance Criteria**
- Given masa sewa selesai, When klik "kembalikan", Then status menjadi selesai  

---

### 🟢 US-06 – Denda Keterlambatan
**User Story**  
As a user, I want melihat denda keterlambatan, so that saya memahami konsekuensi keterlambatan  

**Acceptance Criteria**
- Given terlambat mengembalikan, When cek pengembalian, Then denda ditampilkan  

---

### 🟢 US-07 – Riwayat Sewa
**User Story**  
As a user, I want melihat riwayat sewa dan status transaksi, so that saya dapat memantau aktivitas saya  

**Acceptance Criteria**
- Given halaman riwayat, Then semua transaksi ditampilkan  

---

### 🟢 US-08 – Review Barang
**User Story**  
As a user, I want memberikan review setelah menyewa, so that saya dapat memberikan feedback  

**Acceptance Criteria**
- Given transaksi selesai, When isi review, Then review tersimpan  

---

## 👤 User (Owner)

### 🔵 US-09 – Mengelola Katalog Barang
**User Story**  
As a user (owner), I want menambahkan, mengedit, dan menghapus barang, so that barang dapat disewakan  

**Acceptance Criteria**
- Given saya menambahkan barang, When simpan, Then barang tampil di katalog  
- Given saya edit/hapus barang, Then data diperbarui  

---

### 🔵 US-10 – Persetujuan Sewa
**User Story**  
As a user (owner), I want menyetujui atau menolak permintaan sewa, so that saya dapat mengontrol penyewaan  

**Acceptance Criteria**
- Given ada request sewa, When approve, Then status disetujui  
- When reject, Then status ditolak  

---

### 🔵 US-11 – Melihat Transaksi & Saldo
**User Story**  
As a user (owner), I want melihat transaksi dan saldo, so that saya dapat memantau pendapatan  

**Acceptance Criteria**
- Given data transaksi, Then daftar transaksi dan total saldo ditampilkan  

---

## 🛡️ Admin (Monitoring & Moderasi)

### 🔴 US-12 – Monitoring Platform
**User Story**  
As an admin, I want memantau aktivitas platform, so that sistem berjalan dengan baik  

**Acceptance Criteria**
- Given admin login, When membuka dashboard, Then tampil ringkasan data platform  

---

### 🔴 US-13 – Melihat Detail User
**User Story**  
As an admin, I want melihat detail user, so that saya dapat memantau aktivitas pengguna  

**Acceptance Criteria**
- Given admin memilih user, When membuka detail, Then tampil profil, barang, dan histori transaksi  

---

### 🔴 US-14 – Freeze / Ban Account
**User Story**  
As an admin, I want membekukan akun user yang memiliki review buruk atau laporan negatif, so that saya dapat menjaga kualitas platform  

**Acceptance Criteria**
- Given terdapat review buruk atau laporan, When admin melakukan pengecekan, Then akun dapat dibekukan  
- Given akun dibekukan, When user login, Then akses ditolak  

---
