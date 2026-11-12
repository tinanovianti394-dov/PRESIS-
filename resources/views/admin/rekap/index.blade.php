{{--
    Halaman Rekapitulasi Laporan Presensi Admin PRESIS
--}}

<x-layouts.dashboard :title="'Rekap Laporan'" :role="'ADMIN'" :pageTitle="'Rekapitulasi Laporan Presensi'">

    <x-slot:sidebar>
        @include('components.sidebar-item', ['href' => '/admin/dashboard', 'label' => 'Dashboard'])
        @include('components.sidebar-item', ['href' => '/admin/siswa', 'label' => 'Data Siswa'])
        @include('components.sidebar-item', ['href' => '/admin/guru', 'label' => 'Data Guru'])
        @include('components.sidebar-item', ['href' => '/admin/absensi', 'label' => 'Data Absensi'])
        @include('components.sidebar-item', ['href' => '/admin/rekap', 'label' => 'Rekap Laporan', 'active' => true])
    </x-slot:sidebar>

    {{-- Filter Periode dan Kelas --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm mb-6">
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
            <form method="GET" action="{{ route('admin.rekap.index') }}" class="flex flex-wrap items-end gap-3 flex-1">
                <div>
                    <label for="start_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Dari Tanggal
                    </label>
                    <input type="date" id="start_date" name="start_date" value="{{ $startDate }}"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm font-medium text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-600 shadow-sm transition-all">
                </div>

                <div>
                    <label for="end_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Sampai Tanggal
                    </label>
                    <input type="date" id="end_date" name="end_date" value="{{ $endDate }}"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm font-medium text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-600 shadow-sm transition-all">
                </div>

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

                <button type="submit"
                        class="px-4 py-2 rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-semibold text-sm shadow-sm transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    <span>Filter Laporan</span>
                </button>
            </form>

            <div class="flex items-center gap-2 flex-shrink-0">
                <button onclick="window.print()"
                        class="px-4 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-700 font-semibold text-sm border border-slate-300 shadow-sm transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    <span>Cetak</span>
                </button>

                <a href="{{ route('admin.rekap.exportPdf', ['start_date' => $startDate, 'end_date' => $endDate, 'kelas' => $selectedKelas]) }}"
                   class="px-4 py-2 rounded-xl bg-gradient-to-r from-rose-600 to-red-700 hover:from-rose-700 hover:to-red-800 text-white font-bold text-sm shadow-sm shadow-rose-600/25 transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Export PDF</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Ringkasan Akumulasi Periode --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <div class="p-4 rounded-xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Hadir</span>
                <p class="text-2xl font-extrabold text-emerald-600 mt-0.5">{{ $totalHadirGlobal }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">✓</div>
        </div>

        <div class="p-4 rounded-xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Sakit</span>
                <p class="text-2xl font-extrabold text-sky-600 mt-0.5">{{ $totalSakitGlobal }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold">✚</div>
        </div>

        <div class="p-4 rounded-xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Izin</span>
                <p class="text-2xl font-extrabold text-amber-600 mt-0.5">{{ $totalIzinGlobal }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">✉</div>
        </div>

        <div class="p-4 rounded-xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Alfa</span>
                <p class="text-2xl font-extrabold text-rose-600 mt-0.5">{{ $totalAlfaGlobal }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold">✕</div>
        </div>
    </div>

    {{-- Dokumen Laporan Rekapitulasi --}}
    <div id="printReportArea" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
        {{-- Header Laporan --}}
        <div class="border-b border-slate-200 pb-5 mb-6 text-center">
            <h1 class="text-lg font-extrabold text-slate-900 uppercase tracking-tight">LAPORAN REKAPITULASI PRESENSI SISWA</h1>
            <h2 class="text-sm font-bold text-sky-700 mt-0.5">SMK NEGERI 3 BENGKALIS</h2>
            <p class="text-xs text-slate-500 mt-1 font-medium">
                Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
                @if($selectedKelas)
                    · Kelas: <span class="font-bold text-slate-700">{{ $selectedKelas }}</span>
                @endif
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50/80 text-xs font-semibold text-slate-500 uppercase tracking-wider border-b border-slate-200/80">
                    <tr>
                        <th class="px-4 py-3 text-center w-12">No</th>
                        <th class="px-4 py-3">NISN</th>
                        <th class="px-4 py-3">Nama Lengkap Siswa</th>
                        <th class="px-4 py-3">Kelas</th>
                        <th class="px-4 py-3 text-center bg-emerald-50/50 text-emerald-800">Hadir</th>
                        <th class="px-4 py-3 text-center bg-sky-50/50 text-sky-800">Sakit</th>
                        <th class="px-4 py-3 text-center bg-amber-50/50 text-amber-800">Izin</th>
                        <th class="px-4 py-3 text-center bg-rose-50/50 text-rose-800">Alfa</th>
                        <th class="px-4 py-3 text-center">% Kehadiran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($laporan as $index => $row)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-4 py-3 text-center text-xs text-slate-400 font-mono">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 font-mono text-xs font-semibold text-slate-800">{{ $row['nisn'] }}</td>
                            <td class="px-4 py-3 font-semibold text-slate-900">{{ $row['nama'] }}</td>
                            <td class="px-4 py-3 text-xs text-slate-600">{{ $row['kelas'] }}</td>
                            <td class="px-4 py-3 text-center font-bold font-mono text-emerald-700 bg-emerald-50/20">{{ $row['hadir'] }}</td>
                            <td class="px-4 py-3 text-center font-bold font-mono text-sky-700 bg-sky-50/20">{{ $row['sakit'] }}</td>
                            <td class="px-4 py-3 text-center font-bold font-mono text-amber-700 bg-amber-50/20">{{ $row['izin'] }}</td>
                            <td class="px-4 py-3 text-center font-bold font-mono text-rose-700 bg-rose-50/20">{{ $row['alfa'] }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold {{ $row['persen'] >= 75 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                    {{ $row['persen'] }}%
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center text-slate-400">
                                <p class="font-semibold text-slate-500">Tidak ada data rekapitulasi pada periode ini</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Tanda Tangan Cetak --}}
        <div class="mt-12 pt-6 hidden print:flex justify-between text-xs text-slate-700">
            <div>
                <p>Mengetahui,</p>
                <p class="font-bold">Kepala SMKN 3 Bengkalis</p>
                <div class="h-20"></div>
                <p class="font-bold underline">Kusno, S.Pd, M.Pd</p>
                <p class="font-mono text-[10px] text-slate-500">NIP. 197001011995031002</p>
            </div>
            <div>
                <p>Bengkalis, {{ now()->translatedFormat('d F Y') }}</p>
                <p class="font-bold">Petugas Administrator PRESIS</p>
                <div class="h-20"></div>
                <p class="font-bold underline">{{ Auth::user()->name }}</p>
                <p class="font-mono text-[10px] text-slate-500">Administrator Sistem</p>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        @media print {
            body * { visibility: hidden; }
            #printReportArea, #printReportArea * { visibility: visible; }
            #printReportArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
            }
        }
    </style>
    @endpush

</x-layouts.dashboard>
