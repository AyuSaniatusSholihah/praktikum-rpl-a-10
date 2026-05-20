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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kategori_id')->constrained('kategoris')->cascadeOnDelete();
            $table->string('nama_barang', 100);
            $table->text('deskripsi')->nullable();
            $table->decimal('harga_sewa', 15, 2);
            $table->decimal('harga_jaminan', 15, 2);
            $table->decimal('harga_denda_perjam', 15, 2);
            $table->integer('stok')->default(1);
            $table->string('lokasi', 100);
            $table->string('foto_barang', 255)->nullable();
            $table->enum('status', ['tersedia', 'tidak_tersedia'])->default('tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
