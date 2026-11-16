<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$siswa = new \App\Models\Siswa();
$siswa->id = 1;
$siswa->nama = 'AHMAD REZKY';
$siswa->nisn = '0109401780';
$siswa->kelas = 'XI TKJ 1';
$siswa->no_hp_orangtua = '081234567801';

$absensiHariIni = null;
$hadirBulan = 18;
$sakitBulan = 1;
$izinBulan = 0;
$alfaBulan = 0;
$persenHadir = 90.0;
$hariKerja = 20;
$riwayatAbsensi = collect([]);

$encryptedPayload = \App\Services\QrCryptoService::generateSiswaQrPayload($siswa, 'card');
$qrCodeSvg = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(190)->margin(0)->generate($encryptedPayload);

$renderedPortal = view('siswa.portal', compact(
    'siswa', 'absensiHariIni', 'hadirBulan', 'sakitBulan', 'izinBulan',
    'alfaBulan', 'persenHadir', 'hariKerja', 'riwayatAbsensi',
    'encryptedPayload', 'qrCodeSvg'
))->render();
echo "RENDER PORTAL SUCCESS: " . strlen($renderedPortal) . " bytes\n";

$renderedQr = view('siswa.qrcode', compact('siswa', 'encryptedPayload', 'qrCodeSvg'))->render();
echo "RENDER QRCODE SUCCESS: " . strlen($renderedQr) . " bytes\n";
