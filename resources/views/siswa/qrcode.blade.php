{{--
    Halaman Kartu QR Code Siswa PRESIS
    Desain Modern Clean SaaS & Enterprise Identity Card untuk SMKN 3 Bengkalis
    Menampilkan QR Code dinamis terenkripsi AES-128-CBC dengan proteksi anti-cloning & expiry countdown.
--}}

<x-layouts.dashboard :title="'QR Code Presensi'" :role="'SISWA'" :pageTitle="'KARTU PRESENSI DIGITAL'">

    {{-- Sidebar Menu Siswa --}}
    <x-slot:sidebar>
        @include('components.sidebar-item', ['href' => '/siswa/portal', 'label' => 'PORTAL'])
        @include('components.sidebar-item', ['href' => '/siswa/qrcode', 'label' => 'QR CODE SAYA'])
        @include('components.sidebar-item', ['href' => '/siswa/riwayat', 'label' => 'RIWAYAT ABSENSI'])
    </x-slot:sidebar>

    <div class="max-w-3xl mx-auto space-y-6">

        {{-- ============================================================ --}}
        {{-- KARTU PRESENSI DIGITAL SISWA (ID CARD) --}}
        {{-- ============================================================ --}}
        <div id="printArea" class="bg-white rounded-3xl border border-slate-200/80 shadow-lg shadow-slate-200/40 overflow-hidden">
            
            {{-- Header Kartu Bernuansa SMKN 3 Bengkalis --}}
            <div class="bg-gradient-to-r from-sky-600 via-blue-700 to-indigo-800 p-6 sm:p-7 text-white relative overflow-hidden">
                {{-- Aksen Dekoratif Lingkaran Halus --}}
                <div class="absolute -right-10 -top-10 w-44 h-44 rounded-full bg-white/10 blur-xl pointer-events-none"></div>
                <div class="absolute right-32 -bottom-12 w-32 h-32 rounded-full bg-sky-400/20 blur-lg pointer-events-none"></div>

                <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-14 h-14 rounded-2xl bg-white p-1.5 shadow-md flex-shrink-0 flex items-center justify-center">
                            <img src="{{ asset('images/logo-smkn3.jpg') }}" alt="Logo SMKN 3 Bengkalis" class="w-full h-full object-cover rounded-xl">
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-sky-200 uppercase tracking-widest block">KARTU PRESENSI DIGITAL</span>
                            <h2 class="text-lg sm:text-xl font-extrabold tracking-tight text-white leading-tight">SMK NEGERI 3 BENGKALIS</h2>
                            <p class="text-xs text-sky-100 font-medium">Sistem Presensi Siswa Terenkripsi (PRESIS)</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 self-start sm:self-center">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-white/15 backdrop-blur-md text-sky-100 border border-white/20 shadow-sm">
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
                    
                    {{-- Sisi Kiri: Box QR Code --}}
                    <div class="md:col-span-5 flex flex-col items-center justify-center print-qr-col">
                        <div class="relative w-full max-w-[220px] p-3.5 bg-slate-50/80 rounded-2xl border border-slate-200/80 shadow-inner text-center print-qr-box">
                            
                            {{-- Wadah QR Code SVG --}}
                            <div id="qrCodeContainer" class="p-2.5 bg-white rounded-xl shadow-sm border border-slate-100 transition-all duration-300 flex items-center justify-center print-qr-inner">
                                {!! $qrCodeSvg !!}
                            </div>

                            {{-- Overlay saat QR Code Kadaluarsa (Hanya di Layar) --}}
                            <div id="qrExpiredOverlay" class="no-print hidden absolute inset-0 bg-slate-900/85 backdrop-blur-sm rounded-2xl flex flex-col items-center justify-center p-4 text-center text-white z-20">
                                <div class="w-12 h-12 rounded-full bg-rose-500/20 text-rose-400 flex items-center justify-center mb-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-sm text-white">Token Kadaluarsa</h4>
                                <p class="text-[11px] text-slate-300 mt-1 mb-3 leading-snug">Masa berlaku QR habis untuk mencegah duplikasi & titip absen.</p>
                                <a href="{{ route('siswa.qrcode') }}"
                                   class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-sky-500 hover:bg-sky-600 text-white shadow-md shadow-sky-500/30 transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Perbarui QR
                                </a>
                            </div>

                            {{-- Indikator Countdown Masa Berlaku Dinamis (Hanya di Layar) --}}
                            @if(isset($expirySeconds) && $expirySeconds > 0)
                                <div class="mt-3.5 w-full no-print">
                                    <div class="flex items-center justify-between text-xs font-semibold mb-1.5">
                                        <span class="text-slate-500 text-[11px]">Masa Berlaku</span>
                                        <span id="timerBadge" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-bold font-mono bg-sky-100 text-sky-700">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span id="countdownText">--:--</span>
                                        </span>
                                    </div>
                                    <div class="w-full bg-slate-200 rounded-full h-1.5 overflow-hidden">
                                        <div id="progressBar" class="bg-gradient-to-r from-sky-500 to-blue-600 h-full rounded-full transition-all duration-1000 ease-linear" style="width: 100%;"></div>
                                    </div>
                                </div>
                            @endif

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

        </div>

        {{-- ============================================================ --}}
        {{-- TOMBOL TINDAKAN (ACTION BUTTONS) --}}
        {{-- ============================================================ --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 no-print">
            <a href="{{ route('siswa.cetak-kartu') }}" target="_blank"
               class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl text-sm font-bold bg-gradient-to-r from-sky-600 to-blue-700 text-white shadow-md shadow-sky-600/20 hover:from-sky-500 hover:to-blue-600 active:scale-[0.99] transition-all text-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                </svg>
                Cetak Kartu CR80
            </a>
            <button onclick="window.print()" 
                    class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl text-sm font-bold bg-white text-slate-700 border border-slate-200/80 shadow-sm hover:bg-slate-50 hover:text-slate-900 active:scale-[0.99] transition-all">
                <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print Cepat
            </button>
            <a href="{{ route('siswa.qrcode') }}" 
               class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl text-sm font-bold bg-white text-slate-700 border border-slate-200/80 shadow-sm hover:bg-slate-50 hover:text-slate-900 active:scale-[0.99] transition-all">
                <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Perbarui Token
            </a>
        </div>

        {{-- ============================================================ --}}
        {{-- PANDUAN PENGGUNAAN & KEAMANAN PRESENSI DIGITAL --}}
        {{-- ============================================================ --}}
        <div class="bg-white rounded-3xl border border-slate-200/80 p-5 sm:p-6 shadow-sm no-print">
            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                <div class="w-8 h-8 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center flex-shrink-0">
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
                        <p class="text-[11px] text-slate-500">Arahkan barcode QR ke perangkat kamera scanner guru pengampu pada setiap jam presensi kelas dimulai.</p>
                    </div>
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                        <p class="font-bold text-slate-800 mb-1 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                            Proteksi Token Digital
                        </p>
                        <p class="text-[11px] text-slate-500">Token QR terenkripsi dan diperbarui secara dinamis untuk menjamin validitas kehadiran serta mencegah duplikasi data.</p>
                    </div>
                </div>

                <div class="p-3 rounded-xl bg-sky-50/70 border border-sky-100 flex items-center gap-2.5 text-sky-800 text-xs">
                    <svg class="w-4 h-4 text-sky-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Jika batas waktu token QR berakhir saat hendak dipindai, cukup klik tombol <strong>"Perbarui Token"</strong> di atas untuk memuat kode baru.</span>
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
            /* 1. Reset background & layout dashboard */
            html, body {
                background: white !important;
                margin: 0 !important;
                padding: 0 !important;
                height: auto !important;
                min-height: 0 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Sembunyikan elemen dashboard & non-cetak */
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

            /* 2. Kartu Cetak: Kompak, Elegan, Pasti 1 Halaman Rapi */
            #printArea {
                position: relative !important;
                left: auto !important;
                top: auto !important;
                transform: none !important;
                margin: 15px auto 0 auto !important;
                width: 100% !important;
                max-width: 440px !important;
                box-shadow: none !important;
                border: 1.5px solid #0284c7 !important;
                border-radius: 16px !important;
                overflow: hidden !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                page-break-after: avoid !important;
                break-after: avoid !important;
            }

            /* Header Kartu Cetak */
            #printArea > div:first-child {
                padding: 10px 16px !important;
                background: #024b72 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Body Kartu Cetak */
            #printArea .print-body {
                padding: 14px 16px !important;
            }
            #printArea .print-grid {
                display: flex !important;
                flex-direction: row !important;
                align-items: center !important;
                gap: 14px !important;
            }

            /* Ukuran QR Code Cetak */
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

            /* Info Siswa Cetak */
            #printArea .print-info-col {
                flex: 1 1 0% !important;
                gap: 6px !important;
            }
            #printArea .print-info-col > div {
                padding: 7px 10px !important;
                border-radius: 8px !important;
            }

            /* Footer Kartu Cetak */
            #printArea .print-footer {
                padding: 7px 16px !important;
                font-size: 9px !important;
                background-color: #f8fafc !important;
            }
        }
    </style>
    @endpush

    @if(isset($expirySeconds) && $expirySeconds > 0)
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const totalDuration = {{ $expirySeconds }};
            let remaining = totalDuration;

            const countdownText = document.getElementById('countdownText');
            const timerBadge = document.getElementById('timerBadge');
            const progressBar = document.getElementById('progressBar');
            const qrContainer = document.getElementById('qrCodeContainer');
            const expiredOverlay = document.getElementById('qrExpiredOverlay');

            function updateDisplay() {
                const minutes = Math.floor(remaining / 60);
                const seconds = remaining % 60;
                countdownText.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

                const percentage = Math.max(0, (remaining / totalDuration) * 100);
                progressBar.style.width = `${percentage}%`;

                if (remaining <= 30 && remaining > 0) {
                    progressBar.className = 'bg-rose-500 h-full rounded-full transition-all duration-1000 ease-linear';
                    timerBadge.className = 'inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-bold font-mono bg-rose-100 text-rose-700 animate-pulse';
                }
            }

            updateDisplay();

            const timerInterval = setInterval(() => {
                remaining--;

                if (remaining <= 0) {
                    clearInterval(timerInterval);
                    countdownText.textContent = '00:00';
                    progressBar.style.width = '0%';
                    timerBadge.className = 'inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-bold font-mono bg-rose-100 text-rose-700';

                    // Tampilkan overlay kadaluarsa dan blur QR Code
                    if (qrContainer && expiredOverlay) {
                        qrContainer.classList.add('blur-sm', 'opacity-30', 'pointer-events-none');
                        expiredOverlay.classList.remove('hidden');
                    }
                } else {
                    updateDisplay();
                }
            }, 1000);
        });
    </script>
    @endpush
    @endif

</x-layouts.dashboard>
