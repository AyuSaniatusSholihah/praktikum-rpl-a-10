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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id(); // Pembayaran_id (PK)
            $table->enum('metode', ['transfer bank', 'e-wallet', 'qris']);
            $table->string('detail_metode', 50)->nullable(); // BCA, Mandiri, ShopeePay, Gopay, dll.
            $table->timestamp('tanggal_bayar')->nullable();
            $table->decimal('jumlah_bayar', 10, 2);
            $table->timestamps(); // Mengisi created_at dan updated_at
        });

        // Tambahkan constraint foreign key ke transaksi_penyewaans
        Schema::table('transaksi_penyewaans', function (Blueprint $table) {
            $table->foreign('pembayaran_id')->references('id')->on('pembayarans')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi_penyewaans', function (Blueprint $table) {
            $table->dropForeign(['pembayaran_id']);
        });
        Schema::dropIfExists('pembayarans');
    }
};
