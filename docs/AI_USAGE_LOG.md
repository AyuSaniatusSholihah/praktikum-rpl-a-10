# AI-Usage Log — SEWAIN

Dokumen ini mencatat penggunaan *AI assistant* selama pengembangan proyek SEWAIN,
sesuai prinsip **Responsible AI Use**: transparansi, verifikasi, keamanan data, dan pemahaman.

| Keterangan | Detail |
|---|---|
| Kelompok | 10 — SewaDev |
| Mata Kuliah | Rekayasa Perangkat Lunak (RPL) Kelas A |
| AI Tool yang digunakan | Claude (Anthropic), GitHub Copilot (bantuan autocomplete) |
| Periode | P1 – P12 (satu semester) |

---

## 1. Ringkasan Tingkat Penggunaan

Penggunaan AI pada proyek ini tergolong **signifikan namun terkontrol**. AI digunakan
sebagai *asisten* — untuk mempercepat penyusunan boilerplate, dokumentasi, dan debugging —
bukan sebagai pengganti pemahaman tim. Seluruh output AI **diverifikasi manual**, diuji,
dan disesuaikan dengan konteks proyek sebelum di-*commit*.

---

## 2. Rincian Penggunaan per Area

| Area | Bagaimana AI Digunakan | Verifikasi oleh Tim |
|---|---|---|
| **Deployment** | Panduan langkah deploy Laravel ke Railway lalu migrasi ke Hostinger (PHP 8.4, MySQL), konfigurasi environment variable. | Dijalankan manual; env & kredensial diisi sendiri oleh tim, tidak dimasukkan ke prompt. |
| **REST API Mobile** | Bantuan implementasi endpoint yang belum ada (`forgot-password`, `reset-password`, `resend-otp`, `kategori`) di Laravel + penyesuaian `ApiClient.kt` Android. | Kode diuji via Postman/emulator; logika bisnis dibaca ulang dan dipahami tim. |
| **Dokumentasi** | Penyusunan draf README, CHANGELOG, laporan UTS/akhir, data dictionary, dan diagram (Activity, MVC, UML). | Isi disunting agar sesuai kondisi nyata proyek; angka & fakta dicek ulang. |
| **Debugging & Refactor** | Analisis *bug* (mis. stok tidak kembali saat konfirmasi pengembalian) dan saran perbaikan. | Perbaikan diuji ulang melalui unit test (pola AAA) sebelum merge. |
| **Unit Testing** | Saran struktur test case PHPUnit (Arrange–Act–Assert). | Assertion & skenario disesuaikan dengan logika domain SEWAIN. |

---

## 3. Penerapan Prinsip Responsible AI

- **Transparansi** — Setiap pemanfaatan AI dicatat di dokumen ini dan tidak disembunyikan dari penilaian.
- **Verifikasi** — Tidak ada output AI yang langsung dipakai tanpa dibaca, diuji, dan disesuaikan. Beberapa saran AI ditolak/direvisi ketika tidak sesuai konteks (mis. framing logika denda & integritas log sempat dikoreksi tim).
- **Keamanan Data** — Kredensial database, `APP_KEY`, kunci OAuth, dan data pengguna **tidak pernah** dimasukkan ke dalam prompt AI. Konfigurasi sensitif diisi manual di server.
- **Pemahaman** — Setiap anggota memastikan mampu menjelaskan kode yang dihasilkan; AI dipakai untuk *mempercepat*, bukan menggantikan proses belajar.

---

## 4. Refleksi Efektivitas Penggunaan AI

**Yang berhasil**
- Mempercepat penyusunan boilerplate & dokumentasi sehingga waktu tim lebih banyak untuk logika inti.
- Membantu memetakan *gap* fitur antara sisi web (Laravel) dan mobile (Kotlin) dengan cepat.
- Berguna sebagai "pasangan diskusi" saat *debugging* dan meninjau desain.

**Yang tidak berhasil / perlu hati-hati**
- Output AI kadang mengasumsikan konteks yang salah (mis. base URL, versi dependensi) sehingga tetap butuh koreksi manual.
- Saran AI bisa terdengar meyakinkan meski keliru — verifikasi tetap wajib.
- Tidak bisa diandalkan untuk aksi yang butuh kredensial/akses nyata (deploy & push tetap dilakukan tim).

**Kesimpulan** — AI memberi *leverage* nyata pada produktivitas tim selama tanggung jawab
verifikasi tetap di tangan manusia. Keputusan akhir dan pemahaman kode sepenuhnya milik tim SewaDev.
