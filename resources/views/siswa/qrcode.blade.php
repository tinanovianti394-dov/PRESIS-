{{--
    Halaman Kartu QR Code Siswa PRESIS (Murni Read-Only Berstandar AES-128-CBC)
    Selaras dengan Kartu Fisik CR80 untuk Sidang Skripsi SMKN 3 Bengkalis
--}}

<x-layouts.dashboard :title="'QR Code Presensi'" :role="'SISWA'" :pageTitle="'KARTU PRESENSI DIGITAL'">

    {{-- Sidebar Menu Siswa --}}
    <x-slot:sidebar>
        @include('components.sidebar-item', ['href' => '/siswa/portal', 'label' => 'PORTAL AKADEMIK'])
        @include('components.sidebar-item', ['href' => '/siswa/qrcode', 'label' => 'QR CODE SAYA', 'active' => true])
        @include('components.sidebar-item', ['href' => '/siswa/riwayat', 'label' => 'RIWAYAT ABSENSI'])
        @include('components.sidebar-item', ['href' => '/siswa/cetak-kartu', 'label' => 'CETAK KARTU CR80'])
    </x-slot:sidebar>

    <div class="max-w-3xl mx-auto space-y-6">

        {{-- ============================================================ --}}
        {{-- KARTU PRESENSI DIGITAL SISWA (ID CARD STATIS READ-ONLY) --}}
        {{-- ============================================================ --}}
        <div id="printArea" class="bg-white rounded-3xl border border-slate-200/80 shadow-lg shadow-slate-200/40 overflow-hidden">
            
            {{-- Header Kartu Bernuansa SMKN 3 Bengkalis --}}
            <div class="bg-gradient-to-r from-[#023A58] via-[#046EA7] to-[#035D8D] p-5 sm:p-6 text-white relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-44 h-44 rounded-full bg-white/10 blur-xl pointer-events-none"></div>

                <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-2xl bg-white p-1 shadow-md flex-shrink-0 flex items-center justify-center">
                            <img src="{{ asset('images/logo-smkn3.jpg') }}" alt="Logo SMKN 3 Bengkalis" class="w-full h-full object-cover rounded-xl">
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-sky-200 uppercase tracking-widest block">KARTU PRESENSI DIGITAL</span>
                            <h2 class="text-base sm:text-lg font-black tracking-tight text-white leading-tight">SMK NEGERI 3 BENGKALIS</h2>
                            <p class="text-[11px] text-sky-100 font-medium">Sistem Presensi Siswa Terenkripsi (PRESIS)</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 self-start sm:self-center">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-extrabold bg-white/15 backdrop-blur-md text-sky-100 border border-white/20 shadow-sm">
                            <svg class="w-3.5 h-3.5 text-sky-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            AES-128-CBC
                        </span>
                    </div>
                </div>
            </div>

            {{-- Body: QR Code & Identitas Siswa --}}
            <div class="p-5 sm:p-7 print-body">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center print-grid">
                    
                    {{-- Sisi Kiri: Box QR Code Statis Permanen --}}
                    <div class="md:col-span-5 flex flex-col items-center justify-center print-qr-col">
                        <div class="relative w-full max-w-[220px] p-3.5 bg-slate-50/80 rounded-2xl border border-slate-200/80 shadow-inner text-center print-qr-box">
                            
                            {{-- Wadah QR Code SVG Statis --}}
                            <div id="qrCodeContainer" class="p-2.5 bg-white rounded-xl shadow-sm border border-slate-100 flex items-center justify-center print-qr-inner">
                                {!! $qrCodeSvg !!}
                            </div>

                            {{-- Badge Statis Permanen --}}
                            <div class="mt-3 w-full">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    TOKEN STATIS CR80
                                </span>
                            </div>

                            {{-- Teks Label Bawah QR Saat Cetak --}}
                            <p class="text-[9.5px] font-bold text-slate-500 mt-2 tracking-wider uppercase font-mono print-qr-label">
                                SCANNER PRESENSI
                            </p>
                        </div>
                    </div>

                    {{-- Sisi Kanan: Data Profil Siswa --}}
                    <div class="md:col-span-7 space-y-3 print-info-col">
                        <div class="p-3.5 rounded-2xl bg-gradient-to-br from-slate-50 to-sky-50/40 border border-slate-200/80">
                            <span class="text-[9.5px] font-bold uppercase tracking-wider text-sky-700 block">Nama Lengkap Siswa</span>
                            <h3 class="text-base sm:text-lg font-extrabold text-slate-900 mt-0.5 leading-snug">{{ $siswa->nama }}</h3>
                        </div>

                        <div class="grid grid-cols-2 gap-2.5">
                            <div class="p-3 rounded-xl bg-white border border-slate-200/80 shadow-2xs">
                                <span class="text-[9.5px] font-bold uppercase tracking-wider text-slate-500 block">ID / NISN</span>
                                <p class="text-xs sm:text-sm font-extrabold font-mono text-slate-900 mt-0.5">{{ $siswa->nisn }}</p>
                            </div>
                            <div class="p-3 rounded-xl bg-white border border-slate-200/80 shadow-2xs">
                                <span class="text-[9.5px] font-bold uppercase tracking-wider text-slate-500 block">Kelas Terdaftar</span>
                                <p class="text-xs sm:text-sm font-extrabold text-sky-700 mt-0.5">{{ $siswa->kelas }}</p>
                            </div>
                        </div>

                        <div class="p-3 rounded-xl bg-sky-50/70 border border-sky-200/80 flex items-center justify-between gap-2.5">
                            <div>
                                <span class="text-[9.5px] font-bold uppercase tracking-wider text-sky-700 block">Jurusan / Program Keahlian</span>
                                <p class="text-xs font-bold text-slate-900 mt-0.5">Teknik Komputer & Jaringan ( TKJ )</p>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[9.5px] font-extrabold bg-sky-100 text-sky-800 flex-shrink-0">
                                TKJ
                            </span>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Footer Kartu --}}
            <div class="px-5 py-3 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500 print-footer">
                <span class="flex items-center gap-1.5 font-medium">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Sistem Enkripsi: AES-128-CBC + IV Acak
                </span>
                <span class="font-mono text-[10px] text-slate-400">SMKN 3 BENGKALIS</span>
            </div>

        </div>

        {{-- ============================================================ --}}
        {{-- TOMBOL TINDAKAN (ACTION BUTTONS) --}}
        {{-- ============================================================ --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 no-print">
            <a href="{{ route('siswa.cetak-kartu') }}" target="_blank"
               class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl text-sm font-bold bg-[#046EA7] hover:bg-[#035D8D] text-white shadow-md shadow-sky-600/20 active:scale-[0.99] transition-all text-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                </svg>
                <span>Cetak Kartu Standar CR80</span>
            </a>

            <button onclick="window.print()" 
                    class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl text-sm font-bold bg-white text-slate-700 border border-slate-200/80 shadow-sm hover:bg-slate-50 active:scale-[0.99] transition-all">
                <svg class="w-4 h-4 text-[#046EA7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                <span>Print Cepat (1 Halaman)</span>
            </button>
        </div>

        {{-- ============================================================ --}}
        {{-- PANDUAN PENGGUNAAN & KEAMANAN PRESENSI DIGITAL --}}
        {{-- ============================================================ --}}
        <div class="bg-white rounded-3xl border border-slate-200/80 p-5 sm:p-6 shadow-sm no-print">
            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                <div class="w-8 h-8 rounded-xl bg-sky-50 text-[#046EA7] flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-900">Petunjuk Penggunaan Kartu Presensi</h4>
                    <p class="text-xs text-slate-500">Tata cara presensi digital SMK Negeri 3 Bengkalis</p>
                </div>
            </div>

            <div class="mt-4 space-y-3 text-xs text-slate-600 leading-relaxed">
                <p>
                    Barcode QR Presensi ini merupakan identitas digital resmi peserta didik SMKN 3 Bengkalis untuk pencatatan kehadiran harian secara otomatis, cepat, dan akurat.
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                        <p class="font-bold text-slate-800 mb-1 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            Pemindaian Kamera di Kelas
                        </p>
                        <p class="text-[11px] text-slate-500">Arahkan barcode QR fisik ID Card ke perangkat kamera scanner guru pengampu pada setiap jam presensi dimulai.</p>
                    </div>
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                        <p class="font-bold text-slate-800 mb-1 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-[#046EA7]"></span>
                            Proteksi Kriptografi AES-128
                        </p>
                        <p class="text-[11px] text-slate-500">Data QR terenkripsi dengan kunci rahasia sekolah untuk menjamin keaslian data serta mencegah pemalsuan atau titip absen.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('styles')
    <style>
        @page {
            size: portrait;
            margin: 10mm;
        }

        @media print {
            html, body {
                background: white !important;
                margin: 0 !important;
                padding: 0 !important;
                height: auto !important;
                min-height: 0 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            aside, header, footer, #sidebar, #sidebarOverlay,
            .no-print, nav, [role="navigation"] {
                display: none !important;
            }

            .lg\:ml-64 {
                margin-left: 0 !important;
            }
            main {
                padding: 0 !important;
                margin: 0 !important;
                max-width: 100% !important;
                width: 100% !important;
            }
            .max-w-3xl {
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            #printArea {
                position: relative !important;
                left: auto !important;
                top: auto !important;
                transform: none !important;
                margin: 15px auto 0 auto !important;
                width: 100% !important;
                max-width: 440px !important;
                box-shadow: none !important;
                border: 1.5px solid #046EA7 !important;
                border-radius: 16px !important;
                overflow: hidden !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                page-break-after: avoid !important;
                break-after: avoid !important;
            }

            #printArea > div:first-child {
                padding: 10px 16px !important;
                background: #023A58 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            #printArea .print-body {
                padding: 14px 16px !important;
            }
            #printArea .print-grid {
                display: flex !important;
                flex-direction: row !important;
                align-items: center !important;
                gap: 14px !important;
            }

            #printArea .print-qr-col {
                width: 130px !important;
                max-width: 130px !important;
                flex-shrink: 0 !important;
            }
            #printArea .print-qr-box {
                padding: 8px !important;
                max-width: 100% !important;
                border-radius: 12px !important;
            }
            #printArea .print-qr-inner {
                padding: 6px !important;
                border-radius: 10px !important;
            }
            #printArea #qrCodeContainer svg {
                width: 105px !important;
                height: 105px !important;
                display: block !important;
                margin: 0 auto !important;
            }
            #printArea .print-qr-label {
                font-size: 8px !important;
                margin-top: 5px !important;
            }

            #printArea .print-info-col {
                flex: 1 1 0% !important;
                gap: 6px !important;
            }
            #printArea .print-info-col > div {
                padding: 7px 10px !important;
                border-radius: 8px !important;
            }

            #printArea .print-footer {
                padding: 7px 16px !important;
                font-size: 9px !important;
                background-color: #f8fafc !important;
            }
        }
    </style>
    @endpush

</x-layouts.dashboard>
