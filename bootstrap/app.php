<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Daftarkan middleware alias 'role' untuk cek role user
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

        // Redirect pengguna yang sudah login ke dashboard sesuai perannya masing-masing
        $middleware->redirectUsersTo(function () {
            if (Auth::guard('siswa')->check()) {
                return route('siswa.portal');
            }

            $user = Auth::guard('web')->user();
            if ($user?->role === 'admin') {
                return route('admin.dashboard');
            } elseif ($user?->role === 'guru') {
                return route('guru.dashboard');
            }

            return route('admin.dashboard');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Tangani error 419 (Page Expired / TokenMismatch) secara otomatis
        // Mengarahkan kembali pengguna ke halaman login dengan token baru yang segar
        $exceptions->respond(function ($response, Throwable $exception, \Illuminate\Http\Request $request) {
            if ($response->getStatusCode() === 419) {
                return redirect()->route('login.portal')->withErrors([
                    'login_error' => 'Sesi form telah diperbarui untuk keamanan. Silakan pilih role dan masuk kembali.',
                ]);
            }

            return $response;
        });
    })->create();
