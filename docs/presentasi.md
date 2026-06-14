# Struktur Presentasi Proyek RPL (Kelompok A-10)

Berikut adalah rancangan struktur slide presentasi untuk menampilkan secara komprehensif hasil kerja keras kelompok dari tahap analisis hingga implementasi program. Presentasi ini dirancang agar mengalir secara logis: **masalah $\rightarrow$ perancangan $\rightarrow$ solusi (fitur program)**.

---

## Slide 1: Judul & Perkenalan
* **Judul Presentasi**: Platform Sistem Informasi Penyewaan Barang Berbasis Web (atau sesuaikan dengan nama aplikasi kalian).
* **Tim Pengembang (Kelompok A-10)**:
  - APRILIA ALFA GUSASTI CIPTANINGTYAS
  - AYU SANIATUS SHOLIHAH
  - GHAZI FAHMI RAMADHAN

## Slide 2: Latar Belakang & Problem Statement (Masalah Utama)
*Menceritakan alasan mendasar mengapa aplikasi ini dibuat.*
* **Kondisi Saat Ini**: Proses penyewaan barang masih manual (melalui *chat* pribadi), sehingga informasi jadwal, harga, dan ketersediaan barang sering tidak jelas.
* **Dampak**: Muncul miskomunikasi, pemborosan waktu, serta rendahnya tingkat kepercayaan antara penyewa dan pemilik barang.
* **Peluang**: Banyak orang memiliki barang *nganggur* yang bisa menjadi sumber penghasilan, namun belum ada wadah yang terpercaya untuk menyewakannya.

## Slide 3: Solusi yang Ditawarkan
*Bagaimana kelompok kalian memecahkan masalah di atas.*
* **Konsep Aplikasi**: Membangun sebuah *platform* digital terintegrasi yang mempertemukan penyewa dan pemilik barang (Owner).
* **Tujuan**:
  - **Sentralisasi**: Menyediakan informasi barang, jadwal, dan harga di satu tempat.
  - **Terstruktur**: Membuat transaksi penyewaan (dari *checkout* hingga pengembalian) menjadi transparan.
  - **Keamanan**: Meningkatkan kepercayaan dengan sistem rekam jejak transaksi dan moderasi admin.

## Slide 4: Analisis Pengguna & Use Case (Aktor)
*Menunjukkan tahapan analisis (User Stories) bahwa sistem dirancang sesuai kebutuhan riil.*
* **3 Aktor Utama & Perannya**:
  1. **Penyewa**: Mencari barang, menambahkan ke keranjang, menyewa, membayar, dan memberi ulasan.
  2. **Owner**: Menambahkan katalog barang, menyetujui pesanan, dan memantau penyewaan barang miliknya.
  3. **Admin**: Memonitor aktivitas platform, mengelola *user*, dan memblokir (ban/freeze) akun bermasalah.
* *Visual di slide*: Tampilkan gambar **Use Case Diagram** secara sekilas di slide ini.

## Slide 5: Alur Kerja Sistem (Activity Diagram)
*Menunjukkan bahwa alur bisnis dari aplikasi sudah dianalisis dengan matang dan tidak asal buat.*
* *Visual di slide*: Tampilkan **Activity Diagram** utama, misalnya alur proses sewa.
* **Poin Bicara**: Jelaskan secara singkat alur dari (Pilih Barang $\rightarrow$ Masuk Keranjang $\rightarrow$ Checkout $\rightarrow$ Verifikasi Owner $\rightarrow$ Pembayaran $\rightarrow$ Pengembalian barang). 

## Slide 6: Perancangan Basis Data & Sistem (ERD & Class Diagram)
*Menunjukkan struktur teknis (kerja keras di bagian perancangan backend).*
* *Visual di slide*: Cuplikan dari **ERD** (Entity Relationship Diagram) atau **Class Diagram**.
* **Poin Bicara**: "Aplikasi kami dirancang dengan struktur *database* relasional yang solid, mencakup tabel *users*, *barangs*, *orders*, *transaksi_penyewaans*, hingga *web_reviews* untuk memastikan semua fitur dapat saling terhubung dengan baik."

## Slide 7: Fitur Utama Program (Implementasi)
*Puncak presentasi: Menunjukkan fitur apa saja yang berhasil diimplementasikan dari hasil rancangan di atas.*
1. **Autentikasi Aman**: Login/Register dengan verifikasi OTP dan Google OAuth (Login with Google).
2. **Katalog & Keranjang (Cart)**: Fitur pencarian barang dan *Add to Cart* untuk *checkout* multi-barang sekaligus.
3. **Manajemen Transaksi Terpadu**: Proses *checkout*, pemilihan *shipping method*, pencatatan alamat, hingga simulasi pembayaran menggunakan saldo (My Wallet).
4. **Dashboard Role-based**: Panel khusus yang berbeda-beda untuk Admin, Owner, dan Penyewa (Memonitor katalog, riwayat sewa, dll).

## Slide 8: Desain vs Implementasi (Wireframe & Demo)
* **Rancangan vs Realita**: Sangat bagus untuk menampilkan perbandingan antara desain **Wireframe** UI yang dibuat di awal, disandingkan dengan *screenshot* / rekaman layar dari aplikasi web (Laravel) yang sudah jadi.
* **Demo Aplikasi**: (Opsional) Jika memungkinkan, lakukan demo singkat (misal: demo cara *checkout* barang atau cara login menggunakan Google).

## Slide 9: Kesimpulan
* **Value / Nilai Tambah**: Aplikasi ini berhasil mendigitalisasi proses sewa yang manual menjadi terstruktur, transparan, dan dapat dilacak.
* Target dan harapan ke depannya (misalnya bisa diekspansi untuk fitur notifikasi *real-time* atau integrasi payment gateway sungguhan).

## Slide 10: Tanya Jawab (Q&A) & Penutup
* Ucapan terima kasih dan sesi tanya jawab dengan dosen/audiens.

---
### Tips Tambahan Saat Presentasi:
- **Jangan Membaca Slide**: Gunakan poin-poin singkat di slide dan ceritakan prosesnya secara lisan. Audiens lebih suka mendengar cerita daripada membaca tulisan panjang.
- **Highlight Proses RPL-nya**: Tekankan bahwa aplikasi ini dibangun secara **metodis**. Ucapkan kalimat seperti: *"Kami tidak langsung coding, tapi berangkat dari Problem Statement $\rightarrow$ User Story $\rightarrow$ Perancangan UML & ERD $\rightarrow$ Baru tahap Implementasi Backend/Frontend."* Hal ini akan sangat diapresiasi dalam mata kuliah Rekayasa Perangkat Lunak.
