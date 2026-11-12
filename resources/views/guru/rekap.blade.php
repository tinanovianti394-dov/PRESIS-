{{--
    Halaman Rekap Harian Guru PRESIS
    Menampilkan rekapitulasi kehadiran per kelas pada tanggal tertentu.
--}}

<x-layouts.dashboard :title="'Rekap Harian'" :role="'GURU'" :pageTitle="'Rekapitulasi Harian Kehadiran'">

    {{-- Sidebar Menu Guru --}}
    <x-slot:sidebar>
        @include('components.sidebar-item', ['href' => '/guru/dashboard', 'label' => 'Dashboard'])
        @include('components.sidebar-item', ['href' => '/guru/scanner', 'label' => 'Scan QR Code'])
        @include('components.sidebar-item', ['href' => '/guru/absensi', 'label' => 'Data Absensi'])
        @include('components.sidebar-item', ['href' => '/guru/rekap', 'label' => 'Rekap Harian', 'active' => true])
    </x-slot:sidebar>

    {{-- ============================================================ --}}
    {{-- FILTER TANGGAL & AKSI CETAK --}}
    {{-- ============================================================ --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm mb-6 flex flex-wrap items-center justify-between gap-4">
        <form method="GET" action="{{ route('guru.rekap') }}" class="flex flex-wrap items-end gap-3">
            <div>
                <label for="tanggal" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Pilih Tanggal Rekap
                </label>
                <input type="date" id="tanggal" name="tanggal" value="{{ $selectedTanggal }}"
                       class="px-3.5 py-2 rounded-xl border border-slate-300 text-sm font-medium text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-600 shadow-sm transition-all">
            </div>

            <button type="submit"
                    class="px-4 py-2 rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-semibold text-sm shadow-sm transition-all flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <span>Tampilkan Rekap</span>
            </button>
        </form>

        <div class="flex items-center gap-2">
            <button onclick="window.print()"
                    class="px-4 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-700 font-semibold text-sm border border-slate-300 shadow-sm transition-all flex items-center gap-1.5">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                <span>Cetak</span>
            </button>

            <a href="{{ route('guru.rekap.exportPdf', ['tanggal' => $selectedTanggal]) }}"
               class="px-4 py-2 rounded-xl bg-gradient-to-r from-rose-600 to-red-700 hover:from-rose-700 hover:to-red-800 text-white font-bold text-sm shadow-sm shadow-rose-600/25 transition-all flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Export PDF</span>
            </a>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- TABEL REKAPITULASI KELAS --}}
    {{-- ============================================================ --}}
    <div class="rounded-2xl bg-white border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-white">
            <div>
                <h3 class="text-sm font-bold text-slate-900">
                    Rekapitulasi Kehadiran Per Kelas ({{ \Carbon\Carbon::parse($selectedTanggal)->translatedFormat('l, d F Y') }})
                </h3>
                <p class="text-xs text-slate-500">Ringkasan status kehadiran seluruh rombel</p>
            </div>
            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-100">
                PRESIS SMKN 3 Bengkalis
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50/80 text-xs font-semibold text-slate-500 uppercase tracking-wider border-b border-slate-200/80">
                    <tr>
                        <th class="px-4 py-3.5 text-center w-12">No</th>
                        <th class="px-4 py-3.5">Kelas</th>
                        <th class="px-4 py-3.5 text-center">Total Siswa</th>
                        <th class="px-4 py-3.5 text-center bg-emerald-50/50 text-emerald-800">Hadir</th>
                        <th class="px-4 py-3.5 text-center bg-sky-50/50 text-sky-800">Sakit</th>
                        <th class="px-4 py-3.5 text-center bg-amber-50/50 text-amber-800">Izin</th>
                        <th class="px-4 py-3.5 text-center bg-rose-50/50 text-rose-800">Alfa</th>
                        <th class="px-4 py-3.5 text-center bg-slate-100/70 text-slate-600">Belum Scan</th>
                        <th class="px-4 py-3.5 text-center">% Kehadiran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php
                        $sumTotal = 0; $sumHadir = 0; $sumSakit = 0; $sumIzin = 0; $sumAlfa = 0; $sumBelum = 0;
                    @endphp
                    @forelse($rekapData as $index => $row)
                        @php
                            $sumTotal += $row['total_siswa'];
                            $sumHadir += $row['hadir'];
                            $sumSakit += $row['sakit'];
                            $sumIzin  += $row['izin'];
                            $sumAlfa  += $row['alfa'];
                            $sumBelum += $row['belum_scan'];
                        @endphp
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-4 py-3 text-center text-xs text-slate-400 font-mono">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 font-bold text-slate-900">{{ $row['kelas'] }}</td>
                            <td class="px-4 py-3 text-center font-bold font-mono text-slate-700">{{ $row['total_siswa'] }}</td>
                            <td class="px-4 py-3 text-center font-bold font-mono text-emerald-700 bg-emerald-50/20">{{ $row['hadir'] }}</td>
                            <td class="px-4 py-3 text-center font-bold font-mono text-sky-700 bg-sky-50/20">{{ $row['sakit'] }}</td>
                            <td class="px-4 py-3 text-center font-bold font-mono text-amber-700 bg-amber-50/20">{{ $row['izin'] }}</td>
                            <td class="px-4 py-3 text-center font-bold font-mono text-rose-700 bg-rose-50/20">{{ $row['alfa'] }}</td>
                            <td class="px-4 py-3 text-center font-mono text-slate-400 bg-slate-50/40">{{ $row['belum_scan'] }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold {{ $row['persen'] >= 75 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                    {{ $row['persen'] }}%
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center text-slate-400">
                                <p class="font-semibold text-slate-500">Belum ada data kelas yang terdaftar</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if(count($rekapData) > 0)
                    <tfoot>
                        <tr class="border-t-2 border-slate-200 bg-slate-50/80 font-bold text-slate-800">
                            <td colspan="2" class="px-4 py-3 text-right uppercase text-xs tracking-wider">Total Keseluruhan:</td>
                            <td class="px-4 py-3 text-center font-mono">{{ $sumTotal }}</td>
                            <td class="px-4 py-3 text-center font-mono text-emerald-700">{{ $sumHadir }}</td>
                            <td class="px-4 py-3 text-center font-mono text-sky-700">{{ $sumSakit }}</td>
                            <td class="px-4 py-3 text-center font-mono text-amber-700">{{ $sumIzin }}</td>
                            <td class="px-4 py-3 text-center font-mono text-rose-700">{{ $sumAlfa }}</td>
                            <td class="px-4 py-3 text-center font-mono text-slate-400">{{ $sumBelum }}</td>
                            <td class="px-4 py-3 text-center font-mono text-sky-700">
                                {{ $sumTotal > 0 ? round(($sumHadir / $sumTotal) * 100, 1) : 0 }}%
                            </td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>

</x-layouts.dashboard>
