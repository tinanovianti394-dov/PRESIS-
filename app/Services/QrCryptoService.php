<?php

namespace App\Services;

use App\Models\Siswa;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Service Kriptografi QR Code menggunakan AES-128-CBC.
 *
 * Sesuai aturan skripsi:
 * - Menggunakan OpenSSL dengan algoritma AES-128-CBC
 * - Menggabungkan IV (Initialization Vector) acak 16-byte di depan ciphertext
 * - Output di-encode menggunakan Base64 agar aman dijadikan teks QR Code
 * - Mudah dijelaskan saat sidang skripsi:
 *   1. Plaintext dibuat dalam format JSON (nisn, nama, timestamp, dll.)
 *   2. Generate IV acak 16 byte dengan random_bytes(16)
 *   3. Enkripsi dengan openssl_encrypt($plaintext, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv)
 *   4. Gabungkan: IV (16 byte) + Ciphertext
 *   5. Encode Base64: base64_encode($iv . $ciphertext)
 */
class QrCryptoService
{
    /**
     * Panjang kunci AES-128 adalah 16 byte (128 bit).
     */
    private const KEY_LENGTH = 16;

    /**
     * Panjang IV untuk CBC mode adalah 16 byte (128 bit).
     */
    private const IV_LENGTH = 16;

    /**
     * Cipher method yang digunakan.
     */
    private const CIPHER_METHOD = 'AES-128-CBC';

    /**
     * Mengambil kunci rahasia 16-byte dari konfigurasi aplikasi.
     * Jika APP_KEY atau QR_SECRET_KEY belum 16 byte, kita derivasi menggunakan sha256 dipotong 16 byte.
     */
    public static function getSecretKey(): string
    {
        $rawKey = env('QR_SECRET_KEY', config('app.key', 'PresisSecret123!'));

        // Jika diawali dengan 'base64:', decode terlebih dahulu
        if (str_starts_with($rawKey, 'base64:')) {
            $rawKey = base64_decode(substr($rawKey, 7));
        }

        // Ambil hash SHA-256 lalu potong tepat 16 byte untuk AES-128
        return substr(hash('sha256', $rawKey, true), 0, self::KEY_LENGTH);
    }

