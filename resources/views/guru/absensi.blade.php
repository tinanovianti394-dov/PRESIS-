{{--
    Halaman Data Absensi Guru PRESIS
    Menampilkan data absensi harian dengan filter tanggal, kelas, dan status.
--}}

<x-layouts.dashboard :title="'Data Absensi'" :role="'GURU'" :pageTitle="'Data Rekam Kehadiran Siswa'">

    {{-- Sidebar Menu Guru --}}
    <x-slot:sidebar>
        @include('components.sidebar-item', ['href' => '/guru/dashboard', 'label' => 'Dashboard'])
        @include('components.sidebar-item', ['href' => '/guru/scanner', 'label' => 'Scan QR Code'])
        @include('components.sidebar-item', ['href' => '/guru/absensi', 'label' => 'Data Absensi', 'active' => true])
        @include('components.sidebar-item', ['href' => '/guru/rekap', 'label' => 'Rekap Harian'])
    </x-slot:sidebar>

    {{-- ============================================================ --}}
    {{-- STATISTIK TANGGAL TERPILIH --}}
    {{-- ============================================================ --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <div class="p-4 rounded-xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Hadir</span>
                <p class="text-2xl font-extrabold text-emerald-600 mt-0.5">{{ $totalHadir }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">✓</div>
        </div>

        <div class="p-4 rounded-xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Sakit</span>
                <p class="text-2xl font-extrabold text-sky-600 mt-0.5">{{ $totalSakit }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold">✚</div>
        </div>

        <div class="p-4 rounded-xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Izin</span>
                <p class="text-2xl font-extrabold text-amber-600 mt-0.5">{{ $totalIzin }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">✉</div>
        </div>

        <div class="p-4 rounded-xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Alfa</span>
                <p class="text-2xl font-extrabold text-rose-600 mt-0.5">{{ $totalAlfa }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold">✕</div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- FILTER FORM --}}
    {{-- ============================================================ --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm mb-6">
        <form method="GET" action="{{ route('guru.absensi') }}" class="flex flex-wrap items-end gap-3">
            <div>
                <label for="tanggal" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Tanggal
                </label>
                <input type="date" id="tanggal" name="tanggal" value="{{ $selectedTanggal }}"
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm font-medium text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-600 shadow-sm transition-all">
            </div>

            <div class="min-w-[130px]">
                <label for="kelas" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Kelas
                </label>
                <select id="kelas" name="kelas"
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm font-medium text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-600 shadow-sm transition-all">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas }}" {{ $selectedKelas === $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                    @endforeach
                </select>
            </div>

            <div class="min-w-[130px]">
                <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Status
                </label>
                <select id="status" name="status"
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm font-medium text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-600 shadow-sm transition-all">
                    <option value="">Semua Status</option>
                    <option value="hadir" {{ $selectedStatus === 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="sakit" {{ $selectedStatus === 'sakit' ? 'selected' : '' }}>Sakit</option>
                    <option value="izin" {{ $selectedStatus === 'izin' ? 'selected' : '' }}>Izin</option>
                    <option value="alfa" {{ $selectedStatus === 'alfa' ? 'selected' : '' }}>Alfa</option>
                </select>
            </div>

            <button type="submit"
                    class="px-4 py-2 rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-semibold text-sm shadow-sm transition-all flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <span>Filter</span>
            </button>

            @if(request()->hasAny(['tanggal', 'kelas', 'status']) && ($selectedTanggal !== date('Y-m-d') || $selectedKelas || $selectedStatus))
                <a href="{{ route('guru.absensi') }}"
                   class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-sm transition-all">
                    Hari Ini
                </a>
            @endif
        </form>
    </div>

    {{-- ============================================================ --}}
    {{-- TABEL DATA ABSENSI --}}
    {{-- ============================================================ --}}
    <div class="rounded-2xl bg-white border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-white">
            <div>
                <h3 class="text-sm font-bold text-slate-900">
                    Daftar Absensi ({{ \Carbon\Carbon::parse($selectedTanggal)->translatedFormat('l, d F Y') }})
                </h3>
                <p class="text-xs text-slate-500">Rekam presensi siswa untuk tanggal terpilih</p>
            </div>
            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-100">
                Total: {{ $absensiList->total() }} Data
            </span>
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
                        <th class="px-5 py-3.5">Guru Validasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($absensiList as $index => $absensi)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-5 py-3.5 text-center text-xs text-slate-400 font-mono">
                                {{ $absensiList->firstItem() + $index }}
                            </td>
                            <td class="px-5 py-3.5 font-mono text-xs font-semibold text-slate-700">{{ $absensi->nisn }}</td>
                            <td class="px-5 py-3.5 font-semibold text-slate-900 flex items-center gap-2.5">
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
                            <td class="px-5 py-3.5 font-mono text-xs text-slate-600">
                                {{ $absensi->waktu_scan->format('H:i:s') }} WIB
                            </td>
                            <td class="px-5 py-3.5 text-xs text-slate-600">
                                {{ $absensi->guru->name ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                                <p class="font-semibold text-slate-500">Belum ada data absensi untuk filter yang dipilih</p>
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

</x-layouts.dashboard>
