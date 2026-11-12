<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Absensi;
use Carbon\Carbon;

/**
 * Controller Dashboard Admin.
 *
 * Menampilkan ringkasan statistik sistem:
 * - Total siswa, guru, absensi hari ini
 * - Persentase kehadiran hari ini
 * - Daftar absensi terbaru
 */
class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total data
        $totalSiswa = Siswa::count();
        $totalGuru  = User::where('role', 'guru')->count();

        // Statistik absensi hari ini
        $today        = Carbon::today();
        $absensiToday = Absensi::whereDate('waktu_scan', $today)->count();
        $hadirToday   = Absensi::whereDate('waktu_scan', $today)->where('status', 'hadir')->count();
        $sakitToday   = Absensi::whereDate('waktu_scan', $today)->where('status', 'sakit')->count();
        $izinToday    = Absensi::whereDate('waktu_scan', $today)->where('status', 'izin')->count();
        $alfaToday    = Absensi::whereDate('waktu_scan', $today)->where('status', 'alfa')->count();

        // Persentase kehadiran hari ini (hindari division by zero)
        $persenHadir = $totalSiswa > 0
            ? round(($hadirToday / $totalSiswa) * 100, 1)
            : 0;

        // 5 data absensi terbaru (untuk tabel ringkasan)
        $absensiTerbaru = Absensi::with('siswa')
            ->latest('waktu_scan')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalGuru',
            'absensiToday',
            'hadirToday',
            'sakitToday',
            'izinToday',
            'alfaToday',
            'persenHadir',
            'absensiTerbaru',
        ));
    }
}
