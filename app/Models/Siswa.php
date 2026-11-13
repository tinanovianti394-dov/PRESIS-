<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Model Siswa — untuk login siswa pakai NISN.
 *
 * Extends Authenticatable (bukan Model biasa) karena siswa
 * punya guard autentikasi sendiri (guard 'siswa' di config/auth.php).
 */
class Siswa extends Authenticatable
{
    use HasFactory;

    /**
     * Nama tabel di database.
     * Perlu didefinisikan karena Laravel default akan cari tabel 'siswas' (plural).
     */
    protected $table = 'siswa';

    /**
     * Field yang boleh diisi massal.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nisn',
        'nama',
        'kelas',
        'no_hp_orangtua',
        'password',
    ];

    /**
     * Field yang disembunyikan saat serialisasi (JSON response).
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting otomatis tipe data.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // ============================================================
    // ACCESSOR: Kriptografi QR Code
    // ============================================================

    /**
     * Accessor untuk payload QR Code terenkripsi (AES-128-CBC) tipe 'card' (permanen).
     * Dapat diakses langsung melalui: $siswa->encrypted_qr_data
     *
     * Digunakan pada pencetakan kartu fisik ID Card CR80:
     * {!! QrCode::size(120)->margin(0)->generate($siswa->encrypted_qr_data) !!}
     */
    public function getEncryptedQrDataAttribute(): string
    {
        return \App\Services\QrCryptoService::generateSiswaQrPayload($this, 'card');
    }

    // ============================================================
    // RELASI: Hubungan antar tabel
    // ============================================================

    /**
     * Relasi: Siswa punya banyak data absensi.
     */
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'nisn', 'nisn');
    }
}
