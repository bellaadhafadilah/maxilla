<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Reservasi | Maxilla Dental Care</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Inter'], heading: ['Poppins'] }, colors: { primary: '#0ea5e9', secondary: '#0f172a' } } }
        }
    </script>
</head>

<body class="font-sans antialiased text-slate-800 bg-white min-h-screen flex flex-col">

    <!-- TOP NAVIGATION BAR (ORIGINAL) -->
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
                        class="text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors py-7">Beranda</a>
                    <a href="/pasien/riwayat"
                        class="text-sm font-bold text-primary border-b-2 border-primary py-7">Riwayat
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
                            <form action="{{ route('logout') }}" method="POST" x-data="{ showLogoutConfirm: false }"
                                x-ref="logoutForm">
                                @csrf
                                <button type="button" @click="showLogoutConfirm = true"
                                    class="w-full text-left block px-4 py-2 text-sm font-bold text-red-500 hover:bg-red-50 transition-colors">
                                    Keluar Aplikasi
                                </button>
                                <!-- Modal Konfirmasi Logout -->
                                <template x-teleport="body">
                                    <div x-show="showLogoutConfirm"
                                        x-transition:enter="transition ease-out duration-300"
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

                                            <div
                                                class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                                                <svg class="w-10 h-10" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                                    </path>
                                                </svg>
                                            </div>

                                            <h3 class="font-bold text-xl text-slate-800 mb-3">Konfirmasi Logout</h3>
                                            <p class="text-slate-500 text-sm mb-8 leading-relaxed">Apakah Anda yakin
                                                ingin keluar dari aplikasi?</p>

                                            <div class="grid grid-cols-2 gap-4">
                                                <button @click="showLogoutConfirm = false" type="button"
                                                    class="px-6 py-3 rounded-2xl text-sm font-bold text-slate-500 bg-slate-100 hover:bg-slate-200 transition-colors">
                                                    Batal
                                                </button>
                                                <button type="button" @click="$refs.logoutForm.submit()"
                                                    class="px-6 py-3 rounded-2xl text-sm font-bold text-white bg-red-500 hover:bg-red-600 transition-all shadow-lg shadow-red-100">
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

    <!-- CONTENT (REFINED & COMPACT) -->
    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        <!-- <div class="mb-10">
            <h1 class="font-heading text-3xl font-bold text-secondary mb-1">Riwayat Reservasi</h1>
            <p class="text-slate-500">Catatan historis perawatan medis Anda di Maxilla Dental Care.</p>
        </div> -->

        <div class="space-y-4">
            @forelse($riwayats as $riwayat)
                <div
                    class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all p-5 md:px-8">
                    <div class="flex flex-col md:flex-row items-center gap-6">
                        <!-- Date Section (Compact) -->
                        <div
                            class="flex md:flex-col items-center md:items-start min-w-[120px] shrink-0 border-b md:border-b-0 md:border-r border-slate-100 pb-4 md:pb-0 md:pr-6 w-full md:w-auto">
                            <div
                                class="bg-blue-50 text-primary px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider mb-1 hidden md:block">
                                Jadwal</div>
                            <p class="font-black text-slate-800 text-lg">
                                {{ \Carbon\Carbon::parse($riwayat->tanggal)->locale('id')->translatedFormat('d M Y') }}
                            </p>
                            <p class="text-xs font-bold text-slate-500">Sesi {{ $riwayat->jam }}</p>
                        </div>

                        <!-- Service Detail (Compact) -->
                        <div class="flex-1 flex items-center gap-4 w-full">
                            <div
                                class="w-10 h-10 rounded-xl bg-slate-50 text-primary flex items-center justify-center shrink-0 border border-slate-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-slate-800 text-sm md:text-base">
                                    {{ $riwayat->nama_pasien ?? 'Layanan Perawatan Gigi' }}
                                    @if($riwayat->hubungan && $riwayat->hubungan !== 'Diri Sendiri')
                                        <span
                                            class="text-[10px] font-medium bg-slate-100 text-slate-500 px-1.5 py-0.5 rounded ml-1">({{ $riwayat->hubungan }})</span>
                                    @endif
                                </h4>
                                <p class="text-xs md:text-sm text-slate-500 line-clamp-1">Keluhan:
                                    {{ $riwayat->keluhan ?: '-' }}
                                </p>
                            </div>
                        </div>

                        <!-- Doctor Section (Compact) -->
                        <div class="flex flex-col text-xs md:text-sm min-w-[180px] w-full md:w-auto">
                            <span class="font-bold text-slate-700">{{ $riwayat->dokter_nama }}</span>
                            <span class="text-slate-400">Cabang {{ $riwayat->cabang }}</span>
                        </div>

                        <!-- Status Section (Compact) -->
                        <div class="min-w-[110px] flex justify-end w-full md:w-auto">
                            @if($riwayat->status === 'Selesai')
                                <div class="flex flex-col items-end gap-2">
                                    <span
                                        class="px-3 py-1 bg-green-50 text-green-700 text-[10px] font-black uppercase tracking-wider rounded-lg border border-green-100">Selesai</span>
                                    <a href="/pasien/buat-janji?cabang={{ $riwayat->cabang }}&dokter={{ $riwayat->dokter_nama }}"
                                        class="text-[10px] font-black text-primary hover:text-blue-700 uppercase tracking-widest flex items-center gap-1 group">
                                        Booking Lagi
                                        <svg class="w-3 h-3 group-hover:translate-x-0.5 transition-transform" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                    </a>
                                </div>
                            @elseif($riwayat->status === 'Dibatalkan')
                                <span
                                    class="px-3 py-1 bg-red-50 text-red-700 text-[10px] font-black uppercase tracking-wider rounded-lg border border-red-100">Batal</span>
                            @else
                                @php
                                    $tanggalReservasi = \Carbon\Carbon::parse($riwayat->tanggal);
                                    $isToday = $tanggalReservasi->isToday();
                                    $isPast = $tanggalReservasi->isPast() && !$isToday;
                                @endphp

                                @if($isToday && strtolower($riwayat->status) === 'menunggu')
                                    <button onclick="handleCheckIn(this, {{ $riwayat->id_reservasi }}, '{{ $riwayat->cabang }}')"
                                        class="w-full md:w-auto px-5 py-2 bg-primary hover:bg-blue-600 text-white text-[10px] font-black uppercase tracking-widest rounded-xl shadow-sm transition-all active:scale-95">
                                        Check-In
                                    </button>
                                @elseif($isPast && strtolower($riwayat->status) === 'menunggu')
                                    <span
                                        class="px-3 py-1 bg-slate-100 text-slate-400 text-[10px] font-black uppercase tracking-wider rounded-lg border border-slate-200">Kedaluwarsa</span>
                                @else
                                    <span
                                        class="px-3 py-1 bg-amber-50 text-amber-700 text-[10px] font-black uppercase tracking-wider rounded-lg border border-amber-100">{{ $riwayat->status }}</span>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-12 text-center">
                    <p class="text-slate-400 text-sm">Belum ada riwayat reservasi.</p>
                </div>
            @endforelse
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="mt-auto border-t border-slate-200 bg-white">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex justify-between items-center text-[11px] font-bold text-slate-400 uppercase tracking-widest">
            <p>© 2026 Maxilla Dental Care.</p>
            <p>Kerahasiaan Data Terjamin</p>
        </div>
    </footer>

    <script>
        const csrfToken = '{{ csrf_token() }}';
        const CABANG_LOCATIONS = {
            @if(isset($setting) && is_array($setting->cabang_list))
                @foreach($setting->cabang_list as $cabang)
                    '{{ $cabang['name'] ?? '' }}': { lat: {{ !empty($cabang['lat']) ? $cabang['lat'] : 0 }}, lng: {{ !empty($cabang['lng']) ? $cabang['lng'] : 0 }}, radius: {{ !empty($cabang['radius']) ? $cabang['radius'] : 0.1 }} },
                @endforeach
            @endif
        };

        function calculateDistance(lat1, lon1, lat2, lon2) {
            function deg2rad(deg) { return deg * (Math.PI / 180); }
            const R = 6371;
            const dLat = deg2rad(lat2 - lat1);
            const dLon = deg2rad(lon2 - lon1);
            const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }

        async function handleCheckIn(btn, idReservasi, namaCabang) {
            const originalText = btn.innerHTML;
            btn.innerHTML = `<svg class="animate-spin h-4 w-4 mx-auto text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>`;
            btn.disabled = true;

            let targetCoords = null;
            for (let key in CABANG_LOCATIONS) {
                if (key.toLowerCase().includes(namaCabang.toLowerCase()) || namaCabang.toLowerCase().includes(key.toLowerCase())) {
                    targetCoords = CABANG_LOCATIONS[key];
                    break;
                }
            }

            if (!targetCoords) {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Koordinat lokasi tidak ditemukan.' });
                btn.innerHTML = originalText; btn.disabled = false; return;
            }

            if (!navigator.geolocation) {
                Swal.fire({ icon: 'error', title: 'Error', text: 'GPS tidak didukung.' });
                btn.innerHTML = originalText; btn.disabled = false; return;
            }

            navigator.geolocation.getCurrentPosition(
                async (position) => {
                    const distance = calculateDistance(position.coords.latitude, position.coords.longitude, targetCoords.lat, targetCoords.lng);
                    if (distance > targetCoords.radius) {
                        Swal.fire({ icon: 'warning', title: 'Terlalu Jauh', text: 'Jarak Anda masih di luar jangkauan area klinik.' });
                        btn.innerHTML = originalText; btn.disabled = false; return;
                    }

                    try {
                        const res = await fetch(`/pasien/reservasi/${idReservasi}/checkin`, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                        });
                        const data = await res.json();
                        if (data.success) {
                            Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Check-in berhasil!' }).then(() => window.location.reload());
                        } else {
                            Swal.fire({ icon: 'error', title: 'Gagal', text: data.message });
                            btn.innerHTML = originalText; btn.disabled = false;
                        }
                    } catch (e) {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Kesalahan koneksi.' });
                        btn.innerHTML = originalText; btn.disabled = false;
                    }
                },
                (error) => {
                    Swal.fire({ icon: 'error', title: 'GPS Gagal', text: 'Izin lokasi ditolak.' });
                    btn.innerHTML = originalText; btn.disabled = false;
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        }
    </script>
</body>

</html>