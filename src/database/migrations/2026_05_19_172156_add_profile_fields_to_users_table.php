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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 100)->nullable()->unique()->after('name');
            $table->string('alamat')->nullable()->after('username');
            $table->decimal('saldo', 15, 2)->default(1000000)->after('alamat');
            $table->string('foto_profil', 255)->nullable()->after('saldo');
            $table->boolean('is_banned')->default(false)->after('foto_profil');
            $table->enum('role', ['user', 'admin'])->default('user')->after('is_banned');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'alamat', 'saldo', 'foto_profil', 'is_banned', 'role']);
        });
    }
};
