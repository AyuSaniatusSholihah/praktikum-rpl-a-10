<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('keranjangs', function (Blueprint $table) {
            $table->time('waktu_sewa')->default('08:00:00')->after('tanggal_sewa');
            $table->time('waktu_kembali_rencana')->default('08:00:00')->after('tanggal_kembali_rencana');
        });

        Schema::table('transaksi_penyewaans', function (Blueprint $table) {
            $table->time('waktu_sewa')->default('08:00:00')->after('tanggal_sewa');
            $table->time('waktu_kembali_rencana')->default('08:00:00')->after('tanggal_kembali_rencana');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keranjangs', function (Blueprint $table) {
            $table->dropColumn(['waktu_sewa', 'waktu_kembali_rencana']);
        });

        Schema::table('transaksi_penyewaans', function (Blueprint $table) {
            $table->dropColumn(['waktu_sewa', 'waktu_kembali_rencana']);
        });
    }
};
