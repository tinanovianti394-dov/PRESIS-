<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Sistem — PRESIS SMKN 3 Bengkalis</title>

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

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-sky-50/60 to-blue-50/40 text-slate-800 min-h-screen flex items-center justify-center p-4 sm:p-6 antialiased">

    <!-- Card Login Utama -->
    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-200/80 max-w-md w-full p-6 sm:p-8 backdrop-blur-sm relative overflow-hidden">
        
        <!-- Aksen Dekoratif Atas -->
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-sky-500 via-blue-600 to-indigo-600"></div>

        <!-- Header Logo SMKN 3 Bengkalis -->
        <div class="text-center mb-6 pt-2">
            <div class="inline-flex p-2 rounded-2xl bg-gradient-to-b from-sky-50 to-white ring-1 ring-slate-200/80 shadow-sm mb-3">
                <img src="{{ asset('images/logo-smkn3.jpg') }}" alt="Logo SMKN 3 Bengkalis" class="w-16 h-16 rounded-xl object-cover">
            </div>
            
            <div class="flex items-center justify-center gap-1.5 mb-1">
                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-extrabold tracking-wider bg-sky-100 text-sky-800 uppercase">
                    PRESIS
                </span>
                <span class="text-xs text-slate-400 font-medium">·</span>
                <span class="text-xs font-semibold text-slate-500">SMKN 3 Bengkalis</span>
            </div>

            <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight text-slate-900">
                Sistem Presensi Siswa
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                QR Code Presensi Terenkripsi Dinamis AES-128-CBC
            </p>
        </div>

        <!-- Tab Navigasi Segmented Control (Admin / Guru / Siswa) -->
        <div class="p-1 bg-slate-100/90 rounded-2xl flex items-center gap-1 mb-5 border border-slate-200/60 text-xs">
            <button type="button" id="tab-admin" onclick="switchRole('admin')" 
                    class="flex-1 py-2 px-3 rounded-xl font-bold transition-all duration-200 text-center flex items-center justify-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <span>Admin</span>
            </button>
            <button type="button" id="tab-guru" onclick="switchRole('guru')" 
                    class="flex-1 py-2 px-3 rounded-xl font-bold transition-all duration-200 text-center flex items-center justify-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                </svg>
                <span>Guru</span>
            </button>
            <button type="button" id="tab-siswa" onclick="switchRole('siswa')" 
                    class="flex-1 py-2 px-3 rounded-xl font-bold transition-all duration-200 text-center flex items-center justify-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span>Siswa</span>
            </button>
        </div>

        <!-- Pesan Alert Error -->
        @if (isset($errors) && $errors->has('login_error'))
            <div class="mb-5 p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-medium flex items-start gap-2.5 animate-shake">
                <svg class="w-4 h-4 text-rose-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">{{ $errors->first('login_error') }}</div>
            </div>
        @endif

        <!-- Form Login -->
        <form action="{{ route('login') }}" method="POST" id="loginForm" class="space-y-4">
            @csrf
            <input type="hidden" name="role" id="roleInput" value="{{ old('role', 'admin') }}">

            <!-- Input Login ID -->
            <div>
                <label id="inputLabel" for="loginIdInput" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Email Administrator
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <input type="text" name="login_id" id="loginIdInput" required value="{{ old('login_id') }}"
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 text-sm font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-600 transition-all duration-150 shadow-sm"
                        placeholder="admin@smkn3bengkalis.sch.id" autocomplete="username">
                </div>
            </div>

            <!-- Input Password -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="passwordInput" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Kata Sandi (Password)
                    </label>
                    <button type="button" onclick="togglePasswordVisibility()" class="text-xs text-sky-600 hover:text-sky-700 font-semibold transition-colors">
                        <span id="togglePasswordText">Tampilkan</span>
                    </button>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <input type="password" name="password" id="passwordInput" required
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 text-sm font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-600 transition-all duration-150 shadow-sm"
                        placeholder="••••••••" autocomplete="current-password">
                </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between pt-1">
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded-md border-slate-300 text-sky-600 focus:ring-sky-500/30 transition-all">
                    <span class="text-xs text-slate-600 font-medium">Ingat sesi di perangkat ini</span>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full py-3 px-4 rounded-xl font-bold text-sm text-white bg-gradient-to-r from-sky-600 via-sky-700 to-blue-700 hover:from-sky-700 hover:via-sky-800 hover:to-blue-800 shadow-md shadow-sky-600/25 hover:shadow-lg hover:shadow-sky-600/30 transition-all duration-150 active:scale-[0.99] flex items-center justify-center gap-2">
                <span>Masuk ke Dashboard</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </button>
        </form>

        <!-- Bantuan Akses & Informasi Login Resmi -->
        <div class="mt-6 pt-5 border-t border-slate-100">
            <div class="bg-slate-50 rounded-xl p-3 border border-slate-200/80 text-xs text-slate-600">
                <div class="flex items-center gap-1.5 font-bold text-slate-800 mb-1">
                    <svg class="w-3.5 h-3.5 text-sky-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Pusat Bantuan Autentikasi</span>
                </div>
                <p class="text-[11px] text-slate-500 leading-relaxed">
                    Gunakan kredensial resmi sekolah yang telah terdaftar. Apabila Anda lupa kata sandi atau mengalami kendala akses akun, silakan hubungi <strong class="text-slate-700">Administrator IT SMKN 3 Bengkalis</strong>.
                </p>
            </div>
        </div>

    </div>

    <!-- Script Switching Tab Role -->
    <script>
        function switchRole(role) {
            const roleInput = document.getElementById('roleInput');
            const inputLabel = document.getElementById('inputLabel');
            const loginIdInput = document.getElementById('loginIdInput');

            const tabAdmin = document.getElementById('tab-admin');
            const tabGuru = document.getElementById('tab-guru');
            const tabSiswa = document.getElementById('tab-siswa');

            // Reset tab styles ke inactive
            [tabAdmin, tabGuru, tabSiswa].forEach(tab => {
                tab.className = "flex-1 py-2 px-3 rounded-xl font-semibold text-slate-600 hover:text-slate-900 transition-all duration-150 text-center flex items-center justify-center gap-1.5";
            });

            roleInput.value = role;

            if (role === 'admin') {
                tabAdmin.className = "flex-1 py-2 px-3 rounded-xl font-bold bg-white text-sky-700 shadow-sm transition-all duration-150 text-center flex items-center justify-center gap-1.5";
                inputLabel.innerText = "Email Administrator";
                loginIdInput.placeholder = "admin@smkn3bengkalis.sch.id";
            } else if (role === 'guru') {
                tabGuru.className = "flex-1 py-2 px-3 rounded-xl font-bold bg-white text-sky-700 shadow-sm transition-all duration-150 text-center flex items-center justify-center gap-1.5";
                inputLabel.innerText = "NIP (18 Digit) atau Email Guru";
                loginIdInput.placeholder = "198501012010011002 atau guru@smkn3bengkalis.sch.id";
            } else if (role === 'siswa') {
                tabSiswa.className = "flex-1 py-2 px-3 rounded-xl font-bold bg-white text-emerald-700 shadow-sm transition-all duration-150 text-center flex items-center justify-center gap-1.5";
                inputLabel.innerText = "NISN Siswa (10 Digit)";
                loginIdInput.placeholder = "0109401780";
            }
        }

        // Toggle password visibility
        function togglePasswordVisibility() {
            const pwd = document.getElementById('passwordInput');
            const toggleText = document.getElementById('togglePasswordText');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                toggleText.innerText = 'Sembunyikan';
            } else {
                pwd.type = 'password';
                toggleText.innerText = 'Tampilkan';
            }
        }
        }

        // Set initial tab from old('role')
        document.addEventListener('DOMContentLoaded', () => {
            const initialRole = document.getElementById('roleInput').value || 'admin';
            switchRole(initialRole);
        });

        // Cegah error 419 (Page Expired) akibat browser BFCache
        window.addEventListener('pageshow', function (event) {
            if (event.persisted || (window.performance && window.performance.navigation && window.performance.navigation.type === 2)) {
                window.location.reload();
            }
        });
    </script>
</body>
</html>
