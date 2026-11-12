<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Controller Laporan dan Rekapitulasi oleh Admin.
 *
 * Menghasilkan rekap absensi per periode tanggal dan kelas, serta tampilan cetak & export PDF.
 */
class RekapController extends Controller
{
    /**
     * Bangun data rekapitulasi berdasarkan filter request.
     *
     * @return array  Data rekap yang bisa dipakai oleh index() maupun exportPdf().
     */
    private function buildRekapData(Request $request): array
    {
        $startDate     = $request->input('start_date', Carbon::today()->startOfMonth()->format('Y-m-d'));
        $endDate       = $request->input('end_date', Carbon::today()->format('Y-m-d'));
        $selectedKelas = $request->input('kelas');

        $kelasList = Siswa::select('kelas')->distinct()->pluck('kelas');

        // Query siswa sesuai kelas
        $siswaQuery = Siswa::query();
        if (!empty($selectedKelas)) {
            $siswaQuery->where('kelas', $selectedKelas);
        }
        $daftarSiswa = $siswaQuery->orderBy('kelas')->orderBy('nama')->get();

        // Hitung rekap per siswa dalam rentang tanggal
        $laporan = [];
        $totalHadirGlobal = 0;
        $totalSakitGlobal = 0;
        $totalIzinGlobal  = 0;
        $totalAlfaGlobal  = 0;

        foreach ($daftarSiswa as $siswa) {
            $absensiSiswa = Absensi::where('nisn', $siswa->nisn)
                ->whereBetween('waktu_scan', [
                    Carbon::parse($startDate)->startOfDay(),
                    Carbon::parse($endDate)->endOfDay(),
                ]);

            $hadir = (clone $absensiSiswa)->where('status', 'hadir')->count();
            $sakit = (clone $absensiSiswa)->where('status', 'sakit')->count();
            $izin  = (clone $absensiSiswa)->where('status', 'izin')->count();
            $alfa  = (clone $absensiSiswa)->where('status', 'alfa')->count();
            $total = $hadir + $sakit + $izin + $alfa;

            $totalHadirGlobal += $hadir;
            $totalSakitGlobal += $sakit;
            $totalIzinGlobal  += $izin;
            $totalAlfaGlobal  += $alfa;

            $persenHadir = $total > 0 ? round(($hadir / $total) * 100, 1) : 0;

            $laporan[] = [
                'nisn'   => $siswa->nisn,
                'nama'   => $siswa->nama,
                'kelas'  => $siswa->kelas,
                'hadir'  => $hadir,
                'sakit'  => $sakit,
                'izin'   => $izin,
                'alfa'   => $alfa,
                'total'  => $total,
                'persen' => $persenHadir,
            ];
        }

        return compact(
            'laporan',
            'kelasList',
            'startDate',
            'endDate',
            'selectedKelas',
            'totalHadirGlobal',
            'totalSakitGlobal',
            'totalIzinGlobal',
            'totalAlfaGlobal',
        );
    }

    /**
     * Tampilkan rekapitulasi laporan presensi.
     */
    public function index(Request $request)
    {
        $data = $this->buildRekapData($request);

        return view('admin.rekap.index', $data);
    }

    /**
     * Export rekapitulasi sebagai file PDF (download).
     */
    public function exportPdf(Request $request)
    {
        $data = $this->buildRekapData($request);
        $data['adminName'] = $request->user()->name;

        $pdf = Pdf::loadView('admin.rekap.pdf', $data);

        $pdf->setPaper('A4', 'landscape');

        // Nama file: rekap_presensi_<tanggal_awal>_<tanggal_akhir>.pdf
        $fileName = 'rekap_presensi_' . $data['startDate'] . '_' . $data['endDate'] . '.pdf';

        return $pdf->download($fileName);
    }
}
