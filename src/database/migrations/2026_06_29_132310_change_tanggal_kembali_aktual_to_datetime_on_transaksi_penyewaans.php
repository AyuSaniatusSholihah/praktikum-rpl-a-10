<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi_penyewaans', function (Blueprint $table) {
            $table->dateTime('tanggal_kembali_aktual')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('transaksi_penyewaans', function (Blueprint $table) {
            $table->date('tanggal_kembali_aktual')->nullable()->change();
        });
    }
};
