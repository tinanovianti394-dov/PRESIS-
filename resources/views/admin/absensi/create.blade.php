{{--
    Form Input Absensi Manual Admin PRESIS
--}}

<x-layouts.dashboard :title="'Input Absensi Manual'" :role="'ADMIN'" :pageTitle="'Input Presensi Manual'">

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
                    <h2 class="text-base font-bold text-slate-900">Input Presensi Manual</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Catat kehadiran, sakit, izin, atau alfa untuk siswa</p>
                </div>
                <a href="{{ route('admin.absensi.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center gap-1 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Kembali</span>
                </a>
            </div>

            @if($errors->any())
                <div class="mb-5 p-4 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-800">
                    <p class="font-bold mb-1">Terdapat kesalahan input:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.absensi.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="nisn" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Pilih Siswa <span class="text-rose-500">*</span>
                    </label>
                    <select id="nisn" name="nisn" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-medium text-slate-800 bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-600 shadow-sm transition-all">
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($siswaList as $s)
                            <option value="{{ $s->nisn }}" {{ old('nisn') === $s->nisn ? 'selected' : '' }}>
                                {{ $s->nisn }} — {{ $s->nama }} ({{ $s->kelas }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="id_user" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Guru / Petugas Validasi <span class="text-rose-500">*</span>
                    </label>
                    <select id="id_user" name="id_user" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-medium text-slate-800 bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-600 shadow-sm transition-all">
                        <option value="">-- Pilih Guru --</option>
                        @foreach($guruList as $g)
                            <option value="{{ $g->id }}" {{ old('id_user') == $g->id ? 'selected' : '' }}>
                                {{ $g->name }} ({{ $g->nip ?? 'NIP -' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Status Presensi <span class="text-rose-500">*</span>
                        </label>
                        <select id="status" name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-medium text-slate-800 bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-600 shadow-sm transition-all">
                            <option value="sakit" {{ old('status') === 'sakit' ? 'selected' : '' }}>Sakit (Surat Dokter)</option>
                            <option value="izin" {{ old('status') === 'izin' ? 'selected' : '' }}>Izin (Keluarga/Orang Tua)</option>
                            <option value="hadir" {{ old('status') === 'hadir' ? 'selected' : '' }}>Hadir Manual</option>
                            <option value="alfa" {{ old('status') === 'alfa' ? 'selected' : '' }}>Alfa (Tanpa Keterangan)</option>
                        </select>
                    </div>

                    <div>
                        <label for="waktu_scan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Waktu & Tanggal <span class="text-rose-500">*</span>
                        </label>
                        <input type="datetime-local" id="waktu_scan" name="waktu_scan" value="{{ old('waktu_scan', now()->format('Y-m-d\TH:i')) }}" required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 font-mono text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-600 shadow-sm transition-all">
                    </div>
                </div>

                <div>
                    <label for="keterangan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Keterangan Tambahan
                    </label>
                    <textarea id="keterangan" name="keterangan" rows="3" placeholder="Contoh: Sakit demam berdarah, izin keperluan keluarga..."
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-600 shadow-sm transition-all">{{ old('keterangan') }}</textarea>
                </div>

                <div class="pt-5 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.absensi.index') }}"
                       class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-sm transition-all">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-sky-600 to-blue-700 hover:from-sky-700 hover:to-blue-800 text-white font-bold text-sm shadow-sm shadow-sky-600/25 transition-all">
                        Simpan Presensi
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-layouts.dashboard>
