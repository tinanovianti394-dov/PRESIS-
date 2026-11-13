{{--
    Halaman Cetak Kartu ID Presensi Siswa — Standar Internasional CR80 PORTRAIT TIMBAL BALIK (2 SISI)
    PRESIS SMK Negeri 3 Bengkalis

    Format:
    - Dimensi: 54mm (lebar) × 85.6mm (tinggi) - ISO/IEC 7810 ID-1 Portrait
    - Timbal Balik (Duplex):
      * SISI DEPAN (FRONT)    : Foto Siswa, Nama Lengkap, Status Siswa, NISN, Kelas, Jurusan, Identitas Sekolah.
      * SISI BELAKANG (BACK)  : QR Code Presensi Dinamis Terenkripsi AES-128-CBC diperbesar (32mm × 32mm), Tata Tertib Kartu, Validasi Sekolah.
--}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu ID Presensi Timbal Balik — {{ $siswa->nama }} — PRESIS</title>

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
                            300: '#76B3D1',
                            400: '#3D91BD',
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

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }

        /* ============================================================
         * DIMENSI KARTU ID CR80 PORTRAIT (54mm × 85.6mm)
         * ============================================================ */
        .card-face {
            width: 54mm;
            height: 85.6mm;
            position: relative;
            overflow: hidden;
            background: #ffffff;
            box-sizing: border-box;
            flex-shrink: 0;
        }

        /* ============================================================
         * ATURAN CETAK DUPLEX / TIMBAL BALIK (PRINT)
         * ============================================================ */
        @page {
            size: 54mm 85.6mm portrait;
            margin: 0;
        }

        @media print {
            html, body {
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .no-print {
                display: none !important;
            }

            .cards-container {
                display: block !important;
                padding: 0 !important;
                margin: 0 !important;
                gap: 0 !important;
                transform: none !important;
            }

            .card-wrapper {
                padding: 0 !important;
                margin: 0 !important;
                transform: none !important;
            }

            .card-face {
                box-shadow: none !important;
                border: none !important;
                border-radius: 0 !important;
                margin: 0 !important;
                width: 54mm !important;
                height: 85.6mm !important;
                page-break-after: always !important;
                break-after: page !important;
            }

            .card-face:last-child {
                page-break-after: auto !important;
                break-after: auto !important;
            }
        }

        @media screen {
            .card-face {
                border-radius: 12px;
                box-shadow: 0 15px 35px -10px rgba(2, 58, 88, 0.25), 0 0 0 1px rgba(2, 58, 88, 0.08);
            }
            .holder-clip {
                width: 14mm;
                height: 5mm;
                background: linear-gradient(180deg, #1e293b, #0f172a);
                border-radius: 3px 3px 0 0;
                margin: 0 auto -1px auto;
                box-shadow: 0 -2px 4px rgba(0,0,0,0.15);
                position: relative;
                z-index: 20;
            }
            .holder-slot {
                width: 7mm;
                height: 1.8mm;
                background: #0284c7;
                border-radius: 1mm;
                margin: 1.6mm auto 0 auto;
            }
        }

        /* Kontainer QR Code Sisi Belakang */
        .qr-box-back {
            width: 32mm;
            height: 32mm;
        }
        .qr-box-back svg {
            width: 100% !important;
            height: 100% !important;
            display: block;
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex flex-col items-center justify-center p-4 sm:p-8 print:p-0 print:bg-white antialiased">

    {{-- ============================================================
         KONTROL CETAK & NAVIGASI (Hanya tampil di layar)
         ============================================================ --}}
    <div class="no-print mb-6 text-center max-w-2xl w-full">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-sky-100 text-sky-800 mb-2 border border-sky-200">
            <span class="w-2 h-2 rounded-full bg-sky-500 animate-pulse"></span>
            Format Kartu ID: CR80 Portrait Timbal Balik (54mm × 85.6mm)
        </div>
        <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Cetak Kartu ID Presensi (2 Sisi)</h1>
        <p class="text-xs text-slate-500 mt-0.5 mb-4">
            Sisi Depan: Identitas & Foto Siswa · Sisi Belakang: QR Code Presensi AES-128 & Tata Tertib
        </p>

        {{-- Tombol Aksi --}}
        <div class="flex flex-wrap items-center justify-center gap-2.5">
            <button onclick="window.print()"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold bg-gradient-to-r from-brand-600 to-brand-700 hover:from-brand-500 hover:to-brand-600 text-white shadow-md shadow-brand-600/30 transition-all active:scale-[0.98]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                <span>Cetak 2 Sisi (Ctrl+P)</span>
            </button>

            {{-- Zoom Control (hanya untuk layar) --}}
            <div class="inline-flex items-center bg-white border border-slate-200 rounded-xl p-1 text-xs font-semibold text-slate-600 shadow-sm">
                <span class="px-2 text-[11px] text-slate-400">Zoom:</span>
                <button onclick="setZoom(1)" class="px-2 py-1 rounded-lg hover:bg-slate-100" id="zoom1">1x</button>
                <button onclick="setZoom(1.2)" class="px-2 py-1 rounded-lg bg-slate-100 font-bold text-brand-600" id="zoom12">1.2x</button>
                <button onclick="setZoom(1.5)" class="px-2 py-1 rounded-lg hover:bg-slate-100" id="zoom15">1.5x</button>
            </div>

            <a href="javascript:history.back()"
               class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 transition-all shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    {{-- ============================================================
         CONTAINER KEDUA SISI KARTU (TIMBAL BALIK)
         ============================================================ --}}
    <div id="cardsScaleWrapper" class="cards-container flex flex-col md:flex-row items-center justify-center gap-8 print:block transition-transform origin-top" style="transform: scale(1.2);">

        {{-- ====================================================================
             1. SISI DEPAN (FRONT SIDE) — IDENTITAS SISWA & FOTO
             ==================================================================== --}}
        <div class="card-wrapper flex flex-col items-center">
            
            <span class="no-print text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-brand-500"></span>
                SISI DEPAN (FRONT)
            </span>

            {{-- Mockup Klip Lanyard Holder Sisi Depan --}}
            <div class="no-print holder-clip">
                <div class="holder-slot"></div>
            </div>

            <div class="card-face flex flex-col justify-between">

                {{-- BACKGROUND CORAK GEOMETRIS CHEVRON BIRU --}}
                <svg class="absolute inset-0 w-full h-full pointer-events-none z-0" viewBox="0 0 54 85.6" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Sisi Kiri: Poligon Chevron Bertingkat -->
                    <polygon points="0,18 7,26 0,34" fill="#035D8D" opacity="0.95" />
                    <polygon points="0,32 8,41 0,50" fill="#046EA7" opacity="0.95" />
                    <polygon points="0,48 7,56 0,64" fill="#76B3D1" opacity="0.85" />
                    <polygon points="0,62 5,68 0,74" fill="#A2CBD9" opacity="0.75" />

                    <!-- Sisi Kanan: Poligon Chevron Bertingkat (Simetris) -->
                    <polygon points="54,18 47,26 54,34" fill="#035D8D" opacity="0.95" />
                    <polygon points="54,32 46,41 54,50" fill="#046EA7" opacity="0.95" />
                    <polygon points="54,48 47,56 54,64" fill="#76B3D1" opacity="0.85" />
                    <polygon points="54,62 49,68 54,74" fill="#A2CBD9" opacity="0.75" />
                </svg>

                {{-- HEADER DEPAN --}}
                <div class="relative z-10 pt-[3.2mm] px-[3mm] text-center">
                    <div class="flex items-center justify-center gap-[1.5mm] mb-[1mm]">
                        <div class="w-[7mm] h-[7mm] rounded-full overflow-hidden flex-shrink-0 bg-white shadow-sm ring-[0.4mm] ring-brand-500/30 flex items-center justify-center">
                            <img src="{{ asset('images/logo-smkn3.jpg') }}" alt="Logo SMKN 3" class="w-full h-full object-cover">
                        </div>
                        <div class="text-left">
                            <h2 class="text-slate-900 font-black leading-none tracking-tight uppercase" style="font-size: 5.8pt;">
                                SMK NEGERI 3 BENGKALIS
                            </h2>
                            <p class="text-brand-600 font-extrabold leading-tight tracking-wider uppercase" style="font-size: 4pt; margin-top: 0.4mm;">
                                KARTU IDENTITAS SISWA
                            </p>
                        </div>
                    </div>
                    <div class="h-[0.35mm] w-[38mm] mx-auto bg-gradient-to-r from-transparent via-brand-500 to-transparent"></div>
                </div>

                {{-- FOTO / AVATAR SISWA DEPAN --}}
                <div class="relative z-10 flex flex-col items-center mt-[2mm]">
                    <div class="w-[22mm] h-[22mm] rounded-[3.5mm] bg-gradient-to-b from-sky-50 to-brand-50 border-[0.7mm] border-brand-500 shadow-sm flex items-center justify-center overflow-hidden">
                        {{-- Ilustrasi Avatar Siswa Profesional --}}
                        <svg class="w-[19mm] h-[19mm]" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="50" cy="50" r="48" fill="#EBF5FB"/>
                            <path d="M28 36C28 22 38 15 50 15C62 15 72 22 72 36C72 40 70 42 70 42C67 36 62 34 50 34C38 34 33 36 30 42C30 42 28 40 28 36Z" fill="#2C3E50"/>
                            <path d="M32 38C32 38 32 58 50 58C68 58 68 38 68 38C68 38 62 38 50 38C38 38 32 38 32 38Z" fill="#FAD7A0"/>
                            <circle cx="31" cy="45" r="3.5" fill="#FAD7A0"/>
                            <circle cx="69" cy="45" r="3.5" fill="#FAD7A0"/>
                            <rect x="36" y="40" width="11" height="8" rx="2" stroke="#1E293B" stroke-width="2.2" fill="none"/>
                            <rect x="53" y="40" width="11" height="8" rx="2" stroke="#1E293B" stroke-width="2.2" fill="none"/>
                            <line x1="47" y1="44" x2="53" y2="44" stroke="#1E293B" stroke-width="2"/>
                            <path d="M42 51C44 54 47 55 50 55C53 55 56 54 58 51" stroke="#2C3E50" stroke-width="1.8" stroke-linecap="round"/>
                            <path d="M38 48C38 57 44 63 50 63C56 63 62 57 62 48C62 48 58 58 50 58C42 58 38 48 38 48Z" fill="#2C3E50"/>
                            <rect x="45" y="58" width="10" height="9" fill="#F5B7B1"/>
                            <path d="M22 88C22 72 34 67 44 66L46 75L50 78L54 75L56 66C66 67 78 72 78 88H22Z" fill="#046EA7"/>
                            <polygon points="46,66 54,66 52,78 48,78" fill="#FFFFFF"/>
                            <polygon points="49,67 51,67 52,80 50,83 48,80" fill="#012C43"/>
                        </svg>
                    </div>

                    {{-- NAMA SISWA & JABATAN DEPAN --}}
                    <div class="text-center mt-[1.8mm] px-[3mm] w-full">
                        <h3 class="text-slate-900 font-black leading-tight tracking-tight uppercase truncate" style="font-size: 7.5pt;">
                            {{ $siswa->nama }}
                        </h3>
                        <p class="text-brand-600 font-extrabold tracking-wider uppercase leading-none" style="font-size: 4.8pt; margin-top: 0.5mm;">
                            SISWA &bull; {{ $siswa->kelas }}
                        </p>
                    </div>
                </div>

                {{-- DETAIL BIODATA LENGKAP DEPAN --}}
                <div class="relative z-10 px-[5.5mm] my-[2mm]">
                    <div class="bg-white/90 p-[2.2mm] rounded-[2mm] border-[0.3mm] border-slate-200/80 shadow-xs">
                        <table class="w-full text-left" style="font-size: 5pt; line-height: 1.55;">
                            <tbody>
                                <tr>
                                    <td class="font-bold text-slate-500 whitespace-nowrap" style="width: 14mm;">ID / NISN</td>
                                    <td class="font-bold text-slate-400 px-[0.6mm]" style="width: 1.5mm;">:</td>
                                    <td class="font-bold font-mono text-slate-900 truncate">{{ $siswa->nisn }}</td>
                                </tr>
                                <tr>
                                    <td class="font-bold text-slate-500 whitespace-nowrap">Kelas</td>
                                    <td class="font-bold text-slate-400 px-[0.6mm]">:</td>
                                    <td class="font-extrabold text-brand-700 truncate">{{ $siswa->kelas }}</td>
                                </tr>
                                <tr>
                                    <td class="font-bold text-slate-500 whitespace-nowrap">Jurusan</td>
                                    <td class="font-bold text-slate-400 px-[0.6mm]">:</td>
                                    <td class="font-bold text-slate-800 truncate">Teknik Komputer & Jaringan ( TKJ )</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- FOOTER SISI DEPAN --}}
                <div class="relative z-10 bg-gradient-to-r from-brand-900 via-brand-800 to-brand-900 text-center flex items-center justify-center" style="height: 5mm;">
                    <p class="text-brand-200 font-extrabold tracking-wider leading-none" style="font-size: 3.6pt; letter-spacing: 0.04em;">
                        SMK NEGERI 3 BENGKALIS &bull; TAHUN 2026/2027
                    </p>
                </div>

            </div>

        </div>


        {{-- ====================================================================
             2. SISI BELAKANG (BACK SIDE) — QR CODE PRESENSI AES-128 & KETENTUAN
             ==================================================================== --}}
        <div class="card-wrapper flex flex-col items-center">
            
            <span class="no-print text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                SISI BELAKANG (BACK)
            </span>

            {{-- Mockup Klip Lanyard Holder Sisi Belakang --}}
            <div class="no-print holder-clip">
                <div class="holder-slot"></div>
            </div>

            <div class="card-face flex flex-col justify-between">

                {{-- BACKGROUND CORAK GEOMETRIS CHEVRON BIRU --}}
                <svg class="absolute inset-0 w-full h-full pointer-events-none z-0" viewBox="0 0 54 85.6" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <polygon points="0,18 7,26 0,34" fill="#035D8D" opacity="0.95" />
                    <polygon points="0,32 8,41 0,50" fill="#046EA7" opacity="0.95" />
                    <polygon points="0,48 7,56 0,64" fill="#76B3D1" opacity="0.85" />
                    <polygon points="0,62 5,68 0,74" fill="#A2CBD9" opacity="0.75" />

                    <polygon points="54,18 47,26 54,34" fill="#035D8D" opacity="0.95" />
                    <polygon points="54,32 46,41 54,50" fill="#046EA7" opacity="0.95" />
                    <polygon points="54,48 47,56 54,64" fill="#76B3D1" opacity="0.85" />
                    <polygon points="54,62 49,68 54,74" fill="#A2CBD9" opacity="0.75" />
                </svg>

                {{-- HEADER BELAKANG --}}
                <div class="relative z-10 pt-[3.2mm] px-[3mm] text-center">
                    <h4 class="text-slate-900 font-black leading-none tracking-tight uppercase" style="font-size: 5.8pt;">
                        PRESENSI DIGITAL (PRESIS)
                    </h4>
                    <p class="text-brand-600 font-extrabold leading-tight tracking-wider uppercase" style="font-size: 4pt; margin-top: 0.4mm;">
                        SMK NEGERI 3 BENGKALIS
                    </p>
                    <div class="h-[0.35mm] w-[38mm] mx-auto mt-[1mm] bg-gradient-to-r from-transparent via-brand-500 to-transparent"></div>
                </div>

                {{-- QR CODE PRESENSI DINAMIS TERENKRIPSI AES-128 (BESAR & JELAS DI SISI BELAKANG) --}}
                <div class="relative z-10 flex flex-col items-center mt-[1.5mm]">
                    <div class="qr-box-back p-[1.2mm] bg-white rounded-[2.5mm] border-[0.5mm] border-brand-500 shadow-md flex items-center justify-center">
                        {!! QrCode::size(140)->margin(0)->generate($siswa->encrypted_qr_data) !!}
                    </div>
                    
                    {{-- Badge Status Enkripsi & NISN --}}
                    <div class="text-center mt-[1.2mm]">
                        <span class="inline-flex items-center gap-[1mm] px-[2mm] py-[0.5mm] rounded-full bg-brand-50 border border-brand-200 text-brand-700 font-bold uppercase tracking-wider" style="font-size: 3.6pt;">
                            <span class="w-[1.2mm] h-[1.2mm] rounded-full bg-emerald-500 animate-pulse"></span>
                            NISN: <span class="font-mono">{{ $siswa->nisn }}</span> &bull; ENCRYPTED AES-128
                        </span>
                        <p class="font-extrabold text-slate-400 uppercase tracking-widest leading-none" style="font-size: 3.4pt; margin-top: 0.8mm;">
                            ARAHKAN KODE KE KAMERA SCANNER GURU
                        </p>
                    </div>
                </div>

                {{-- KETENTUAN PENGGUNAAN KARTU (TATA TERTIB RESMI) --}}
                <div class="relative z-10 px-[6mm] my-[1mm]">
                    <div class="bg-slate-50/90 p-[1.8mm] rounded-[2mm] border-[0.3mm] border-slate-200 text-slate-600" style="font-size: 3.6pt; line-height: 1.35;">
                        <p class="font-extrabold text-slate-800 uppercase tracking-wide mb-[0.6mm]">Ketentuan Kartu Presensi:</p>
                        <ol class="list-decimal list-inside space-y-[0.4mm] text-slate-500">
                            <li>Kartu wajib dibawa setiap hari sekolah aktif.</li>
                            <li>Kode QR terenkripsi anti-titip absen & anti-duplikasi.</li>
                            <li>Jika kartu hilang, segera lapor ke admin sekolah.</li>
                        </ol>
                    </div>
                </div>

                {{-- FOOTER SISI BELAKANG --}}
                <div class="relative z-10 bg-gradient-to-r from-brand-900 via-brand-800 to-brand-900 text-center flex items-center justify-center" style="height: 5mm;">
                    <p class="text-brand-200 font-extrabold tracking-wider leading-none" style="font-size: 3.5pt; letter-spacing: 0.04em;">
                        AES-128 ENCRYPTED ATTENDANCE SYSTEM &bull; PRESIS
                    </p>
                </div>

            </div>

        </div>

    </div>

    {{-- ============================================================
         PETUNJUK CETAK DUPLEX / TIMBAL BALIK (Hanya di Layar)
         ============================================================ --}}
    <div class="no-print mt-8 max-w-xl w-full">
        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-sm text-xs text-slate-600">
            <div class="flex items-center gap-2 mb-2.5 font-bold text-slate-900">
                <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Panduan Cetak ID Card Timbal Balik (2 Sisi):</span>
            </div>
            <ul class="space-y-1.5 text-[11px] list-disc list-inside text-slate-500">
                <li>Kartu ini terdiri dari <strong>2 Halaman (Sisi Depan & Sisi Belakang)</strong>.</li>
                <li><strong>Untuk Printer Kartu PVC Duplex</strong> (Fargo, Evolis, Zebra): Pilih opsi <em>"Print Both Sides / Duplex"</em> pada driver printer kartu. Halaman 1 akan otomatis dicetak di depan dan Halaman 2 di belakang kartu.</li>
                <li><strong>Untuk Kertas Foto / PVC Lembaran</strong>: Cetak Halaman 1, balik kertas, lalu cetak Halaman 2, atau cetak keduanya berdampingan dan rekatkan secara bolak-balik sebelum dimasukkan ke dalam plastik mika / acrylic lanyard holder.</li>
                <li>Pastikan orientasi disetel ke <strong>Portrait</strong>, margin <strong>None (0)</strong>, dan centang opsi <strong>"Background Graphics"</strong>.</li>
            </ul>
        </div>
    </div>

    {{-- Script Kontrol Zoom Preview Layar --}}
    <script>
        function setZoom(scale) {
            const wrapper = document.getElementById('cardsScaleWrapper');
            wrapper.style.transform = `scale(${scale})`;

            ['zoom1', 'zoom12', 'zoom15'].forEach(id => {
                document.getElementById(id).className = 'px-2 py-1 rounded-lg hover:bg-slate-100';
            });
            if (scale === 1) document.getElementById('zoom1').className = 'px-2 py-1 rounded-lg bg-slate-100 font-bold text-brand-600';
            if (scale === 1.2) document.getElementById('zoom12').className = 'px-2 py-1 rounded-lg bg-slate-100 font-bold text-brand-600';
            if (scale === 1.5) document.getElementById('zoom15').className = 'px-2 py-1 rounded-lg bg-slate-100 font-bold text-brand-600';
        }
    </script>

</body>
</html>
