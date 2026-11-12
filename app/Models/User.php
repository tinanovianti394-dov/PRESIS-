<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Field yang boleh diisi massal.
     * - nip: Nomor Induk Pegawai (khusus guru)
     * - role: admin, guru, atau siswa
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'nip',
        'email',
        'role',
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
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ============================================================
    // HELPER METHODS: Cek role user
    // ============================================================

    /**
     * Cek apakah user adalah Admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user adalah Guru.
     */
    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    /**
     * Cek apakah user adalah Siswa.
     */
    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    // ============================================================
    // RELASI: Hubungan antar tabel
    // ============================================================

    /**
     * Relasi: User (guru) memiliki banyak data absensi yang dia buat/validasi.
     */
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'id_user');
    }

}
