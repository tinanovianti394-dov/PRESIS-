{{--
    Dashboard Admin PRESIS
    Menampilkan ringkasan statistik: total siswa, guru, kehadiran hari ini,
    dan tabel absensi terbaru dengan visualisasi profesional.
--}}

<x-layouts.dashboard :title="'Dashboard Admin'" :role="'ADMIN'" :pageTitle="'Dashboard Administrator'">

    {{-- Sidebar Menu Admin --}}
    <x-slot:sidebar>
        @include('components.sidebar-item', ['href' => '/admin/dashboard', 'label' => 'Dashboard', 'active' => true])
        @include('components.sidebar-item', ['href' => '/admin/siswa', 'label' => 'Data Siswa'])
        @include('components.sidebar-item', ['href' => '/admin/guru', 'label' => 'Data Guru'])
        @include('components.sidebar-item', ['href' => '/admin/absensi', 'label' => 'Data Absensi'])
        @include('components.sidebar-item', ['href' => '/admin/rekap', 'label' => 'Rekap Laporan'])
    </x-slot:sidebar>

    {{-- Welcome Banner --}}
    <div class="mb-6 p-6 rounded-2xl bg-gradient-to-r from-sky-700 via-sky-800 to-blue-900 text-white shadow-sm relative overflow-hidden">
        <div class="relative z-10">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white/15 backdrop-blur-md text-sky-100 mb-3 border border-white/20">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Panel Manajemen Utama
            </span>
            <h2 class="text-xl sm:text-2xl font-extrabold tracking-tight">Selamat Datang, {{ Auth::user()->name }}</h2>
            <p class="text-xs sm:text-sm text-sky-100/90 mt-1 max-w-2xl leading-relaxed">
                Pantau kehadiran siswa kelas XI TKJ 1, kelola guru pengampu, dan lakukan rekapitulasi presensi harian secara akurat dan real-time.
            </p>
        </div>
        <div class="absolute -right-8 -bottom-10 w-48 h-48 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
    </div>

    {{-- ============================================================ --}}
    {{-- KARTU STATISTIK UTAMA --}}
    {{-- ============================================================ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        {{-- Total Siswa --}}
        <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Siswa</p>
                <p class="text-3xl font-extrabold text-slate-900 mt-1.5">{{ $totalSiswa }}</p>
                <p class="text-[11px] font-semibold text-sky-600 mt-1">Kelas XI TKJ 1</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center ring-1 ring-sky-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
        </div>

        {{-- Total Guru --}}
        <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Guru Pengampu</p>
                <p class="text-3xl font-extrabold text-slate-900 mt-1.5">{{ $totalGuru }}</p>
                <p class="text-[11px] font-semibold text-blue-600 mt-1">15 Mapel Kejuruan & Umum</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center ring-1 ring-blue-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>

        {{-- Scan Hari Ini --}}
        <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Scan Hari Ini</p>
                <p class="text-3xl font-extrabold text-slate-900 mt-1.5">{{ $absensiToday }}</p>
                <p class="text-[11px] font-semibold text-emerald-600 mt-1">QR Code Valid</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center ring-1 ring-emerald-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                </svg>
            </div>
        </div>

        {{-- Persentase Hadir --}}
        <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">% Kehadiran</p>
                <p class="text-3xl font-extrabold text-slate-900 mt-1.5">{{ $persenHadir }}%</p>
                <div class="w-24 bg-slate-100 h-1.5 rounded-full overflow-hidden mt-2">
                    <div class="bg-emerald-500 h-full rounded-full" style="width: {{ min(100, $persenHadir) }}%"></div>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center ring-1 ring-teal-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- DETAIL STATUS PRESENSI HARI INI --}}
    {{-- ============================================================ --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 mb-6">
        <div class="p-4 rounded-xl bg-emerald-50/70 border border-emerald-200/70 flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-emerald-800 uppercase tracking-wide">Hadir</span>
                <p class="text-2xl font-extrabold text-emerald-900 mt-0.5">{{ $hadirToday }}</p>
            </div>
            <span class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 font-bold flex items-center justify-center text-sm">✓</span>
        </div>

        <div class="p-4 rounded-xl bg-sky-50/70 border border-sky-200/70 flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-sky-800 uppercase tracking-wide">Sakit</span>
                <p class="text-2xl font-extrabold text-sky-900 mt-0.5">{{ $sakitToday }}</p>
            </div>
            <span class="w-8 h-8 rounded-lg bg-sky-100 text-sky-700 font-bold flex items-center justify-center text-sm">✚</span>
        </div>

        <div class="p-4 rounded-xl bg-amber-50/70 border border-amber-200/70 flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-amber-800 uppercase tracking-wide">Izin</span>
                <p class="text-2xl font-extrabold text-amber-900 mt-0.5">{{ $izinToday }}</p>
            </div>
            <span class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 font-bold flex items-center justify-center text-sm">✉</span>
        </div>

        <div class="p-4 rounded-xl bg-rose-50/70 border border-rose-200/70 flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-rose-800 uppercase tracking-wide">Alfa</span>
                <p class="text-2xl font-extrabold text-rose-900 mt-0.5">{{ $alfaToday }}</p>
            </div>
            <span class="w-8 h-8 rounded-lg bg-rose-100 text-rose-700 font-bold flex items-center justify-center text-sm">✕</span>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- TABEL ABSENSI TERBARU --}}
    {{-- ============================================================ --}}
    <div class="rounded-2xl bg-white border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-white">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Aktivitas Presensi Hari Ini</h3>
                <p class="text-xs text-slate-500">10 data scan QR Code siswa terbaru secara langsung</p>
            </div>
            <a href="/admin/absensi" class="inline-flex items-center gap-1 text-xs font-semibold text-sky-600 hover:text-sky-700 transition-colors">
                <span>Lihat Semua</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50/80 text-xs font-semibold text-slate-500 uppercase tracking-wider border-b border-slate-200/80">
                    <tr>
                        <th class="px-6 py-3.5">Siswa</th>
                        <th class="px-6 py-3.5">NISN</th>
                        <th class="px-6 py-3.5">Kelas</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5">Waktu Scan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($absensiTerbaru as $absensi)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-6 py-3.5 font-medium text-slate-900 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-sky-100 text-sky-700 font-bold text-xs flex items-center justify-center flex-shrink-0">
                                    {{ strtoupper(substr($absensi->siswa->nama ?? 'S', 0, 1)) }}
                                </div>
                                <span>{{ $absensi->siswa->nama ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-3.5 font-mono text-xs text-slate-600">{{ $absensi->nisn }}</td>
                            <td class="px-6 py-3.5">
                                <span class="px-2 py-0.5 rounded-md text-xs font-medium bg-slate-100 text-slate-700">
                                    {{ $absensi->siswa->kelas ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-3.5">
                                @php
                                    $statusConfig = match($absensi->status) {
                                        'hadir' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'dot' => 'bg-emerald-500'],
                                        'sakit' => ['bg' => 'bg-sky-50', 'text' => 'text-sky-700', 'border' => 'border-sky-200', 'dot' => 'bg-sky-500'],
                                        'izin'  => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'dot' => 'bg-amber-500'],
                                        'alfa'  => ['bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'border' => 'border-rose-200', 'dot' => 'bg-rose-500'],
                                        default => ['bg' => 'bg-slate-50', 'text' => 'text-slate-700', 'border' => 'border-slate-200', 'dot' => 'bg-slate-500'],
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold border {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} {{ $statusConfig['border'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>
                                    {{ ucfirst($absensi->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-3.5 text-xs text-slate-500">
                                {{ $absensi->waktu_scan->format('d/m/Y H:i') }} WIB
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    <p class="font-semibold text-slate-500">Belum ada aktivitas presensi hari ini</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Siswa yang melakukan scan QR akan otomatis tampil di sini</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-layouts.dashboard>
