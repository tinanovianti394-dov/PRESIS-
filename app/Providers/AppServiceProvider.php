<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Daftarkan class alias QrCode agar sintaks {!! QrCode::... !!} dapat digunakan langsung di Blade
        if (!class_exists('QrCode')) {
            class_alias(\SimpleSoftwareIO\QrCode\Facades\QrCode::class, 'QrCode');
        }
    }
}
