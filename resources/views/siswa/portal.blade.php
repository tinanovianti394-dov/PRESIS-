{{--
    Portal Peserta Didik — PRESIS SMK Negeri 3 Bengkalis
    Tampilan Murni Read-Only Berstandar Kriptografi AES-128-CBC
    Selaras dengan Konsep Keamanan Kartu Fisik CR80 (Tanpa Token Dinamis / Countdown)
--}}

<x-layouts.dashboard :title="'Portal Siswa'" :role="'SISWA'" :pageTitle="'Portal Peserta Didik'">

    {{-- Sidebar Menu Siswa --}}
    <x-slot:sidebar>
        @include('components.sidebar-item', ['href' => '/siswa/portal', 'label' => 'PORTAL AKADEMIK', 'active' => true])
        @include('components.sidebar-item', ['href' => '/siswa/riwayat', 'label' => 'RIWAYAT ABSENSI'])
        @include('components.sidebar-item', ['href' => '/siswa/cetak-kartu', 'label' => 'CETAK KARTU CR80'])
    </x-slot:sidebar>

    <div class="space-y-6">

        {{-- ============================================================ --}}
        {{-- 1. HEADER PROFIL AKADEMIK SISWA --}}
        {{-- ============================================================ --}}
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#023A58] via-[#046EA7] to-[#035D8D] text-white p-6 sm:p-8 shadow-md">
            {{-- Aksen Dekoratif Geometris Lembut --}}
            <div class="absolute -right-12 -top-12 w-56 h-56 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
            <div class="absolute right-36 -bottom-16 w-48 h-48 rounded-full bg-sky-400/15 blur-xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                {{-- Profil Siswa --}}
                <div class="flex items-start sm:items-center gap-4 sm:gap-5">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-white p-1 shadow-lg ring-2 ring-white/30 flex-shrink-0 flex items-center justify-center overflow-hidden">
                        {{-- Avatar Siswa Formal --}}
                        <svg class="w-full h-full" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="50" cy="50" r="48" fill="#EBF5FB"/>
                            <path d="M28 36C28 22 38 15 50 15C62 15 72 22 72 36C72 40 70 42 70 42C67 36 62 34 50 34C38 34 33 36 30 42C30 42 28 40 28 36Z" fill="#1E293B"/>
                            <path d="M32 38C32 38 32 58 50 58C68 58 68 38 68 38C68 38 62 38 50 38C38 38 32 38 32 38Z" fill="#FAD7A0"/>
                            <circle cx="31" cy="45" r="3.5" fill="#FAD7A0"/>
                            <circle cx="69" cy="45" r="3.5" fill="#FAD7A0"/>
                            <rect x="36" y="40" width="11" height="8" rx="2" stroke="#0F172A" stroke-width="2.2" fill="none"/>
                            <rect x="53" y="40" width="11" height="8" rx="2" stroke="#0F172A" stroke-width="2.2" fill="none"/>
                            <line x1="47" y1="44" x2="53" y2="44" stroke="#0F172A" stroke-width="2"/>
                            <path d="M42 51C44 54 47 55 50 55C53 55 56 54 58 51" stroke="#1E293B" stroke-width="1.8" stroke-linecap="round"/>
                            <rect x="45" y="58" width="10" height="9" fill="#F5B7B1"/>
                            <path d="M22 88C22 72 34 67 44 66L46 75L50 78L54 75L56 66C66 67 78 72 78 88H22Z" fill="#046EA7"/>
                            <polygon points="46,66 54,66 52,78 48,78" fill="#FFFFFF"/>
                            <polygon points="49,67 51,67 52,80 50,83 48,80" fill="#023A58"/>
                        </svg>
                    </div>

                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-[10px] font-extrabold uppercase bg-white/20 backdrop-blur-md text-sky-100 border border-white/25">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                SISWA AKTIF &bull; TP 2026/2027
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-[#A2CBD9]/25 text-white border border-white/20">
                                SMKN 3 BENGKALIS
                            </span>
                        </div>

                        <h1 class="text-xl sm:text-2xl font-black tracking-tight text-white leading-tight">
                            {{ $siswa->nama }}
                        </h1>

                        <div class="mt-2 flex flex-wrap items-center gap-y-1 gap-x-4 text-xs text-sky-100">
                            <div class="flex items-center gap-1.5">
                                <span class="text-sky-200">NISN:</span>
                                <span class="font-bold font-mono text-white">{{ $siswa->nisn }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="text-sky-200">Kelas:</span>
                                <span class="font-extrabold text-white">{{ $siswa->kelas }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="text-sky-200">Jurusan:</span>
                                <span class="font-bold text-sky-100">Teknik Komputer & Jaringan ( TKJ )</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi Cepat Header --}}
                <div class="flex flex-wrap items-center gap-2.5 self-start md:self-center">
                    <a href="{{ route('siswa.cetak-kartu') }}" target="_blank"
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs bg-white text-[#046EA7] hover:bg-sky-50 shadow-md shadow-black/10 transition-all active:scale-95 flex-shrink-0">
                        <svg class="w-4 h-4 text-[#046EA7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                        </svg>
                        <span>Cetak Kartu CR80</span>
                    </a>

                    <a href="{{ route('siswa.riwayat') }}"
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs bg-white/15 hover:bg-white/25 text-white border border-white/20 transition-all active:scale-95 flex-shrink-0">
                        <svg class="w-4 h-4 text-sky-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        <span>Riwayat Absensi</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- 2. GRID UTAMA: KARTU QR STATIS (KIRI) & STATUS/STATISTIK (KANAN) --}}
        {{-- ============================================================ --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            {{-- ======================================================== --}}
            {{-- KOLOM KIRI: VISUALISASI QR CODE STATIS RESMI SISWA (5/12) --}}
            {{-- ======================================================== --}}
            <div class="lg:col-span-5 space-y-4">
                <div id="printArea" class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden transition-all">
                    {{-- Header Kartu Presensi Digital --}}
                    <div class="p-4 sm:p-5 bg-gradient-to-r from-slate-900 via-[#023A58] to-[#046EA7] text-white flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <img src="{{ asset('images/logo-smkn3.jpg') }}" alt="Logo SMKN 3" class="w-8 h-8 rounded-lg object-cover ring-1 ring-white/30 shadow-xs">
                            <div>
                                <h3 class="text-xs font-black tracking-tight uppercase leading-tight">Kartu Presensi Siswa</h3>
                                <p class="text-[10px] text-sky-200">Kode QR Terenkripsi AES-128</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[9px] font-extrabold uppercase bg-emerald-500/20 text-emerald-300 border border-emerald-400/30">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                            Statis CR80
                        </span>
                    </div>

                    {{-- Badan QR Code Statis Read-Only --}}
                    <div class="p-6 flex flex-col items-center justify-center text-center bg-gradient-to-b from-slate-50/50 to-white">
                        {{-- Frame Kontainer QR Code --}}
                        <div class="p-3 bg-white rounded-2xl border-2 border-slate-200/90 shadow-md shadow-slate-200/60 inline-flex items-center justify-center">
                            <div class="w-[190px] h-[190px] flex items-center justify-center">
                                {!! $qrCodeSvg !!}
                            </div>
                        </div>

                        {{-- Metadata Identitas QR --}}
                        <div class="mt-4 w-full">
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase bg-sky-50 text-[#046EA7] border border-sky-200/80 mb-2 font-mono">
                                NISN: {{ $siswa->nisn }}
                            </div>
                            <h4 class="font-black text-sm text-slate-900 uppercase tracking-tight">
                                {{ $siswa->nama }}
                            </h4>
                            <p class="text-[11px] font-bold text-slate-500 mt-0.5">
                                Kelas {{ $siswa->kelas }} &bull; Teknik Komputer & Jaringan
                            </p>
                        </div>

                        {{-- Box Keterangan Keamanan Read-Only --}}
                        <div class="mt-4 p-3 bg-slate-50 rounded-xl border border-slate-200/80 text-left w-full space-y-1.5 text-[11px] text-slate-600">
                            <div class="flex items-center gap-1.5 font-bold text-slate-800 text-[11px]">
                                <svg class="w-3.5 h-3.5 text-[#046EA7] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <span>Spesifikasi Kriptografi Kartu:</span>
                            </div>
                            <ul class="text-[10.5px] text-slate-500 space-y-1 list-disc list-inside">
                                <li>Algoritma: <strong>AES-128-CBC</strong> dengan IV 16-byte acak.</li>
                                <li>Masa Berlaku: <strong>Permanen</strong> (Statis pada ID Card fisik).</li>
                                <li>Anti-Titip Absen: Hanya dapat didekripsi kamera scanner guru.</li>
                            </ul>
                        </div>

                        {{-- Tombol Aksi Cetak Kartu --}}
                        <div class="mt-5 w-full grid grid-cols-2 gap-2.5 no-print">
                            <a href="{{ route('siswa.cetak-kartu') }}" target="_blank"
                               class="inline-flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl text-xs font-bold bg-[#046EA7] hover:bg-[#035D8D] text-white shadow-sm transition-all active:scale-95 text-center">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                </svg>
                                <span>Cetak ID CR80</span>
                            </a>

                            <button onclick="window.print()" type="button"
                                    class="inline-flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl text-xs font-bold bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 shadow-2xs transition-all active:scale-95 text-center">
                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                <span>Print Lembar A4</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ======================================================== --}}
            {{-- KOLOM KANAN: STATUS HARI INI & STATISTIK BULAN INI (7/12) --}}
            {{-- ======================================================== --}}
            <div class="lg:col-span-7 space-y-6">

                {{-- Status Presensi Hari Ini --}}
                @if($absensiHariIni)
                    @php
                        $statusConfig = match($absensiHariIni->status) {
                            'hadir' => ['bg' => 'bg-emerald-50/90', 'border' => 'border-emerald-200', 'text' => 'text-emerald-900', 'badge' => 'bg-emerald-100 text-emerald-800', 'icon' => '✓', 'title' => 'PRESENSI HADIR TERKONFIRMASI'],
                            'sakit' => ['bg' => 'bg-sky-50/90', 'border' => 'border-sky-200', 'text' => 'text-sky-900', 'badge' => 'bg-sky-100 text-sky-800', 'icon' => '✚', 'title' => 'KETERANGAN SAKIT TERVERIFIKASI'],
                            'izin'  => ['bg' => 'bg-amber-50/90', 'border' => 'border-amber-200', 'text' => 'text-amber-900', 'badge' => 'bg-amber-100 text-amber-800', 'icon' => '✉', 'title' => 'KETERANGAN IZIN TERCATAT'],
                            'alfa'  => ['bg' => 'bg-rose-50/90', 'border' => 'border-rose-200', 'text' => 'text-rose-900', 'badge' => 'bg-rose-100 text-rose-800', 'icon' => '✕', 'title' => 'TANPA KETERANGAN'],
                            default => ['bg' => 'bg-slate-50', 'border' => 'border-slate-200', 'text' => 'text-slate-900', 'badge' => 'bg-slate-100 text-slate-800', 'icon' => '•', 'title' => 'STATUS TERCATAT'],
                        };
                    @endphp
                    <div class="{{ $statusConfig['bg'] }} border {{ $statusConfig['border'] }} rounded-3xl p-5 sm:p-6 shadow-xs">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-[11px] font-extrabold uppercase tracking-wider {{ $statusConfig['text'] }}">
                                Status Presensi Hari Ini ({{ now()->translatedFormat('l, d F Y') }})
                            </span>
                            <span class="px-3 py-0.5 rounded-full text-xs font-black uppercase {{ $statusConfig['badge'] }}">
                                {{ strtoupper($absensiHariIni->status) }}
                            </span>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-white shadow-sm flex items-center justify-center font-black text-xl text-emerald-600 flex-shrink-0">
                                {{ $statusConfig['icon'] }}
                            </div>
                            <div>
                                <h3 class="text-base sm:text-lg font-black {{ $statusConfig['text'] }}">
                                    {{ $statusConfig['title'] }}
                                </h3>
                                <p class="text-xs text-slate-600 mt-0.5">
                                    Tercatat pukul <span class="font-bold font-mono text-slate-800">{{ $absensiHariIni->waktu_scan->format('H:i:s') }} WIB</span>
                                    @if($absensiHariIni->keterangan)
                                        &bull; {{ $absensiHariIni->keterangan }}
                                    @endif
                                </p>
                                <p class="text-[11px] text-emerald-700 mt-2 flex items-center gap-1 font-semibold">
                                    <span>📲</span> Notifikasi kehadiran otomatis telah diteruskan ke WhatsApp orang tua/wali.
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-3xl border border-slate-200/90 p-5 sm:p-6 shadow-xs">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">
                                Status Presensi Hari Ini ({{ now()->translatedFormat('l, d F Y') }})
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                Belum Presensi
                            </span>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 font-bold text-xl flex-shrink-0">
                                ⏱
                            </div>
                            <div>
                                <h3 class="text-base font-extrabold text-slate-800">
                                    Presensi Belum Tercatat Hari Ini
                                </h3>
                                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                    Silakan tunjukkan ID Card presensi fisik CR80 Anda atau barcode QR di sebelah kiri ke kamera pemindai guru pengampu di kelas.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Statistik Kehadiran Kumulatif Bulan Ini --}}
                <div class="bg-white rounded-3xl border border-slate-200/90 p-5 sm:p-6 shadow-xs">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900">Rekapitulasi Kehadiran Bulanan</h3>
                            <p class="text-xs text-slate-500">{{ now()->translatedFormat('F Y') }} &bull; Semester Berjalan</p>
                        </div>
                        <span class="text-lg font-black text-[#046EA7] font-mono">
                            {{ $persenHadir }}%
                        </span>
                    </div>

                    {{-- Bar Persentase --}}
                    <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden mb-2">
                        <div class="bg-gradient-to-r from-[#046EA7] to-emerald-500 h-full rounded-full transition-all duration-500"
                             style="width: {{ min($persenHadir, 100) }}%"></div>
                    </div>

                    <p class="text-xs text-slate-500 mb-4">
                        Tercatat hadir sebanyak <strong class="text-slate-800">{{ $hadirBulan }} hari</strong> dari total <strong class="text-slate-800">{{ $hariKerja }} hari efektif sekolah</strong>.
                    </p>

                    {{-- 4 Kotak Metrik --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-2">
                        <div class="p-3 rounded-2xl bg-emerald-50/80 border border-emerald-200/80 text-center">
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-700 block">Hadir</span>
                            <p class="text-xl font-black text-emerald-700 mt-0.5">{{ $hadirBulan }}</p>
                        </div>
                        <div class="p-3 rounded-2xl bg-sky-50/80 border border-sky-200/80 text-center">
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-sky-700 block">Sakit</span>
                            <p class="text-xl font-black text-sky-700 mt-0.5">{{ $sakitBulan }}</p>
                        </div>
                        <div class="p-3 rounded-2xl bg-amber-50/80 border border-amber-200/80 text-center">
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-amber-700 block">Izin</span>
                            <p class="text-xl font-black text-amber-700 mt-0.5">{{ $izinBulan }}</p>
                        </div>
                        <div class="p-3 rounded-2xl bg-rose-50/80 border border-rose-200/80 text-center">
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-rose-700 block">Alfa</span>
                            <p class="text-xl font-black text-rose-700 mt-0.5">{{ $alfaBulan }}</p>
                        </div>
                    </div>
                </div>

                {{-- Tabel Ringkas 5 Catatan Riwayat Presensi Terakhir --}}
                <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900">Catatan Presensi Terakhir</h3>
                            <p class="text-xs text-slate-400">5 riwayat pemindaian kehadiran terbaru</p>
                        </div>
                        <a href="{{ route('siswa.riwayat') }}"
                           class="text-xs font-bold text-[#046EA7] hover:text-[#035D8D] flex items-center gap-1 transition-colors">
                            <span>Semua Riwayat</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-50 text-[10px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                                <tr>
                                    <th class="px-4 py-3">Tanggal</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3">Waktu</th>
                                    <th class="px-4 py-3">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($riwayatAbsensi as $absensi)
                                    <tr class="hover:bg-slate-50/60 transition-colors">
                                        <td class="px-4 py-3 font-semibold text-slate-800">
                                            {{ $absensi->waktu_scan->format('d/m/Y') }}
                                            <span class="text-[10px] text-slate-400 block">{{ $absensi->waktu_scan->translatedFormat('l') }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            @php
                                                $badgeStyle = match($absensi->status) {
                                                    'hadir' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                    'sakit' => 'bg-sky-50 text-sky-700 border-sky-200',
                                                    'izin'  => 'bg-amber-50 text-amber-700 border-amber-200',
                                                    'alfa'  => 'bg-rose-50 text-rose-700 border-rose-200',
                                                    default => 'bg-slate-50 text-slate-700 border-slate-200',
                                                };
                                            @endphp
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-extrabold border uppercase {{ $badgeStyle }}">
                                                {{ $absensi->status }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 font-mono text-slate-600">
                                            {{ $absensi->waktu_scan->format('H:i') }} WIB
                                        </td>
                                        <td class="px-4 py-3 text-slate-500 truncate max-w-[140px]">
                                            {{ $absensi->keterangan ?? 'Scan QR Card' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-8 text-center text-slate-400">
                                            Belum ada catatan presensi pada semester ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>

    </div>

    {{-- ============================================================ --}}
    {{-- CSS PRINT (OPTIMAL 1 HALAMAN RINGKAS CETAK A4) --}}
    {{-- ============================================================ --}}
    @push('styles')
    <style>
        @page {
            size: portrait;
            margin: 12mm 15mm;
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

            /* Sembunyikan semua elemen layout non-cetak */
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

            /* Tampilkan Kartu Presensi Saja Saat Dicetak */
            #printArea {
                position: relative !important;
                margin: 20px auto 0 auto !important;
                width: 100% !important;
                max-width: 440px !important;
                box-shadow: none !important;
                border: 1.5px solid #046EA7 !important;
                border-radius: 16px !important;
                overflow: hidden !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }
        }
    </style>
    @endpush

</x-layouts.dashboard>
