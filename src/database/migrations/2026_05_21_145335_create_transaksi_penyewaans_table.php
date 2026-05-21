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
        Schema::create('transaksi_penyewaans', function (Blueprint $table) {
            $table->id(); // Transaksi_id (PK)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Penyewa (FK)
            $table->foreignId('barang_id')->constrained('barangs')->cascadeOnDelete(); // Barang (FK)
            $table->integer('jumlah');
            $table->date('tanggal_sewa');
            $table->date('tanggal_kembali_rencana');
            $table->date('tanggal_kembali_aktual')->nullable();
            $table->enum('status', [
                'upcoming', 
                'aktif', 
                'selesai', 
                'tunggu verifikasi pengembalian', 
                'dibatalkan'
            ])->default('upcoming');
            $table->string('foto_buktipengembalian')->nullable();
            $table->timestamp('tanggal_verifikasipengembalian')->nullable();
            $table->decimal('total_harga', 10, 2);
            $table->integer('jam_terlambat')->default(0);
            $table->decimal('total_denda', 10, 2)->default(0);
            $table->timestamps(); // Mengisi created_at (waktu transaksi) dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_penyewaans');
    }
};
