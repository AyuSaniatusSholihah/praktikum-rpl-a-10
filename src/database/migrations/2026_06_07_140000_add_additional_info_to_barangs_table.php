<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom additional_information (informasi tambahan produk)
     * untuk ditampilkan di tab "Additional Information" di halaman produk.
     */
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->text('additional_information')->nullable()->after('deskripsi');
        });
    }

    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn('additional_information');
        });
    }
};
