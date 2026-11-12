{{--
    Halaman Kartu QR Code Siswa PRESIS
    Desain Modern Clean SaaS & Enterprise Identity Card untuk SMKN 3 Bengkalis
    Menampilkan QR Code dinamis terenkripsi AES-128-CBC dengan proteksi anti-cloning & expiry countdown.
--}}

<x-layouts.dashboard :title="'QR Code Presensi'" :role="'SISWA'" :pageTitle="'KARTU PRESENSI DIGITAL'">

    {{-- Sidebar Menu Siswa --}}
    <x-slot:sidebar>
        @include('components.sidebar-item', ['href' => '/siswa/portal', 'label' => 'PORTAL'])
        @include('components.sidebar-item', ['href' => '/siswa/qrcode', 'label' => 'QR CODE SAYA'])
        @include('components.sidebar-item', ['href' => '/siswa/riwayat', 'label' => 'RIWAYAT ABSENSI'])
    </x-slot:sidebar>

    <div class="max-w-3xl mx-auto space-y-6">

        {{-- ============================================================ --}}
        {{-- KARTU PRESENSI DIGITAL SISWA (ID CARD) --}}
        {{-- ============================================================ --}}
        <div id="printArea" class="bg-white rounded-3xl border border-slate-200/80 shadow-lg shadow-slate-200/40 overflow-hidden">
            
            {{-- Header Kartu Bernuansa SMKN 3 Bengkalis --}}
            <div class="bg-gradient-to-r from-sky-600 via-blue-700 to-indigo-800 p-6 sm:p-7 text-white relative overflow-hidden">
                {{-- Aksen Dekoratif Lingkaran Halus --}}
                <div class="absolute -right-10 -top-10 w-44 h-44 rounded-full bg-white/10 blur-xl pointer-events-none"></div>
                <div class="absolute right-32 -bottom-12 w-32 h-32 rounded-full bg-sky-400/20 blur-lg pointer-events-none"></div>

                <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-14 h-14 rounded-2xl bg-white p-1.5 shadow-md flex-shrink-0 flex items-center justify-center">
                            <img src="{{ asset('images/logo-smkn3.jpg') }}" alt="Logo SMKN 3 Bengkalis" class="w-full h-full object-cover rounded-xl">
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-sky-200 uppercase tracking-widest block">KARTU PRESENSI DIGITAL</span>
                            <h2 class="text-lg sm:text-xl font-extrabold tracking-tight text-white leading-tight">SMK NEGERI 3 BENGKALIS</h2>
                            <p class="text-xs text-sky-100 font-medium">Sistem Presensi Siswa Terenkripsi (PRESIS)</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 self-start sm:self-center">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-white/15 backdrop-blur-md text-sky-100 border border-white/20 shadow-sm">
                            <svg class="w-3.5 h-3.5 text-sky-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            AES-128-CBC
                        </span>
                    </div>
                </div>
            </div>

            {{-- Body: QR Code & Identitas Siswa --}}
            <div class="p-6 sm:p-8">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
                    
                    {{-- Sisi Kiri: Box QR Code & Countdown --}}
                    <div class="md:col-span-5 flex flex-col items-center justify-center">
                        <div class="relative w-full max-w-[240px] p-4 bg-slate-50/80 rounded-2xl border border-slate-200/80 shadow-inner text-center">
                            
                            {{-- Wadah QR Code SVG --}}
                            <div id="qrCodeContainer" class="p-3 bg-white rounded-xl shadow-sm border border-slate-100 transition-all duration-300 flex items-center justify-center">
                                {!! $qrCodeSvg !!}
                            </div>

                            {{-- Overlay saat QR Code Kadaluarsa --}}
                            <div id="qrExpiredOverlay" class="hidden absolute inset-0 bg-slate-900/85 backdrop-blur-sm rounded-2xl flex flex-col items-center justify-center p-4 text-center text-white z-20">
                                <div class="w-12 h-12 rounded-full bg-rose-500/20 text-rose-400 flex items-center justify-center mb-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-sm text-white">Token Kadaluarsa</h4>
                                <p class="text-[11px] text-slate-300 mt-1 mb-3 leading-snug">Masa berlaku QR habis untuk mencegah duplikasi & titip absen.</p>
                                <a href="{{ route('siswa.qrcode') }}"
                                   class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-sky-500 hover:bg-sky-600 text-white shadow-md shadow-sky-500/30 transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Perbarui QR
                                </a>
                            </div>

                            {{-- Indikator Countdown Masa Berlaku Dinamis --}}
                            @if(isset($expirySeconds) && $expirySeconds > 0)
                                <div class="mt-4 w-full">
                                    <div class="flex items-center justify-between text-xs font-semibold mb-1.5">
                                        <span class="text-slate-500 text-[11px]">Masa Berlaku</span>
                                        <span id="timerBadge" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-bold font-mono bg-sky-100 text-sky-700">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span id="countdownText">--:--</span>
                                        </span>
                                    </div>
                                    <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                                        <div id="progressBar" class="bg-gradient-to-r from-sky-500 to-blue-600 h-full rounded-full transition-all duration-1000 ease-linear" style="width: 100%;"></div>
                                    </div>
                                </div>
                            @else
                                <p class="text-[11px] font-semibold text-slate-400 mt-3 tracking-wide">TUNJUKKAN KE SCANNER GURU</p>
                            @endif
                        </div>
                    </div>

                    {{-- Sisi Kanan: Data Profil Siswa --}}
                    <div class="md:col-span-7 space-y-4">
                        <div class="p-4 rounded-2xl bg-gradient-to-br from-slate-50 to-sky-50/40 border border-slate-200/80">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-sky-700 block">Nama Lengkap Siswa</span>
                            <h3 class="text-lg sm:text-xl font-extrabold text-slate-900 mt-0.5">{{ $siswa->nama }}</h3>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div class="p-3.5 rounded-2xl bg-white border border-slate-200/80 shadow-sm">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 block">NISN Siswa</span>
                                <p class="text-sm font-extrabold font-mono text-slate-900 mt-1">{{ $siswa->nisn }}</p>
                            </div>
                            <div class="p-3.5 rounded-2xl bg-white border border-slate-200/80 shadow-sm">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 block">Kelas Terdaftar</span>
                                <p class="text-sm font-extrabold text-sky-700 mt-1">{{ $siswa->kelas }}</p>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-emerald-50/70 border border-emerald-200/80 flex items-center justify-between gap-3">
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 block">No. WhatsApp Orang Tua</span>
                                <p class="text-xs font-bold font-mono text-emerald-950 mt-0.5">{{ $siswa->no_hp_orangtua ?? '-' }}</p>
                            </div>
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 flex-shrink-0">
                                <svg class="w-3 h-3 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Siap Notifikasi
                            </span>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Footer Kartu --}}
            <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-2">
                <span class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Sistem Enkripsi: AES-128-CBC + IV Acak
                </span>
                <span class="font-mono text-[11px] text-slate-400">Dibuat: {{ now()->format('d/m/Y H:i:s') }} WIB</span>
            </div>

        </div>

        {{-- ============================================================ --}}
        {{-- TOMBOL TINDAKAN (ACTION BUTTONS) --}}
        {{-- ============================================================ --}}
        <div class="flex flex-col sm:flex-row gap-3">
            <button onclick="window.print()" 
                    class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl text-sm font-bold bg-gradient-to-r from-sky-600 to-blue-700 text-white shadow-md shadow-sky-600/20 hover:from-sky-500 hover:to-blue-600 active:scale-[0.99] transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak Kartu QR
            </button>
            <a href="{{ route('siswa.qrcode') }}" 
               class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl text-sm font-bold bg-white text-slate-700 border border-slate-200/80 shadow-sm hover:bg-slate-50 hover:text-slate-900 active:scale-[0.99] transition-all">
                <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Perbarui Token QR
            </a>
        </div>

        {{-- ============================================================ --}}
        {{-- PANEL KETERANGAN TEKNIS SIDANG (SKRIPSI) --}}
        {{-- ============================================================ --}}
        <div class="bg-white rounded-3xl border border-slate-200/80 p-5 sm:p-6 shadow-sm">
            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                <div class="w-8 h-8 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-900">Keterangan Teknis Enkripsi (Untuk Bahan Sidang Skripsi)</h4>
                    <p class="text-xs text-slate-500">Mekanisme keamanan kriptografi presensi digital PRESIS</p>
                </div>
            </div>

            <div class="mt-4 space-y-3 text-xs text-slate-600 leading-relaxed">
                <p>
                    QR Code di atas tidak memuat NISN dalam bentuk teks biasa (plaintext), melainkan hasil enkripsi simetris 
                    <strong class="text-slate-800">OpenSSL AES-128-CBC</strong> yang dilengkapi dengan <strong class="text-slate-800">Initialization Vector (IV) 16-byte acak</strong>.
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/60">
                        <p class="font-bold text-slate-800 mb-1">🛡 Anti-Cloning & Unik</p>
                        <p class="text-[11px] text-slate-500">Setiap generate menghasilkan IV acak baru, sehingga barcode QR selalu berbeda meski memuat data siswa yang sama.</p>
                    </div>
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/60">
                        <p class="font-bold text-slate-800 mb-1">⏱ Batas Waktu ({{ $expirySeconds ?? 300 }} Detik)</p>
                        <p class="text-[11px] text-slate-500">QR Code memiliki masa kedaluwarsa otomatis. Mencegah tangkapan layar (screenshot) disebarkan untuk titip presensi.</p>
                    </div>
                </div>

                <div class="mt-3">
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Ciphertext Payload (Terenkripsi):</p>
                    <div class="bg-slate-900 text-sky-400 p-3 rounded-xl font-mono text-[10px] break-all border border-slate-800 select-all">
                        {{ $encryptedPayload }}
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('styles')
    <style>
        @media print {
            body { background: white !important; }
            body * { visibility: hidden !important; }
            #printArea, #printArea * { visibility: visible !important; }
            #printArea {
                position: absolute !important;
                left: 50% !important;
                top: 50% !important;
                transform: translate(-50%, -50%) !important;
                width: 90% !important;
                max-width: 600px !important;
                box-shadow: none !important;
                border: 1px solid #cbd5e1 !important;
            }
        }
    </style>
    @endpush

    @if(isset($expirySeconds) && $expirySeconds > 0)
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const totalDuration = {{ $expirySeconds }};
            let remaining = totalDuration;

            const countdownText = document.getElementById('countdownText');
            const timerBadge = document.getElementById('timerBadge');
            const progressBar = document.getElementById('progressBar');
            const qrContainer = document.getElementById('qrCodeContainer');
            const expiredOverlay = document.getElementById('qrExpiredOverlay');

            function updateDisplay() {
                const minutes = Math.floor(remaining / 60);
                const seconds = remaining % 60;
                countdownText.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

                const percentage = Math.max(0, (remaining / totalDuration) * 100);
                progressBar.style.width = `${percentage}%`;

                if (remaining <= 30 && remaining > 0) {
                    progressBar.className = 'bg-rose-500 h-full rounded-full transition-all duration-1000 ease-linear';
                    timerBadge.className = 'inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-bold font-mono bg-rose-100 text-rose-700 animate-pulse';
                }
            }

            updateDisplay();

            const timerInterval = setInterval(() => {
                remaining--;

                if (remaining <= 0) {
                    clearInterval(timerInterval);
                    countdownText.textContent = '00:00';
                    progressBar.style.width = '0%';
                    timerBadge.className = 'inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-bold font-mono bg-rose-100 text-rose-700';

                    // Tampilkan overlay kadaluarsa dan blur QR Code
                    if (qrContainer && expiredOverlay) {
                        qrContainer.classList.add('blur-sm', 'opacity-30', 'pointer-events-none');
                        expiredOverlay.classList.remove('hidden');
                    }
                } else {
                    updateDisplay();
                }
            }, 1000);
        });
    </script>
    @endpush
    @endif

</x-layouts.dashboard>
