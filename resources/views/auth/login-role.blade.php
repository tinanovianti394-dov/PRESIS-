<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk {{ $title }} — PRESIS SMKN 3 Bengkalis</title>

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
@php
    // Konfigurasi warna & ikon berdasarkan role
    $roleConfig = match($role) {
        'admin' => [
            'accent'     => 'brand',
            'gradient'   => 'from-brand-500 to-brand-700',
            'bgLight'    => 'bg-brand-50',
            'textAccent' => 'text-brand-600',
            'badgeBg'    => 'bg-brand-500',
            'icon'       => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
            'helpTitle'  => 'Pusat Bantuan Administrator',
            'helpDesc'   => 'Akses terbatas untuk Pengelola Sistem & Tim IT Sekolah. Jika mengalami kendala otentikasi, periksa koneksi server atau hubungi Kepala Sekolah.',
        ],
        'guru' => [
            'accent'     => 'brand',
            'gradient'   => 'from-brand-400 to-brand-600',
            'bgLight'    => 'bg-brand-50',
            'textAccent' => 'text-brand-600',
            'badgeBg'    => 'bg-brand-500',
            'icon'       => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>',
            'helpTitle'  => 'Panduan Akses Guru / Pendidik',
            'helpDesc'   => 'Gunakan 18 digit NIP atau email dinas Anda yang terdaftar pada sistem kurikulum SMKN 3 Bengkalis. Reset password dapat diajukan ke Administrator.',
        ],
        'siswa' => [
            'accent'     => 'emerald',
            'gradient'   => 'from-emerald-500 to-teal-600',
            'bgLight'    => 'bg-emerald-50',
            'textAccent' => 'text-emerald-600',
            'badgeBg'    => 'bg-emerald-500',
            'icon'       => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>',
            'helpTitle'  => 'Informasi Login Peserta Didik',
            'helpDesc'   => 'Masukkan 10 digit NISN resmi Anda. Jika belum menerima kata sandi akun presensi atau kartu hilang, silakan lapor kepada Wali Kelas.',
        ],
        default => [
            'accent'     => 'brand',
            'gradient'   => 'from-brand-500 to-brand-700',
            'bgLight'    => 'bg-brand-50',
            'textAccent' => 'text-brand-600',
            'badgeBg'    => 'bg-brand-500',
            'icon'       => '',
            'helpTitle'  => 'Bantuan Pengguna',
            'helpDesc'   => 'Silakan hubungi pihak sekolah jika membutuhkan bantuan.',
        ],
    };
