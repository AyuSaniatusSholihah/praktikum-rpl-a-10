<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom foto produk tambahan (angle 1-4) untuk upload lebih dari satu gambar.
     * foto_barang tetap dipakai sebagai foto utama.
     */
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->string('fotoproduk1')->nullable()->after('foto_barang');
            $table->string('fotoproduk2')->nullable()->after('fotoproduk1');
            $table->string('fotoproduk3')->nullable()->after('fotoproduk2');
            $table->string('fotoproduk4')->nullable()->after('fotoproduk3');
        });
    }

    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn(['fotoproduk1', 'fotoproduk2', 'fotoproduk3', 'fotoproduk4']);
        });
    }
};
