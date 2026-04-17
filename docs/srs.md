# Sistem Penyewaan Barang Berbasis Web

## BAB I - Pendahuluan

### 1.1 Tujuan Dokumen
Dokumen ini merupakan *Software Requirements Specification (SRS)* untuk proyek pengembangan sistem informasi penyewaan barang berbasis web. Tujuan utama dokumen ini adalah mendeskripsikan secara terstruktur seluruh kebutuhan perangkat lunak yang harus dipenuhi oleh sistem, mencakup kebutuhan fungsional maupun non-fungsional.

Dokumen ini digunakan sebagai acuan bersama antara tim pengembang dan pemangku kepentingan agar terdapat pemahaman yang selaras mengenai ruang lingkup, fungsi, dan batasan sistem sebelum dan selama proses pengembangan berlangsung.

Selain itu, dokumen ini juga berfungsi sebagai dasar *traceability*, yaitu menghubungkan setiap kebutuhan fungsional dengan *user story* yang telah didefinisikan pada P2, sehiingga setiap fitur yang dibangun dapat dilacak kembali ke kebutuhan pengguna. Dokumen ini juga menjadi referensi dalam proses pengujian untuk memastikan sistem telah memenuhi kebutuhan yang ditentukan.

---

### 1.2 Ruang Lingkup
Sistem yang dikembangkan merupakan platform web penyewaan barang yang bertujuan untuk mengatasi proses penyewaan yang masih dilakukan secara manual melalui komunikasi langsung atau pesan pribadi.

Permasalahan yang dihadapi saat ini meliputi:
- Informasi ketersediaan barang tidak transparan  
- Mekanisme transaksi tidak jelas  
- Sering terjadi miskomunikasi antara penyewa dan pemilik barang  

Platform ini melibatkan:
- **USER (Penyewa)** → Sistem akan menyediakan fitur pencarian barang, proses penyewaan, simulasi pembayaran, serta riwayat sewa.  
- **USER (Pemilik Barang)** → Sistem menyediakan fitur pengelolaan katalog barang pribadi, menyewakan barang beserta pengaturan harga dan denda. 
- **Admin** → Sistem menyediakan dashboard untuk memantau aktivitas platform.

**Di luar ruang lingkup:**
- Integrasi pembayaran nyata (QRIS, transfer bank, dll)  
- Notifikasi via email/SMS  
- Fitur Approve/reject sewa oleh pemilik  
- Fitur Approve/reject barang oleh admin  
- Perhitungan jarak GPS real-time  

---

### 1.3 Definisi dan Akronim

| Istilah | Definisi |
|--------|---------|
| FR | Functional Requirement |
| NFR | Non-Functional Requirement |
| US | User Story |
| AC | Acceptance Criteria |
| Penyewa | Pengguna yang menyewa barang |
| Pemilik Barang | Pengguna yang menyewakan barang |
| Admin | Pengelola platform |
| OTP | One-Time Password |
| Denda | Biaya keterlambatan |
| SRS | Software Requirements Specification |
| Simulasi Pembayaran | Pembayaran tanpa gateway nyata |

---

## BAB II - Deskripsi Sistem

### 2.1 Deskripsi Umum

#### 2.1.1 Perspektif Produk
Sistem ini merupakan aplikasi web mandiri yang digunakan untuk mengelola penyewaan barang secara digital dan tidak terintegrasi dengan sistem eksternal lainnya.

#### 2.1.2 Fungsi Produk
Fungsi utama sistem:
- Registrasi dan login pengguna  
- Reset password dengan OTP  
- Pencarian dan filter barang sewaan
- Penyewaan dan simulasi pembayaran sewa barang 
- Pengelolaan katalog barang oleh pemilik
- Perhitungan denda keterlambatan pengembalian
- Riwayat transaksi sewa pengguna
- Dashboard admin untuk monitoring  

#### 2.1.3 Karakteristik Pengguna

| Pengguna | Deskripsi |
|---------|----------|
| USER (Penyewa) | Mahasiswa/masyarakat umum yang menyewa barang |
| USER ()Pemilik Barang | Pengguna yang menyewakan barang |
| Admin | memiliki akses penuh terhadap ringkasan data dan aktivitas platform |

#### 2.1.4 Batasan
- Sistem hanya menggunakan simulasi pembayaran, tidak pembayaran secara nyata.
- Lokasi hanya berdasarkan kota / wilayah umum (bukan GPS)  
- Sistem hanya bisa diakses berbasis web (belum mobile app)  
- Admin dibuat manual oleh developer  

---

### 2.2 Functional Requirements (FR)