    /**
     * Enkripsi array data menjadi string Base64 yang siap dijadikan QR Code.
     *
     * @param array $payload Data yang akan dienkripsi (misal: ['nisn' => '...', 'timestamp' => ...])
     * @return string Ciphertext gabungan IV + ciphertext dalam format Base64
     */
    public static function encrypt(array $payload): string
    {
        $jsonString = json_encode($payload, JSON_UNESCAPED_UNICODE);
        $key        = self::getSecretKey();

        // 1. Buat Initialization Vector (IV) acak sepanjang 16 byte
        $iv = random_bytes(self::IV_LENGTH);

        // 2. Enkripsi data menggunakan OpenSSL AES-128-CBC
        $ciphertext = openssl_encrypt(
            $jsonString,
            self::CIPHER_METHOD,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        if ($ciphertext === false) {
            throw new Exception('Gagal mengenkripsi data QR Code dengan AES-128-CBC: ' . openssl_error_string());
        }

        // 3. Gabungkan IV (16 byte awal) + Ciphertext, lalu di-Base64
        return base64_encode($iv . $ciphertext);
    }

    /**
     * Dekripsi string Base64 kembali menjadi array data asli.
     *
     * @param string $base64Payload String dari scan QR Code
     * @return array|null Array payload hasil dekripsi, atau null jika gagal/palsu
     */
    public static function decrypt(string $base64Payload): ?array
    {
        try {
            // Bersihkan spasi atau karakter newline
            $base64Payload = trim($base64Payload);
            $rawBinary     = base64_decode($base64Payload, true);

            // Payload harus valid dan panjangnya minimal lebih besar dari ukuran IV (16 byte)
            if ($rawBinary === false || strlen($rawBinary) <= self::IV_LENGTH) {
                Log::warning('Dekripsi QR gagal: payload base64 tidak valid atau terlalu pendek.');
                return null;
            }

            // 1. Ekstrak IV dari 16 byte pertama
            $iv = substr($rawBinary, 0, self::IV_LENGTH);

            // 2. Ekstrak ciphertext setelah 16 byte pertama
            $ciphertext = substr($rawBinary, self::IV_LENGTH);

            $key = self::getSecretKey();

            // 3. Dekripsi menggunakan OpenSSL AES-128-CBC
            $decryptedJson = openssl_decrypt(
                $ciphertext,
                self::CIPHER_METHOD,
                $key,
                OPENSSL_RAW_DATA,
                $iv
            );

            if ($decryptedJson === false) {
                Log::warning('Dekripsi QR gagal: kunci salah atau ciphertext rusak.');
                return null;
            }

            $data = json_decode($decryptedJson, true);

            return is_array($data) ? $data : null;
        } catch (Exception $e) {
            Log::error('Exception saat dekripsi QR: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Mengambil durasi masa berlaku QR Code dinamis dalam detik dari environment.
     * Nilai default adalah 300 detik (5 menit). Nilai 0 berarti tidak ada batas waktu.
     */
    public static function getExpirySeconds(): int
    {
        return (int) env('QR_EXPIRY_SECONDS', 300);
    }

    /**
     * Helper khusus: Membuat token QR terenkripsi untuk seorang Siswa.
     * Payload berisi:
     * - nisn: NISN siswa
     * - nama: Nama siswa
     * - kelas: Kelas siswa
     * - type: 'dynamic' (di HP siswa) atau 'card' (kartu cetak fisik)
     * - created_at: Unix timestamp pembuatan QR
     * - expires_at: Unix timestamp batas waktu berlaku (null jika permanen/kartu cetak)
     *
     * @param Siswa $siswa Data siswa pemilik QR
     * @param string $type Jenis QR: 'dynamic' (bisa kadaluarsa) atau 'card' (permanen)
     * @return string Ciphertext gabungan IV + ciphertext dalam format Base64
     */
    public static function generateSiswaQrPayload(Siswa $siswa, string $type = 'dynamic'): string
    {
        $now = now()->timestamp;
        $expirySeconds = self::getExpirySeconds();

        // Kartu cetak fisik ('card') tidak memiliki batas kadaluarsa
        $expiresAt = ($type === 'dynamic' && $expirySeconds > 0)
            ? ($now + $expirySeconds)
            : null;

        $payload = [
            'nisn'       => $siswa->nisn,
            'nama'       => $siswa->nama,
            'kelas'      => $siswa->kelas,
            'type'       => $type,
            'created_at' => $now,
            'expires_at' => $expiresAt,
        ];

        return self::encrypt($payload);
    }

    /**
     * Validasi masa berlaku (expiry) payload QR Code hasil dekripsi.
     *
     * @param array $payload Data payload hasil dekripsi
     * @return array [
     *     'expired'   => bool,
     *     'message'   => string,
     *     'remaining' => int, // sisa detik jika valid, 0 jika kadaluarsa, -1 jika permanen
     *     'type'      => string ('dynamic'|'card'|'legacy')
     * ]
     */
    public static function checkExpiry(array $payload): array
    {
        $type = $payload['type'] ?? 'dynamic';

        // 1. Kartu cetak fisik ('card') bersifat permanen
        if ($type === 'card') {
            return [
                'expired'   => false,
                'message'   => 'Kartu Fisik Cetak (Permanen)',
                'remaining' => -1,
                'type'      => 'card',
            ];
        }

        $now = now()->timestamp;

        // 2. Jika payload memiliki field 'expires_at' eksplisit
        if (array_key_exists('expires_at', $payload) && $payload['expires_at'] !== null) {
            $expiresAt = (int) $payload['expires_at'];
            if ($now > $expiresAt) {
                $selisih = $now - $expiresAt;
                $menit   = floor($selisih / 60);
                $detik   = $selisih % 60;
                $teks    = $menit > 0 ? "{$menit} menit {$detik} detik" : "{$detik} detik";

                return [
                    'expired'   => true,
                    'message'   => "QR Code telah kadaluarsa ({$teks} yang lalu).",
                    'remaining' => 0,
                    'type'      => $type,
                ];
            }

            return [
                'expired'   => false,
                'message'   => 'QR Code masih berlaku.',
                'remaining' => max(0, $expiresAt - $now),
                'type'      => $type,
            ];
        }

        // 3. Fallback untuk payload lawas (legacy) yang hanya memiliki 'created_at'
        $expirySeconds = self::getExpirySeconds();
        if ($expirySeconds > 0 && isset($payload['created_at'])) {
            $createdAt = (int) $payload['created_at'];
            $usia      = $now - $createdAt;

            if ($usia > $expirySeconds) {
                $lewat = $usia - $expirySeconds;
                return [
                    'expired'   => true,
                    'message'   => "QR Code telah melewati batas waktu ({$lewat} detik yang lalu).",
                    'remaining' => 0,
                    'type'      => 'legacy',
                ];
            }

            return [
                'expired'   => false,
                'message'   => 'QR Code masih berlaku.',
                'remaining' => max(0, $expirySeconds - $usia),
                'type'      => 'legacy',
            ];
        }

        // 4. Jika batas waktu dinonaktifkan (QR_EXPIRY_SECONDS = 0)
        return [
            'expired'   => false,
            'message'   => 'QR Code valid tanpa batas waktu.',
            'remaining' => -1,
            'type'      => $type,
        ];
    }
}
