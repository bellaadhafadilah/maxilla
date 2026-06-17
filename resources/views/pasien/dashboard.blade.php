<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pasien | Maxilla Dental Care</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: '#0ea5e9', // Sky 500
                        secondary: '#0f172a', // Slate 900
                        surface: '#f8fafc', // Slate 50
                    }
                }
            }
        }
    </script>
</head>

<body class="font-sans antialiased text-slate-800 bg-white min-h-screen flex flex-col">

    <!-- TOP NAVIGATION BAR (No Sidebar) -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo & Brand -->
                <div class="flex items-center gap-3">
                    <img src="{{ asset('image/logo-maxilla.png') }}" alt="Logo" class="h-8 w-auto">
                    <span class="font-heading font-bold text-xl tracking-tight text-secondary">Maxilla <span
                            class="text-primary hidden sm:inline">Dental Care</span></span>
                </div>

                <!-- Desktop Menu -->
                <nav class="hidden md:flex items-center gap-8">
                    <a href="/pasien/dashboard"
                        class="text-sm font-bold text-primary border-b-2 border-primary py-7">Beranda</a>
                    <a href="/pasien/riwayat"
                        class="text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors py-7">Riwayat
                        Reservasi</a>
                    <a href="/pasien/bantuan"
                        class="text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors py-7">Bantuan</a>
                </nav>

                <!-- Profile Dropdown & Mobile Menu Button -->
                <div class="flex items-center gap-4">
                    <a href="/pasien/buat-janji"
                        class="hidden md:inline-flex items-center justify-center px-4 py-2 rounded-xl text-sm font-bold text-white bg-primary hover:bg-blue-600 transition-colors shadow-[0_4px_10px_rgb(14,165,233,0.3)]">
                        Buat Reservasi
                    </a>

                    @include('components.notification-bell')

                    <!-- Profile Dropdown (Alpine) -->
                    <div class="relative" x-data="{ userMenuOpen: false }">
                        <button @click="userMenuOpen = !userMenuOpen" @click.away="userMenuOpen = false"
                            class="flex items-center gap-2 lg:gap-3 hover:opacity-80 transition-opacity focus:outline-none">
                            <div class="hidden sm:block text-right">
                                <p class="text-sm font-bold text-slate-800">{{ auth()->user()->nama ?? 'Pasien' }}</p>
                                <p class="text-[11px] text-slate-500 font-medium">Pasien Terdaftar</p>
                            </div>
                            @if(auth()->user()->foto)
                                <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Profil"
                                    class="w-10 h-10 rounded-full object-cover border border-blue-200 shadow-sm">
                            @else
                                <div
                                    class="w-10 h-10 rounded-full bg-blue-100 border border-blue-200 flex items-center justify-center text-primary font-heading font-bold overflow-hidden shadow-sm">
                                    {{ substr(auth()->user()->nama ?? 'P', 0, 1) }}
                                </div>
                            @endif
                            <svg class="hidden sm:block w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="userMenuOpen" x-transition.origin.top.right
                            class="absolute right-0 mt-3 w-48 bg-white rounded-xl shadow-lg border border-slate-100 py-2 z-50"
                            style="display: none;">
                            <div class="px-4 py-2 border-b border-slate-100 sm:hidden">
                                <p class="text-sm font-bold text-slate-800">{{ auth()->user()->nama ?? 'Pasien' }}</p>
                                <p class="text-xs text-primary font-medium">Pasien Terdaftar</p>
                            </div>
                            <a href="/pasien/profil/lengkapi"
                                class="block px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-primary transition-colors">Profil
                                Saya</a>
                            <div class="border-t border-slate-100 my-1"></div>
                            <form action="{{ route('logout') }}" method="POST" x-data="{ showLogoutConfirm: false }" x-ref="logoutForm">
                                @csrf
                                <button type="button" @click="showLogoutConfirm = true"
                                    class="w-full text-left block px-4 py-2 text-sm font-bold text-red-500 hover:bg-red-50 transition-colors">
                                    Keluar Aplikasi
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
                    </div>
                </div>
            </div>
        </div>
    </header>

    @if(empty(auth()->user()->pasien->alamat) || empty(auth()->user()->pasien->tanggal_lahir))
        <!-- PENGUMUMAN / ALERT -->
        <div class="bg-blue-600 text-white border-b border-blue-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="flex h-6 w-6 rounded-full bg-white/20 items-center justify-center shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </span>
                    <p class="text-sm font-medium">Lengkapi profil medis Anda untuk mempercepat proses pendaftaran di
                        klinik.</p>
                </div>
                <a href="/pasien/profil/lengkapi"
                    class="hidden sm:inline-block text-xs font-bold text-blue-100 hover:text-white underline underline-offset-2">Lengkapi
                    Sekarang</a>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl relative flex items-start gap-3 shadow-sm"
                role="alert">
                <svg class="w-5 h-5 text-green-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <span class="block font-bold text-sm">Berhasil!</span>
                    <span class="block text-sm text-green-600 mt-0.5">{{ session('success') }}</span>
                </div>
            </div>
        </div>
    @endif

    <!-- MAIN DASHBOARD CONTENT -->
    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">

        <!-- Welcome Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div>
                <h1 class="font-heading text-3xl md:text-4xl font-bold text-secondary mb-2">Halo,
                    {{ auth()->user()->nama ?? 'Pasien' }}!</h1>
                <p class="text-slate-500 text-lg">Bagaimana perasaan gigi dan mulut Anda hari ini?</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Left Column: Upcoming & Features -->
            <div class="lg:col-span-2 space-y-8">

                <!-- Upcoming Appointment Card -->
                @forelse($reservasiAktif as $latestReservasi)
                    <div
                        class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden mb-6">
                        <div
                            class="absolute top-0 right-0 w-64 h-64 bg-slate-50 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none">
                        </div>

                        <div class="flex items-center justify-between mb-6 relative z-10">
                            <h2 class="font-heading text-xl font-bold text-slate-800">Jadwal Anda Berikutnya</h2>
                            <span
                                class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded-full">{{ $latestReservasi->status }}</span>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-center gap-6 relative z-10">
                            <!-- Date Badge -->
                            <div
                                class="w-24 h-24 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col items-center justify-center shrink-0 shadow-sm">
                                <span
                                    class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">{{ \Carbon\Carbon::parse($latestReservasi->tanggal)->locale('id')->translatedFormat('M') }}</span>
                                <span
                                    class="font-heading text-3xl font-black text-primary">{{ \Carbon\Carbon::parse($latestReservasi->tanggal)->format('d') }}</span>
                            </div>

                            <!-- Details -->
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-slate-800 mb-1">
                                    {{ $latestReservasi->nama_pasien ?? 'Pemeriksaan Gigi Rutin' }}
                                    @if($latestReservasi->hubungan && $latestReservasi->hubungan !== 'Diri Sendiri')
                                        <span
                                            class="text-xs font-medium text-primary bg-blue-50 px-2 py-0.5 rounded-full">({{ $latestReservasi->hubungan }})</span>
                                    @endif
                                </h3>
                                <p class="text-xs text-slate-500 mb-2 italic">Keluhan:
                                    {{ $latestReservasi->keluhan ?: '-' }}</p>
                                <div class="flex items-center gap-4 text-sm text-slate-500 mt-3">
                                    <div class="flex items-center gap-1.5 border-r border-slate-200 pr-4">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Sesi {{ $latestReservasi->jam }}
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                            </path>
                                        </svg>
                                        Cabang {{ $latestReservasi->cabang }}
                                    </div>
                                </div>
                                <div class="mt-4 space-y-3">
                                    <span
                                        class="inline-flex items-center gap-2 text-xs font-bold bg-slate-50 text-slate-600 px-3 py-1.5 rounded-lg border border-slate-200">
                                        <img src="{{ asset('image/dokter-1.png') }}"
                                            onerror="this.src='https://ui-avatars.com/api/?name=' + encodeURIComponent('{{ $latestReservasi->dokter_nama }}') + '&background=random'"
                                            class="w-5 h-5 rounded-full" alt="Drg">
                                        {{ $latestReservasi->dokter_nama }}
                                    </span>
                                    
                                    <div class="bg-blue-50/50 border border-blue-100 rounded-xl p-3 flex flex-col sm:flex-row gap-3 sm:gap-6 items-start sm:items-center max-w-max">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-black text-lg shadow-sm shadow-blue-200/50">
                                                {{ $latestReservasi->antrian }}
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-[10px] font-black text-blue-400 uppercase tracking-widest leading-tight">Nomor</span>
                                                <span class="text-sm font-bold text-blue-700 leading-tight">Antrean</span>
                                            </div>
                                        </div>
                                        
                                        <div class="hidden sm:block w-px h-8 bg-blue-200/50"></div>

                                        @if($latestReservasi->menunggu > 0)
                                        <div class="flex flex-col gap-1">
                                            <span class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Tunggu: {{ $latestReservasi->estimasiWaktuMin }} - {{ $latestReservasi->estimasiWaktuMax }} Mnt
                                            </span>
                                            <span class="text-[11px] font-semibold text-slate-500 flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                Diperiksa Pukul: {{ $latestReservasi->estimasiJamDiperiksaMin }} - {{ $latestReservasi->estimasiJamDiperiksaMax }} WIB
                                            </span>
                                        </div>
                                        @elseif($latestReservasi->menunggu == 0)
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-emerald-600 flex items-center gap-1.5">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Giliran Selanjutnya!
                                            </span>
                                            <span class="text-[11px] font-medium text-emerald-500">Silakan bersiap menuju ruang periksa.</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex flex-row sm:flex-col gap-2 shrink-0 w-full sm:w-auto mt-4 sm:mt-0"
                                x-data="{ showCancelModal: false }">
                                <a href="/pasien/buat-janji?reschedule={{ $latestReservasi->id_reservasi }}"
                                    class="flex-1 sm:flex-none px-4 py-2 bg-slate-100 text-slate-700 text-sm font-bold rounded-xl hover:bg-slate-200 transition-colors border border-slate-200 text-center">
                                    Jadwal Ulang
                                </a>
                                <button @click="showCancelModal = true" type="button"
                                    class="flex-1 sm:flex-none px-4 py-2 bg-red-50 text-red-600 text-sm font-bold rounded-xl hover:bg-red-100 hover:text-red-700 transition-colors border border-red-100 text-center">
                                    Batalkan
                                </button>

                                <!-- Modal Konfirmasi Batal -->
                                <template x-teleport="body">
                                    <div x-show="showCancelModal" x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                        x-transition:leave="transition ease-in duration-200"
                                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                        class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                                        style="display: none;">

                                        <div @click.away="showCancelModal = false" x-show="showCancelModal"
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                            x-transition:leave="transition ease-in duration-200"
                                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                                            class="bg-white rounded-3xl p-8 max-w-sm w-full shadow-2xl border border-slate-100 text-center relative overflow-hidden">

                                            <!-- Warning Icon -->
                                            <div
                                                class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                                                <svg class="w-10 h-10" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                                    </path>
                                                </svg>
                                            </div>

                                            <h3 class="font-heading text-xl font-bold text-slate-800 mb-3">Batalkan
                                                Reservasi?</h3>
                                            <p class="text-slate-500 text-sm mb-8 leading-relaxed">Apakah Anda yakin ingin
                                                membatalkan jadwal ini? Tindakan ini tidak dapat dibatalkan.</p>

                                            <div class="grid grid-cols-2 gap-4">
                                                <button @click="showCancelModal = false" type="button"
                                                    class="px-6 py-3 rounded-2xl text-sm font-bold text-slate-500 bg-slate-100 hover:bg-slate-200 transition-colors uppercase tracking-wider">
                                                    Tidak, Kembali
                                                </button>
                                                <form
                                                    action="{{ route('pasien.reservasi.batal', $latestReservasi->id_reservasi) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="w-full px-6 py-3 rounded-2xl text-sm font-bold text-white bg-red-500 hover:bg-red-600 transition-all shadow-lg shadow-red-100 uppercase tracking-wider">
                                                        Ya, Batalkan
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] text-center mb-6">
                        <img src="{{ asset('image/illust-empty.svg') }}" onerror="this.style.display='none'"
                            class="w-32 h-32 mx-auto mb-4 opacity-50">
                        <h2 class="font-heading text-xl font-bold text-slate-800 mb-2">Belum Ada Jadwal Reservasi</h2>
                        <p class="text-slate-500 mb-6">Anda belum memiliki jadwal reservasi dokter gigi terdekat.</p>
                        <a href="/pasien/buat-janji"
                            class="inline-flex items-center justify-center px-6 py-3 rounded-xl text-sm font-bold text-white bg-primary hover:bg-blue-600 transition-colors shadow-[0_4px_10px_rgb(14,165,233,0.3)]">
                            Buat Reservasi Sekarang
                        </a>
                    </div>
                @endforelse

                <!-- Riwayat & Dokumen -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-heading text-lg font-bold text-slate-800">Riwayat Perawatan Terakhir</h2>
                        <a href="/pasien/riwayat"
                            class="text-sm font-bold text-primary hover:text-blue-700 transition-colors">Lihat Semua</a>
                    </div>

                    <div
                        class="bg-white rounded-3xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
                        @forelse($riwayats as $riwayat)
                            <!-- Item -->
                            <div
                                class="p-5 sm:p-6 {{ !$loop->last ? 'border-b border-slate-100' : '' }} hover:bg-slate-50 transition-colors flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="flex items-start sm:items-center gap-4">
                                    <div
                                        class="w-12 h-12 rounded-xl bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800">
                                            {{ $riwayat->nama_pasien ?? 'Pemeriksaan Gigi Rutin' }}
                                            @if($riwayat->hubungan && $riwayat->hubungan !== 'Diri Sendiri')
                                                <span
                                                    class="text-[10px] font-medium bg-slate-100 text-slate-500 px-1.5 py-0.5 rounded ml-1">({{ $riwayat->hubungan }})</span>
                                            @endif
                                        </h4>
                                        <p class="text-[10px] text-slate-400 italic mb-1">Keluhan:
                                            {{ $riwayat->keluhan ?: '-' }}</p>
                                        <p class="text-xs font-medium text-slate-500 mt-0.5">
                                            {{ \Carbon\Carbon::parse($riwayat->tanggal)->locale('id')->translatedFormat('d M Y') }}
                                            • Cabang {{ $riwayat->cabang }} • {{ $riwayat->dokter_nama }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="flex flex-col items-end gap-1">
                                        <span
                                            class="px-2.5 py-1 bg-green-50 border border-green-200 text-green-700 text-[10px] font-black uppercase tracking-wider rounded-md">Selesai</span>
                                        <a href="/pasien/buat-janji?copy_from={{ $riwayat->id_reservasi }}"
                                            class="text-[9px] font-black text-primary hover:text-blue-700 uppercase tracking-widest flex items-center gap-0.5 group">
                                            Booking Lagi
                                            <svg class="w-2.5 h-2.5 group-hover:translate-x-0.5 transition-transform"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                            </svg>
                                        </a>
                                    </div>
                                    <button class="p-2 text-slate-400 hover:text-primary transition-colors"><svg
                                            class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg></button>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-slate-500 text-sm">
                                Belum ada riwayat perawatan selesai saat ini.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- Right Column: Info & Widgets -->
            <div class="space-y-6">
                <!-- User Profile Mini -->
                <div
                    class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl p-6 text-white shadow-xl relative overflow-hidden">
                    <!-- Decor -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full blur-2xl -mr-10 -mt-10"></div>

                    <div class="flex flex-col items-center text-center relative z-10 mb-6 mt-2">
                        <div
                            class="w-20 h-20 rounded-2xl bg-slate-700/50 border border-slate-600/50 flex items-center justify-center text-3xl font-heading font-bold mb-4 shadow-inner overflow-hidden">
                            @if(auth()->user()->foto)
                                <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Profil"
                                    class="w-full h-full object-cover">
                            @else
                                {{ substr(auth()->user()->nama ?? 'P', 0, 1) }}
                            @endif
                        </div>
                        <h3 class="text-xl font-bold">{{ auth()->user()->nama ?? 'Pasien Maxilla' }}</h3>
                        <p class="text-sm text-slate-400 mt-1">ID:
                            #MXL-{{ str_pad(auth()->user()->id_user ?? 1, 4, '0', STR_PAD_LEFT) }}</p>
                    </div>

                    <div class="bg-slate-800/80 rounded-2xl p-4 border border-slate-700/50">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs font-medium text-slate-400">Total Kunjungan</span>
                            <span class="text-sm font-bold text-white">{{ $totalKunjungan }} Kali</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-medium text-slate-400">Status Keaktifan</span>
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-400">
                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span> Aktif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Call to Action Widget -->
                <div class="bg-blue-50 rounded-3xl p-6 border border-blue-100 flex flex-col items-center text-center">
                    <div class="w-14 h-14 rounded-full bg-blue-100 text-primary flex items-center justify-center mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-800 mb-2">Butuh Bantuan Darurat?</h3>
                    <p class="text-sm text-slate-600 mb-5 leading-relaxed">Hubungi resepsionis kami untuk penanganan
                        darurat sakit gigi atau konsultasi kilat.</p>
                    <a href="/pasien/bantuan"
                        class="w-full py-2.5 rounded-xl text-sm font-bold text-primary bg-white border border-blue-200 hover:bg-blue-50 hover:border-blue-300 transition-colors shadow-sm block text-center">
                        Hubungi via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="mt-auto border-t border-slate-200 bg-white">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="text-sm text-slate-500 font-medium">© 2026 Maxilla Dental Care. Seluruh Hak Cipta Dilindungi.</p>
            <div class="flex items-center gap-4 text-sm font-medium text-slate-400">
                <a href="#" class="hover:text-primary transition-colors">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-primary transition-colors">Privasi</a>
            </div>
        </div>
    </footer>

</body>

</html>