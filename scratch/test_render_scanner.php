<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$guru = new \App\Models\User();
$guru->id = 2;
$guru->name = 'AHMAD DAROINI, S.Ag';
$guru->nip = '198501012010011002';
$guru->role = 'guru';

$scanHariIni = collect([]);

$rendered = view('guru.scanner', compact('guru', 'scanHariIni'))->render();
echo "RENDER SCANNER SUCCESS: " . strlen($rendered) . " bytes\n";
