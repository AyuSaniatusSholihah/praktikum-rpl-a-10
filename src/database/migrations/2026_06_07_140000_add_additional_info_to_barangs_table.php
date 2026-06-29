<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom additional_information (informasi tambahan produk)
     * untuk ditampilkan di tab "Additional Information" di halaman produk.
     *
     * Catatan: Kolom ini sudah ditambahkan di migration fotoproduk (2026_06_07_090000).
     * Guard `hasColumn` mencegah error "duplicate column" saat test suite berjalan
     * dengan SQLite in-memory yang menjalankan seluruh migration fresh dari awal.
     */
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            if (!Schema::hasColumn('barangs', 'additional_information')) {
                $table->text('additional_information')->nullable()->after('deskripsi');
            }
        });
    }

    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            if (Schema::hasColumn('barangs', 'additional_information')) {
                $table->dropColumn('additional_information');
            }
        });
    }
};
