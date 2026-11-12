<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Siswa;

class LoginRequest extends FormRequest
{
    /**
     * Tentukan apakah user boleh melakukan request ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi login.
     * Field 'login' bisa berisi: email (admin), NIP (guru), atau NISN (siswa).
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'string'],    // Bisa email, NIP, atau NISN
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Proses autentikasi: cek apakah input login adalah email, NIP, atau NISN.
     *
     * Logika:
     * 1. Kalau formatnya email (ada @) → cari user berdasarkan email (Admin)
     * 2. Kalau 18 digit angka → cari user berdasarkan NIP (Guru)
     * 3. Kalau 10 digit angka → cari siswa berdasarkan NISN, ambil user_id-nya (Siswa)
     * 4. Kalau tidak cocok semua → coba cari NIP dulu, kalau tidak ada coba email
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $loginInput = $this->input('login');
        $password = $this->input('password');
        $remember = $this->boolean('remember');

        // Deteksi jenis login berdasarkan format input
        $credentials = $this->resolveCredentials($loginInput, $password);

        if (!$credentials || !Auth::attempt($credentials, $remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'login' => 'Login gagal. Periksa kembali email/NIP/NISN dan password Anda.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Tentukan kredensial berdasarkan format input login.
     *
     * @param string $loginInput  Input dari user (email/NIP/NISN)
     * @param string $password    Password user
     * @return array|null         Array kredensial untuk Auth::attempt()
     */
    private function resolveCredentials(string $loginInput, string $password): ?array
    {
        // Cek 1: Apakah format email? (ada tanda @)
        if (filter_var($loginInput, FILTER_VALIDATE_EMAIL)) {
            return [
                'email' => $loginInput,
                'password' => $password,
            ];
        }

        // Cek 2: Apakah NISN? (10 digit angka)
        // Kalau NISN, cari data siswa dulu, lalu ambil user_id-nya
        if (preg_match('/^\d{10}$/', $loginInput)) {
            $siswa = Siswa::where('nisn', $loginInput)->first();

            if ($siswa && $siswa->user_id) {
                $user = User::find($siswa->user_id);
                if ($user) {
                    return [
                        'email' => $user->email,
                        'password' => $password,
                    ];
                }
            }

            return null; // NISN tidak ditemukan
        }

        // Cek 3: Apakah NIP? (18 digit angka, format NIP PNS Indonesia)
        if (preg_match('/^\d{18}$/', $loginInput)) {
            $user = User::where('nip', $loginInput)->first();

            if ($user) {
                return [
                    'email' => $user->email,
                    'password' => $password,
                ];
            }

            return null; // NIP tidak ditemukan
        }

        // Cek 4: Fallback — coba cari sebagai NIP (untuk NIP non-standar)
        $user = User::where('nip', $loginInput)->first();
        if ($user) {
            return [
                'email' => $user->email,
                'password' => $password,
            ];
        }

        // Terakhir, coba sebagai email
        return [
            'email' => $loginInput,
            'password' => $password,
        ];
    }

    /**
     * Pastikan request login tidak kena rate limit (maks 5 percobaan).
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => 'Terlalu banyak percobaan login. Coba lagi dalam ' . ceil($seconds / 60) . ' menit.',
        ]);
    }

    /**
     * Key untuk rate limiting (berdasarkan input login + IP address).
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('login')).'|'.$this->ip());
    }
}
