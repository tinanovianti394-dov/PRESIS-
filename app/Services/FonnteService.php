<?php

namespace App\Services;

use App\Models\Absensi;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

/**
 * Service Integrasi WhatsApp Gateway Fonnte API.
 *
 * Sesuai aturan skripsi:
 * - Menggunakan Guzzle HTTP Client
 * - Endpoint: https://api.fonnte.com/send
 * - Mengirim pesan notifikasi presensi siswa secara real-time ke nomor HP orang tua
 * - Memiliki fallback logging jika token belum dikonfigurasi agar sistem tetap berjalan
 */
class FonnteService
{
    /**
     * Endpoint resmi Fonnte API untuk pengiriman pesan WhatsApp.
     */
    private const API_URL = 'https://api.fonnte.com/send';

    /**
     * Guzzle HTTP Client instance.
     */
    protected Client $client;

    /**
     * Token API Fonnte dari file .env (FONNTE_TOKEN).
     */
    protected ?string $token;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 10.0, // Batas timeout 10 detik agar tidak menggantung
        ]);
        $this->token = env('FONNTE_TOKEN');
    }

    /**
     * Normalisasi nomor telepon ke format internasional (628xxx).
     * Contoh:
     * - 08123456789 -> 628123456789
     * - +628123456789 -> 628123456789
     * - 628123456789 -> 628123456789
     */
    public static function formatPhoneNumber(?string $phone): ?string
    {
        if (empty($phone)) {
            return null;
        }

        // Hapus karakter selain angka
        $cleaned = preg_replace('/[^0-9]/', '', $phone);

        // Jika diawali 08, ubah 0 jadi 62
        if (str_starts_with($cleaned, '08')) {
            $cleaned = '62' . substr($cleaned, 1);
        }

        return $cleaned;
    }

    /**
     * Kirim pesan teks WhatsApp melalui Fonnte API.
     *
     * @param string $target Nomor HP tujuan (format: 628xxx)
     * @param string $message Isi pesan WhatsApp
     * @return array Status hasil pengiriman [success => bool, message => string]
     */
    public function sendMessage(string $target, string $message): array
    {
        $formattedTarget = self::formatPhoneNumber($target);

        if (!$formattedTarget) {
            return [
                'success' => false,
                'message' => 'Nomor HP tujuan kosong atau tidak valid.',
            ];
        }

        // Jika token Fonnte belum diisi di .env, kita jalankan mode simulasi (Logged)
        if (empty($this->token) || $this->token === 'your_fonnte_token_here') {
            Log::info("Fonnte WA Simulation to {$formattedTarget}: \n{$message}");
            return [
                'success' => true,
                'simulated' => true,
                'message' => 'Simulasi WhatsApp berhasil dicatat ke sistem log (FONNTE_TOKEN belum diisi).',
            ];
        }

        try {
            // Request POST ke Fonnte API menggunakan Guzzle HTTP
            $response = $this->client->post(self::API_URL, [
                'headers' => [
                    'Authorization' => $this->token,
                ],
                'form_params' => [
                    'target'      => $formattedTarget,
                    'message'     => $message,
                    'countryCode' => '62',
                ],
            ]);

            $body = json_decode($response->getBody()->getContents(), true);

            $isSuccess = ($response->getStatusCode() === 200 && ($body['status'] ?? false) === true);

            if ($isSuccess) {
                Log::info("WhatsApp Fonnte terkirim ke {$formattedTarget}");
            } else {
                Log::warning("Fonnte response failure: " . json_encode($body));
            }

            return [
                'success' => $isSuccess,
                'simulated' => false,
                'response' => $body,
                'message' => $isSuccess ? 'Pesan WhatsApp berhasil dikirim.' : ($body['reason'] ?? 'Gagal kirim WA.'),
            ];
        } catch (GuzzleException $e) {
            Log::error("Fonnte GuzzleException ke {$formattedTarget}: " . $e->getMessage());
            return [
                'success' => false,
                'simulated' => false,
                'message' => 'Terjadi kesalahan jaringan saat menghubungi Fonnte: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Kirim notifikasi kehadiran absensi ke nomor HP orang tua siswa.
     *
     * @param Absensi $absensi Model Absensi yang baru saja dicatat
     * @return array Status hasil pengiriman
     */
    public function sendAbsensiNotification(Absensi $absensi): array
    {
        // Pastikan relasi siswa dan guru sudah dimuat
        $absensi->loadMissing(['siswa', 'guru']);

        $siswa = $absensi->siswa;
        if (!$siswa || empty($siswa->no_hp_orangtua)) {
            return [
                'success' => false,
                'message' => 'Data siswa atau nomor HP orang tua tidak tersedia.',
            ];
        }

        $waktuStr = $absensi->waktu_scan
            ? $absensi->waktu_scan->format('d/m/Y H:i') . ' WIB'
            : now()->format('d/m/Y H:i') . ' WIB';

        $guruNama = $absensi->guru ? $absensi->guru->name : 'Petugas Presensi';

        // Susun template pesan notifikasi resmi SMKN 3 Bengkalis
        $statusUpper = strtoupper($absensi->status);
        $message = "📢 *PRESIS - SMKN 3 BENGKALIS*\n"
                 . "─────────────────────────\n"
                 . "Yth. Orang Tua / Wali Murid,\n\n"
                 . "Berikut informasi kehadiran putra/putri Anda:\n"
                 . "▪ *Nama* : {$siswa->nama}\n"
                 . "▪ *NISN* : {$siswa->nisn}\n"
                 . "▪ *Kelas*: {$siswa->kelas}\n"
                 . "▪ *Status Presensi*: *{$statusUpper}*\n"
                 . "▪ *Waktu Scan*    : {$waktuStr}\n"
                 . "▪ *Guru Petugas*  : {$guruNama}\n";

        if (!empty($absensi->keterangan)) {
            $message .= "▪ *Keterangan*    : {$absensi->keterangan}\n";
        }

        $message .= "\n─────────────────────────\n"
                  . "Pesan ini dikirim otomatis oleh Sistem Presensi Siswa (PRESIS) SMKN 3 Bengkalis.";

        return $this->sendMessage($siswa->no_hp_orangtua, $message);
    }
}
