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

        // 10 riwayat absensi terakhir
        $riwayatAbsensi = Absensi::where('nisn', $siswa->nisn)
            ->latest('waktu_scan')
            ->take(10)
            ->get();

        return view('siswa.dashboard', compact(
            'siswa',
            'absensiHariIni',
            'hadirBulan',
            'sakitBulan',
            'izinBulan',
            'alfaBulan',
            'persenHadir',
            'hariKerja',
            'riwayatAbsensi',
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
     * Halaman Kartu QR Code Siswa Terenkripsi AES-128-CBC.
     */
    public function showQrCode()
    {
        $siswa = Auth::guard('siswa')->user();

        // 1. Enkripsi payload data siswa menggunakan OpenSSL AES-128-CBC (tipe: dynamic dengan batas kadaluarsa)
        $encryptedPayload = QrCryptoService::generateSiswaQrPayload($siswa, 'dynamic');

        // 2. Generate gambar QR Code dalam format SVG menggunakan Simple QrCode
        $qrCodeSvg = QrCode::size(240)
            ->margin(1)
            ->generate($encryptedPayload);

        // 3. Ambil masa berlaku QR dari konfigurasi
        $expirySeconds = QrCryptoService::getExpirySeconds();

        return view('siswa.qrcode', compact('siswa', 'encryptedPayload', 'qrCodeSvg', 'expirySeconds'));
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
