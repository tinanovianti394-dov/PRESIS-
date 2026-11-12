{{--
    Template PDF Rekap Harian Presensi Per Kelas — PRESIS Guru
    Dirender oleh DomPDF.
--}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Harian Presensi - PRESIS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            line-height: 1.4;
        }

        .kop-surat {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }

        .kop-surat .instansi {
            font-size: 11px;
            color: #444;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .kop-surat .sekolah {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 2px;
        }

        .kop-surat .alamat {
            font-size: 9px;
            color: #666;
            margin-top: 4px;
        }

        .judul-dokumen {
            text-align: center;
            margin-bottom: 16px;
        }

        .judul-dokumen h2 {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: underline;
            margin-bottom: 4px;
        }

        .judul-dokumen .periode {
            font-size: 10px;
            color: #555;
        }

        .tabel-rekap {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .tabel-rekap thead tr {
            background-color: #f3f4f6;
        }

        .tabel-rekap th {
            border: 1px solid #000;
            padding: 7px 8px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
        }

        .tabel-rekap td {
            border: 1px solid #000;
            padding: 6px 8px;
            font-size: 10px;
        }

        .tabel-rekap td.center {
            text-align: center;
        }

        .tabel-rekap td.bold {
            font-weight: bold;
        }

        .tabel-rekap tbody tr:nth-child(even) {
            background-color: #fafafa;
        }

        .tabel-rekap tfoot tr {
            background-color: #f3f4f6;
            font-weight: bold;
        }

        .tabel-rekap tfoot td {
            font-size: 10px;
            padding: 7px 8px;
            border: 1px solid #000;
        }

        .th-hadir { background-color: #dcfce7; }
        .th-sakit { background-color: #dbeafe; }
        .th-izin  { background-color: #fef3c7; }
        .th-alfa  { background-color: #fee2e2; }

        .ttd-container {
            width: 100%;
            margin-top: 30px;
            page-break-inside: avoid;
        }

        .ttd-container td {
            vertical-align: top;
            padding: 0 10px;
        }

        .ttd-block {
            text-align: center;
            font-size: 10px;
        }

        .ttd-block .jabatan {
            font-weight: bold;
        }

        .ttd-block .spacer {
            height: 60px;
        }

        .ttd-block .nama {
            font-weight: bold;
            text-decoration: underline;
        }

        .ttd-block .nip {
            font-size: 9px;
            color: #444;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 4px;
        }
    </style>
</head>
<body>

    @php
        $logoPath = public_path('images/logo-smkn3.jpg');
        $logoData = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : null;
    @endphp

    {{-- ============ KOP SURAT RESMI DENGAN LOGO ============ --}}
    <table style="width: 100%; border-bottom: 3px double #000; padding-bottom: 8px; margin-bottom: 14px;">
        <tr>
            <td style="width: 70px; text-align: center; vertical-align: middle;">
                @if($logoData)
                    <img src="data:image/jpeg;base64,{{ $logoData }}" style="width: 65px; height: 65px;">
                @endif
            </td>
            <td style="text-align: center; vertical-align: middle;">
                <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #333;">Pemerintah Provinsi Riau — Dinas Pendidikan</div>
                <div style="font-size: 18px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; color: #0369a1; margin: 2px 0;">SMK NEGERI 3 BENGKALIS</div>
                <div style="font-size: 9px; color: #555;">Jl. Industri, Kelurahan Sungai Alam, Kec. Bengkalis, Kab. Bengkalis, Riau 28711</div>
            </td>
            <td style="width: 70px;"></td>
        </tr>
    </table>

    <div class="judul-dokumen">
        <h2>Rekapitulasi Kehadiran Siswa Per Kelas</h2>
        <div class="periode">
            Hari / Tanggal: {{ \Carbon\Carbon::parse($selectedTanggal)->translatedFormat('l, d F Y') }}
        </div>
    </div>

    <table class="tabel-rekap">
        <thead>
            <tr>
                <th style="width: 35px;">No</th>
                <th>Kelas</th>
                <th style="width: 80px;">Total Siswa</th>
                <th class="th-hadir" style="width: 60px;">Hadir</th>
                <th class="th-sakit" style="width: 60px;">Sakit</th>
                <th class="th-izin" style="width: 60px;">Izin</th>
                <th class="th-alfa" style="width: 60px;">Alfa</th>
                <th style="width: 75px;">Belum Scan</th>
                <th style="width: 80px;">% Hadir</th>
            </tr>
        </thead>
        <tbody>
            @php
                $sumTotal = 0; $sumHadir = 0; $sumSakit = 0; $sumIzin = 0; $sumAlfa = 0; $sumBelum = 0;
            @endphp
            @forelse($rekapData as $index => $row)
                @php
                    $sumTotal += $row['total_siswa'];
                    $sumHadir += $row['hadir'];
                    $sumSakit += $row['sakit'];
                    $sumIzin  += $row['izin'];
                    $sumAlfa  += $row['alfa'];
                    $sumBelum += $row['belum_scan'];
                @endphp
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td class="bold">{{ $row['kelas'] }}</td>
                    <td class="center bold">{{ $row['total_siswa'] }}</td>
                    <td class="center">{{ $row['hadir'] }}</td>
                    <td class="center">{{ $row['sakit'] }}</td>
                    <td class="center">{{ $row['izin'] }}</td>
                    <td class="center">{{ $row['alfa'] }}</td>
                    <td class="center">{{ $row['belum_scan'] }}</td>
                    <td class="center bold">{{ $row['persen'] }}%</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="center" style="padding: 20px; color: #999;">
                        Belum ada data kelas yang terdaftar.
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if(count($rekapData) > 0)
        <tfoot>
            <tr>
                <td colspan="2" class="center bold">TOTAL KESELURUHAN</td>
                <td class="center">{{ $sumTotal }}</td>
                <td class="center">{{ $sumHadir }}</td>
                <td class="center">{{ $sumSakit }}</td>
                <td class="center">{{ $sumIzin }}</td>
                <td class="center">{{ $sumAlfa }}</td>
                <td class="center">{{ $sumBelum }}</td>
                <td class="center">
                    {{ $sumTotal > 0 ? round(($sumHadir / $sumTotal) * 100, 1) : 0 }}%
                </td>
            </tr>
        </tfoot>
        @endif
    </table>

    <table class="ttd-container">
        <tr>
            <td width="50%">
                <div class="ttd-block">
                    <div>Mengetahui,</div>
                    <div class="jabatan">Kepala SMKN 3 Bengkalis</div>
                    <div class="spacer"></div>
                    <div class="nama">Kusno, S.Pd, M.Pd</div>
                    <div class="nip">NIP. 197001011995031002</div>
                </div>
            </td>
            <td width="50%">
                <div class="ttd-block">
                    <div>Bengkalis, {{ \Carbon\Carbon::parse($selectedTanggal)->translatedFormat('d F Y') }}</div>
                    <div class="jabatan">Guru Piket / Pemeriksa</div>
                    <div class="spacer"></div>
                    <div class="nama">{{ $guru->name }}</div>
                    <div class="nip">NIP. {{ $guru->nip ?? '-' }}</div>
                </div>
            </td>
        </tr>
    </table>

    <div class="footer">
        Dokumen ini dicetak otomatis oleh Sistem PRESIS (Presensi Siswa) SMKN 3 Bengkalis — {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB
    </div>

</body>
</html>

