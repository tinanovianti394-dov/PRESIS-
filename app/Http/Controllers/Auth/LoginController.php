<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Controller Login Multi-Role PRESIS.
 *
 * Menangani portal pemilihan role dan form login terpisah untuk:
 * 1. Admin  → login dengan Email & Password (Guard: web)
 * 2. Guru   → login dengan NIP / Email & Password (Guard: web)
 * 3. Siswa  → login dengan NISN & Password (Guard: siswa)
 *
 * Setiap role memiliki halaman login tersendiri dengan konteks UI yang sesuai.
 * Autentikasi dilakukan oleh method `authenticate()` tunggal yang menerima
 * field hidden `role` dari masing-masing form.
 */
class LoginController extends Controller
{
    // ============================================================
    // TAMPILKAN HALAMAN
    // ============================================================

    /**
     * Halaman Portal Utama — Pemilihan Role (3 Kartu).
     */
    public function portal()
    {
        // Jika sudah login, redirect langsung ke dashboard perannya
        if (Auth::guard('siswa')->check()) {
            return redirect()->route('siswa.portal');
        }

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            return $user->role === 'guru'
                ? redirect()->route('guru.dashboard')
                : redirect()->route('admin.dashboard');
        }

        return response()
            ->view('auth.portal')
            ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');
    }

    /**
     * Form Login Administrator.
     */
    public function showAdminLogin()
    {
        return $this->showRoleLogin('admin', 'Administrator', 'Email Administrator', 'admin@smkn3bengkalis.sch.id');
    }

    /**
     * Form Login Guru / Staf Pengajar.
     */
    public function showGuruLogin()
    {
        return $this->showRoleLogin('guru', 'Guru / Staf', 'NIP atau Email Guru', '198501012010011002');
    }

    /**
     * Form Login Siswa.
     */
    public function showSiswaLogin()
    {
        return $this->showRoleLogin('siswa', 'Siswa', 'NISN Siswa (10 Digit)', '0109401780');
    }

    /**
     * Helper internal: render view login-role dengan parameter yang disesuaikan.
     */
    private function showRoleLogin(string $role, string $title, string $inputLabel, string $placeholder)
    {
        return response()
            ->view('auth.login-role', compact('role', 'title', 'inputLabel', 'placeholder'))
            ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');
    }

    // ============================================================
    // PROSES AUTENTIKASI
    // ============================================================

    /**
     * Memproses autentikasi berdasarkan role yang dikirim dari form.
     */
    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'role'     => 'required|in:admin,guru,siswa',
        ], [
            'username.required' => 'ID Login wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $username = trim($request->input('username'));
        $password = $request->input('password');
        $role     = $request->input('role');
        $remember = $request->boolean('remember');

        // Bersihkan NIP/NISN dari karakter non-angka (untuk format copy-paste)
        $numericId = preg_replace('/[^0-9]/', '', $username);

        // ============================================================
        // 1. AUTENTIKASI SISWA (Guard: siswa)
        // ============================================================
        if ($role === 'siswa') {
            $siswa = Siswa::where('nisn', $username)
                ->orWhere('nisn', $numericId)
                ->first();

            if ($siswa && Hash::check($password, $siswa->password)) {
                Auth::guard('web')->logout();
                Auth::guard('siswa')->login($siswa, $remember);
                $request->session()->regenerate();
                return redirect()->route('siswa.portal');
            }

            return back()->withErrors([
                'login_error' => 'NISN atau Password salah. Pastikan NISN dan Password yang Anda masukkan sudah benar.',
            ])->withInput();
        }

        // ============================================================
        // 2. AUTENTIKASI ADMIN & GURU (Guard: web)
        // ============================================================
        $user = User::where('email', $username)
            ->orWhere('nip', $username)
            ->when(!empty($numericId), fn($q) => $q->orWhere('nip', $numericId))
            ->first();

        if ($user && Hash::check($password, $user->password)) {
            // Validasi: role di database harus sesuai dengan role form login yang dipilih
            if ($user->role !== $role) {
                $roleName = match($user->role) {
                    'admin' => 'Administrator',
                    'guru'  => 'Guru / Staf',
                    default => ucfirst($user->role),
                };
                return back()->withErrors([
                    'login_error' => "Akun Anda terdaftar sebagai {$roleName}. Silakan gunakan portal login {$roleName}.",
                ])->withInput();
            }

            Auth::guard('siswa')->logout();
            Auth::guard('web')->login($user, $remember);
            $request->session()->regenerate();

            return $role === 'guru'
                ? redirect()->route('guru.dashboard')
                : redirect()->route('admin.dashboard');
        }

        // ============================================================
        // 3. FALLBACK AUTH ATTEMPT STANDAR
        // ============================================================
        $field = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'nip';
        if (Auth::guard('web')->attempt([$field => $username, 'password' => $password], $remember)) {
            Auth::guard('siswa')->logout();
            $request->session()->regenerate();
            $user = Auth::guard('web')->user();

            if ($user->role !== $role) {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors([
                    'login_error' => 'Role akun Anda tidak sesuai dengan portal login yang dipilih.',
                ])->withInput();
            }

            return $user->role === 'guru'
                ? redirect()->route('guru.dashboard')
                : redirect()->route('admin.dashboard');
        }

        // ============================================================
        // 4. GAGAL LOGIN
        // ============================================================
        $pesan = match($role) {
            'admin' => 'Email atau Password Administrator salah.',
            'guru'  => 'NIP/Email atau Password Guru salah.',
            default => 'Kredensial tidak ditemukan atau password salah.',
        };

        return back()->withErrors([
            'login_error' => $pesan . ' Silakan periksa kembali data login Anda.',
        ])->withInput();
    }
}
