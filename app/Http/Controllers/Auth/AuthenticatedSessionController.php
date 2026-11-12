<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Proses login dan redirect berdasarkan role user.
     *
     * - Admin  → /admin/dashboard
     * - Guru   → /guru/dashboard (default)
     * - Siswa  → /siswa/dashboard
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Redirect ke dashboard sesuai role
        $user = Auth::user();

        return match ($user->role) {
            'admin' => redirect()->intended(route('admin.dashboard', absolute: false)),
            'guru'  => redirect()->intended(route('guru.dashboard', absolute: false)),
            'siswa' => redirect()->intended(route('siswa.dashboard', absolute: false)),
            default => redirect()->intended(route('dashboard', absolute: false)),
        };
    }

    /**
     * Logout: hapus session dan redirect ke halaman utama.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
