<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database.
     * Perlu didefinisikan karena Laravel default akan cari tabel 'absensis' (plural).
     */
    protected $table = 'absensi';

    /**
     * Field yang boleh diisi massal.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nisn',
        'id_user',
        'status',
        'waktu_scan',
        'keterangan',
    ];

    /**
     * Casting otomatis tipe data.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'waktu_scan' => 'datetime',
        ];
    }

    // ============================================================
    // RELASI: Hubungan antar tabel
    // ============================================================

    /**
     * Relasi: Absensi milik satu siswa (berdasarkan NISN).
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nisn', 'nisn');
    }

    /**
     * Relasi: Absensi dibuat/divalidasi oleh satu guru.
     */
    public function guru()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