@endphp
<body class="bg-[#F8FAFC] text-slate-800 min-h-screen flex items-center justify-center p-4 sm:p-6 antialiased">

    {{-- Dekorasi Background --}}
    <div class="fixed inset-0 pointer-events-none overflow-hidden -z-10">
        <div class="absolute -top-32 -right-32 w-96 h-96 rounded-full bg-brand-200/25 blur-3xl"></div>
        <div class="absolute -bottom-32 -left-32 w-80 h-80 rounded-full bg-brand-100/30 blur-3xl"></div>
    </div>

    <div class="max-w-md w-full">

        {{-- Tombol Kembali ke Portal --}}
        <a href="{{ route('login.portal') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-brand-600 mb-5 transition-colors group">
            <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Portal Utama
        </a>

        {{-- Card Login --}}
        <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-200/80 overflow-hidden">

            {{-- Aksen Warna Atas --}}
            <div class="h-1.5 bg-gradient-to-r {{ $roleConfig['gradient'] }}"></div>

            <div class="p-6 sm:p-8">

                {{-- Header dengan Icon & Badge --}}
                <div class="text-center mb-6">
                    <div class="w-14 h-14 rounded-2xl {{ $roleConfig['bgLight'] }} {{ $roleConfig['textAccent'] }} flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $roleConfig['icon'] !!}
                        </svg>
                    </div>

                    <div class="flex items-center justify-center gap-1.5 mb-1">
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-extrabold tracking-wider {{ $roleConfig['badgeBg'] }} text-white uppercase">
                            {{ $role }}
                        </span>
                        <span class="text-xs text-slate-400">·</span>
                        <span class="text-xs font-semibold text-slate-500">SMKN 3 Bengkalis</span>
                    </div>

                    <h1 class="text-xl font-extrabold tracking-tight text-slate-900">Masuk {{ $title }}</h1>
                    <p class="text-xs text-slate-500 mt-1">Sistem Presensi Siswa Terenkripsi (PRESIS)</p>
                </div>

                {{-- Alert Error --}}
                @if (isset($errors) && $errors->has('login_error'))
                    <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-medium flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-rose-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="flex-1">{{ $errors->first('login_error') }}</div>
                    </div>
                @endif

                {{-- Form Login --}}
                <form action="{{ route('login.authenticate') }}" method="POST" id="loginForm" class="space-y-4">
                    @csrf
                    <input type="hidden" name="role" value="{{ $role }}">

                    {{-- Input Username (Email / NIP / NISN) --}}
                    <div>
                        <label for="usernameInput" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            {{ $inputLabel }}
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <input type="text" name="username" id="usernameInput" required
                                value="{{ old('username') }}"
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 text-sm font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-200 focus:border-brand-500 transition-all shadow-sm"
                                placeholder="{{ $placeholder }}" autocomplete="username">
                        </div>
                    </div>

                    {{-- Input Password --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="passwordInput" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Kata Sandi
                            </label>
                            <button type="button" onclick="togglePwd()" class="text-xs {{ $roleConfig['textAccent'] }} hover:opacity-80 font-semibold transition-opacity">
                                <span id="togglePwdText">Tampilkan</span>
                            </button>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input type="password" name="password" id="passwordInput" required
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 text-sm font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-200 focus:border-brand-500 transition-all shadow-sm"
                                placeholder="••••••••" autocomplete="current-password">
                        </div>
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center justify-between pt-0.5">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-brand-500 focus:ring-brand-200/50 transition-all">
                            <span class="text-xs text-slate-600 font-medium">Ingat sesi login</span>
                        </label>
                    </div>

                    {{-- Tombol Submit --}}
                    <button type="submit"
                            class="w-full py-3 px-4 rounded-xl font-bold text-sm text-white bg-gradient-to-r {{ $roleConfig['gradient'] }} hover:opacity-90 shadow-md hover:shadow-lg transition-all duration-150 active:scale-[0.99] flex items-center justify-center gap-2">
                        <span>Masuk ke Dashboard</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </form>

                {{-- Informasi & Layanan Bantuan Sekolah --}}
                <div class="mt-6 pt-5 border-t border-slate-100">
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg {{ $roleConfig['bgLight'] }} {{ $roleConfig['textAccent'] }} flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1 text-xs">
                            <h4 class="font-bold text-slate-800">{{ $roleConfig['helpTitle'] }}</h4>
                            <p class="text-[11px] text-slate-500 mt-0.5 leading-relaxed">
                                {{ $roleConfig['helpDesc'] }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <p class="mt-6 text-xs text-slate-400 text-center">
            © {{ date('Y') }} PRESIS — SMK Negeri 3 Bengkalis · Jurusan TJKT
        </p>

    </div>

    <script>
        // Toggle password visibility
        function togglePwd() {
            const pwd = document.getElementById('passwordInput');
            const txt = document.getElementById('togglePwdText');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                txt.innerText = 'Sembunyikan';
            } else {
                pwd.type = 'password';
                txt.innerText = 'Tampilkan';
            }
        }

        // Anti BFCache 419
        window.addEventListener('pageshow', function (event) {
            if (event.persisted || (window.performance && window.performance.navigation && window.performance.navigation.type === 2)) {
                window.location.reload();
            }
        });
    </script>

</body>
</html>
