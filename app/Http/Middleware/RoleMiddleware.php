<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware untuk membatasi akses berdasarkan role user.
 *
 * Cara pakai di routes:
 *   Route::middleware('role:admin')->group(...)      // Hanya admin
 *   Route::middleware('role:guru')->group(...)       // Hanya guru
 *   Route::middleware('role:admin,guru')->group(...) // Admin atau guru
 */
class RoleMiddleware
{
    /**
     * Cek apakah user yang login punya role yang diizinkan.
     *
     * @param Request $request
     * @param Closure $next
     * @param string  ...$roles  Daftar role yang diizinkan (bisa lebih dari satu)
     * @return Response
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Kalau belum login, redirect ke halaman login
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Cek apakah role user ada di daftar role yang diizinkan
        if (!in_array($request->user()->role, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
