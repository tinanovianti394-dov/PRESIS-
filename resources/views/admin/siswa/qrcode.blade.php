{{--
    Halaman Cetak Kartu QR Siswa oleh Admin PRESIS
--}}

<x-layouts.dashboard :title="'Kartu QR Siswa'" :role="'ADMIN'" :pageTitle="'Kartu Identitas QR Siswa'">

    <x-slot:sidebar>
        @include('components.sidebar-item', ['href' => '/admin/dashboard', 'label' => 'Dashboard'])
        @include('components.sidebar-item', ['href' => '/admin/siswa', 'label' => 'Data Siswa', 'active' => true])
        @include('components.sidebar-item', ['href' => '/admin/guru', 'label' => 'Data Guru'])
        @include('components.sidebar-item', ['href' => '/admin/absensi', 'label' => 'Data Absensi'])
        @include('components.sidebar-item', ['href' => '/admin/rekap', 'label' => 'Rekap Laporan'])
    </x-slot:sidebar>

    <div class="max-w-xl mx-auto">
        <div class="mb-5 flex items-center justify-between no-print">
            <a href="{{ route('admin.siswa.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center gap-1.5 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Kembali ke Data Siswa</span>
            </a>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.siswa.cetak-kartu', $siswa) }}" target="_blank"
                   class="px-4 py-2 rounded-xl bg-gradient-to-r from-sky-600 to-blue-700 hover:from-sky-500 hover:to-blue-600 text-white font-semibold text-xs shadow-sm shadow-sky-600/25 flex items-center gap-1.5 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                    </svg>
                    <span>Cetak CR80 (PVC)</span>
                </a>
                <button onclick="window.print()"
                        class="px-4 py-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold text-xs shadow-sm flex items-center gap-1.5 transition-all">
                    <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    <span>Print Cepat</span>
                </button>
            </div>
        </div>

        {{-- Kartu QR Desain Kompak --}}
        <div id="printArea" class="bg-white rounded-3xl border border-slate-200/80 shadow-md relative overflow-hidden">
            <!-- Header Kartu -->
            <div class="print-header border-b border-slate-100 p-5 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo-smkn3.jpg') }}" alt="Logo SMKN 3 Bengkalis" class="w-10 h-10 rounded-xl object-cover ring-1 ring-slate-200 shadow-sm flex-shrink-0">
                    <div>
                        <h2 class="font-extrabold text-sm tracking-tight text-slate-900 leading-tight">SMK NEGERI 3 BENGKALIS</h2>
                        <p class="text-[9.5px] font-bold text-sky-600 uppercase tracking-wider">Kartu Presensi Digital (PRESIS)</p>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[9.5px] font-bold bg-sky-50 text-sky-700 border border-sky-200/60 uppercase">
                    <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span> AES-128
                </span>
            </div>

            <!-- Konten Kartu QR & Identitas Siswa -->
            <div class="print-body p-5">
                <div class="print-grid flex flex-col sm:flex-row items-center gap-5">
                    <!-- QR Box -->
                    <div class="print-qr-col p-2.5 rounded-2xl bg-slate-50 border border-slate-200/80 text-center flex-shrink-0">
                        <div class="print-qr-inner p-2 bg-white rounded-xl shadow-sm border border-slate-200/60">
                            {!! $qrCodeSvg !!}
                        </div>
                        <p class="print-qr-label text-[9.5px] font-mono font-bold text-slate-500 mt-1.5 tracking-wider uppercase">SCANNER PRESENSI</p>
                    </div>

                    <!-- Info Siswa -->
                    <div class="print-info-col flex-1 w-full space-y-2.5 text-xs">
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/60">
                            <span class="text-[9.5px] font-bold text-slate-400 uppercase tracking-wider block">Nama Lengkap Siswa</span>
                            <p class="font-bold text-sm text-slate-900 mt-0.5 leading-snug">{{ $siswa->nama }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200/60">
                                <span class="text-[9.5px] font-bold text-slate-400 uppercase tracking-wider block">ID / NISN</span>
                                <p class="font-mono font-bold text-sm text-slate-900 mt-0.5">{{ $siswa->nisn }}</p>
                            </div>
                            <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200/60">
                                <span class="text-[9.5px] font-bold text-slate-400 uppercase tracking-wider block">Kelas</span>
                                <p class="font-bold text-sm text-sky-700 mt-0.5">{{ $siswa->kelas }}</p>
                            </div>
                        </div>

                        <div class="p-2.5 rounded-xl bg-sky-50/70 border border-sky-200/60 flex items-center justify-between gap-2">
                            <div>
                                <span class="text-[9.5px] font-bold text-sky-700 uppercase tracking-wider block">Jurusan / Program Keahlian</span>
                                <p class="font-bold text-xs text-slate-900 mt-0.5">Teknik Komputer & Jaringan ( TKJ )</p>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[9px] font-extrabold bg-sky-100 text-sky-800 flex-shrink-0">TKJ</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Kartu -->
            <div class="print-footer px-5 py-2.5 bg-slate-50 border-t border-slate-100 text-[10px] text-slate-400 flex items-center justify-between font-mono">
                <span class="flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Enkripsi: AES-128-CBC + IV Acak
                </span>
                <span>SMKN 3 BENGKALIS</span>
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
            /* Reset background & layout dashboard */
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
            .max-w-xl {
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            /* Kartu Cetak: Kompak, 1 Halaman */
            #printArea {
                position: relative !important;
                margin: 15px auto 0 auto !important;
                width: 100% !important;
                max-width: 440px !important;
                box-shadow: none !important;
                border: 1.5px solid #0284c7 !important;
                border-radius: 16px !important;
                overflow: hidden !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            /* Header Kartu Cetak */
            #printArea .print-header {
                padding: 10px 14px !important;
            }

            /* Body Kartu Cetak */
            #printArea .print-body {
                padding: 12px 14px !important;
            }
            #printArea .print-grid {
                display: flex !important;
                flex-direction: row !important;
                align-items: center !important;
                gap: 12px !important;
            }

            /* Ukuran QR Code Cetak */
            #printArea .print-qr-col {
                width: 125px !important;
                max-width: 125px !important;
                flex-shrink: 0 !important;
                padding: 7px !important;
            }
            #printArea .print-qr-inner {
                padding: 5px !important;
            }
            #printArea .print-qr-inner svg {
                width: 100px !important;
                height: 100px !important;
                display: block !important;
                margin: 0 auto !important;
            }
            #printArea .print-qr-label {
                font-size: 7.5px !important;
                margin-top: 4px !important;
            }

            /* Info Siswa Cetak */
            #printArea .print-info-col {
                flex: 1 1 0% !important;
                gap: 5px !important;
            }
            #printArea .print-info-col > div {
                padding: 6px 9px !important;
                border-radius: 8px !important;
            }

            /* Footer Kartu Cetak */
            #printArea .print-footer {
                padding: 6px 14px !important;
                font-size: 8.5px !important;
                background-color: #f8fafc !important;
            }
        }
    </style>
    @endpush

</x-layouts.dashboard>
