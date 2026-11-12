<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel siswa: menyimpan data siswa SMKN 3 Bengkalis.
     * - NISN digunakan sebagai identifier login siswa.
     * - no_hp_orangtua digunakan untuk kirim notifikasi WhatsApp via Fonnte API.
     */
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nisn', 10)->unique();                   // NISN (10 digit, unik) — dipakai login siswa
            $table->string('nama');                                  // Nama lengkap siswa
            $table->string('kelas');                                 // Kelas siswa (misal: XII RPL 1)
            $table->string('no_hp_orangtua')->nullable();            // No HP orangtua (format: 628xxx) untuk Fonnte
            $table->foreignId('user_id')->nullable()                 // Relasi ke tabel users (akun login siswa)
                  ->constrained('users')
                  ->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Hapus tabel siswa.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
