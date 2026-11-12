<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Hapus kolom user_id dari tabel siswa.
     * Siswa sekarang login langsung via tabel siswa sendiri (guard 'siswa'),
     * tidak perlu lagi relasi ke tabel users.
     */
    public function up(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropForeign(['user_id']);  // Hapus foreign key dulu
            $table->dropColumn('user_id');     // Lalu hapus kolomnya
        });
    }

    /**
     * Kembalikan kolom user_id.
     */
    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
        });
    }
};
