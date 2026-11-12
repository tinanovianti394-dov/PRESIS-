@props(['title' => 'Dashboard', 'role' => 'USER', 'pageTitle' => 'Dashboard'])

<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} — PRESIS SMKN 3 Bengkalis</title>

    {{-- Tailwind CSS via CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'Inter', 'system-ui', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'Fira Code', 'monospace'],
                    },
                    colors: {
                        brand: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
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

    {{-- Google Fonts: Plus Jakarta Sans (Primary UI) & JetBrains Mono (Codes / Numbers) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }

        /* Custom scrollbar halus */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .sidebar-overlay { transition: opacity 0.3s ease; }
        .sidebar-panel { transition: transform 0.3s ease; }
    </style>

    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- ============================================================ -->
    <!-- SIDEBAR MOBILE OVERLAY -->
    <!-- ============================================================ -->
    <div id="sidebarOverlay" class="sidebar-overlay fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 lg:hidden hidden" onclick="toggleSidebar()"></div>

    <!-- ============================================================ -->
    <!-- SIDEBAR -->
    <!-- ============================================================ -->
    <aside id="sidebar" class="sidebar-panel fixed top-0 left-0 z-50 h-full w-64 bg-white border-r border-slate-200/80 transform -translate-x-full lg:translate-x-0 transition-transform flex flex-col shadow-sm">
        
        <!-- Header Logo & Identitas Sekolah -->
        <div class="h-16 flex items-center gap-3 px-5 border-b border-slate-100 bg-white">
            <img src="{{ asset('images/logo-smkn3.jpg') }}" alt="Logo SMKN 3 Bengkalis" class="w-9 h-9 rounded-xl object-cover shadow-sm ring-1 ring-slate-200/80 flex-shrink-0">
            <div class="overflow-hidden">
                <div class="font-extrabold text-base tracking-tight text-slate-900 leading-tight">PRESIS</div>
                <p class="text-[10px] font-semibold text-sky-600 truncate">SMKN 3 Bengkalis</p>
            </div>
        </div>

        <!-- Info Profil User Aktif -->
        <div class="p-4 mx-3 my-3 rounded-2xl bg-slate-50 border border-slate-200/80">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-sky-500 to-blue-600 text-white flex items-center justify-center font-bold text-sm shadow-sm flex-shrink-0">
                    @if(Auth::guard('siswa')->check())
                        {{ strtoupper(substr(Auth::guard('siswa')->user()->nama, 0, 1)) }}
                    @else
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                    @endif
                </div>
                <div class="overflow-hidden flex-1">
                    <p class="text-xs font-bold text-slate-900 truncate">
                        @if(Auth::guard('siswa')->check())
                            {{ Auth::guard('siswa')->user()->nama }}
                        @else
                            {{ Auth::user()->name ?? 'Pengguna' }}
                        @endif
                    </p>
                    <p class="text-[10px] text-slate-500 font-mono truncate mt-0.5">
                        @if(Auth::guard('siswa')->check())
                            NISN: {{ Auth::guard('siswa')->user()->nisn }}
                        @elseif(Auth::user() && Auth::user()->nip)
                            NIP: {{ Auth::user()->nip }}
                        @else
                            {{ Auth::user()->email ?? '' }}
                        @endif
                    </p>
                </div>
            </div>
            <div class="mt-2.5 pt-2 border-t border-slate-200/60 flex items-center justify-between">
                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold bg-sky-100 text-sky-700 uppercase tracking-wide">
                    {{ $role ?? 'USER' }}
                </span>
                <span class="inline-flex items-center gap-1.5 text-[10px] font-medium text-emerald-600 font-mono">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Online
                </span>
            </div>
        </div>

        <!-- Menu Navigasi Sidebar -->
        <nav class="px-3 flex-1 overflow-y-auto space-y-1">
            <p class="px-3.5 pt-2 pb-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Menu Navigasi</p>
            {{ $sidebar }}
        </nav>

        <!-- Footer Sidebar & Logout -->
        <div class="p-3 border-t border-slate-100 bg-white">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl text-xs font-semibold text-rose-600 hover:bg-rose-50 border border-rose-200/60 transition-all duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Keluar Sistem (Logout)</span>
                </button>
            </form>
            <p class="text-[9px] text-slate-400 text-center mt-2">PRESIS v1.0 · SMKN 3 Bengkalis</p>
        </div>
    </aside>

    <!-- ============================================================ -->
    <!-- MAIN CONTENT AREA -->
    <!-- ============================================================ -->
    <div class="lg:ml-64 min-h-screen flex flex-col flex-1">

        <!-- Topbar Modern -->
        <header class="h-16 bg-white/90 backdrop-blur-md border-b border-slate-200/80 px-4 sm:px-6 sticky top-0 z-30 flex items-center justify-between shadow-sm">
            <!-- Mobile Toggle -->
            <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl border border-slate-200 text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <!-- Page Title -->
            <div class="flex items-center gap-3">
                <h1 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">{{ $pageTitle ?? 'Dashboard' }}</h1>
            </div>

            <!-- Date & Profile Pill -->
            <div class="flex items-center gap-3">
                <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-100/80 border border-slate-200/60 text-xs text-slate-600">
                    <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="font-medium">{{ now()->translatedFormat('l, d F Y') }}</span>
                </div>

                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-sky-500 to-blue-600 text-white flex items-center justify-center font-bold text-xs shadow-sm ring-2 ring-sky-100">
                    @if(Auth::guard('siswa')->check())
                        {{ strtoupper(substr(Auth::guard('siswa')->user()->nama, 0, 1)) }}
                    @else
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                    @endif
                </div>
            </div>
        </header>

        <!-- Main Body -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto">
            <!-- Flash Message Alerts -->
            @if(session('success'))
                <div class="mb-5 p-4 rounded-xl bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-sm font-medium flex items-center justify-between shadow-sm animate-fade-in">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-sm font-bold ml-3">✕</button>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-5 p-4 rounded-xl bg-rose-50 border border-rose-200/80 text-rose-800 text-sm font-medium flex items-center justify-between shadow-sm animate-fade-in">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 text-sm font-bold ml-3">✕</button>
                </div>
            @endif

            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="border-t border-slate-200/80 bg-white px-6 py-4 text-center mt-auto">
            <p class="text-xs text-slate-500">
                &copy; {{ date('Y') }} <span class="font-semibold text-slate-700">PRESIS</span> — Sistem Presensi Siswa QR Terenkripsi · 
                <span class="text-sky-600 font-medium">SMK Negeri 3 Bengkalis</span>
            </p>
        </footer>
    </div>

    <!-- Script Sidebar Toggle -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
                overlay.classList.add('hidden');
            }
        }
    </script>

    @stack('scripts')
</body>
</html>
