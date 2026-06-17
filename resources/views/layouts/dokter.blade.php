<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dokter Dashboard') | Maxilla Dental Care</title>
    <!-- Tailwind CSS & Alpine.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'], heading: ['Poppins', 'sans-serif'] },
                    colors: { primary: '#2563eb', secondary: '#1e293b', surface: '#f8fafc' }
                }
            }
        }
    </script>
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-white text-slate-800 font-sans antialiased h-screen flex overflow-hidden"
    x-data="{ sidebarOpen: false, showLogoutConfirm: false }">

    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" x-cloak class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm md:hidden"
        @click="sidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
    </div>

    <!-- Sidebar -->
    <aside
        class="fixed inset-y-0 left-0 z-50 w-64 bg-blue-100 border-r border-blue-200 transform transition-transform duration-300 ease-in-out md:relative md:translate-x-0 flex flex-col"
        :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">

        <!-- Sidebar Header / Logo -->
        <div class="h-16 flex items-center px-6 border-b border-blue-200/60 shrink-0 bg-white/40 backdrop-blur-md">
            <div class="flex items-center gap-3">
                <div class="p-1.5 bg-white rounded-xl shadow-sm border border-blue-100">
                    <img src="{{ asset('image/logo-maxilla.png') }}" alt="Logo" class="h-6 w-auto">
                </div>
                <span class="font-heading font-black text-lg text-slate-800 tracking-tight">Maxilla<span
                        class="text-blue-600">Dokter</span></span>
            </div>
            <!-- Close Sidebar Button (Mobile) -->
            <button @click="sidebarOpen = false" class="md:hidden ml-auto text-slate-500 hover:text-slate-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Sidebar Navigation -->
        <div class="flex-1 overflow-y-auto custom-scrollbar py-6 px-4 space-y-1.5">
            <p class="px-2 text-xs font-black text-blue-400 uppercase tracking-wider mb-2">Menu Utama</p>

            <a href="{{ route('dokter.dashboard') }}"
                class="{{ request()->is('dokter/dashboard') ? 'bg-white text-blue-700 shadow-sm border border-blue-200/50' : 'text-slate-600 hover:bg-white/60 hover:text-blue-700' }} group flex items-center px-3 py-3 text-sm font-bold rounded-xl transition-all duration-200">
                <div
                    class="{{ request()->is('dokter/dashboard') ? 'bg-blue-100 text-blue-600' : 'bg-transparent text-slate-500 group-hover:text-blue-500 group-hover:bg-white' }} p-1.5 rounded-lg mr-3 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                </div>
                Dashboard
            </a>

            <a href="{{ route('dokter.jadwal') }}"
                class="{{ request()->is('dokter/jadwal*') ? 'bg-white text-blue-700 shadow-sm border border-blue-200/50' : 'text-slate-600 hover:bg-white/60 hover:text-blue-700' }} group flex items-center px-3 py-3 text-sm font-bold rounded-xl transition-all duration-200">
                <div
                    class="{{ request()->is('dokter/jadwal*') ? 'bg-blue-100 text-blue-600' : 'bg-transparent text-slate-500 group-hover:text-blue-500 group-hover:bg-white' }} p-1.5 rounded-lg mr-3 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                Jadwal Praktik
            </a>

            <p class="px-3 text-[10px] font-black text-slate-400 uppercase tracking-widest mt-6 mb-2">Pemeriksaan</p>

            <a href="{{ route('dokter.antrian') }}"
                class="{{ request()->is('dokter/antrian*') || request()->is('dokter/rekam-medis*') ? 'bg-white text-blue-700 shadow-sm border border-blue-200/50' : 'text-slate-600 hover:bg-white/60 hover:text-blue-700' }} group flex items-center px-3 py-3 text-sm font-bold rounded-xl transition-all duration-200">
                <div
                    class="{{ request()->is('dokter/antrian*') || request()->is('dokter/rekam-medis*') ? 'bg-emerald-100 text-emerald-600' : 'bg-transparent text-slate-500 group-hover:text-emerald-500 group-hover:bg-white' }} p-1.5 rounded-lg mr-3 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
                Antrian Pasien
            </a>

            <a href="{{ route('dokter.riwayat') }}"
                class="{{ request()->is('dokter/riwayat*') ? 'bg-white text-blue-700 shadow-sm border border-blue-200' : 'text-slate-600 hover:bg-white/60 hover:text-blue-700' }} group flex items-center px-3 py-3 text-sm font-bold rounded-xl transition-all duration-200">
                <div
                    class="{{ request()->is('dokter/riwayat*') ? 'bg-blue-100 text-blue-600' : 'bg-transparent text-slate-500 group-hover:text-blue-500 group-hover:bg-white' }} p-1.5 rounded-lg mr-3 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                </div>
                Riwayat Pemeriksaan
            </a>
        </div>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-blue-200 bg-white/30">
            <div class="flex items-center gap-3">
                @if(auth()->user()->foto)
                    <img src="{{ Storage::url(auth()->user()->foto) }}" alt="Foto Profil" class="h-10 w-10 rounded-full object-cover shadow-md shrink-0 border border-blue-200">
                @else
                    <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center text-white font-bold shadow-md shrink-0">
                        {{ substr(auth()->user()->nama ?? 'D', 0, 1) }}
                    </div>
                @endif
                <div class="overflow-hidden">
                    <p class="text-sm font-bold text-slate-800 truncate">{{ auth()->user()->nama ?? 'Dokter' }}</p>
                    <p class="text-[11px] font-bold text-blue-500 uppercase truncate">
                        {{ auth()->user()->cabang ? 'Cabang ' . auth()->user()->cabang : 'Maxilla Dokter' }}
                    </p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col min-w-0 bg-white">
        <!-- Top Header -->
        <header
            class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 z-30 shrink-0">
            <!-- Mobile Menu Button -->
            <div class="flex items-center">
                <button @click="sidebarOpen = true"
                    class="md:hidden text-slate-500 hover:text-slate-800 focus:outline-none p-2 -ml-2 rounded-lg hover:bg-slate-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Right Side (Notifications & Profile) -->
            <div class="flex items-center gap-2">
                @include('components.notification-bell')

                <div class="h-6 w-px bg-slate-200 mx-2"></div>

                <!-- Profile Dropdown (Alpine) -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false" type="button"
                        class="flex items-center gap-3 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 p-1 pr-3 hover:bg-slate-100 transition-colors border border-transparent hover:border-slate-200">
                        @if(auth()->user()->foto)
                            <img src="{{ Storage::url(auth()->user()->foto) }}" alt="Foto Profil" class="h-8 w-8 rounded-full object-cover shadow-sm border border-slate-200">
                        @else
                            <div class="h-8 w-8 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center text-white font-bold shadow-sm">
                                {{ substr(auth()->user()->nama ?? 'D', 0, 1) }}
                            </div>
                        @endif
                        <div class="hidden sm:block text-left">
                            <p class="text-sm font-bold text-slate-800 leading-none">
                                {{ auth()->user()->nama ?? 'Dokter' }}
                            </p>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 z-50 mt-2 w-48 origin-top-right rounded-xl bg-white py-1 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.1)] ring-1 ring-black ring-opacity-5 focus:outline-none border border-slate-100">

                        <div class="px-4 py-3 border-b border-slate-100 sm:hidden">
                            <p class="text-sm font-bold text-slate-800">{{ auth()->user()->nama ?? 'Dokter' }}</p>
                            <p class="text-[11px] text-slate-500 truncate">{{ auth()->user()->email }}</p>
                        </div>

                        <a href="{{ route('dokter.profil') }}"
                            class="block px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-blue-600 font-bold transition-colors">Pengaturan
                            Profil</a>
                        <div class="h-px bg-slate-100 my-1"></div>
                        <form x-ref="logoutForm" action="{{ route('logout') }}" method="POST" class="w-full">
                            @csrf
                            <button type="button" @click="showLogoutConfirm = true"
                                class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-bold transition-colors">Keluar
                                Aplikasi</button>
                        
