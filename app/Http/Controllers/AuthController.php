<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Controller Autentikasi Multi-Role PRESIS.
 *
 * Mendukung login fleksibel untuk 3 peran:
 * 1. Admin: login dengan Email & Password
 * 2. Guru: login dengan NIP atau Email & Password (Guard: web)
 * 3. Siswa: login dengan NISN & Password (Guard: siswa)
 *
 * Dilengkapi auto-detect role agar pengguna tidak terjebak jika salah klik tab.
 */
class AuthController extends Controller
{
    /**
     * Menampilkan form login multi-role.
     */
    public function showLoginForm()
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

        // Kirim header anti-cache agar browser selalu memuat CSRF token segar
        // dan tidak menggunakan salinan usang dari browser BFCache/memory
        return response()
            ->view('auth.login')
            ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');
    }

    /**
     * Memproses login multi-role dengan deteksi pintar.
     */
    public function login(Request $request)
    {
        $rawLoginId   = trim($request->input('login_id') ?? $request->input('nisn') ?? $request->input('email') ?? $request->input('nip') ?? '');
        $password     = $request->input('password');
        $selectedRole = $request->input('role', 'admin');
        $remember     = $request->boolean('remember');

        if (empty($rawLoginId) || empty($password)) {
            return back()->withErrors([
                'login_error' => 'ID Login (Email / NIP / NISN) dan Password wajib diisi.',
            ])->withInput();
        }

        // Bersihkan NIP/NISN dari karakter non-angka
        $numericId = preg_replace('/[^0-9]/', '', $rawLoginId);

        // ============================================================
        // 1. AUTENTIKASI SISWA (Guard: siswa)
        // ============================================================
        if ($selectedRole === 'siswa' || strlen($numericId) === 10) {
            $siswa = Siswa::where('nisn', $rawLoginId)
                ->orWhere('nisn', $numericId)
                ->first();

            if ($siswa && Hash::check($password, $siswa->password)) {
                // Logout dari guard web agar tidak terjadi tumpang tindih session
                Auth::guard('web')->logout();

                Auth::guard('siswa')->login($siswa, $remember);
                $request->session()->regenerate();
                return redirect()->route('siswa.portal');
            }
        }

        // ============================================================
        // 2. AUTENTIKASI ADMIN & GURU (Guard: web)
        // ============================================================
        // Cari user di tabel users berdasarkan email atau NIP
        $user = User::where('email', $rawLoginId)
            ->orWhere('nip', $rawLoginId)
            ->when(!empty($numericId), fn($q) => $q->orWhere('nip', $numericId))
            ->first();

        if ($user && Hash::check($password, $user->password)) {
            // Logout dari guard siswa agar tidak terjadi tumpang tindih session
            Auth::guard('siswa')->logout();

            Auth::guard('web')->login($user, $remember);
            $request->session()->regenerate();

            // Arahkan ke dashboard sesuai peran sebenarnya di database
            if ($user->role === 'guru') {
                return redirect()->route('guru.dashboard');
            } elseif ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
        }

        // ============================================================
        // 3. FALLBACK AUTH ATTEMPT STANDAR
        // ============================================================
        $field = filter_var($rawLoginId, FILTER_VALIDATE_EMAIL) ? 'email' : 'nip';
        if (Auth::guard('web')->attempt([$field => $rawLoginId, 'password' => $password], $remember)) {
            Auth::guard('siswa')->logout();
            $request->session()->regenerate();
            $user = Auth::guard('web')->user();
            return $user->role === 'guru'
                ? redirect()->route('guru.dashboard')
                : redirect()->route('admin.dashboard');
        }

        // Coba lagi untuk siswa jika NISN tidak persis format 006
        if (Auth::guard('siswa')->attempt(['nisn' => $rawLoginId, 'password' => $password], $remember)) {
            Auth::guard('web')->logout();
            $request->session()->regenerate();
            return redirect()->route('siswa.portal');
        }

        // ============================================================
        // 4. GAGAL LOGIN
        // ============================================================
        return back()->withErrors([
            'login_error' => 'Kredensial tidak ditemukan atau password salah. Pastikan NIP/Email/NISN dan Password sudah sesuai.',
        ])->withInput();
    }

    /**
     * Memproses logout untuk seluruh guard (web & siswa).
     */
    public function logout(Request $request)
    {
        if (Auth::guard('siswa')->check()) {
            Auth::guard('siswa')->logout();
        }

        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}