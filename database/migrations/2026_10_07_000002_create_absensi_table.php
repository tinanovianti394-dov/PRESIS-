<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel absensi: menyimpan data scan QR Code siswa.
     * - nisn: NISN siswa yang scan
     * - id_user: guru yang membuat sesi absensi / memvalidasi
     * - status: hadir, izin, sakit, alfa
     * - waktu_scan: waktu saat siswa scan QR Code
     */
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->string('nisn', 10);                              // NISN siswa yang melakukan scan
            $table->foreignId('id_user')                             // ID guru yang membuat sesi / memvalidasi
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alfa']) // Status kehadiran
                  ->default('hadir');
            $table->dateTime('waktu_scan');                           // Waktu saat siswa scan QR Code
            $table->string('keterangan')->nullable();                 // Keterangan tambahan (opsional)
            $table->timestamps();

            // Index untuk query cepat berdasarkan NISN dan tanggal
            $table->foreign('nisn')
                  ->references('nisn')
                  ->on('siswa')
                  ->onDelete('cascade');

            $table->index(['nisn', 'waktu_scan']);                   // Index gabungan untuk pencarian harian
        });
    }

    /**
     * Hapus tabel absensi.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
