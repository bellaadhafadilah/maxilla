<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') | Maxilla Dental Care</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Arial', 'Helvetica', 'sans-serif'] },
                    colors: { primary: '#2563eb', secondary: '#1e293b', surface: '#f8fafc' }
                }
            }
        }
    </script>
</head>

<body class="bg-white text-slate-800 font-sans antialiased" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        <!-- OVERLAY (mobile) -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black/30 md:hidden"
            style="display:none;"></div>

        <!-- SIDEBAR -->
        <aside
            class="fixed inset-y-0 left-0 z-50 w-64 bg-blue-50 border-r border-blue-100 transform transition-transform duration-300 ease-in-out md:relative md:translate-x-0 flex flex-col"
            :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">

            <!-- Logo -->
            <div class="px-5 py-5 border-b border-blue-100">
                <div class="flex items-center gap-3">
                    <div class="p-1.5 bg-blue-100 rounded-xl border border-blue-200">
                        <img src="{{ asset('image/logo-maxilla.png') }}" alt="Logo" class="h-6 w-auto">
                    </div>
                    <span class="font-black text-lg text-slate-800 tracking-tight">
                        Maxilla<span class="text-blue-600">Admin</span>
                    </span>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto px-3 py-4 flex flex-col gap-0.5">
                <p class="text-[10px] font-extrabold text-blue-300 uppercase tracking-widest px-2 pb-2">Menu Utama</p>

                <a href="{{ route('admin.dashboard') }}"
                    class="{{ request()->is('admin/dashboard') ? 'bg-blue-200 text-blue-900' : 'text-slate-500 hover:bg-blue-100 hover:text-blue-800' }} flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-bold transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.booking.index') }}"
                    class="{{ request()->is('admin/booking') ? 'bg-blue-200 text-blue-900' : 'text-slate-500 hover:bg-blue-100 hover:text-blue-800' }} flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-bold transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Booking & Antrian
                </a>

                <a href="{{ route('admin.booking.riwayat') }}"
                    class="{{ request()->is('admin/riwayat') ? 'bg-blue-200 text-blue-900' : 'text-slate-500 hover:bg-blue-100 hover:text-blue-800' }} flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-bold transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Riwayat Reservasi
                </a>

                <a href="{{ route('admin.jadwal.index') }}"
                    class="{{ request()->is('admin/jadwal-dokter*') ? 'bg-blue-200 text-blue-900' : 'text-slate-500 hover:bg-blue-100 hover:text-blue-800' }} flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-bold transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Jadwal Shift Dokter
                </a>
            </nav>

            <!-- User Profile (Bottom) -->
            <div class="px-4 py-4 border-t border-blue-100 flex items-center gap-3">
                <div
                    class="h-9 w-9 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center text-white font-bold text-sm shadow shrink-0">
                    {{ substr(auth()->user()->nama ?? 'A', 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-slate-800 truncate">{{ auth()->user()->nama ?? 'Admin' }}</p>
                    <p class="text-[10px] font-bold text-blue-500 uppercase">
                        {{ auth()->user()->cabang ? 'Cabang ' . auth()->user()->cabang : 'Admin Cabang' }}
                    </p>
                </div>
                <form action="{{ route('logout') }}" method="POST" x-data="{ showLogoutConfirm: false }" x-ref="logoutForm">
                    @csrf
                    <button type="button" @click="showLogoutConfirm = true" title="Keluar"
                        class="p-1.5 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                
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
        </aside>

        <!-- MAIN AREA -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Top Header (slim, hanya notif & toggle mobile) -->
            <header
                class="bg-white border-b border-slate-200 h-14 flex items-center justify-between px-6 shrink-0 shadow-sm">
                <div class="flex items-center gap-3">
                    <!-- Hamburger (mobile only) -->
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="md:hidden p-1.5 rounded-lg text-slate-500 hover:bg-slate-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <span class="text-sm font-extrabold text-slate-700">@yield('title', 'Dashboard')</span>
                </div>

                <div class="flex items-center gap-3">
                    @include('components.notification-bell')
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6 bg-white">
                @yield('content')
            </main>
        </div>

    </div>

    @stack('scripts')
</body>

</html>