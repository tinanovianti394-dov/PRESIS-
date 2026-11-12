{{--
    Halaman Riwayat Absensi Siswa PRESIS
    Desain Modern Clean SaaS & Enterprise Dashboard untuk SMKN 3 Bengkalis
    Menampilkan rekap status bulanan dan tabel detail kehadiran siswa.
--}}

<x-layouts.dashboard :title="'Riwayat Absensi'" :role="'SISWA'" :pageTitle="'RIWAYAT KEHADIRAN'">

    {{-- Sidebar Menu Siswa --}}
    <x-slot:sidebar>
        @include('components.sidebar-item', ['href' => '/siswa/portal', 'label' => 'PORTAL'])
        @include('components.sidebar-item', ['href' => '/siswa/qrcode', 'label' => 'QR CODE SAYA'])
        @include('components.sidebar-item', ['href' => '/siswa/riwayat', 'label' => 'RIWAYAT ABSENSI'])
    </x-slot:sidebar>

    <div class="space-y-6">

        {{-- ============================================================ --}}
        {{-- STATISTIK REKAPITULASI BULANAN --}}
        {{-- ============================================================ --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            
            {{-- HADIR --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-4 sm:p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Hadir</span>
                    <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $totalHadir }}</span>
                    <span class="text-xs text-emerald-600 font-semibold">Tepat Waktu</span>
                </div>
            </div>

            {{-- SAKIT --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-4 sm:p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Sakit</span>
                    <span class="w-8 h-8 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $totalSakit }}</span>
                    <span class="text-xs text-sky-600 font-semibold">Surat / Ket.</span>
                </div>
            </div>

            {{-- IZIN --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-4 sm:p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Izin</span>
                    <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $totalIzin }}</span>
                    <span class="text-xs text-amber-600 font-semibold">Izin Resmi</span>
                </div>
            </div>

            {{-- ALFA --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-4 sm:p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tanpa Ket. (Alfa)</span>
                    <span class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $totalAlfa }}</span>
                    <span class="text-xs text-rose-600 font-semibold">Tidak Hadir</span>
                </div>
            </div>

        </div>

        {{-- ============================================================ --}}
        {{-- FORM FILTER PERIODE & STATUS --}}
        {{-- ============================================================ --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
            <form method="GET" action="{{ route('siswa.riwayat') }}" class="flex flex-col sm:flex-row sm:items-end gap-3.5">
                
                {{-- Periode Bulan --}}
                <div class="flex-1">
                    <label for="bulan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Pilih Periode Bulan
                    </label>
                    <div class="relative">
                        <input type="month" id="bulan" name="bulan" value="{{ $selectedBulan }}"
                               class="w-full bg-slate-50 border border-slate-200/80 rounded-xl px-3.5 py-2.5 text-xs font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all font-mono">
                    </div>
                </div>

                {{-- Status --}}
                <div class="w-full sm:w-48">
                    <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Status Kehadiran
                    </label>
                    <select id="status" name="status"
                            class="w-full bg-slate-50 border border-slate-200/80 rounded-xl px-3.5 py-2.5 text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all">
                        <option value="">Semua Status</option>
                        <option value="hadir" {{ request('status') === 'hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="sakit" {{ request('status') === 'sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="izin" {{ request('status') === 'izin' ? 'selected' : '' }}>Izin</option>
                        <option value="alfa" {{ request('status') === 'alfa' ? 'selected' : '' }}>Alfa</option>
                    </select>
                </div>

                {{-- Tombol Submit & Reset --}}
                <div class="flex items-center gap-2 pt-1 sm:pt-0">
                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold bg-gradient-to-r from-sky-600 to-blue-700 text-white shadow-sm shadow-sky-600/20 hover:from-sky-500 hover:to-blue-600 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Terapkan Filter
                    </button>

                    @if(request()->hasAny(['bulan', 'status']))
                        <a href="{{ route('siswa.riwayat') }}"
                           class="inline-flex items-center justify-center px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">
                            Reset
                        </a>
                    @endif
                </div>

            </form>
        </div>

        {{-- ============================================================ --}}
        {{-- TABEL RIWAYAT ABSENSI --}}
        {{-- ============================================================ --}}
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            
            {{-- Header Tabel --}}
            <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <h3 class="font-bold text-sm text-slate-900">
                        Catatan Kehadiran — {{ \Carbon\Carbon::createFromFormat('Y-m', $selectedBulan)->translatedFormat('F Y') }}
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar riwayat scan QR dan status presensi harian</p>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-100">
                    Total: {{ $absensiList->total() }} Data
                </span>
            </div>

            {{-- Table Content --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50/80 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-100">
                            <th class="py-3 px-4 w-12 text-center">No</th>
                            <th class="py-3 px-4">Tanggal & Hari</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Waktu Scan</th>
                            <th class="py-3 px-4">Guru Pengampu / Piket</th>
                            <th class="py-3 px-4">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($absensiList as $index => $absensi)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-3.5 px-4 text-center text-slate-400 font-mono text-[11px]">
                                    {{ $absensiList->firstItem() + $index }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="font-bold text-slate-900">{{ $absensi->waktu_scan->format('d/m/Y') }}</div>
                                    <div class="text-[11px] text-slate-500">{{ $absensi->waktu_scan->translatedFormat('l') }}</div>
                                </td>
                                <td class="py-3.5 px-4">
                                    @php
                                        $badgeConfig = match($absensi->status) {
                                            'hadir' => ['bg' => 'bg-emerald-50 text-emerald-700 border-emerald-200/80', 'dot' => 'bg-emerald-500'],
                                            'sakit' => ['bg' => 'bg-sky-50 text-sky-700 border-sky-200/80', 'dot' => 'bg-sky-500'],
                                            'izin'  => ['bg' => 'bg-amber-50 text-amber-700 border-amber-200/80', 'dot' => 'bg-amber-500'],
                                            'alfa'  => ['bg' => 'bg-rose-50 text-rose-700 border-rose-200/80', 'dot' => 'bg-rose-500'],
                                            default => ['bg' => 'bg-slate-50 text-slate-700 border-slate-200/80', 'dot' => 'bg-slate-400'],
                                        };
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $badgeConfig['bg'] }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $badgeConfig['dot'] }}"></span>
                                        {{ strtoupper($absensi->status) }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 font-mono text-[11px] text-slate-600">
                                    {{ $absensi->waktu_scan->format('H:i') }} WIB
                                </td>
                                <td class="py-3.5 px-4 font-medium text-slate-800">
                                    {{ $absensi->guru->name ?? '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-slate-500">
                                    {{ $absensi->keterangan ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 px-4 text-center">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 mx-auto flex items-center justify-center mb-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-slate-700 text-sm">Tidak Ada Riwayat</h4>
                                    <p class="text-xs text-slate-400 mt-1">Belum ada catatan presensi pada periode yang dipilih.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($absensiList->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $absensiList->links() }}
                </div>
            @endif

        </div>

    </div>

</x-layouts.dashboard>
