{{--
    Form Edit Status Absensi Admin PRESIS
--}}

<x-layouts.dashboard :title="'Ubah Status Absensi'" :role="'ADMIN'" :pageTitle="'Koreksi Status Presensi'">

    <x-slot:sidebar>
        @include('components.sidebar-item', ['href' => '/admin/dashboard', 'label' => 'Dashboard'])
        @include('components.sidebar-item', ['href' => '/admin/siswa', 'label' => 'Data Siswa'])
        @include('components.sidebar-item', ['href' => '/admin/guru', 'label' => 'Data Guru'])
        @include('components.sidebar-item', ['href' => '/admin/absensi', 'label' => 'Data Absensi', 'active' => true])
        @include('components.sidebar-item', ['href' => '/admin/rekap', 'label' => 'Rekap Laporan'])
    </x-slot:sidebar>

    <div class="max-w-xl mx-auto">
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
            <div class="border-b border-slate-100 pb-4 mb-6 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Koreksi Data Presensi</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Ubah status kehadiran atau catatan keterangan</p>
                </div>
                <a href="{{ route('admin.absensi.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center gap-1 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Kembali</span>
                </a>
            </div>

            {{-- Ringkasan Siswa --}}
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80 mb-5 text-xs space-y-1.5">
                <div class="flex items-center justify-between">
                    <span class="text-slate-500 font-medium">Nama Siswa:</span>
                    <span class="font-bold text-slate-900">{{ $absensi->siswa->nama ?? '-' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-500 font-medium">NISN / Kelas:</span>
                    <span class="font-mono text-slate-700 font-semibold">{{ $absensi->nisn }} ({{ $absensi->siswa->kelas ?? '-' }})</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-500 font-medium">Waktu Rekam:</span>
                    <span class="font-mono text-slate-600">{{ $absensi->waktu_scan->format('d/m/Y H:i:s') }} WIB</span>
                </div>
            </div>

            <form action="{{ route('admin.absensi.update', $absensi->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Status Presensi <span class="text-rose-500">*</span>
                    </label>
                    <select id="status" name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-medium text-slate-800 bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-600 shadow-sm transition-all">
                        <option value="hadir" {{ old('status', $absensi->status) === 'hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="sakit" {{ old('status', $absensi->status) === 'sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="izin" {{ old('status', $absensi->status) === 'izin' ? 'selected' : '' }}>Izin</option>
                        <option value="alfa" {{ old('status', $absensi->status) === 'alfa' ? 'selected' : '' }}>Alfa</option>
                    </select>
                </div>

                <div>
                    <label for="keterangan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Keterangan Tambahan / Alasan Koreksi
                    </label>
                    <textarea id="keterangan" name="keterangan" rows="3" placeholder="Alasan perubahan atau keterangan surat..."
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-600 shadow-sm transition-all">{{ old('keterangan', $absensi->keterangan) }}</textarea>
                </div>

                <div class="pt-5 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.absensi.index') }}"
                       class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-sm transition-all">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-sky-600 to-blue-700 hover:from-sky-700 hover:to-blue-800 text-white font-bold text-sm shadow-sm shadow-sky-600/25 transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-layouts.dashboard>
