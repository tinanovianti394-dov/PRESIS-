<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Services\FonnteService;
use App\Services\QrCryptoService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller Scanner QR Code Guru.
 *
 * Mengelola pemindaian QR Code terenkripsi siswa menggunakan html5-qrcode:
 * 1. Menampilkan antarmuka pemindai kamera (html5-qrcode JS)
 * 2. Menerima payload QR via AJAX
 * 3. Mendekripsi AES-128-CBC
 * 4. Menyimpan data absensi ke database
 * 5. Memicu pengiriman notifikasi WhatsApp ke orang tua via Fonnte
 */
class ScannerController extends Controller
{
    /**
     * Tampilkan halaman pemindai kamera QR Code.
     */
    public function index()
    {
        $guru = Auth::user();
        
        // Ambil 5 riwayat scan terakhir hari ini oleh guru ini untuk live list
        $scanHariIni = Absensi::with('siswa')
            ->where('id_user', $guru->id)
            ->whereDate('waktu_scan', Carbon::today())
            ->latest('waktu_scan')
            ->take(5)
            ->get();

        return view('guru.scanner', compact('guru', 'scanHariIni'));
    }

    /**
     * Memproses payload hasil pemindaian kamera QR Code via AJAX.
     *
     * @param Request $request Berisi field 'qr_payload' (string base64 ciphertext)
     * @param FonnteService $fonnteService Service WhatsApp Gateway
     * @return JsonResponse Status proses absensi
     */
    public function processScan(Request $request, FonnteService $fonnteService): JsonResponse
    {
        $request->validate([
            'qr_payload' => 'required|string',
        ]);

        $rawPayload = trim($request->input('qr_payload'));

        // 1. Dekripsi data QR Code menggunakan AES-128-CBC
        $decryptedData = QrCryptoService::decrypt($rawPayload);

        if (!$decryptedData || empty($decryptedData['nisn'])) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code TIDAK VALID! Pastikan siswa menggunakan QR Code resmi dari aplikasi PRESIS.',
            ], 422);
        }

        // 2. Validasi masa berlaku (expiry) QR Code
        $expiryCheck = QrCryptoService::checkExpiry($decryptedData);
        if ($expiryCheck['expired']) {
            return response()->json([
                'success' => false,
                'expired' => true,
                'message' => 'QR Code SUDAH KADALUARSA! ' . $expiryCheck['message'] . ' Minta siswa menekan tombol "REFRESH QR TOKEN" di ponselnya.',
            ], 422);
        }

        $nisn = $decryptedData['nisn'];

        // 3. Cari data siswa berdasarkan NISN hasil dekripsi
        $siswa = Siswa::where('nisn', $nisn)->first();

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => "Data siswa dengan NISN {$nisn} tidak terdaftar di sistem!",
            ], 404);
        }

        // 3. Cek apakah siswa sudah melakukan absensi pada hari ini
        $today          = Carbon::today();
        $alreadyScanned = Absensi::where('nisn', $siswa->nisn)
            ->whereDate('waktu_scan', $today)
            ->first();

        if ($alreadyScanned) {
            return response()->json([
                'success'        => false,
                'already_scanned' => true,
                'message'        => "Siswa {$siswa->nama} ({$siswa->kelas}) SUDAH ABSENSI hari ini pada pukul " . $alreadyScanned->waktu_scan->format('H:i') . ' WIB!',
                'data'           => [
                    'nama'       => $siswa->nama,
                    'nisn'       => $siswa->nisn,
                    'kelas'      => $siswa->kelas,
                    'waktu_scan' => $alreadyScanned->waktu_scan->format('H:i:s'),
                    'status'     => strtoupper($alreadyScanned->status),
                ],
            ], 200);
        }

        // 4. Simpan absensi baru ke tabel absensi
        $absensi = Absensi::create([
            'nisn'       => $siswa->nisn,
            'id_user'    => Auth::id(), // ID Guru yang sedang memindai
            'status'     => 'hadir',
            'waktu_scan' => now(),
            'keterangan' => 'Scan QR Siswa',
        ]);

        // 5. Kirim notifikasi WhatsApp ke nomor HP orang tua melalui Fonnte API
        $waResult = $fonnteService->sendAbsensiNotification($absensi);

        return response()->json([
            'success' => true,
            'message' => "Presensi BERHASIL! Selamat pagi, {$siswa->nama}.",
            'data'    => [
                'nama'         => $siswa->nama,
                'nisn'         => $siswa->nisn,
                'kelas'        => $siswa->kelas,
                'waktu_scan'   => $absensi->waktu_scan->format('H:i:s'),
                'status'       => 'HADIR',
                'wa_target'    => $siswa->no_hp_orangtua ?? '-',
                'wa_status'    => $waResult['success'] ? 'Terkirim' : 'Gagal',
                'wa_simulated' => $waResult['simulated'] ?? false,
                'wa_message'   => $waResult['message'] ?? '',
            ],
        ]);
    }
}
