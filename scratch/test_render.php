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

$rendered = view('siswa.cetak-kartu', ['siswa' => $siswa])->render();
file_put_contents(__DIR__ . '/cetak_output.html', $rendered);
echo "RENDER SUCCESS: " . strlen($rendered) . " bytes\n";