- **FR-01:** Registrasi Akun
    Sistem memungkinkan pengguna untuk mendaftarkan akun menggunakan nama, email, nomor telepon, dan password
    **Prioritas:** High | **Ref:** US-01  

- **FR-02:** Login & Reset Password
    Sistem memungkinkan pengguna untuk login menggunakan email dan password serta mereset password melalui OTP yang dikirim ke email.  
    **Prioritas:** High | **Ref:** US-02  

- **FR-03:** Pencarian dan Filter Barang
    Sistem memungkinkan pengguna untuk mencari barang berdasarkan kata kunci serta memfilter berdasarkan kategori & lokasi terdekat.  
    **Prioritas:** High | **Ref:** US-03  

- **FR-04:** Penyewaan Barang
    Sistem memungkinkan pengguna untuk memilih barang, menentukan jumlah, dan memilih tanggal sewa. 
    **Prioritas:** High | **Ref:** US-04  

- **FR-05:** Sistem Pembayaran (simulasi)  
    Sistem memproses pembayaran penyewaan melalui metode QISR, bank, dan e-wallet sehingga transaksi menjadi aktif setelah pembayaran berhasil.
    **Prioritas:** High | **Ref:** US-04  

- **FR-06:** Manajemen Katalog Barang  
    Sistem memungkinkan pengguna untuk menambahkan, mengedit, dan menghapus barang pada katalog pemiliknya.
    **Prioritas:** Medium | **Ref:** US-05  

- **FR-07:** Perhitungan Denda
    Sistem menghitung dan menampilkan denda ketika pengguna terlambat mengembalikan barang.  
    **Prioritas:** Medium | **Ref:** US-06  

- **FR-08:** Riwayat Penyewaan Barang  
    Sistem menampilkan riwayat penyewaan barang beserta status transaksi (menunggu, aktif, selesai, dibatalkan)
    **Prioritas:** High | **Ref:** US-07  

- **FR-09:** Monitoring oleh Admin
    Sistem memungkinkan admin untuk melihat dashboard berisi jumlah pengguna, barang, transaksi, serta melakukan pengelolaan akun pengguna.   
    **Prioritas:** High | **Ref:** US-08  

---

### 2.3 Non-Functional Requirements (NFR)

- **NFR-01 (Performance):**  
    Halaman utama dan dashboard sistem harus dapat dimuat dalam waktu kurang dari 5 detik pada koneksi internet standar.

- **NFR-02 (Security):**  
    Password pengguna harus disimpan dalam bentuk ter-hash menggunakan algoritma bcrypt dengan minimum salt round 10. Tidak ada password yang disimpan dalam bentuk plain text.

- **NFR-03 (Usability):**  
    Sistem harus memiliki antarmuka yang responsif dan dapat digunakan dengan baik pada perangkat desktop dan mobile.

- **NFR-04 (Reliability):**  
    Sistem harus mampu menangani minimal 10 pengguna yang mengakses secara bersamaan tanpa terjadi error atau penurunan fungsi inti (login,     pencarian barang, proses pembayaran).

- **NFR-05 (Maintainability):**  
    Seluruh kode mengikuti style-guide yang disepakati tim dan terdokumentasi inline.


---

### 2.4 Catatan & Asumsi

#### 2.4.1 Asumsi
- Setiap user (Penyewa dan Pemilik Barang) diasumsikan memiliki alamat email yang aktif dan valid untuk keperluan registrasi dan proses reset password melalui OTP.
- Harga sewa dan tarif denda harian (jika berlaku) ditetapkan dan sudah dimasukkan oleh Pemilik Barang (user) saat menambahkan barang ke katalog.
- Semua perhitungan waktu, termasuk tanggal sewa dan penentuan keterlambatan pengembalian, didasarkan pada zona waktu sistem yang seragam.

#### 2.4.2 Dependensi
- Fungsi Reset Password bergantung pada ketersediaan dan keandalan layanan pengiriman OTP via email.
- Ketersediaan barang ditentukan berdasarkan tanggal sewa yang dipilih, sistem harus dapat mengelola jadwal peminjaman untuk mencegah double booking.

#### 2.4.2 Batasan Teknis
- Implementasi pembayaran hanya berupa simulasi, tidakada integrasi dengan *payment gateway* pihak ketiga (misalnya QRIS, Bank, E-Wallet) pada iterasi ini.
- Filter lokasi pencarian barang hanya mencakup wilayah atau kota umum, tanpa menggunakan kalkulasi jarak spesifik berbasis GPS.
- Sistem tidak menyediakan notifikasi *push* (melalui email atau SMS) untuk perubahan status transaksi.

---
