<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Login — PRESIS SMKN 3 Bengkalis</title>

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
                            50:  '#EBF5FB',
                            100: '#D6ECF8',
                            200: '#A2CBD9',
                            300: '#5BA4C9',
                            400: '#2B89B8',
                            500: '#046EA7',
                            600: '#035D8D',
                            700: '#024B72',
                            800: '#023A58',
                            900: '#012C43',
                        }
                    }
                }
            }
        }
    </script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-800 min-h-screen flex flex-col items-center justify-center p-4 sm:p-6 antialiased">

    {{-- Dekorasi Background Halus --}}
    <div class="fixed inset-0 pointer-events-none overflow-hidden -z-10">
        <div class="absolute -top-32 -right-32 w-96 h-96 rounded-full bg-brand-200/30 blur-3xl"></div>
        <div class="absolute -bottom-32 -left-32 w-96 h-96 rounded-full bg-brand-100/40 blur-3xl"></div>
    </div>

    {{-- Header Identitas Sekolah --}}
    <div class="text-center mb-8 sm:mb-10">
        <div class="inline-flex p-2.5 rounded-2xl bg-white ring-1 ring-slate-200/80 shadow-sm mb-4">
            <img src="{{ asset('images/logo-smkn3.jpg') }}" alt="Logo SMKN 3 Bengkalis" class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl object-cover">
        </div>

        <div class="flex items-center justify-center gap-2 mb-1.5">
            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-extrabold tracking-wider bg-brand-500 text-white uppercase">
                PRESIS
            </span>
            <span class="text-xs text-slate-400">·</span>
            <span class="text-xs font-semibold text-slate-500">Presensi Siswa</span>
        </div>

        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">
            SMK Negeri 3 Bengkalis
        </h1>
        <p class="text-sm text-slate-500 mt-1.5 max-w-md mx-auto">
            Sistem Presensi Digital Terenkripsi QR Code AES-128-CBC
        </p>
    </div>

    {{-- Grid 3 Kartu Portal Masuk --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5 max-w-3xl w-full">

        {{-- KARTU 1: Administrator --}}
        <a href="{{ route('login.admin') }}"
           class="group relative bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-7 shadow-sm hover:shadow-lg hover:border-brand-300 transition-all duration-200 text-center overflow-hidden">
            {{-- Aksen atas --}}
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-brand-500 to-brand-700 opacity-0 group-hover:opacity-100 transition-opacity rounded-t-2xl"></div>

            <div class="w-14 h-14 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center mx-auto mb-4 group-hover:bg-brand-500 group-hover:text-white transition-colors duration-200">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>

            <h3 class="font-bold text-base text-slate-900 group-hover:text-brand-700 transition-colors">Administrator</h3>
            <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">Kelola data siswa, guru, absensi, dan cetak laporan rekap</p>

            <div class="mt-4 inline-flex items-center gap-1 text-xs font-semibold text-brand-600 opacity-0 group-hover:opacity-100 transition-opacity">
                <span>Masuk sebagai Admin</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </div>
        </a>

        {{-- KARTU 2: Guru / Staf Pengajar --}}
        <a href="{{ route('login.guru') }}"
           class="group relative bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-7 shadow-sm hover:shadow-lg hover:border-brand-300 transition-all duration-200 text-center overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-brand-400 to-brand-600 opacity-0 group-hover:opacity-100 transition-opacity rounded-t-2xl"></div>

            <div class="w-14 h-14 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center mx-auto mb-4 group-hover:bg-brand-500 group-hover:text-white transition-colors duration-200">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                </svg>
            </div>

            <h3 class="font-bold text-base text-slate-900 group-hover:text-brand-700 transition-colors">Guru / Staf</h3>
            <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">Scan QR presensi siswa, input manual, dan rekap harian kelas</p>

            <div class="mt-4 inline-flex items-center gap-1 text-xs font-semibold text-brand-600 opacity-0 group-hover:opacity-100 transition-opacity">
                <span>Masuk sebagai Guru</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </div>
        </a>

        {{-- KARTU 3: Siswa / Wali --}}
        <a href="{{ route('login.siswa') }}"
           class="group relative bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-7 shadow-sm hover:shadow-lg hover:border-emerald-300 transition-all duration-200 text-center overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 to-teal-600 opacity-0 group-hover:opacity-100 transition-opacity rounded-t-2xl"></div>

            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-4 group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-200">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>

            <h3 class="font-bold text-base text-slate-900 group-hover:text-emerald-700 transition-colors">Siswa / Wali</h3>
            <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">Lihat QR Code presensi, riwayat kehadiran, dan kartu digital</p>

            <div class="mt-4 inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity">
                <span>Masuk sebagai Siswa</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </div>
        </a>

    </div>

    {{-- Footer --}}
    <p class="mt-8 text-xs text-slate-400 text-center">
        © {{ date('Y') }} PRESIS — SMK Negeri 3 Bengkalis
    </p>

    {{-- Anti BFCache 419 --}}
    <script>
        window.addEventListener('pageshow', function (event) {
            if (event.persisted || (window.performance && window.performance.navigation && window.performance.navigation.type === 2)) {
                window.location.reload();
            }
        });
    </script>

</body>
</html>
