{{--
    Halaman Kelola Data Absensi Admin PRESIS
--}}

<x-layouts.dashboard :title="'Data Absensi'" :role="'ADMIN'" :pageTitle="'Rekam Kehadiran Siswa'">

    <x-slot:sidebar>
        @include('components.sidebar-item', ['href' => '/admin/dashboard', 'label' => 'Dashboard'])
        @include('components.sidebar-item', ['href' => '/admin/siswa', 'label' => 'Data Siswa'])
        @include('components.sidebar-item', ['href' => '/admin/guru', 'label' => 'Data Guru'])
        @include('components.sidebar-item', ['href' => '/admin/absensi', 'label' => 'Data Absensi', 'active' => true])
        @include('components.sidebar-item', ['href' => '/admin/rekap', 'label' => 'Rekap Laporan'])
    </x-slot:sidebar>

    {{-- Filter & Tombol Tambah Manual --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm mb-6">
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
            <form method="GET" action="{{ route('admin.absensi.index') }}" class="flex flex-wrap items-end gap-3 flex-1">
                {{-- Tanggal --}}
                <div class="min-w-[150px]">
                    <label for="tanggal" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Tanggal
                    </label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ $selectedTanggal }}"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm font-medium text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-600 shadow-sm transition-all">
                </div>

                {{-- Kelas --}}
                <div class="min-w-[130px]">
                    <label for="kelas" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Kelas
                    </label>
                    <select id="kelas" name="kelas"
                            class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm font-medium text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-600 shadow-sm transition-all">
                        <option value="">Semua Kelas</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k }}" {{ $selectedKelas === $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Status --}}
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

                {{-- Pencarian --}}
                <div class="flex-1 min-w-[180px]">
                    <label for="search" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Cari Siswa
                    </label>
                    <input type="text" id="search" name="search" value="{{ $search }}" placeholder="Nama / NISN..."
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-600 shadow-sm transition-all">
                </div>

                {{-- Tombol Filter --}}
                <div class="flex items-center gap-2">
                    <button type="submit"
                            class="px-4 py-2 rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-semibold text-sm shadow-sm transition-all flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        <span>Filter</span>
                    </button>

                    @if($selectedTanggal || $selectedKelas || $selectedStatus || $search)
                        <a href="{{ route('admin.absensi.index') }}"
                           class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-sm transition-all">
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            <a href="{{ route('admin.absensi.create') }}"
               class="px-4 py-2 rounded-xl bg-gradient-to-r from-sky-600 to-blue-700 hover:from-sky-700 hover:to-blue-800 text-white font-bold text-sm shadow-sm shadow-sky-600/25 hover:shadow transition-all flex items-center justify-center gap-2 flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Input Manual</span>
            </a>
        </div>
    </div>

    {{-- Tabel Data Absensi --}}
    <div class="rounded-2xl bg-white border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-white">
            <h3 class="text-sm font-bold text-slate-900">Catatan Rekam Kehadiran</h3>
            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-100">
                Total: {{ $absensiList->total() }} Data
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50/80 text-xs font-semibold text-slate-500 uppercase tracking-wider border-b border-slate-200/80">
                    <tr>
                        <th class="px-5 py-3.5 w-12 text-center">No</th>
                        <th class="px-5 py-3.5">Nama Siswa</th>
                        <th class="px-5 py-3.5">NISN</th>
                        <th class="px-5 py-3.5">Kelas</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5">Waktu Scan</th>
                        <th class="px-5 py-3.5">Guru Validasi</th>
                        <th class="px-5 py-3.5">Keterangan</th>
                        <th class="px-5 py-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($absensiList as $index => $a)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-5 py-3.5 text-center text-xs text-slate-400 font-mono">
                                {{ $absensiList->firstItem() + $index }}
                            </td>
                            <td class="px-5 py-3.5 font-semibold text-slate-900 flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full bg-sky-100 text-sky-700 font-bold text-xs flex items-center justify-center flex-shrink-0">
                                    {{ strtoupper(substr($a->siswa->nama ?? 'S', 0, 1)) }}
                                </div>
                                <span>{{ $a->siswa->nama ?? '-' }}</span>
                            </td>
                            <td class="px-5 py-3.5 font-mono text-xs text-slate-600">{{ $a->nisn }}</td>
                            <td class="px-5 py-3.5">
                                <span class="px-2 py-0.5 rounded-md text-xs font-medium bg-slate-100 text-slate-700">
                                    {{ $a->siswa->kelas ?? '-' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                @php
                                    $statusConfig = match($a->status) {
                                        'hadir' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'dot' => 'bg-emerald-500'],
                                        'sakit' => ['bg' => 'bg-sky-50', 'text' => 'text-sky-700', 'border' => 'border-sky-200', 'dot' => 'bg-sky-500'],
                                        'izin'  => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'dot' => 'bg-amber-500'],
                                        'alfa'  => ['bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'border' => 'border-rose-200', 'dot' => 'bg-rose-500'],
                                        default => ['bg' => 'bg-slate-50', 'text' => 'text-slate-700', 'border' => 'border-slate-200', 'dot' => 'bg-slate-500'],
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold border {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} {{ $statusConfig['border'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>
                                    {{ ucfirst($a->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 font-mono text-xs text-slate-600">
                                {{ $a->waktu_scan->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-5 py-3.5 text-xs text-slate-600">
                                {{ $a->guru->name ?? '-' }}
                            </td>
                            <td class="px-5 py-3.5 text-xs text-slate-500">
                                {{ $a->keterangan ?? '-' }}
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('admin.absensi.edit', $a->id) }}" title="Ubah Status Absensi"
                                       class="p-1.5 rounded-lg text-amber-600 hover:bg-amber-50 border border-amber-200 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.absensi.destroy', $a->id) }}" method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan absensi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Data"
                                                class="p-1.5 rounded-lg text-rose-600 hover:bg-rose-50 border border-rose-200 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center text-slate-400">
                                <p class="font-semibold text-slate-500">Tidak ada data absensi ditemukan</p>
                                <p class="text-xs text-slate-400 mt-0.5">Silakan sesuaikan tanggal atau filter yang digunakan</p>
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
