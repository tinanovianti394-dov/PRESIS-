<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRESIS — Sistem Presensi Siswa SMKN 3 Bengkalis</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'Inter', 'system-ui', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    },
                    colors: {
                        brand: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        }
                    }
                }
            }
        }
    </script>

    {{-- Google Fonts: Plus Jakarta Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-sky-50/50 to-blue-50/30 text-slate-800 min-h-screen flex flex-col antialiased">

    <!-- Top Navigation Bar -->
    <header class="w-full bg-white/80 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-30">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo-smkn3.jpg') }}" alt="Logo SMKN 3 Bengkalis" class="w-10 h-10 rounded-xl object-cover shadow-sm ring-1 ring-slate-200/80">
                <div>
                    <h1 class="font-extrabold text-base tracking-tight text-slate-900 leading-tight">PRESIS</h1>
                    <p class="text-[11px] font-semibold text-sky-600">SMK Negeri 3 Bengkalis</p>
                </div>
            </div>

            <div>
                @auth('web')
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold bg-gradient-to-r from-sky-600 to-blue-700 text-white shadow-sm hover:from-sky-500 hover:to-blue-600 transition-all">
                        <span>Buka Dashboard</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                @elseif(Auth::guard('siswa')->check())
                    <a href="{{ route('siswa.portal') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold bg-gradient-to-r from-sky-600 to-blue-700 text-white shadow-sm hover:from-sky-500 hover:to-blue-600 transition-all">
                        <span>Portal Siswa</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold bg-gradient-to-r from-sky-600 to-blue-700 text-white shadow-sm hover:from-sky-500 hover:to-blue-600 transition-all">
                        <span>Masuk ke Portal</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Content -->
    <main class="flex-1 max-w-5xl mx-auto px-4 sm:px-6 py-12 sm:py-16 flex flex-col items-center justify-center text-center">
        
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold bg-sky-100 text-sky-800 mb-6 shadow-sm border border-sky-200">
            <span class="w-2 h-2 rounded-full bg-sky-500 animate-pulse"></span>
            Sistem Informasi Presensi Digital Terenkripsi
        </div>

        <h2 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight max-w-3xl leading-tight sm:leading-tight">
            Presensi Siswa Cepat, Akurat & Terenkripsi di <span class="bg-gradient-to-r from-sky-600 to-blue-700 bg-clip-text text-transparent">SMKN 3 Bengkalis</span>
        </h2>

        <p class="text-slate-600 text-sm sm:text-base max-w-2xl mt-4 leading-relaxed">
            Platform presensi modern berbasis QR Code terenkripsi AES-128 dengan integrasi notifikasi WhatsApp Gateway otomatis dan rekapitulasi real-time untuk SMK Negeri 3 Bengkalis.
        </p>

        <div class="mt-8 flex flex-col sm:flex-row gap-3">
            <a href="{{ route('login') }}" 
               class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl text-sm font-bold bg-gradient-to-r from-sky-600 to-blue-700 text-white shadow-lg shadow-sky-600/30 hover:from-sky-500 hover:to-blue-600 transition-all">
                <span>Mulai Masuk Presensi</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>

        <!-- Key Highlights Grid -->
        <div class="mt-16 grid grid-cols-1 sm:grid-cols-3 gap-6 w-full text-left">
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-10 h-10 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-slate-900 text-sm">QR Code Dinamis AES-128</h3>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">Dilengkapi enkripsi cipher dan batas waktu expiry (300 detik) untuk memvalidasi presensi anti-titip absen.</p>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-slate-900 text-sm">Notifikasi WhatsApp Otomatis</h3>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">Orang tua siswa langsung menerima pesan WhatsApp resmi ketika siswa berhasil melakukan presensi.</p>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-slate-900 text-sm">Rekap & Export PDF Resmi</h3>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">Laporan absensi harian dan bulanan terstruktur lengkap dengan kop resmi dan tanda tangan kepala sekolah.</p>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="w-full border-t border-slate-200/80 bg-white/50 py-6 text-center text-xs text-slate-500">
        <p>© {{ date('Y') }} PRESIS — SMK Negeri 3 Bengkalis</p>
    </footer>

</body>
</html>
