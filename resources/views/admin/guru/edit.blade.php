{{--
    Form Edit Guru Admin PRESIS
--}}

<x-layouts.dashboard :title="'Edit Guru'" :role="'ADMIN'" :pageTitle="'Edit Data Guru'">

    <x-slot:sidebar>
        @include('components.sidebar-item', ['href' => '/admin/dashboard', 'label' => 'Dashboard'])
        @include('components.sidebar-item', ['href' => '/admin/siswa', 'label' => 'Data Siswa'])
        @include('components.sidebar-item', ['href' => '/admin/guru', 'label' => 'Data Guru', 'active' => true])
        @include('components.sidebar-item', ['href' => '/admin/absensi', 'label' => 'Data Absensi'])
        @include('components.sidebar-item', ['href' => '/admin/rekap', 'label' => 'Rekap Laporan'])
    </x-slot:sidebar>

    <div class="max-w-xl mx-auto">
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
            <div class="border-b border-slate-100 pb-4 mb-6 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Perbarui Data Guru</h2>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $guru->name }}</p>
                </div>
                <a href="{{ route('admin.guru.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center gap-1 transition-colors">
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

            <form action="{{ route('admin.guru.update', $guru->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="nip" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        NIP (18 Digit) <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="nip" name="nip" value="{{ old('nip', $guru->nip) }}" required maxlength="18"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 font-mono text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-600 shadow-sm transition-all">
                </div>

                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Nama Lengkap & Gelar <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $guru->name) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-600 shadow-sm transition-all">
                </div>

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Alamat Email <span class="text-rose-500">*</span>
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email', $guru->email) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-600 shadow-sm transition-all">
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Ganti Password Baru (Opsional)
                    </label>
                    <input type="password" id="password" name="password" placeholder="Biarkan kosong jika tidak diubah..."
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-600 shadow-sm transition-all">
                </div>

                <div class="pt-5 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.guru.index') }}"
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
