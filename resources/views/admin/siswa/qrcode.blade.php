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
        <div class="mb-5 flex items-center justify-between">
            <a href="{{ route('admin.siswa.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center gap-1.5 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Kembali ke Data Siswa</span>
            </a>
            <button onclick="window.print()"
                    class="px-4 py-2 rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-semibold text-xs shadow-sm shadow-sky-600/25 flex items-center gap-1.5 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                <span>Cetak Kartu</span>
            </button>
        </div>

        {{-- Kartu QR Desain Modern --}}
        <div id="printArea" class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-md relative overflow-hidden">
            <!-- Header Kartu -->
            <div class="border-b border-slate-100 pb-4 mb-5 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo-smkn3.jpg') }}" alt="Logo SMKN 3 Bengkalis" class="w-11 h-11 rounded-xl object-cover ring-1 ring-slate-200 shadow-sm flex-shrink-0">
                    <div>
                        <h2 class="font-extrabold text-base tracking-tight text-slate-900 leading-tight">SMK NEGERI 3 BENGKALIS</h2>
                        <p class="text-[10px] font-bold text-sky-600 uppercase tracking-wider">Kartu Presensi Digital (PRESIS)</p>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-sky-50 text-sky-700 border border-sky-200/60 uppercase">
                    <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span> AES-128
                </span>
            </div>

            <!-- Konten Kartu QR & Identitas Siswa -->
            <div class="flex flex-col sm:flex-row items-center gap-6">
                <!-- QR Box -->
                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/80 text-center flex-shrink-0">
                    <div class="p-2 bg-white rounded-xl shadow-sm border border-slate-200/60">
                        {!! $qrCodeSvg !!}
                    </div>
                    <p class="text-[10px] font-mono font-bold text-slate-500 mt-2 tracking-wider uppercase">KODE PRESENSI SISWA</p>
                </div>

                <!-- Info Siswa -->
                <div class="flex-1 w-full space-y-3 text-xs">
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/60">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Nama Lengkap Siswa</span>
                        <p class="font-bold text-sm text-slate-900 mt-0.5">{{ $siswa->nama }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-2.5">
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/60">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">NISN</span>
                            <p class="font-mono font-bold text-sm text-slate-900 mt-0.5">{{ $siswa->nisn }}</p>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/60">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Kelas</span>
                            <p class="font-bold text-sm text-slate-900 mt-0.5">{{ $siswa->kelas }}</p>
                        </div>
                    </div>

                    <div class="p-3 rounded-xl bg-emerald-50/60 border border-emerald-200/60">
                        <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider block">No. HP Orang Tua (WhatsApp)</span>
                        <p class="font-mono font-bold text-emerald-950 mt-0.5">{{ $siswa->no_hp_orangtua ?? 'Belum Diatur' }}</p>
                    </div>
                </div>
            </div>

            <!-- Footer Kartu -->
            <div class="mt-5 pt-3.5 border-t border-slate-100 text-[10px] text-slate-400 flex items-center justify-between font-mono">
                <span>Enkripsi: OpenSSL AES-128-CBC + IV Acak</span>
                <span>Dicetak: {{ now()->format('d/m/Y') }}</span>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        @media print {
            body * { visibility: hidden; }
            #printArea, #printArea * { visibility: visible; }
            #printArea {
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
                width: 90%;
                box-shadow: none !important;
                border: 1px solid #cbd5e1 !important;
            }
        }
    </style>
    @endpush

</x-layouts.dashboard>
