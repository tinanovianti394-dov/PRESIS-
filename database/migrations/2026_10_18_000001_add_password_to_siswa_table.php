<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom password & remember_token ke tabel siswa.
     * Diperlukan karena model Siswa sekarang extends Authenticatable
     * (siswa login langsung via guard 'siswa', bukan lewat tabel users).
     */
    public function up(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->string('password')->after('no_hp_orangtua');         // Password login siswa (hashed)
            $table->rememberToken()->after('password');                   // Token "Ingat Saya"
        });
    }

    /**
     * Hapus kolom password & remember_token.
     */
    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn(['password', 'remember_token']);
        });
    }
};
