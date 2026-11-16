{{--
    Halaman Scanner QR Code Guru PRESIS
    Menggunakan library html5-qrcode untuk memindai QR Code terenkripsi AES-128-CBC.
    Dilengkapi umpan balik audio, log pemindaian real-time, dan fitur Perbesar Tampilan Scanner.
--}}

<x-layouts.dashboard :title="'Scanner QR Code'" :role="'GURU'" :pageTitle="'Pemindai QR Code Presensi'">

    {{-- Sidebar Menu Guru --}}
    <x-slot:sidebar>
        @include('components.sidebar-item', ['href' => '/guru/dashboard', 'label' => 'Dashboard'])
        @include('components.sidebar-item', ['href' => '/guru/scanner', 'label' => 'Scan QR Code', 'active' => true])
        @include('components.sidebar-item', ['href' => '/guru/absensi', 'label' => 'Data Absensi'])
        @include('components.sidebar-item', ['href' => '/guru/rekap', 'label' => 'Rekap Harian'])
    </x-slot:sidebar>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- ============================================================ --}}
        {{-- AREA SCANNER KAMERA (KOLOM KIRI: 7/8 KOLOM) --}}
        {{-- ============================================================ --}}
        <div class="lg:col-span-7 xl:col-span-8 space-y-5">

            {{-- Kartu Scanner --}}
            <div id="scannerCardContainer" class="bg-white rounded-3xl border border-slate-200/80 p-5 sm:p-7 shadow-sm transition-all duration-300">
                <div id="scannerCardHeader" class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-slate-100 pb-4 mb-5 gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center ring-1 ring-sky-100 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 id="scannerHeading" class="text-base font-bold text-slate-900 leading-tight">Kamera Pemindai QR</h2>
                            <p id="scannerSubHeading" class="text-xs text-slate-500">Arahkan QR Code dinamis siswa ke dalam area kotak</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <span id="scannerStatusText" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200/60">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                            Menyiapkan Kamera...
                        </span>

                        {{-- Tombol Perbesar / Mode Layar Penuh Scanner --}}
                        <button onclick="toggleExpandScanner()" id="btnExpandScanner" type="button" title="Perbesar Tampilan Kamera"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-sky-50 hover:bg-sky-100 text-sky-700 border border-sky-200 text-xs font-bold transition-all active:scale-95">
                            <svg id="expandIcon" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                            </svg>
                            <span id="expandText">Perbesar</span>
                        </button>
                    </div>
                </div>

                {{-- Viewfinder Kamera (Ukuran Awal Semula Sebelum Diperbesar: min-h-[340px]) --}}
                <div id="viewfinderWrapper" class="relative bg-slate-900 rounded-2xl overflow-hidden flex flex-col items-center justify-center min-h-[340px] shadow-inner transition-all duration-300">
                    <div id="qr-reader" class="w-full"></div>

                    {{-- Overlay Target Scanner --}}
                    <div id="scannerOverlay" class="pointer-events-none absolute inset-0 flex items-center justify-center">
                        <div id="scannerTargetBox" class="w-60 h-60 border-2 border-sky-400/80 rounded-2xl relative transition-all duration-300">
                            {{-- Sudut Siku --}}
                            <div class="absolute -top-1 -left-1 w-5 h-5 border-t-4 border-l-4 border-sky-400 rounded-tl"></div>
                            <div class="absolute -top-1 -right-1 w-5 h-5 border-t-4 border-r-4 border-sky-400 rounded-tr"></div>
                            <div class="absolute -bottom-1 -left-1 w-5 h-5 border-b-4 border-l-4 border-sky-400 rounded-bl"></div>
                            <div class="absolute -bottom-1 -right-1 w-5 h-5 border-b-4 border-r-4 border-sky-400 rounded-br"></div>
                            
                            {{-- Laser Scan Line --}}
                            <div class="absolute inset-x-2 top-1/2 h-0.5 bg-gradient-to-r from-transparent via-sky-400 to-transparent shadow-[0_0_8px_#38bdf8] animate-pulse"></div>
                            <span class="absolute bottom-2 inset-x-0 text-center text-[10px] font-semibold text-sky-200 tracking-wider">
                                POSISIKAN QR DI SINI
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Kontrol Scanner --}}
                <div id="scannerControlsBar" class="mt-5 flex flex-wrap items-center gap-3">
                    <div class="flex-1 min-w-[200px]">
                        <select id="cameraSelection" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm font-medium text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-600 shadow-sm transition-all">
                            <option value="">Memindai perangkat kamera...</option>
                        </select>
                    </div>

                    <button id="btnStartStop" onclick="toggleScanner()" 
                            class="px-5 py-2.5 rounded-xl font-bold text-sm bg-slate-800 hover:bg-slate-900 text-white shadow-sm transition-all flex items-center gap-2 active:scale-95">
                        <span class="w-2 h-2 rounded-full bg-rose-400"></span>
                        <span>Stop Kamera</span>
                    </button>

                    <button onclick="toggleManualInputModal()" 
                            class="px-4 py-2.5 rounded-xl font-semibold text-sm bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200/80 transition-all flex items-center gap-1.5 active:scale-95">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <span>Input Manual</span>
                    </button>
                </div>
            </div>

            {{-- Kartu Hasil Scan Terakhir --}}
            <div id="scanResultCard" class="hidden rounded-2xl p-5 border shadow-sm transition-all">
                <div class="flex items-start gap-4">
                    <div id="scanResultIconWrapper" class="w-12 h-12 rounded-xl flex items-center justify-center font-bold text-xl flex-shrink-0">
                        <span id="scanResultIcon">✓</span>
                    </div>
                    <div class="flex-1">
                        <h4 id="scanResultTitle" class="text-base font-extrabold tracking-tight"></h4>
                        <div id="scanResultDesc" class="text-sm mt-1"></div>

                        {{-- Info Notifikasi WhatsApp --}}
                        <div id="scanResultWa" class="mt-3 pt-3 border-t border-slate-200/60 text-xs flex items-center gap-2">
                            <span class="text-slate-500 font-medium">📲 Notifikasi WhatsApp:</span>
                            <span id="scanResultWaStatus" class="font-bold"></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ============================================================ --}}
        {{-- LOG HASIL SCAN HARI INI (KOLOM KANAN: 5/4 KOLOM) --}}
        {{-- ============================================================ --}}
        <div class="lg:col-span-5 xl:col-span-4 space-y-4">

            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm h-full flex flex-col overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-white">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Scan Terakhir Anda</h3>
                        <p class="text-xs text-slate-500">Log kehadiran langsung</p>
                    </div>
                    <span id="scanCountBadge" class="px-2.5 py-1 rounded-full text-xs font-bold bg-sky-50 text-sky-700 border border-sky-200/60">
                        {{ $scanHariIni->count() }} Scan
                    </span>
                </div>

                {{-- Daftar Scan Realtime --}}
                <div id="recentScansList" class="p-4 space-y-2.5 flex-1 overflow-y-auto max-h-[520px]">
                    @forelse($scanHariIni as $scan)
                        <div class="p-3 rounded-xl bg-slate-50/80 border border-slate-200/60 hover:bg-slate-100/60 transition-all flex items-center justify-between text-xs">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 font-bold flex items-center justify-center flex-shrink-0">
                                    {{ strtoupper(substr($scan->siswa->nama ?? 'S', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900">{{ $scan->siswa->nama ?? 'Siswa' }}</p>
                                    <p class="text-[11px] text-slate-500 font-mono">{{ $scan->nisn }} &bull; {{ $scan->siswa->kelas ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    {{ strtoupper($scan->status) }}
                                </span>
                                <p class="text-[10px] text-slate-400 font-mono mt-0.5">{{ $scan->waktu_scan->format('H:i:s') }}</p>
                            </div>
                        </div>
                    @empty
                        <div id="emptyScanPlaceholder" class="p-8 text-center text-slate-400 text-xs">
                            <svg class="w-8 h-8 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                            Belum ada pemindaian hari ini.<br>Arahkan QR Code siswa ke kamera.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

    {{-- MODAL INPUT MANUAL --}}
    <div id="manualModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 w-full max-w-md shadow-xl animate-scale-up">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3.5 mb-4">
                <h3 class="text-sm font-bold text-slate-900">Input Manual Payload QR</h3>
                <button onclick="toggleManualInputModal()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center font-bold text-sm transition-colors">✕</button>
            </div>

            <p class="text-xs text-slate-500 mb-4 leading-relaxed">
                Jika kamera tidak dapat digunakan, Anda dapat menempelkan ciphertext Base64 dari QR Code siswa di bawah ini:
            </p>

            <form onsubmit="handleManualSubmit(event)" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Payload QR Terenkripsi
                    </label>
                    <textarea id="manualPayloadInput" rows="3" required placeholder="Tempel ciphertext Base64 di sini..."
                              class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-600 shadow-sm transition-all"></textarea>
                </div>

                <div class="flex gap-2 justify-end pt-2">
                    <button type="button" onclick="toggleManualInputModal()"
                            class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition-all">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-5 py-2 rounded-xl bg-gradient-to-r from-sky-600 to-blue-700 hover:from-sky-700 hover:to-blue-800 text-white font-bold text-xs shadow-sm shadow-sky-600/25 transition-all">
                        Proses Presensi
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
    <style>
        #qr-reader { border: none !important; }
        #qr-reader__scan_region { background: #0f172a; }
        #qr-reader__dashboard { display: none !important; }

        /* Mode Perbesar (Fullscreen Viewfinder Overlay) */
        .scanner-fullscreen-mode {
            position: fixed !important;
            inset: 0 !important;
            z-index: 9999 !important;
            width: 100vw !important;
            height: 100vh !important;
            max-width: 100vw !important;
            margin: 0 !important;
            border-radius: 0 !important;
            padding: 1.25rem sm:1.5rem !important;
            background: #090d16 !important;
            box-shadow: none !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
        }
        .scanner-fullscreen-mode #scannerCardHeader {
            border-color: #1e293b !important;
            padding-bottom: 0.75rem !important;
            margin-bottom: 0.75rem !important;
        }
        .scanner-fullscreen-mode #scannerHeading {
            color: #ffffff !important;
        }
        .scanner-fullscreen-mode #scannerSubHeading {
            color: #94a3b8 !important;
        }
        .scanner-fullscreen-mode #viewfinderWrapper {
            flex: 1 1 0% !important;
            min-height: 0 !important;
            height: 100% !important;
            border-radius: 1.25rem !important;
        }
        .scanner-fullscreen-mode #viewfinderWrapper video {
            width: 100% !important;
            height: 100% !important;
            object-fit: contain !important;
        }
        .scanner-fullscreen-mode #scannerTargetBox {
            width: 320px !important;
            height: 320px !important;
        }
        @media (min-width: 640px) {
            .scanner-fullscreen-mode #scannerTargetBox {
                width: 380px !important;
                height: 380px !important;
            }
        }
        .scanner-fullscreen-mode #scannerControlsBar {
            margin-top: 0.75rem !important;
        }
    </style>
    @endpush

    {{-- Script library html5-qrcode dari CDN --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let html5QrCode = null;
        let isScanning = false;
        let isProcessing = false;
        let audioContext = null;
        let isExpanded = false;

        // Toggle Perbesar / Perkecil Scanner
        function toggleExpandScanner() {
            const card = document.getElementById('scannerCardContainer');
            const expandText = document.getElementById('expandText');
            const expandIcon = document.getElementById('expandIcon');

            isExpanded = !isExpanded;

            if (isExpanded) {
                card.classList.add('scanner-fullscreen-mode');
                expandText.textContent = 'Perkecil';
                expandIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>';
            } else {
                card.classList.remove('scanner-fullscreen-mode');
                expandText.textContent = 'Perbesar';
                expandIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>';
            }
        }

        // Tutup mode perbesar dengan tombol Escape (Esc)
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && isExpanded) {
                toggleExpandScanner();
            }
        });

        function playBeep(success = true) {
            try {
                if (!audioContext) {
                    audioContext = new (window.AudioContext || window.webkitAudioContext)();
                }
                const osc = audioContext.createOscillator();
                const gain = audioContext.createGain();
                osc.connect(gain);
                gain.connect(audioContext.destination);

                if (success) {
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(587.33, audioContext.currentTime);
                    osc.frequency.setValueAtTime(880, audioContext.currentTime + 0.1);
                    gain.gain.setValueAtTime(0.3, audioContext.currentTime);
                    gain.gain.exponentialRampToValueAtTime(0.001, audioContext.currentTime + 0.35);
                    osc.start();
                    osc.stop(audioContext.currentTime + 0.35);
                } else {
                    osc.type = 'sawtooth';
                    osc.frequency.setValueAtTime(180, audioContext.currentTime);
                    gain.gain.setValueAtTime(0.4, audioContext.currentTime);
                    gain.gain.exponentialRampToValueAtTime(0.001, audioContext.currentTime + 0.4);
                    osc.start();
                    osc.stop(audioContext.currentTime + 0.4);
                }
            } catch (e) {
                console.log('Audio not supported or blocked:', e);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            initScanner();
        });

        async function initScanner() {
            const statusText = document.getElementById('scannerStatusText');
            const cameraSelect = document.getElementById('cameraSelection');

            try {
                const devices = await Html5Qrcode.getCameras();
                if (devices && devices.length > 0) {
                    cameraSelect.innerHTML = '';
                    devices.forEach((cam, index) => {
                        const option = document.createElement('option');
                        option.value = cam.id;
                        option.text = cam.label || `Kamera ${index + 1}`;
                        if (cam.label.toLowerCase().includes('back') || cam.label.toLowerCase().includes('belakang')) {
                            option.selected = true;
                        }
                        cameraSelect.appendChild(option);
                    });

                    cameraSelect.addEventListener('change', () => {
                        if (isScanning) {
                            stopScanner().then(() => startScanner(cameraSelect.value));
                        }
                    });

                    startScanner(cameraSelect.value);
                } else {
                    statusText.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Kamera Tidak Ditemukan';
                    statusText.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200';
                }
            } catch (err) {
                console.error("Camera access error:", err);
                statusText.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Izin Kamera Ditolak';
                statusText.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200';
            }
        }

        async function startScanner(cameraId) {
            const statusText = document.getElementById('scannerStatusText');
            const btn = document.getElementById('btnStartStop');

            html5QrCode = new Html5Qrcode("qr-reader");

            // Konfigurasi Asli Awal Sebelum Revisi
            const config = {
                fps: 15,
                qrbox: { width: 230, height: 230 },
                aspectRatio: 1.0,
            };

            try {
                await html5QrCode.start(
                    cameraId,
                    config,
                    (decodedText, decodedResult) => {
                        onScanSuccess(decodedText);
                    },
                    (errorMessage) => {}
                );

                isScanning = true;
                btn.innerHTML = '<span class="w-2 h-2 rounded-full bg-rose-400"></span><span>Stop Kamera</span>';
                btn.className = 'px-5 py-2.5 rounded-xl font-bold text-sm bg-slate-800 hover:bg-slate-900 text-white shadow-sm transition-all flex items-center gap-2 active:scale-95';
                statusText.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Kamera Aktif (Siap Scan)';
                statusText.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200';
            } catch (err) {
                console.error("Failed to start scanner:", err);
                statusText.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Gagal Memulai Kamera';
                statusText.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200';
            }
        }

        async function stopScanner() {
            if (html5QrCode && isScanning) {
                await html5QrCode.stop();
                isScanning = false;
                const btn = document.getElementById('btnStartStop');
                const statusText = document.getElementById('scannerStatusText');
                btn.innerHTML = '<span class="w-2 h-2 rounded-full bg-emerald-400"></span><span>Nyalakan Kamera</span>';
                btn.className = 'px-5 py-2.5 rounded-xl font-bold text-sm bg-sky-600 hover:bg-sky-700 text-white shadow-sm transition-all flex items-center gap-2 active:scale-95';
                statusText.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Kamera Dimatikan';
                statusText.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200';
            }
        }

        function toggleScanner() {
            const cameraSelect = document.getElementById('cameraSelection');
            if (isScanning) {
                stopScanner();
            } else if (cameraSelect.value) {
                startScanner(cameraSelect.value);
            }
        }

        async function onScanSuccess(decodedText) {
            if (isProcessing) return;
            isProcessing = true;

            const statusText = document.getElementById('scannerStatusText');
            statusText.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-sky-500 animate-pulse"></span> Memverifikasi Kriptografi...';
            statusText.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-200';

            await sendPayloadToBackend(decodedText);

            setTimeout(() => {
                isProcessing = false;
                if (isScanning) {
                    statusText.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Kamera Aktif (Siap Scan)';
                    statusText.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200';
                }
            }, 2000);
        }

        async function sendPayloadToBackend(qrPayload) {
            const card = document.getElementById('scanResultCard');
            const title = document.getElementById('scanResultTitle');
            const desc = document.getElementById('scanResultDesc');
            const icon = document.getElementById('scanResultIcon');
            const iconWrapper = document.getElementById('scanResultIconWrapper');
            const waTarget = document.getElementById('scanResultWa');
            const waStatus = document.getElementById('scanResultWaStatus');

            try {
                const response = await fetch("{{ route('guru.scanner.process') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ qr_payload: qrPayload })
                });

                const result = await response.json();
                card.classList.remove('hidden');

                if (response.ok && result.success) {
                    playBeep(true);

                    card.className = 'rounded-2xl p-5 border border-emerald-200 bg-emerald-50/80 text-emerald-900 shadow-sm transition-all';
                    iconWrapper.className = 'w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xl flex-shrink-0';
                    icon.textContent = '✓';
                    title.textContent = `PRESENSI BERHASIL: ${result.data.nama}`;
                    desc.innerHTML = `NISN: <span class="font-mono font-semibold">${result.data.nisn}</span> &bull; Kelas: <span class="font-semibold">${result.data.kelas}</span> &bull; Jurusan: <span class="font-semibold">Teknik Komputer & Jaringan ( TKJ )</span> &bull; Waktu: <span class="font-mono font-semibold">${result.data.waktu_scan} WIB</span>`;

                    waTarget.classList.remove('hidden');
                    if (result.data.wa_simulated) {
                        waStatus.textContent = `Mode Simulasi Terkirim (${result.data.wa_target})`;
                        waStatus.className = 'font-bold text-sky-700';
                    } else if (result.data.wa_status === 'Terkirim') {
                        waStatus.textContent = `Terkirim ke ${result.data.wa_target}`;
                        waStatus.className = 'font-bold text-emerald-700';
                    } else {
                        waStatus.textContent = `Belum aktif (${result.data.wa_message})`;
                        waStatus.className = 'font-bold text-amber-700';
                    }

                    prependRecentScan(result.data);

                } else if (result.expired) {
                    playBeep(false);

                    card.className = 'rounded-2xl p-5 border border-amber-200 bg-amber-50/80 text-amber-900 shadow-sm transition-all';
                    iconWrapper.className = 'w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-xl flex-shrink-0';
                    icon.textContent = '⏳';
                    title.textContent = 'QR CODE KADALUARSA';
                    desc.textContent = result.message;
                    waTarget.classList.add('hidden');

                } else if (result.already_scanned) {
                    playBeep(false);

                    card.className = 'rounded-2xl p-5 border border-amber-200 bg-amber-50/80 text-amber-900 shadow-sm transition-all';
                    iconWrapper.className = 'w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-xl flex-shrink-0';
                    icon.textContent = '⚠';
                    title.textContent = 'PERINGATAN: SUDAH ABSENSI HARI INI';
                    desc.textContent = result.message;
                    waTarget.classList.add('hidden');

                } else {
                    playBeep(false);

                    card.className = 'rounded-2xl p-5 border border-rose-200 bg-rose-50/80 text-rose-900 shadow-sm transition-all';
                    iconWrapper.className = 'w-12 h-12 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center font-bold text-xl flex-shrink-0';
                    icon.textContent = '✕';
                    title.textContent = 'PRESENSI GAGAL DIVERIFIKASI';
                    desc.textContent = result.message || 'QR Code tidak valid atau token rusak.';
                    waTarget.classList.add('hidden');
                }
            } catch (err) {
                console.error("AJAX Error:", err);
                playBeep(false);
                card.classList.remove('hidden');
                card.className = 'rounded-2xl p-5 border border-rose-200 bg-rose-50/80 text-rose-900 shadow-sm transition-all';
                iconWrapper.className = 'w-12 h-12 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center font-bold text-xl flex-shrink-0';
                icon.textContent = '✕';
                title.textContent = 'KESALAHAN JARINGAN';
                desc.textContent = 'Gagal menghubungi server untuk memvalidasi QR Code.';
                waTarget.classList.add('hidden');
            }
        }

        function prependRecentScan(data) {
            const list = document.getElementById('recentScansList');
            const placeholder = document.getElementById('emptyScanPlaceholder');
            if (placeholder) {
                placeholder.remove();
            }

            const item = document.createElement('div');
            item.className = 'p-3 rounded-xl bg-emerald-50/90 border border-emerald-200/80 flex items-center justify-between text-xs transition-all duration-300';
            item.innerHTML = `
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-full bg-emerald-200 text-emerald-800 font-bold flex items-center justify-center flex-shrink-0">
                        ${data.nama.charAt(0).toUpperCase()}
                    </div>
                    <div>
                        <p class="font-bold text-slate-900">${data.nama}</p>
                        <p class="text-[11px] text-slate-500 font-mono">${data.nisn} &bull; ${data.kelas}</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                        ${data.status.toUpperCase()}
                    </span>
                    <p class="text-[10px] text-slate-400 font-mono mt-0.5">${data.waktu_scan}</p>
                </div>
            `;

            list.insertBefore(item, list.firstChild);
        }

        function toggleManualInputModal() {
            const modal = document.getElementById('manualModal');
            modal.classList.toggle('hidden');
            if (!modal.classList.contains('hidden')) {
                document.getElementById('manualPayloadInput').focus();
            }
        }

        async function handleManualSubmit(e) {
            e.preventDefault();
            const input = document.getElementById('manualPayloadInput');
            const payload = input.value.trim();
            if (!payload) return;

            toggleManualInputModal();
            input.value = '';
            await sendPayloadToBackend(payload);
        }
    </script>

</x-layouts.dashboard>
