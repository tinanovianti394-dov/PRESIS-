{{--
    Template PDF Rekapitulasi Presensi — PRESIS (Presensi Siswa)
    Dirender oleh DomPDF. Semua styling inline agar kompatibel.
--}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Presensi - PRESIS</title>
    <style>
        /* ============================
           BASE RESET & FONT
           ============================ */
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

        /* ============================
           KOP SURAT (HEADER RESMI)
           ============================ */
        .kop-surat {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }

        .kop-surat .instansi {
            font-size: 11px;
            font-weight: normal;
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

        /* ============================
           JUDUL DOKUMEN
           ============================ */
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

        /* ============================
           RINGKASAN STATISTIK
           ============================ */
        .ringkasan {
            width: 100%;
            margin-bottom: 16px;
            border-collapse: collapse;
        }

        .ringkasan td {
            padding: 6px 10px;
            border: 1px solid #ccc;
            text-align: center;
            width: 25%;
        }

        .ringkasan .label {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #555;
        }

        .ringkasan .value {
            font-size: 16px;
            font-weight: bold;
            margin-top: 2px;
        }

        .ringkasan .hadir { background-color: #dcfce7; }
        .ringkasan .sakit { background-color: #dbeafe; }
        .ringkasan .izin  { background-color: #fef3c7; }
        .ringkasan .alfa  { background-color: #fee2e2; }

        /* ============================
           TABEL DATA UTAMA
           ============================ */
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
            padding: 6px 8px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: center;
        }

        .tabel-rekap td {
            border: 1px solid #000;
            padding: 5px 8px;
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
            padding: 6px 8px;
            border: 1px solid #000;
        }

        /* Warna status di header */
        .th-hadir { background-color: #dcfce7; }
        .th-sakit { background-color: #dbeafe; }
        .th-izin  { background-color: #fef3c7; }
        .th-alfa  { background-color: #fee2e2; }

        /* ============================
           TANDA TANGAN
           ============================ */
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

        /* ============================
           FOOTER
           ============================ */
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

        /* ============================
           PESAN KOSONG
           ============================ */
        .empty-msg {
            text-align: center;
            padding: 20px;
            color: #999;
            font-style: italic;
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

    {{-- ============ JUDUL DOKUMEN ============ --}}
    <div class="judul-dokumen">
        <h2>Laporan Rekapitulasi Presensi Siswa</h2>
        <div class="periode">
            Periode: {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }}
            s/d {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}
            @if($selectedKelas)
                &mdash; Kelas: {{ $selectedKelas }}
            @endif
        </div>
    </div>

    {{-- ============ RINGKASAN STATISTIK ============ --}}
    <table class="ringkasan">
        <tr>
            <td class="hadir">
                <div class="label">Total Hadir</div>
                <div class="value">{{ $totalHadirGlobal }}</div>
            </td>
            <td class="sakit">
                <div class="label">Total Sakit</div>
                <div class="value">{{ $totalSakitGlobal }}</div>
            </td>
            <td class="izin">
                <div class="label">Total Izin</div>
                <div class="value">{{ $totalIzinGlobal }}</div>
            </td>
            <td class="alfa">
                <div class="label">Total Alfa</div>
                <div class="value">{{ $totalAlfaGlobal }}</div>
            </td>
        </tr>
    </table>

    {{-- ============ TABEL DATA REKAP ============ --}}
    <table class="tabel-rekap">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 80px;">NISN</th>
                <th>Nama Siswa</th>
                <th style="width: 70px;">Kelas</th>
                <th class="th-hadir" style="width: 45px;">Hadir</th>
                <th class="th-sakit" style="width: 45px;">Sakit</th>
                <th class="th-izin" style="width: 45px;">Izin</th>
                <th class="th-alfa" style="width: 45px;">Alfa</th>
                <th style="width: 55px;">% Hadir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $index => $row)
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td class="center bold">{{ $row['nisn'] }}</td>
                    <td class="bold">{{ $row['nama'] }}</td>
                    <td class="center">{{ $row['kelas'] }}</td>
                    <td class="center">{{ $row['hadir'] }}</td>
                    <td class="center">{{ $row['sakit'] }}</td>
                    <td class="center">{{ $row['izin'] }}</td>
                    <td class="center">{{ $row['alfa'] }}</td>
                    <td class="center bold">{{ $row['persen'] }}%</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="empty-msg">
                        Tidak ada data siswa untuk kriteria ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if(count($laporan) > 0)
        <tfoot>
            <tr>
                <td colspan="4" class="center" style="font-weight: bold;">TOTAL</td>
                <td class="center">{{ $totalHadirGlobal }}</td>
                <td class="center">{{ $totalSakitGlobal }}</td>
                <td class="center">{{ $totalIzinGlobal }}</td>
                <td class="center">{{ $totalAlfaGlobal }}</td>
                <td class="center">
                    @php
                        $totalAll = $totalHadirGlobal + $totalSakitGlobal + $totalIzinGlobal + $totalAlfaGlobal;
                    @endphp
                    {{ $totalAll > 0 ? round(($totalHadirGlobal / $totalAll) * 100, 1) : 0 }}%
                </td>
            </tr>
        </tfoot>
        @endif
    </table>

    {{-- ============ TANDA TANGAN ============ --}}
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
                    <div>Bengkalis, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                    <div class="jabatan">Petugas Admin PRESIS</div>
                    <div class="spacer"></div>
                    <div class="nama">{{ $adminName }}</div>
                    <div class="nip">Administrator Sistem</div>
                </div>
            </td>
        </tr>
    </table>

    {{-- ============ FOOTER ============ --}}
    <div class="footer">
        Dokumen ini dicetak otomatis oleh Sistem PRESIS (Presensi Siswa) SMKN 3 Bengkalis — {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB
    </div>

</body>
</html>

