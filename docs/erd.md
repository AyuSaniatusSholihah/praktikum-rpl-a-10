```mermaid
erDiagram
    users {
        BIGINT id PK
        VARCHAR google_id "nullable"
        TEXT google_token "nullable"
        TEXT google_refresh_token "nullable"
        VARCHAR name "NOT NULL"
        VARCHAR username "UNIQUE, nullable"
        VARCHAR email "UNIQUE, NOT NULL"
        VARCHAR phone_number "nullable"
        VARCHAR alamat "nullable"
        DECIMAL saldo "DEFAULT 1000000"
        VARCHAR foto_profil "nullable"
        BOOLEAN is_banned "DEFAULT false"
        ENUM role "user | admin"
        VARCHAR otp_code "nullable"
        TIMESTAMP otp_expires_at "nullable"
        TIMESTAMP email_verified_at "nullable"
        VARCHAR password "NOT NULL"
        VARCHAR remember_token "nullable"
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    kategoris {
        BIGINT id PK
        VARCHAR nama_kategori "NOT NULL, max 50"
        TEXT deskripsi "nullable"
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    barangs {
        BIGINT id PK
        BIGINT user_id FK "→ users.id"
        BIGINT kategori_id FK "→ kategoris.id"
        VARCHAR nama_barang "NOT NULL, max 100"
        TEXT deskripsi "nullable"
        TEXT additional_information "nullable"
        DECIMAL harga_sewa "15,2"
        DECIMAL harga_jaminan "15,2"
        DECIMAL harga_denda_perjam "15,2"
        INT stok "DEFAULT 1"
        VARCHAR lokasi "NOT NULL, max 100"
        VARCHAR foto_barang "nullable, max 255"
        VARCHAR fotoproduk1 "nullable"
        VARCHAR fotoproduk2 "nullable"
        VARCHAR fotoproduk3 "nullable"
        VARCHAR fotoproduk4 "nullable"
        ENUM status "tersedia | tidak_tersedia"
        DATE tanggal_item_mulai "nullable"
        DATE tanggal_item_tidak_tersedia "nullable"
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    keranjangs {
        BIGINT id PK
        BIGINT user_id FK "→ users.id"
        BIGINT barang_id FK "→ barangs.id"
        INT jumlah "NOT NULL"
        DATE tanggal_sewa "NOT NULL"
        DATE tanggal_kembali_rencana "NOT NULL"
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    pembayarans {
        BIGINT id PK
        ENUM metode "transfer bank | e-wallet | qris"
        VARCHAR detail_metode "nullable, max 50"
        TIMESTAMP tanggal_bayar "nullable"
        DECIMAL jumlah_bayar "10,2"
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    transaksi_penyewaans {
        BIGINT id PK
        BIGINT user_id FK "→ users.id, nullable"
        BIGINT barang_id FK "→ barangs.id"
        BIGINT pembayaran_id FK "→ pembayarans.id, nullable"
        INT jumlah "NOT NULL"
        DATE tanggal_sewa "NOT NULL"
        DATE tanggal_kembali_rencana "NOT NULL"
        DATE tanggal_kembali_aktual "nullable"
        ENUM status "upcoming | aktif | selesai | tunggu verifikasi pengembalian | dibatalkan"
        VARCHAR foto_buktipengembalian "nullable"
        TIMESTAMP tanggal_verifikasipengembalian "nullable"
        DECIMAL total_harga "10,2"
        INT jam_terlambat "DEFAULT 0"
        DECIMAL total_denda "10,2 DEFAULT 0"
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    reviews {
        BIGINT id PK
        BIGINT transaksi_id FK "→ transaksi_penyewaans.id"
        BIGINT user_id FK "→ users.id"
        BIGINT barang_id FK "→ barangs.id"
        INT rating "NOT NULL"
        TEXT komentar "nullable"
        VARCHAR foto_review "nullable, max 255"
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    activity_logs {
        BIGINT id PK
        BIGINT user_id FK "→ users.id"
        VARCHAR action "NOT NULL"
        TEXT description "nullable"
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    orders {
        BIGINT id PK
        BIGINT user_id FK "→ users.id, nullable"
        VARCHAR first_name "NOT NULL"
        VARCHAR last_name "NOT NULL"
        VARCHAR email "NOT NULL"
        VARCHAR phone "NOT NULL"
        VARCHAR shipping_method "nullable"
        TEXT cart_json "nullable"
        TEXT address "nullable"
        VARCHAR city "nullable"
        VARCHAR kode_pos "nullable"
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    web_reviews {
        BIGINT id PK
        BIGINT user_id FK "→ users.id"
        TINYINT rating "NOT NULL"
        TEXT ulasan "nullable"
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    %% Relasi
    users ||--o{ barangs : "memiliki"
    users ||--o{ keranjangs : "memiliki"
    users ||--o{ transaksi_penyewaans : "melakukan"
    users ||--o{ reviews : "menulis"
    users ||--o{ activity_logs : "mencatat"
    users ||--o{ orders : "membuat"
    users ||--o{ web_reviews : "memberikan"
    kategoris ||--o{ barangs : "mengkategorikan"
    barangs ||--o{ keranjangs : "ditambahkan ke"
    barangs ||--o{ transaksi_penyewaans : "disewa dalam"
    barangs ||--o{ reviews : "mendapat"
    pembayarans ||--o{ transaksi_penyewaans : "membayar (1 bayar, banyak transaksi)"
    transaksi_penyewaans ||--o| reviews : "direview"
```

### Relasi Antar Tabel (Diperbaiki)

| Relasi | Kardinalitas | Keterangan |
|--------|:-----------:|-----------|
| users → barangs | 1 : N | Satu user (owner) memiliki banyak barang |
| users → keranjangs | 1 : N | Satu user memiliki banyak item keranjang |
| users → transaksi_penyewaans | 1 : N | Satu user melakukan banyak transaksi sewa |
| users → reviews | 1 : N | Satu user menulis banyak review |
| users → activity_logs | 1 : N | Satu user memiliki banyak catatan aktivitas |
| users → orders | 1 : N | Satu user dapat membuat banyak order |
| users → web_reviews | 1 : N | Satu user memberikan banyak ulasan web |
| kategoris → barangs | 1 : N | Satu kategori memiliki banyak barang |
| barangs → keranjangs | 1 : N | Satu barang bisa di banyak keranjang |
| barangs → transaksi_penyewaans | 1 : N | Satu barang bisa disewa banyak kali |
| barangs → reviews | 1 : N | Satu barang mendapat banyak review |
| **pembayarans → transaksi_penyewaans** | **1 : N** | **1 pembayaran mencakup banyak transaksi** — ketika checkout multi-barang dari keranjang, semua dibayar 1x tapi masing-masing barang punya baris transaksi sendiri |
| transaksi_penyewaans → reviews | 1 : 1 | Satu transaksi hanya punya satu review |

---
