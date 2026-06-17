<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Bantuan | Maxilla Dental Care</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Inter'], heading: ['Poppins'] }, colors: { primary: '#0ea5e9', secondary: '#0f172a' } } }
        }
    </script>
</head>
<body class="font-sans antialiased text-slate-800 bg-white min-h-screen flex flex-col">

    <!-- TOP NAVIGATION BAR -->
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
                        class="text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors py-7">Riwayat
                        Reservasi</a>
                    <a href="/pasien/bantuan"
                        class="text-sm font-bold text-primary border-b-2 border-primary py-7">Bantuan</a>
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

    <!-- CONTENT -->
    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-10">
                <div class="w-16 h-16 bg-blue-100 text-primary rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <h1 class="font-heading text-3xl font-bold text-secondary mb-3">Pusat Bantuan & Layanan Darurat</h1>
                <p class="text-slate-500 text-lg">Jika Anda mengalami sakit gigi hebat, nyeri tidak tertahan, atau darurat gigi lainnya, segera tekan layanan darurat 24 jam di bawah.</p>
            </div>

            <div class="max-w-md mx-auto gap-6">
                <!-- Resepsionis -->
                <div class="bg-white border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-3xl p-8 hover:shadow-lg transition-transform hover:-translate-y-1">
                    <svg class="w-10 h-10 text-primary mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    <h3 class="font-heading text-xl font-bold text-slate-800 mb-2">Tanya Admin/Resepsionis</h3>
                    <p class="text-slate-500 mb-6 text-sm">Gagal login? Salah input data KTP? Konsultasikan keluhan aplikatif dan jadwal Anda ke admin.</p>
                    <div x-data="{ showWaModal: false }">
                        <button type="button" @click="showWaModal = true" class="block text-center w-full py-3.5 px-4 border border-blue-200 bg-blue-50 text-primary font-bold rounded-xl hover:bg-blue-100 transition-colors">Chat Admin Pendaftaran</button>

                        <template x-teleport="body">
                            <div x-show="showWaModal" x-transition.opacity class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" style="display: none;">
                                <div @click.away="showWaModal = false" class="bg-white rounded-3xl p-6 md:p-8 max-w-sm w-full shadow-2xl relative">
                                    <button @click="showWaModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 font-bold">&times;</button>
                                    <h3 class="font-bold text-xl text-slate-800 mb-2">Pilih Cabang Admin</h3>
                                    <p class="text-sm text-slate-500 mb-6">Pilih admin cabang mana yang ingin Anda hubungi via WhatsApp:</p>
                                    
                                    @php
                                        $settingWa = \App\Models\Setting::first();
                                        $waTextTegal = urlencode($settingWa->wa_template_tegal ?? 'Halo Maxilla Dental Care Tegal, saya ingin bertanya tentang layanan Anda.');
                                        $waTextSlawi = urlencode($settingWa->wa_template_slawi ?? 'Halo Maxilla Dental Care Slawi, saya ingin bertanya tentang layanan Anda.');
                                        $waTextBrebes = urlencode($settingWa->wa_template_brebes ?? 'Halo Maxilla Dental Care Brebes, saya ingin bertanya tentang layanan Anda.');
                                    @endphp
                                    <div class="space-y-3">
                                        <a href="https://wa.me/{{ $settingWa->wa_tegal ?? '6281234567890' }}?text={{ $waTextTegal }}" target="_blank" class="flex items-center gap-3 p-4 border border-slate-200 rounded-2xl hover:border-blue-500 hover:bg-blue-50 transition-colors group">
                                            <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564c.173.087.289.129.332.202.043.073.043.423-.101.827z"></path></svg>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-slate-700 group-hover:text-blue-700">Admin Tegal</h4>
                                            </div>
                                        </a>
                                        <a href="https://wa.me/{{ $settingWa->wa_slawi ?? '6281234567891' }}?text={{ $waTextSlawi }}" target="_blank" class="flex items-center gap-3 p-4 border border-slate-200 rounded-2xl hover:border-blue-500 hover:bg-blue-50 transition-colors group">
                                            <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564c.173.087.289.129.332.202.043.073.043.423-.101.827z"></path></svg>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-slate-700 group-hover:text-blue-700">Admin Slawi</h4>
                                            </div>
                                        </a>
                                        <a href="https://wa.me/{{ $settingWa->wa_brebes ?? '6281234567892' }}?text={{ $waTextBrebes }}" target="_blank" class="flex items-center gap-3 p-4 border border-slate-200 rounded-2xl hover:border-blue-500 hover:bg-blue-50 transition-colors group">
                                            <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564c.173.087.289.129.332.202.043.073.043.423-.101.827z"></path></svg>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-slate-700 group-hover:text-blue-700">Admin Brebes</h4>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- FAQ -->
            <div class="mt-12 bg-white p-6 md:p-10 rounded-3xl border border-slate-100 shadow-sm">
                <h3 class="font-bold text-lg text-slate-800 mb-6">Pertanyaan Sering Diajukan (FAQ)</h3>
                <div class="space-y-4">
                    <div class="pb-4">
                        <h4 class="font-bold text-slate-700 text-sm mb-1">Bagaimana cara reschedule/mengubah jadwal?</h4>
                        <p class="text-sm text-slate-500">Anda dapat membatalkan janji temu lama di menu Dashboard, lalu membuat Janji Temu yang baru. Atau Anda dapat menghubungi Admin Pendaftaran.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="mt-auto border-t border-slate-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex justify-between items-center text-sm text-slate-500 font-medium">
            <p>© 2026 Maxilla Dental Care.</p>
        </div>
    </footer>

</body>
</html>
