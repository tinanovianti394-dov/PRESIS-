{{--
    Halaman Cetak Kartu ID Presensi Siswa — Standar CR80 (85.6mm × 54mm)
    PRESIS SMKN 3 Bengkalis

    Dioptimalkan untuk pencetakan ke:
    - PVC Card Blank (via printer ID Card)
    - Kertas Foto Glossy ukuran ID Card
    - Kertas HVS A4 (1 kartu per halaman, potong manual)

    QR Code bertipe 'card' (permanen, tanpa expiry countdown).
--}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu ID — {{ $siswa->nama }} — PRESIS</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'Inter', 'system-ui', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    },
                    colors: {
                        brand: {
                            50:  '#EBF5FB',
                            100: '#D6ECF8',
                            200: '#A2CBD9',
                            500: '#046EA7',
                            600: '#035D8D',
                            700: '#024B72',
                            800: '#023A58',
                            900: '#012C43',
                        }
                    }
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }

        /* ============================================================
         * DIMENSI KARTU ID STANDAR INTERNASIONAL CR80
         * ISO/IEC 7810 ID-1 : 85.6mm × 54mm
         * ============================================================ */
        .id-card {
            width: 85.6mm;
            height: 54mm;
            overflow: hidden;
            position: relative;
            box-sizing: border-box;
        }

        /* ============================================================
         * PENGATURAN CETAK (PRINT)
         * ============================================================ */
        @page {
            size: 85.6mm 54mm landscape;
            margin: 0;
        }

        @media print {
            html, body {
                margin: 0 !important;
                padding: 0 !important;
                width: 85.6mm !important;
                height: 54mm !important;
                background: white !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Sembunyikan elemen kontrol yang tidak perlu dicetak */
            .no-print {
                display: none !important;
            }

            .id-card {
                box-shadow: none !important;
                border: none !important;
                border-radius: 0 !important;
            }
        }

        @media screen {
            .id-card {
                border-radius: 8px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.12), 0 0 0 1px rgba(0,0,0,0.05);
            }
        }

        /* QR Code container exact sizing */
        .qr-box {
            width: 32mm;
            height: 32mm;
            flex-shrink: 0;
        }
        .qr-box svg {
            width: 100% !important;
            height: 100% !important;
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex flex-col items-center justify-center p-8 print:p-0 print:bg-white antialiased">

    {{-- ============================================================
         KONTROL CETAK (Hanya tampil di layar, tersembunyi saat print)
         ============================================================ --}}
    <div class="no-print mb-6 text-center">
        <h1 class="text-lg font-bold text-slate-900 mb-1">Cetak Kartu Presensi Digital</h1>
        <p class="text-xs text-slate-500 mb-4">Standar ID Card Internasional CR80 — 85.6mm × 54mm</p>

        <div class="flex items-center justify-center gap-3">
            <button onclick="window.print()"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold bg-gradient-to-r from-brand-500 to-brand-700 text-white shadow-md hover:opacity-90 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak Kartu (Ctrl+P)
            </button>
            <a href="{{ route('siswa.qrcode') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- ============================================================
         KARTU ID CR80 — SISI DEPAN
         ============================================================ --}}
    <div class="id-card bg-white flex flex-col">

        {{-- ===================== HEADER KARTU ===================== --}}
        <div class="bg-gradient-to-r from-brand-700 via-brand-600 to-brand-500 px-[4mm] py-[2.5mm] flex items-center gap-[2mm]" style="min-height: 12mm;">
            {{-- Logo SMKN 3 Bengkalis --}}
            <div class="flex-shrink-0" style="width: 8mm; height: 8mm;">
                <img src="{{ asset('images/logo-smkn3.jpg') }}" alt="Logo" class="w-full h-full rounded object-cover" style="border: 0.5px solid rgba(255,255,255,0.3);">
            </div>
            {{-- Nama Instansi --}}
            <div class="flex-1 overflow-hidden">
                <p class="text-white font-extrabold leading-none tracking-tight" style="font-size: 7pt;">SMK NEGERI 3 BENGKALIS</p>
                <p class="text-brand-200 font-semibold leading-tight" style="font-size: 5pt; margin-top: 0.5mm;">KARTU PRESENSI DIGITAL SISWA</p>
            </div>
        </div>

        {{-- ===================== BODY KARTU ===================== --}}
        <div class="flex-1 flex items-stretch px-[4mm] py-[2mm] gap-[3mm]">

            {{-- Kolom Kiri: Data Siswa --}}
            <div class="flex-1 flex flex-col justify-center overflow-hidden" style="min-width: 0;">
                {{-- Nama --}}
                <div class="mb-[1.5mm]">
                    <p class="text-slate-400 uppercase font-bold leading-none" style="font-size: 4.5pt; letter-spacing: 0.05em;">Nama Lengkap</p>
                    <p class="text-slate-900 font-extrabold leading-tight truncate" style="font-size: 7.5pt; margin-top: 0.3mm;">{{ $siswa->nama }}</p>
                </div>

                {{-- NISN --}}
                <div class="mb-[1.5mm]">
                    <p class="text-slate-400 uppercase font-bold leading-none" style="font-size: 4.5pt; letter-spacing: 0.05em;">NISN</p>
                    <p class="text-slate-900 font-bold font-mono leading-tight" style="font-size: 7pt; margin-top: 0.3mm;">{{ $siswa->nisn }}</p>
                </div>

                {{-- Kelas --}}
                <div class="mb-[1.5mm]">
                    <p class="text-slate-400 uppercase font-bold leading-none" style="font-size: 4.5pt; letter-spacing: 0.05em;">Kelas</p>
                    <p class="text-brand-700 font-bold leading-tight" style="font-size: 7pt; margin-top: 0.3mm;">{{ $siswa->kelas }}</p>
                </div>

                {{-- Jurusan --}}
                <div>
                    <p class="text-slate-400 uppercase font-bold leading-none" style="font-size: 4.5pt; letter-spacing: 0.05em;">Jurusan</p>
                    <p class="text-slate-700 font-semibold leading-tight" style="font-size: 6pt; margin-top: 0.3mm;">Teknik Jaringan Komputer & Telekomunikasi</p>
                </div>
            </div>

            {{-- Kolom Kanan: QR Code --}}
            <div class="flex flex-col items-center justify-center flex-shrink-0">
                <div class="qr-box bg-white border border-slate-200 rounded-sm p-[1mm] flex items-center justify-center">
                    {!! $qrCodeSvg !!}
                </div>
                <p class="text-slate-400 font-bold text-center leading-none" style="font-size: 3.5pt; margin-top: 1mm; letter-spacing: 0.05em;">SCAN UNTUK PRESENSI</p>
            </div>

        </div>

        {{-- ===================== FOOTER KARTU ===================== --}}
        <div class="bg-brand-900 px-[4mm] flex items-center justify-between" style="height: 5mm;">
            <p class="text-brand-300 font-semibold" style="font-size: 3.5pt; letter-spacing: 0.03em;">
                AES-128 ENCRYPTED ATTENDANCE SYSTEM
            </p>
            <p class="text-brand-400 font-bold" style="font-size: 3.5pt; letter-spacing: 0.05em;">
                PRESIS SMKN 3 BENGKALIS
            </p>
        </div>

    </div>

    {{-- Petunjuk Cetak (hanya di layar) --}}
    <div class="no-print mt-6 max-w-md text-center">
        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
            <h4 class="text-xs font-bold text-slate-800 mb-2">Petunjuk Mencetak Kartu</h4>
            <ul class="text-[11px] text-slate-500 space-y-1 text-left list-disc list-inside">
                <li>Tekan <kbd class="px-1.5 py-0.5 rounded bg-slate-100 text-slate-700 font-mono text-[10px]">Ctrl + P</kbd> untuk membuka dialog cetak.</li>
                <li>Atur ukuran kertas ke <strong>ID Card (CR80)</strong> atau <strong>85.6 × 54 mm</strong>.</li>
                <li>Pilih orientasi <strong>Landscape</strong> dan margin <strong>None (0)</strong>.</li>
                <li>Pastikan opsi <strong>"Background Graphics"</strong> dicentang agar warna tercetak.</li>
                <li>Gunakan kertas foto / PVC card blank untuk hasil terbaik.</li>
            </ul>
        </div>
    </div>

</body>
</html>
