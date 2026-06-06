<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom tanggal ketersediaan barang (dipakai oleh model Barang & form Add Item).
     */
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->date('tanggal_item_mulai')->nullable()->after('status');
            $table->date('tanggal_item_tidak_tersedia')->nullable()->after('tanggal_item_mulai');
        });
    }

    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn(['tanggal_item_mulai', 'tanggal_item_tidak_tersedia']);
        });
    }
};
