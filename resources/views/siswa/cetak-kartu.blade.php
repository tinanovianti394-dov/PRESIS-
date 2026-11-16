{{--
    Halaman Cetak Kartu ID Presensi Siswa — Standar Internasional CR80 PORTRAIT TIMBAL BALIK (2 SISI)
    PRESIS SMK Negeri 3 Bengkalis

    Format Sesuai Sampel Mockup Lanyard:
    - Dimensi: 54mm (lebar) × 85.6mm (tinggi) - ISO/IEC 7810 ID-1 Portrait (CR80)
    - Desain: Ornamen Geometris Poligon Biru Bertingkat di Sisi Samping Kiri & Kanan, Balok Footer Biru Tua Solid
    - Timbal Balik (Duplex):
      * SISI DEPAN (FRONT)    : Foto Siswa, Nama Lengkap, Identitas (ID No / NISN, Kelas, Jurusan TKJ), Identitas Sekolah.
      * SISI BELAKANG (BACK)  : QR Code Presensi Dinamis Terenkripsi AES-128-CBC diperbesar (32mm × 32mm), Tata Tertib Kartu, Validasi Sekolah.
--}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu ID Presensi Siswa — {{ $siswa->nama }} — PRESIS SMKN 3 Bengkalis</title>

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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@500;600;700&display=swap" rel="stylesheet">

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

            .card-holder-wrap {
                padding: 0 !important;
                margin: 0 !important;
                background: none !important;
                border: none !important;
                box-shadow: none !important;
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

        /* ============================================================
         * MOCKUP HOLDER LANYARD (TAMPILAN SCREEN LAYAR)
         * ============================================================ */
        @media screen {
            .lanyard-strap {
                width: 20mm;
                height: 38mm;
                background: repeating-linear-gradient(45deg, #1d4ed8, #1d4ed8 4px, #2563eb 4px, #2563eb 8px);
                margin: 0 auto;
                box-shadow: 0 4px 10px rgba(0,0,0,0.15);
                position: relative;
                border-radius: 2px 2px 0 0;
            }
            .lanyard-buckle {
                width: 16mm;
                height: 8mm;
                background: #111827;
                border-radius: 3px;
                margin: -2mm auto 0 auto;
                position: relative;
                z-index: 30;
                box-shadow: 0 2px 5px rgba(0,0,0,0.3);
            }
            .lanyard-clip {
                width: 10mm;
                height: 12mm;
                background: #374151;
                border-radius: 2px;
                margin: -1mm auto 0 auto;
                position: relative;
                z-index: 25;
            }
            .card-holder-wrap {
                background: rgba(255, 255, 255, 0.7);
                border: 3px solid rgba(14, 165, 233, 0.45);
                border-radius: 14px;
                padding: 7px 7px 9px 7px;
                box-shadow: 0 20px 40px -15px rgba(2, 58, 88, 0.3), 0 0 0 1px rgba(14, 165, 233, 0.2);
                backdrop-filter: blur(8px);
                position: relative;
                margin-top: -3mm;
                z-index: 20;
            }
            .holder-top-bar {
                width: 100%;
                height: 6mm;
                background: #0284c7;
                border-radius: 8px 8px 3px 3px;
                margin-bottom: 2mm;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .holder-top-slot {
                width: 14mm;
                height: 2.2mm;
                background: #082f49;
                border-radius: 2mm;
            }
            .card-face {
                border-radius: 6px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            }
        }

        /* Kontainer QR Code Sisi Belakang */
        .qr-box-back {
            width: 33mm;
            height: 33mm;
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
            Format Resmi: CR80 Portrait Timbal Balik (54mm × 85.6mm)
        </div>
        <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Cetak Kartu ID Presensi Siswa</h1>
        <p class="text-xs text-slate-500 mt-0.5 mb-4">
            Standar Cetak Kartu PVC / Kertas Foto Timbal Balik (Sisi Depan: Identitas & Foto · Sisi Belakang: QR Presensi AES-128)
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

            {{-- Zoom Control Layar --}}
            <div class="inline-flex items-center bg-white border border-slate-200 rounded-xl p-1 text-xs font-semibold text-slate-600 shadow-sm">
                <span class="px-2 text-[11px] text-slate-400">Zoom:</span>
                <button onclick="setZoom(1)" class="px-2.5 py-1 rounded-lg hover:bg-slate-100" id="zoom1">1x</button>
                <button onclick="setZoom(1.15)" class="px-2.5 py-1 rounded-lg bg-slate-100 font-bold text-brand-600" id="zoom115">1.15x</button>
                <button onclick="setZoom(1.35)" class="px-2.5 py-1 rounded-lg hover:bg-slate-100" id="zoom135">1.35x</button>
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
    <div id="cardsScaleWrapper" class="cards-container flex flex-col md:flex-row items-center justify-center gap-8 print:block transition-transform origin-top" style="transform: scale(1.15);">

        {{-- ====================================================================
             1. SISI DEPAN (FRONT SIDE) — IDENTITAS SISWA & FOTO
             ==================================================================== --}}
        <div class="flex flex-col items-center">
            
            <span class="no-print text-xs font-bold text-slate-600 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                <span class="w-2.5 h-2.5 rounded-full bg-brand-500 shadow-sm"></span>
                SISI DEPAN (FRONT)
            </span>

            {{-- Mockup Tali Lanyard & Holder Klip (Screen Only) --}}
            <div class="no-print flex flex-col items-center">
                <div class="lanyard-strap"></div>
                <div class="lanyard-buckle"></div>
                <div class="lanyard-clip"></div>
            </div>

            <div class="card-holder-wrap">
                <div class="no-print holder-top-bar">
                    <div class="holder-top-slot"></div>
                </div>

                {{-- BADAN KARTU SISI DEPAN --}}
                <div class="card-face flex flex-col justify-between">

                    {{-- CORAK GEOMETRIS PITA CHEVRON BIRU BERTINGKAT (PERSIS GAMBAR CONTOH) --}}
                    <svg class="absolute inset-0 w-full h-full pointer-events-none z-0" viewBox="0 0 54 85.6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- SISI KIRI: Poligon Diagonal Bertingkat Biru -->
                        <!-- Layer 1 (Dark Navy) -->
                        <polygon points="0,17 9,25 0,33" fill="#023A58" opacity="0.95" />
                        <!-- Layer 2 (Primary Blue) -->
                        <polygon points="0,31 10,41 0,51" fill="#046EA7" opacity="0.95" />
                        <!-- Layer 3 (Medium Blue) -->
                        <polygon points="0,49 9,58 0,67" fill="#0284c7" opacity="0.90" />
                        <!-- Layer 4 (Soft Cyan) -->
                        <polygon points="0,65 6,71 0,77" fill="#7dd3fc" opacity="0.80" />

                        <!-- SISI KANAN: Poligon Diagonal Bertingkat Simetris -->
                        <!-- Layer 1 (Dark Navy) -->
                        <polygon points="54,17 45,25 54,33" fill="#023A58" opacity="0.95" />
                        <!-- Layer 2 (Primary Blue) -->
                        <polygon points="54,31 44,41 54,51" fill="#046EA7" opacity="0.95" />
                        <!-- Layer 3 (Medium Blue) -->
                        <polygon points="54,49 45,58 54,67" fill="#0284c7" opacity="0.90" />
                        <!-- Layer 4 (Soft Cyan) -->
                        <polygon points="54,65 48,71 54,77" fill="#7dd3fc" opacity="0.80" />
                    </svg>

                    {{-- HEADER DEPAN (COMPANY NAME / TAGLINE STYLE) --}}
                    <div class="relative z-10 pt-[3.8mm] px-[3mm] text-center">
                        <div class="flex items-center justify-center gap-[1.6mm] mb-[0.8mm]">
                            <div class="w-[7.5mm] h-[7.5mm] rounded-full overflow-hidden flex-shrink-0 bg-white shadow-xs ring-[0.4mm] ring-brand-500/40 flex items-center justify-center">
                                <img src="{{ asset('images/logo-smkn3.jpg') }}" alt="Logo SMKN 3" class="w-full h-full object-cover">
                            </div>
                            <div class="text-left">
                                <h2 class="text-slate-900 font-black leading-none tracking-tight uppercase" style="font-size: 5.6pt;">
                                    SMK NEGERI 3 BENGKALIS
                                </h2>
                                <p class="text-brand-600 font-extrabold leading-tight tracking-wider uppercase" style="font-size: 3.8pt; margin-top: 0.5mm;">
                                    KARTU PRESENSI DIGITAL SISWA
                                </p>
                            </div>
                        </div>
                        <div class="h-[0.35mm] w-[36mm] mx-auto bg-gradient-to-r from-transparent via-brand-500 to-transparent"></div>
                    </div>

                    {{-- FOTO / AVATAR SISWA (BINGKAI BIRU CERAH SEPERTI DI GAMBAR CONTOH) --}}
                    <div class="relative z-10 flex flex-col items-center mt-[1.8mm]">
                        <div class="w-[22.5mm] h-[22.5mm] rounded-[3.8mm] bg-gradient-to-b from-sky-50 to-sky-100 border-[0.75mm] border-[#0284c7] shadow-sm flex items-center justify-center overflow-hidden">
                            {{-- Ilustrasi Avatar Siswa Profesional --}}
                            <svg class="w-[20mm] h-[20mm]" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="50" cy="50" r="48" fill="#EBF5FB"/>
                                <path d="M28 36C28 22 38 15 50 15C62 15 72 22 72 36C72 40 70 42 70 42C67 36 62 34 50 34C38 34 33 36 30 42C30 42 28 40 28 36Z" fill="#1E293B"/>
                                <path d="M32 38C32 38 32 58 50 58C68 58 68 38 68 38C68 38 62 38 50 38C38 38 32 38 32 38Z" fill="#FAD7A0"/>
                                <circle cx="31" cy="45" r="3.5" fill="#FAD7A0"/>
                                <circle cx="69" cy="45" r="3.5" fill="#FAD7A0"/>
                                <rect x="36" y="40" width="11" height="8" rx="2" stroke="#0F172A" stroke-width="2.2" fill="none"/>
                                <rect x="53" y="40" width="11" height="8" rx="2" stroke="#0F172A" stroke-width="2.2" fill="none"/>
                                <line x1="47" y1="44" x2="53" y2="44" stroke="#0F172A" stroke-width="2"/>
                                <path d="M42 51C44 54 47 55 50 55C53 55 56 54 58 51" stroke="#1E293B" stroke-width="1.8" stroke-linecap="round"/>
                                <path d="M38 48C38 57 44 63 50 63C56 63 62 57 62 48C62 48 58 58 50 58C42 58 38 48 38 48Z" fill="#1E293B"/>
                                <rect x="45" y="58" width="10" height="9" fill="#F5B7B1"/>
                                <path d="M22 88C22 72 34 67 44 66L46 75L50 78L54 75L56 66C66 67 78 72 78 88H22Z" fill="#046EA7"/>
                                <polygon points="46,66 54,66 52,78 48,78" fill="#FFFFFF"/>
                                <polygon points="49,67 51,67 52,80 50,83 48,80" fill="#023A58"/>
                            </svg>
                        </div>

                        {{-- NAMA & JABATAN (YOUR NAME & CREATIVE DESIGNER STYLE) --}}
                        <div class="text-center mt-[1.8mm] px-[3mm] w-full">
                            <h3 class="text-slate-900 font-black leading-tight tracking-tight uppercase truncate" style="font-size: 7.2pt;">
                                {{ $siswa->nama }}
                            </h3>
                            <p class="text-brand-600 font-extrabold tracking-wider uppercase leading-none" style="font-size: 4.6pt; margin-top: 0.5mm;">
                                SISWA &bull; {{ $siswa->kelas }}
                            </p>
                        </div>
                    </div>

                    {{-- DETAIL BIODATA LENGKAP (DAFTAR TITIK DUA RAPI SEPERTI DI GAMBAR) --}}
                    <div class="relative z-10 px-[5.5mm] my-[1.8mm]">
                        <div class="bg-white/95 p-[2.2mm] rounded-[2mm] border-[0.3mm] border-slate-200/90 shadow-2xs">
                            <table class="w-full text-left" style="font-size: 5pt; line-height: 1.55;">
                                <tbody>
                                    <tr>
                                        <td class="font-bold text-slate-500 whitespace-nowrap" style="width: 14mm;">ID No</td>
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

                    {{-- FOOTER SISI DEPAN (BALOK BIRU TUA SOLID SEPERTI DI GAMBAR CONTOH) --}}
                    <div class="relative z-10 bg-[#023A58] text-center flex items-center justify-center" style="height: 6.5mm;">
                        <p class="text-sky-200 font-extrabold tracking-wider leading-none" style="font-size: 3.8pt; letter-spacing: 0.05em;">
                            SMK NEGERI 3 BENGKALIS &bull; TP 2026/2027
                        </p>
                    </div>

                </div>
            </div>

        </div>


        {{-- ====================================================================
             2. SISI BELAKANG (BACK SIDE) — QR CODE PRESENSI AES-128 & KETENTUAN
             ==================================================================== --}}
        <div class="flex flex-col items-center">
            
            <span class="no-print text-xs font-bold text-slate-600 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-sm"></span>
                SISI BELAKANG (BACK)
            </span>

            {{-- Mockup Tali Lanyard & Holder Klip (Screen Only) --}}
            <div class="no-print flex flex-col items-center">
                <div class="lanyard-strap"></div>
                <div class="lanyard-buckle"></div>
                <div class="lanyard-clip"></div>
            </div>

            <div class="card-holder-wrap">
                <div class="no-print holder-top-bar">
                    <div class="holder-top-slot"></div>
                </div>

                {{-- BADAN KARTU SISI BELAKANG --}}
                <div class="card-face flex flex-col justify-between">

                    {{-- CORAK GEOMETRIS PITA CHEVRON BIRU BERTINGKAT (SIMETRIS) --}}
                    <svg class="absolute inset-0 w-full h-full pointer-events-none z-0" viewBox="0 0 54 85.6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <polygon points="0,17 9,25 0,33" fill="#023A58" opacity="0.95" />
                        <polygon points="0,31 10,41 0,51" fill="#046EA7" opacity="0.95" />
                        <polygon points="0,49 9,58 0,67" fill="#0284c7" opacity="0.90" />
                        <polygon points="0,65 6,71 0,77" fill="#7dd3fc" opacity="0.80" />

                        <polygon points="54,17 45,25 54,33" fill="#023A58" opacity="0.95" />
                        <polygon points="54,31 44,41 54,51" fill="#046EA7" opacity="0.95" />
                        <polygon points="54,49 45,58 54,67" fill="#0284c7" opacity="0.90" />
                        <polygon points="54,65 48,71 54,77" fill="#7dd3fc" opacity="0.80" />
                    </svg>

                    {{-- HEADER BELAKANG --}}
                    <div class="relative z-10 pt-[3.8mm] px-[3mm] text-center">
                        <h4 class="text-slate-900 font-black leading-none tracking-tight uppercase" style="font-size: 5.6pt;">
                            PRESENSI DIGITAL (PRESIS)
                        </h4>
                        <p class="text-brand-600 font-extrabold leading-tight tracking-wider uppercase" style="font-size: 3.8pt; margin-top: 0.5mm;">
                            SMK NEGERI 3 BENGKALIS
                        </p>
                        <div class="h-[0.35mm] w-[36mm] mx-auto mt-[1mm] bg-gradient-to-r from-transparent via-brand-500 to-transparent"></div>
                    </div>

                    {{-- QR CODE PRESENSI DINAMIS TERENKRIPSI AES-128 (BESAR DI SISI BELAKANG) --}}
                    <div class="relative z-10 flex flex-col items-center mt-[1.2mm]">
                        <div class="qr-box-back p-[1.2mm] bg-white rounded-[2.8mm] border-[0.6mm] border-[#0284c7] shadow-sm flex items-center justify-center">
                            {!! QrCode::size(140)->margin(0)->generate($siswa->encrypted_qr_data) !!}
                        </div>
                        
                        {{-- Badge Status Enkripsi & NISN --}}
                        <div class="text-center mt-[1.2mm]">
                            <span class="inline-flex items-center gap-[1mm] px-[2.2mm] py-[0.5mm] rounded-full bg-brand-50 border border-brand-200 text-brand-700 font-bold uppercase tracking-wider" style="font-size: 3.6pt;">
                                <span class="w-[1.2mm] h-[1.2mm] rounded-full bg-emerald-500 animate-pulse"></span>
                                ID: <span class="font-mono">{{ $siswa->nisn }}</span> &bull; ENCRYPTED AES-128
                            </span>
                            <p class="font-extrabold text-slate-400 uppercase tracking-widest leading-none" style="font-size: 3.4pt; margin-top: 0.8mm;">
                                ARAHKAN KODE KE KAMERA SCANNER GURU
                            </p>
                        </div>
                    </div>

                    {{-- KETENTUAN PENGGUNAAN KARTU (TATA TERTIB RESMI) --}}
                    <div class="relative z-10 px-[5.5mm] my-[1mm]">
                        <div class="bg-slate-50/95 p-[1.8mm] rounded-[2mm] border-[0.3mm] border-slate-200 text-slate-600" style="font-size: 3.6pt; line-height: 1.35;">
                            <p class="font-extrabold text-slate-800 uppercase tracking-wide mb-[0.5mm]">Ketentuan Kartu Presensi:</p>
                            <ol class="list-decimal list-inside space-y-[0.3mm] text-slate-500">
                                <li>Kartu wajib dibawa setiap hari sekolah aktif.</li>
                                <li>Kode QR terenkripsi anti-titip absen & anti-duplikasi.</li>
                                <li>Jika kartu hilang, segera lapor ke operator sekolah.</li>
                            </ol>
                        </div>
                    </div>

                    {{-- FOOTER SISI BELAKANG (BALOK BIRU TUA SOLID) --}}
                    <div class="relative z-10 bg-[#023A58] text-center flex items-center justify-center" style="height: 6.5mm;">
                        <p class="text-sky-200 font-extrabold tracking-wider leading-none" style="font-size: 3.6pt; letter-spacing: 0.05em;">
                            AES-128 ENCRYPTED ATTENDANCE SYSTEM &bull; PRESIS
                        </p>
                    </div>

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
                <span>Panduan Cetak ID Card Standar CR80 (Duplex / 2 Sisi):</span>
            </div>
            <ul class="space-y-1.5 text-[11px] list-disc list-inside text-slate-500">
                <li>Kartu ini terdiri dari <strong>2 Sisi Halaman (Depan: Identitas & Foto · Belakang: QR Presensi AES-128)</strong>.</li>
                <li><strong>Untuk Printer Kartu PVC Duplex</strong> (Fargo, Evolis, Zebra): Pilih opsi <em>"Print Both Sides / Duplex"</em> pada driver printer kartu. Sisi 1 akan otomatis dicetak di depan dan Sisi 2 di belakang kartu PVC.</li>
                <li><strong>Untuk Kertas Foto / PVC Lembaran</strong>: Cetak Sisi 1, balik kertas, lalu cetak Sisi 2, atau cetak berdampingan dan rekatkan bolak-balik sebelum dimasukkan ke dalam badge holder mika / acrylic lanyard.</li>
                <li>Pastikan orientasi disetel ke <strong>Portrait</strong>, margin <strong>None (0)</strong>, dan centang opsi <strong>"Background Graphics"</strong>.</li>
            </ul>
        </div>
    </div>

    {{-- Script Kontrol Zoom Preview Layar --}}
    <script>
        function setZoom(scale) {
            const wrapper = document.getElementById('cardsScaleWrapper');
            wrapper.style.transform = `scale(${scale})`;

            ['zoom1', 'zoom115', 'zoom135'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.className = 'px-2.5 py-1 rounded-lg hover:bg-slate-100';
            });
            if (scale === 1) document.getElementById('zoom1').className = 'px-2.5 py-1 rounded-lg bg-slate-100 font-bold text-brand-600';
            if (scale === 1.15) document.getElementById('zoom115').className = 'px-2.5 py-1 rounded-lg bg-slate-100 font-bold text-brand-600';
            if (scale === 1.35) document.getElementById('zoom135').className = 'px-2.5 py-1 rounded-lg bg-slate-100 font-bold text-brand-600';
        }
    </script>

</body>
</html>
