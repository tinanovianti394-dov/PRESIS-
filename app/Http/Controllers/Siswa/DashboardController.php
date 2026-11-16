<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Services\QrCryptoService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/**
 * Controller Portal Siswa PRESIS.
 *
 * Mengelola fitur:
 * 1. Dashboard utama (status hari ini & ringkasan statistik)
 * 2. Kartu QR Code siswa yang terenkripsi AES-128-CBC
 * 3. Riwayat absensi lengkap siswa
 */
class DashboardController extends Controller
{
    /**
     * Halaman Utama Dashboard / Portal Siswa.
     */
    public function index()
    {
        $siswa = Auth::guard('siswa')->user();

        // Status absensi hari ini
        $today          = Carbon::today();
        $absensiHariIni = Absensi::where('nisn', $siswa->nisn)
            ->whereDate('waktu_scan', $today)
            ->first();

        // Statistik bulan ini
        $bulanIni     = Carbon::now()->startOfMonth();
        $absensiBulan = Absensi::where('nisn', $siswa->nisn)
            ->whereDate('waktu_scan', '>=', $bulanIni);

        $hadirBulan = (clone $absensiBulan)->where('status', 'hadir')->count();
        $sakitBulan = (clone $absensiBulan)->where('status', 'sakit')->count();
        $izinBulan  = (clone $absensiBulan)->where('status', 'izin')->count();
        $alfaBulan  = (clone $absensiBulan)->where('status', 'alfa')->count();

        // Hitung hari kerja (Senin-Jumat) dari awal bulan sampai hari ini
        $hariKerja = 0;
        $current   = $bulanIni->copy();
        while ($current->lte(Carbon::today())) {
            if ($current->isWeekday()) {
                $hariKerja++;
            }
            $current->addDay();
        }

        $persenHadir = $hariKerja > 0
            ? round(($hadirBulan / $hariKerja) * 100, 1)
            : 0;

        // 5 riwayat absensi terakhir untuk portal ringkas
        $riwayatAbsensi = Absensi::where('nisn', $siswa->nisn)
            ->latest('waktu_scan')
            ->take(5)
            ->get();

        // 1. Generate payload data siswa berstandar AES-128-CBC (Tipe 'card' - Statis Permanen)
        $encryptedPayload = QrCryptoService::generateSiswaQrPayload($siswa, 'card');

        // 2. Generate visualisasi QR Code SVG tajam tanpa margin untuk kartu digital portal
        $qrCodeSvg = QrCode::size(190)
            ->margin(0)
            ->generate($encryptedPayload);

        return view('siswa.portal', compact(
            'siswa',
            'absensiHariIni',
            'hadirBulan',
            'sakitBulan',
            'izinBulan',
            'alfaBulan',
            'persenHadir',
            'hariKerja',
            'riwayatAbsensi',
            'encryptedPayload',
            'qrCodeSvg'
        ));
    }

    /**
     * Halaman Cetak Kartu ID CR80 (85.6mm × 54mm) — Standar Internasional.
     * Dioptimalkan untuk print ke PVC Card / kertas foto ukuran kartu identitas.
     */
    public function cetakKartu()
    {
        $siswa = Auth::guard('siswa')->user();

        // Gunakan tipe 'card' (permanen, tanpa expiry) untuk kartu cetak fisik
        $encryptedPayload = QrCryptoService::generateSiswaQrPayload($siswa, 'card');

        // Generate QR Code SVG ukuran 120px (optimal untuk kontainer 32mm di kartu CR80)
        $qrCodeSvg = QrCode::size(120)
            ->margin(0)
            ->generate($encryptedPayload);

        return view('siswa.cetak-kartu', compact('siswa', 'encryptedPayload', 'qrCodeSvg'));
    }

    /**
     * Halaman Kartu QR Code Siswa Terenkripsi AES-128-CBC (Murni Read-Only Statis).
     */
    public function showQrCode()
    {
        $siswa = Auth::guard('siswa')->user();

        // Gunakan tipe 'card' (permanen, tanpa expiry) selaras dengan ID card fisik
        $encryptedPayload = QrCryptoService::generateSiswaQrPayload($siswa, 'card');

        $qrCodeSvg = QrCode::size(200)
            ->margin(0)
            ->generate($encryptedPayload);

        return view('siswa.qrcode', compact('siswa', 'encryptedPayload', 'qrCodeSvg'));
    }

    /**
     * Halaman Riwayat Lengkap Absensi Siswa.
     */
    public function riwayat(Request $request)
    {
        $siswa = Auth::guard('siswa')->user();

        // Filter berdasarkan bulan (default: bulan & tahun sekarang)
        $selectedBulan = $request->input('bulan', date('Y-m'));
        $dateFilter    = Carbon::createFromFormat('Y-m', $selectedBulan);

        $query = Absensi::where('nisn', $siswa->nisn)
            ->whereYear('waktu_scan', $dateFilter->year)
            ->whereMonth('waktu_scan', $dateFilter->month)
            ->with('guru')
            ->latest('waktu_scan');

        // Optional filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $absensiList = $query->paginate(15)->withQueryString();

        // Statistik bulan yang dipilih
        $totalHadir = Absensi::where('nisn', $siswa->nisn)
            ->whereYear('waktu_scan', $dateFilter->year)
            ->whereMonth('waktu_scan', $dateFilter->month)
            ->where('status', 'hadir')
            ->count();

        $totalSakit = Absensi::where('nisn', $siswa->nisn)
            ->whereYear('waktu_scan', $dateFilter->year)
            ->whereMonth('waktu_scan', $dateFilter->month)
            ->where('status', 'sakit')
            ->count();

        $totalIzin = Absensi::where('nisn', $siswa->nisn)
            ->whereYear('waktu_scan', $dateFilter->year)
            ->whereMonth('waktu_scan', $dateFilter->month)
            ->where('status', 'izin')
            ->count();

        $totalAlfa = Absensi::where('nisn', $siswa->nisn)
            ->whereYear('waktu_scan', $dateFilter->year)
            ->whereMonth('waktu_scan', $dateFilter->month)
            ->where('status', 'alfa')
            ->count();

        return view('siswa.riwayat', compact(
            'siswa',
            'absensiList',
            'selectedBulan',
            'totalHadir',
            'totalSakit',
            'totalIzin',
            'totalAlfa',
        ));
    }
}