<!-- Modal Konfirmasi Logout -->
<template x-teleport="body">
    <div x-show="showLogoutConfirm" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
        style="display: none;">

        <div @click.away="showLogoutConfirm = false" x-show="showLogoutConfirm"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="bg-white rounded-3xl p-8 max-w-sm w-full shadow-2xl border border-slate-100 text-center relative overflow-hidden">

            <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
            </div>

            <h3 class="font-bold text-xl text-slate-800 mb-3">Konfirmasi Logout</h3>
            <p class="text-slate-500 text-sm mb-8 leading-relaxed">Apakah Anda yakin ingin keluar dari aplikasi?</p>

            <div class="grid grid-cols-2 gap-4">
                <button @click="showLogoutConfirm = false" type="button" class="px-6 py-3 rounded-2xl text-sm font-bold text-slate-500 bg-slate-100 hover:bg-slate-200 transition-colors">
                    Batal
                </button>
                <button type="button" @click="$refs.logoutForm.submit()" class="px-6 py-3 rounded-2xl text-sm font-bold text-white bg-red-500 hover:bg-red-600 transition-all shadow-lg shadow-red-100">
                    Ya, Keluar
                </button>
            </div>
        </div>
    </div>
</template>
</form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Scrollable Content Area -->
        <main class="flex-1 overflow-y-auto custom-scrollbar p-4 sm:p-6 lg:p-8 bg-white">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>

</html>