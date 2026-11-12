{{--
    Portal/Dashboard Siswa PRESIS
    Menampilkan status absensi hari ini, statistik bulanan,
    dan riwayat absensi terakhir.
--}}

<x-layouts.dashboard :title="'Portal Siswa'" :role="'SISWA'" :pageTitle="'Portal Peserta Didik'">

    {{-- Sidebar Menu Siswa --}}
    <x-slot:sidebar>
        @include('components.sidebar-item', ['href' => '/siswa/portal', 'label' => 'Portal', 'active' => true])
        @include('components.sidebar-item', ['href' => '/siswa/qrcode', 'label' => 'QR Code Saya'])
        @include('components.sidebar-item', ['href' => '/siswa/riwayat', 'label' => 'Riwayat Absensi'])
    </x-slot:sidebar>

    {{-- ============================================================ --}}
    {{-- INFO SISWA + STATUS HARI INI --}}
    {{-- ============================================================ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">
        {{-- Kartu Info Siswa --}}
        <div class="lg:col-span-1 rounded-3xl bg-gradient-to-br from-sky-700 via-sky-800 to-blue-900 text-white p-6 shadow-md relative overflow-hidden flex flex-col justify-between">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-white/15 backdrop-blur-md text-sky-100 border border-white/20">
                        🎓 Kartu Pelajar Digital
                    </span>
                    <span class="text-xs font-bold text-sky-200">SMKN 3</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center font-extrabold text-lg text-white mb-3 shadow-inner">
                    {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                </div>
                <h2 class="text-xl font-extrabold tracking-tight leading-snug">{{ $siswa->nama }}</h2>
                <div class="mt-4 space-y-1.5 text-xs text-sky-100/90">
                    <p class="flex items-center justify-between">
                        <span class="text-sky-200">NISN:</span>
                        <span class="font-bold font-mono text-white">{{ $siswa->nisn }}</span>
                    </p>
                    <p class="flex items-center justify-between">
                        <span class="text-sky-200">Kelas / Rombel:</span>
                        <span class="font-bold text-white">{{ $siswa->kelas }}</span>
                    </p>
                    <p class="flex items-center justify-between">
                        <span class="text-sky-200">No. WhatsApp Ortu:</span>
                        <span class="font-bold font-mono text-white">{{ $siswa->no_hp_orangtua ?? '-' }}</span>
                    </p>
                </div>
            </div>
            <div class="mt-5 pt-4 border-t border-white/15 relative z-10 flex items-center justify-between">
                <a href="/siswa/qrcode" class="inline-flex items-center gap-1.5 text-xs font-bold text-white hover:text-sky-200 transition-colors">
                    <span>Tampilkan QR Code</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
            <div class="absolute -right-8 -bottom-10 w-40 h-40 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
        </div>

        {{-- Status Absensi Hari Ini --}}
        <div class="lg:col-span-2">
            @if($absensiHariIni)
                @php
                    $statusConfig = match($absensiHariIni->status) {
                        'hadir' => ['bg' => 'bg-emerald-50/80', 'border' => 'border-emerald-200', 'text' => 'text-emerald-800', 'badge' => 'bg-emerald-100 text-emerald-800', 'icon' => '✓', 'label' => 'Hadir Terkonfirmasi'],
                        'sakit' => ['bg' => 'bg-sky-50/80', 'border' => 'border-sky-200', 'text' => 'text-sky-800', 'badge' => 'bg-sky-100 text-sky-800', 'icon' => '✚', 'label' => 'Keterangan Sakit'],
                        'izin'  => ['bg' => 'bg-amber-50/80', 'border' => 'border-amber-200', 'text' => 'text-amber-800', 'badge' => 'bg-amber-100 text-amber-800', 'icon' => '✉', 'label' => 'Keterangan Izin'],
                        'alfa'  => ['bg' => 'bg-rose-50/80', 'border' => 'border-rose-200', 'text' => 'text-rose-800', 'badge' => 'bg-rose-100 text-rose-800', 'icon' => '✕', 'label' => 'Tanpa Keterangan'],
                        default => ['bg' => 'bg-slate-50', 'border' => 'border-slate-200', 'text' => 'text-slate-800', 'badge' => 'bg-slate-100 text-slate-800', 'icon' => '?', 'label' => '-'],
                    };
                @endphp
                <div class="{{ $statusConfig['bg'] }} border {{ $statusConfig['border'] }} rounded-3xl p-6 shadow-sm h-full flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-bold uppercase tracking-wider {{ $statusConfig['text'] }}">Status Presensi Hari Ini</span>
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $statusConfig['badge'] }}">
                                {{ strtoupper($absensiHariIni->status) }}
                            </span>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-white shadow-sm flex items-center justify-center font-extrabold text-2xl {{ $statusConfig['text'] }}">
                                {{ $statusConfig['icon'] }}
                            </div>
                            <div>
                                <h3 class="text-xl font-extrabold {{ $statusConfig['text'] }}">{{ $statusConfig['label'] }}</h3>
                                <p class="text-xs text-slate-600 mt-1">
                                    Tercatat pada pukul <span class="font-mono font-bold">{{ $absensiHariIni->waktu_scan->format('H:i') }} WIB</span>
                                    @if($absensiHariIni->keterangan)
                                        · {{ $absensiHariIni->keterangan }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-200/60 text-xs text-slate-500 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>Presensi telah tervalidasi secara sah ke dalam basis data sekolah.</span>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm h-full flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Status Presensi Hari Ini</span>
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                                Belum Presensi
                            </span>
                        </div>
                        <div class="flex items-start gap-4 mt-2">
                            <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center font-bold text-2xl text-slate-400">
                                ⏱
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-800">Anda Belum Melakukan Absensi</h3>
                                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                    Buka menu "QR Code Saya", lalu perlihatkan kode QR dinamis Anda ke perangkat kamera guru di kelas.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100">
                        <a href="/siswa/qrcode" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-semibold text-xs shadow-sm transition-all">
                            <span>Tampilkan QR Code Sekarang</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- STATISTIK BULAN INI --}}
    {{-- ============================================================ --}}
    <div class="mb-6">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-sm font-bold text-slate-900">Statistik Kehadiran Bulan Ini</h3>
            <span class="text-xs text-slate-500 font-medium">{{ now()->translatedFormat('F Y') }}</span>
        </div>

        {{-- Progress Bar Kehadiran --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm mb-4">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-600 uppercase tracking-wider">Tingkat Kehadiran Kumulatif</span>
                <span class="text-lg font-extrabold text-sky-700 font-mono">{{ $persenHadir }}%</span>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                <div class="bg-gradient-to-r from-sky-500 to-emerald-500 h-full rounded-full transition-all duration-500"
                     style="width: {{ min($persenHadir, 100) }}%"></div>
            </div>
            <p class="text-xs text-slate-500 mt-2">
                Tercatat <span class="font-bold text-slate-800">{{ $hadirBulan }} hari hadir</span> dari perkiraan <span class="font-bold text-slate-800">{{ $hariKerja }} hari efektif sekolah</span>.
            </p>
        </div>

        {{-- Detail per status --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="p-4 rounded-xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Hadir</span>
                    <p class="text-2xl font-extrabold text-emerald-600 mt-0.5">{{ $hadirBulan }}</p>
                </div>
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">✓</div>
            </div>

            <div class="p-4 rounded-xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Sakit</span>
                    <p class="text-2xl font-extrabold text-sky-600 mt-0.5">{{ $sakitBulan }}</p>
                </div>
                <div class="w-9 h-9 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold">✚</div>
            </div>

            <div class="p-4 rounded-xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Izin</span>
                    <p class="text-2xl font-extrabold text-amber-600 mt-0.5">{{ $izinBulan }}</p>
                </div>
                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">✉</div>
            </div>

            <div class="p-4 rounded-xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Alfa</span>
                    <p class="text-2xl font-extrabold text-rose-600 mt-0.5">{{ $alfaBulan }}</p>
                </div>
                <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold">✕</div>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- TABEL RIWAYAT ABSENSI --}}
    {{-- ============================================================ --}}
    <div class="rounded-2xl bg-white border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-white">
            <h3 class="text-sm font-bold text-slate-900">Riwayat Presensi Terakhir</h3>
            <a href="/siswa/riwayat" class="inline-flex items-center gap-1 text-xs font-semibold text-sky-600 hover:text-sky-700 transition-colors">
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
                        <th class="px-5 py-3.5">Tanggal</th>
                        <th class="px-5 py-3.5">Hari</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5">Waktu Scan</th>
                        <th class="px-5 py-3.5">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($riwayatAbsensi as $index => $absensi)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-5 py-3.5 text-center text-xs text-slate-400 font-mono">{{ $index + 1 }}</td>
                            <td class="px-5 py-3.5 font-medium text-slate-900">{{ $absensi->waktu_scan->format('d/m/Y') }}</td>
                            <td class="px-5 py-3.5 text-xs text-slate-600">{{ $absensi->waktu_scan->translatedFormat('l') }}</td>
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
                            <td class="px-5 py-3.5 font-mono text-xs text-slate-600">{{ $absensi->waktu_scan->format('H:i') }} WIB</td>
                            <td class="px-5 py-3.5 text-xs text-slate-500">{{ $absensi->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <p class="font-semibold text-slate-500">Belum ada catatan riwayat absensi</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-layouts.dashboard>
