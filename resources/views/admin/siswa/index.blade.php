{{--
    Halaman Kelola Data Siswa Admin PRESIS
    Tampilan modern & profesional dengan pencarian, filter kelas, dan aksi lengkap.
--}}

<x-layouts.dashboard :title="'Data Siswa'" :role="'ADMIN'" :pageTitle="'Data Siswa SMKN 3 Bengkalis'">

    <x-slot:sidebar>
        @include('components.sidebar-item', ['href' => '/admin/dashboard', 'label' => 'Dashboard'])
        @include('components.sidebar-item', ['href' => '/admin/siswa', 'label' => 'Data Siswa', 'active' => true])
        @include('components.sidebar-item', ['href' => '/admin/guru', 'label' => 'Data Guru'])
        @include('components.sidebar-item', ['href' => '/admin/absensi', 'label' => 'Data Absensi'])
        @include('components.sidebar-item', ['href' => '/admin/rekap', 'label' => 'Rekap Laporan'])
    </x-slot:sidebar>

    {{-- Header Tindakan & Filter --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <form method="GET" action="{{ route('admin.siswa.index') }}" class="flex flex-wrap items-center gap-3 flex-1">
                {{-- Input Pencarian --}}
                <div class="relative flex-1 min-w-[220px]">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" id="search" name="search" value="{{ $search }}" placeholder="Cari nama, NISN, atau no HP..."
                           class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-300 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-600 shadow-sm transition-all">
                </div>

                {{-- Filter Kelas --}}
                <div class="min-w-[140px]">
                    <select id="kelas" name="kelas"
                            class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm font-medium text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-600 shadow-sm transition-all">
                        <option value="">Semua Kelas</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k }}" {{ $kelas === $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Tombol Filter --}}
                <button type="submit"
                        class="px-4 py-2 rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-semibold text-sm shadow-sm transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    <span>Filter</span>
                </button>

                @if($search || $kelas)
                    <a href="{{ route('admin.siswa.index') }}"
                       class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-sm transition-all">
                        Reset
                    </a>
                @endif
            </form>

            <a href="{{ route('admin.siswa.create') }}"
               class="px-4 py-2 rounded-xl bg-gradient-to-r from-sky-600 to-blue-700 hover:from-sky-700 hover:to-blue-800 text-white font-bold text-sm shadow-sm shadow-sky-600/25 hover:shadow transition-all flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Tambah Siswa</span>
            </a>
        </div>
    </div>

    {{-- Tabel Data Siswa --}}
    <div class="rounded-2xl bg-white border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-white">
            <h3 class="text-sm font-bold text-slate-900">Daftar Siswa Terdaftar</h3>
            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-100">
                Total: {{ $siswaList->total() }} Siswa
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
                        <th class="px-5 py-3.5">No. HP Orang Tua</th>
                        <th class="px-5 py-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($siswaList as $index => $s)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-5 py-3.5 text-center text-xs text-slate-400 font-mono">
                                {{ $siswaList->firstItem() + $index }}
                            </td>
                            <td class="px-5 py-3.5 font-mono text-xs font-semibold text-slate-900">
                                {{ $s->nisn }}
                            </td>
                            <td class="px-5 py-3.5 font-semibold text-slate-900 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-sky-400 to-blue-600 text-white font-bold text-xs flex items-center justify-center shadow-sm flex-shrink-0">
                                    {{ strtoupper(substr($s->nama, 0, 1)) }}
                                </div>
                                <span>{{ $s->nama }}</span>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200/60">
                                    {{ $s->kelas }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 font-mono text-xs text-slate-600">
                                @if($s->no_hp_orangtua)
                                    <span class="inline-flex items-center gap-1.5 text-slate-700">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        {{ $s->no_hp_orangtua }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic">Belum diisi</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('admin.siswa.qrcode', $s->id) }}" title="Lihat Kartu QR Code"
                                       class="p-1.5 rounded-lg text-sky-600 hover:bg-sky-50 border border-sky-200 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.siswa.edit', $s->id) }}" title="Edit Data Siswa"
                                       class="p-1.5 rounded-lg text-amber-600 hover:bg-amber-50 border border-amber-200 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.siswa.destroy', $s->id) }}" method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa {{ $s->nama }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Siswa"
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
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <p class="font-semibold text-slate-500">Tidak ada data siswa ditemukan</p>
                                <p class="text-xs text-slate-400 mt-0.5">Coba ubah kata kunci pencarian atau filter kelas</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($siswaList->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                {{ $siswaList->links() }}
            </div>
        @endif
    </div>

</x-layouts.dashboard>
