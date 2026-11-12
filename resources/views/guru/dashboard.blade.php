{{--
    Dashboard Guru PRESIS
    Menampilkan ringkasan scan hari ini, tombol akses scanner QR,
    dan tabel riwayat absensi yang diinput guru ini.
--}}

<x-layouts.dashboard :title="'Dashboard Guru'" :role="'GURU'" :pageTitle="'Dashboard Pendidik'">

    {{-- Sidebar Menu Guru --}}
    <x-slot:sidebar>
        @include('components.sidebar-item', ['href' => '/guru/dashboard', 'label' => 'Dashboard', 'active' => true])
        @include('components.sidebar-item', ['href' => '/guru/scanner', 'label' => 'Scan QR Code'])
        @include('components.sidebar-item', ['href' => '/guru/absensi', 'label' => 'Data Absensi'])
        @include('components.sidebar-item', ['href' => '/guru/rekap', 'label' => 'Rekap Harian'])
    </x-slot:sidebar>

    {{-- Banner Selamat Datang & Quick Action Scanner --}}
    <div class="bg-gradient-to-r from-sky-700 via-sky-800 to-blue-900 rounded-3xl p-6 sm:p-8 mb-6 text-white shadow-md relative overflow-hidden">
        <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white/15 backdrop-blur-md text-sky-100 mb-3 border border-white/20">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Pendidik & Petugas Presensi
                </span>
                <h2 class="text-xl sm:text-2xl font-extrabold tracking-tight">{{ $guru->name }}</h2>
                <p class="text-xs sm:text-sm text-sky-100 font-medium mt-1">
                    NIP: <span class="font-mono font-semibold">{{ $guru->nip ?? '-' }}</span> · SMKN 3 Bengkalis
                </p>
            </div>
            <a href="/guru/scanner"
               class="px-6 py-3.5 rounded-2xl bg-white hover:bg-sky-50 text-sky-900 font-extrabold text-sm shadow-lg shadow-black/10 hover:shadow-xl transition-all duration-200 active:scale-95 flex items-center gap-2.5 flex-shrink-0 group">
                <div class="w-8 h-8 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                </div>
                <span>Buka Scanner QR</span>
            </a>
        </div>
        <div class="absolute -right-8 -bottom-10 w-48 h-48 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
    </div>

    {{-- Statistik Hari Ini --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Scan</p>
                <p class="text-3xl font-extrabold text-slate-900 mt-1.5">{{ $totalScanHariIni }}</p>
                <p class="text-[11px] font-semibold text-slate-500 mt-1">Siswa hari ini</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center ring-1 ring-sky-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                </svg>
            </div>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Hadir</p>
                <p class="text-3xl font-extrabold text-emerald-600 mt-1.5">{{ $hadirHariIni }}</p>
                <p class="text-[11px] font-semibold text-emerald-600 mt-1">Presensi terkonfirmasi</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center ring-1 ring-emerald-100 font-bold text-xl">
                ✓
            </div>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tidak Hadir</p>
                <p class="text-3xl font-extrabold text-rose-600 mt-1.5">{{ $tidakHadirIni }}</p>
                <p class="text-[11px] font-semibold text-rose-600 mt-1">Izin / Sakit / Alfa</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center ring-1 ring-rose-100 font-bold text-xl">
                ✕
            </div>
        </div>
    </div>

    {{-- Tabel Riwayat Scan Guru Ini --}}
    <div class="rounded-2xl bg-white border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-white">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Riwayat Scan Anda Hari Ini</h3>
                <p class="text-xs text-slate-500">Daftar siswa yang Anda validasi hari ini</p>
            </div>
            <a href="/guru/absensi" class="inline-flex items-center gap-1 text-xs font-semibold text-sky-600 hover:text-sky-700 transition-colors">
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
                        <th class="px-5 py-3.5 w-12 text-center">No</th>
                        <th class="px-5 py-3.5">NISN</th>
                        <th class="px-5 py-3.5">Nama Siswa</th>
                        <th class="px-5 py-3.5">Kelas</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5">Waktu Scan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($absensiTerbaru as $index => $absensi)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-5 py-3.5 text-center text-xs text-slate-400 font-mono">{{ $index + 1 }}</td>
                            <td class="px-5 py-3.5 font-mono text-xs text-slate-600">{{ $absensi->nisn }}</td>
                            <td class="px-5 py-3.5 font-semibold text-slate-900 flex items-center gap-3">
                                <div class="w-7 h-7 rounded-full bg-sky-100 text-sky-700 font-bold text-xs flex items-center justify-center flex-shrink-0">
                                    {{ strtoupper(substr($absensi->siswa->nama ?? 'S', 0, 1)) }}
                                </div>
                                <span>{{ $absensi->siswa->nama ?? '-' }}</span>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="px-2 py-0.5 rounded-md text-xs font-medium bg-slate-100 text-slate-700">
                                    {{ $absensi->siswa->kelas ?? '-' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
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
                            <td class="px-5 py-3.5 font-mono text-xs text-slate-500">
                                {{ $absensi->waktu_scan->format('d/m/Y H:i') }} WIB
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                    </svg>
                                    <p class="font-semibold text-slate-500">Belum ada scan yang Anda lakukan hari ini</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Mulai dengan menekan tombol "Buka Scanner QR"</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-layouts.dashboard>
