<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller Absensi Guru.
 *
 * Mengelola:
 * 1. Daftar data absensi yang discan atau terdaftar di sekolah
 * 2. Rekap harian absensi per kelas (tampilan web & export PDF)
 */
class AbsensiController extends Controller
{
    /**
     * Hitung rekap harian absensi per kelas.
     */
    private function buildDailyRekap(string $selectedTanggal): array
    {
        $kelasList = Siswa::select('kelas')->distinct()->pluck('kelas');
        $rekapData = [];

        foreach ($kelasList as $kelas) {
            $totalSiswaKelas = Siswa::where('kelas', $kelas)->count();

            $hadir = Absensi::whereDate('waktu_scan', $selectedTanggal)
                ->where('status', 'hadir')
                ->whereHas('siswa', fn($q) => $q->where('kelas', $kelas))
                ->count();

            $sakit = Absensi::whereDate('waktu_scan', $selectedTanggal)
                ->where('status', 'sakit')
                ->whereHas('siswa', fn($q) => $q->where('kelas', $kelas))
                ->count();

            $izin = Absensi::whereDate('waktu_scan', $selectedTanggal)
                ->where('status', 'izin')
                ->whereHas('siswa', fn($q) => $q->where('kelas', $kelas))
                ->count();

            $alfa = Absensi::whereDate('waktu_scan', $selectedTanggal)
                ->where('status', 'alfa')
                ->whereHas('siswa', fn($q) => $q->where('kelas', $kelas))
                ->count();

            $belumScan = max(0, $totalSiswaKelas - ($hadir + $sakit + $izin + $alfa));
            $persenHadir = $totalSiswaKelas > 0 ? round(($hadir / $totalSiswaKelas) * 100, 1) : 0;

            $rekapData[] = [
                'kelas'       => $kelas,
                'total_siswa' => $totalSiswaKelas,
                'hadir'       => $hadir,
                'sakit'       => $sakit,
                'izin'        => $izin,
                'alfa'        => $alfa,
                'belum_scan'  => $belumScan,
                'persen'      => $persenHadir,
            ];
        }

        return $rekapData;
    }

    /**
     * Tampilkan data absensi dengan filter tanggal, kelas, dan status.
     */
    public function index(Request $request)
    {
        $guru = Auth::user();

        $selectedTanggal = $request->input('tanggal', Carbon::today()->format('Y-m-d'));
        $selectedKelas   = $request->input('kelas');
        $selectedStatus  = $request->input('status');

        $query = Absensi::with(['siswa', 'guru'])
            ->whereDate('waktu_scan', $selectedTanggal)
            ->latest('waktu_scan');

        if (!empty($selectedKelas)) {
            $query->whereHas('siswa', function ($q) use ($selectedKelas) {
                $q->where('kelas', $selectedKelas);
            });
        }

        if (!empty($selectedStatus)) {
            $query->where('status', $selectedStatus);
        }

        $absensiList = $query->paginate(20)->withQueryString();

        // Daftar kelas yang ada untuk dropdown filter
        $kelasList = Siswa::select('kelas')->distinct()->pluck('kelas');

        // Ringkasan per status pada tanggal yang dipilih
        $totalHadir = Absensi::whereDate('waktu_scan', $selectedTanggal)->where('status', 'hadir')->count();
        $totalSakit = Absensi::whereDate('waktu_scan', $selectedTanggal)->where('status', 'sakit')->count();
        $totalIzin  = Absensi::whereDate('waktu_scan', $selectedTanggal)->where('status', 'izin')->count();
        $totalAlfa  = Absensi::whereDate('waktu_scan', $selectedTanggal)->where('status', 'alfa')->count();

        return view('guru.absensi', compact(
            'guru',
            'absensiList',
            'selectedTanggal',
            'selectedKelas',
            'selectedStatus',
            'kelasList',
            'totalHadir',
            'totalSakit',
            'totalIzin',
            'totalAlfa',
        ));
    }

    /**
     * Tampilkan rekap harian absensi per kelas.
     */
    public function rekap(Request $request)
    {
        $guru            = Auth::user();
        $selectedTanggal = $request->input('tanggal', Carbon::today()->format('Y-m-d'));
        $rekapData       = $this->buildDailyRekap($selectedTanggal);

        return view('guru.rekap', compact(
            'guru',
            'selectedTanggal',
            'rekapData',
        ));
    }

    /**
     * Export rekap harian absensi per kelas sebagai PDF.
     */
    public function exportPdf(Request $request)
    {
        $guru            = Auth::user();
        $selectedTanggal = $request->input('tanggal', Carbon::today()->format('Y-m-d'));
        $rekapData       = $this->buildDailyRekap($selectedTanggal);

        $pdf = Pdf::loadView('guru.rekap-pdf', compact(
            'guru',
            'selectedTanggal',
            'rekapData',
        ));

        $pdf->setPaper('A4', 'landscape');

        $fileName = 'rekap_harian_' . $selectedTanggal . '.pdf';

        return $pdf->download($fileName);
    }
}
