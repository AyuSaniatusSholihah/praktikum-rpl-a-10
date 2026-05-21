<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keranjangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('barang_id')->constrained('barangs')->cascadeOnDelete();
            $table->integer('jumlah');
            $table->date('tanggal_sewa');
            $table->date('tanggal_kembali_rencana');
            $table->timestamps();

            $table->unique(['user_id', 'barang_id', 'tanggal_sewa', 'tanggal_kembali_rencana'], 'keranjang_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keranjangs');
    }
};