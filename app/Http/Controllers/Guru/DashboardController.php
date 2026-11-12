<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * Controller Dashboard Guru.
 *
 * Menampilkan:
 * - Ringkasan absensi hari ini yang diinput guru ini
 * - Tombol akses cepat ke halaman scanner QR
 * - Riwayat absensi yang pernah guru ini validasi
 */
class DashboardController extends Controller
{
    public function index()
    {
        $guru  = Auth::user();
        $today = Carbon::today();

        // Statistik absensi hari ini yang diinput oleh guru ini
        $absensiGuru = Absensi::where('id_user', $guru->id)
            ->whereDate('waktu_scan', $today);

        $totalScanHariIni = $absensiGuru->count();
        $hadirHariIni     = (clone $absensiGuru)->where('status', 'hadir')->count();
        $tidakHadirIni    = $totalScanHariIni - $hadirHariIni;

        // 10 absensi terbaru yang diinput guru ini
        $absensiTerbaru = Absensi::with('siswa')
            ->where('id_user', $guru->id)
            ->latest('waktu_scan')
            ->take(10)
            ->get();

        return view('guru.dashboard', compact(
            'guru',
            'totalScanHariIni',
            'hadirHariIni',
            'tidakHadirIni',
            'absensiTerbaru',
        ));
    }
}
