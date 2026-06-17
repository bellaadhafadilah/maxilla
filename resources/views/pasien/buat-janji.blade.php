<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Reservasi | Maxilla Dental Care</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                        class="text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors py-7">Bantuan</a>
                </nav>

                <!-- Profile Dropdown & Mobile Menu Button -->
                <div class="flex items-center gap-4">
                    <a href="/pasien/buat-janji"
                        class="hidden md:inline-flex items-center justify-center px-4 py-2 rounded-xl text-sm font-bold text-white bg-primary hover:bg-blue-600 transition-colors shadow-[0_4px_10px_rgb(14,165,233,0.3)] border-2 border-primary border-opacity-50">
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
        <div class="mb-10">
            <h1 class="font-heading text-3xl md:text-4xl font-bold text-secondary mb-2 text-center md:text-left">
                Formulir Reservasi Dokter</h1>
            <p class="text-slate-500 text-lg text-center md:text-left">Buat janji temu medis Anda di seluruh cabang
                Maxilla Dental Care.</p>
        </div>

        @if(session('error'))
            <div class="mb-8 p-5 bg-red-50 border border-red-200 rounded-2xl flex items-start gap-4">
                <div class="w-10 h-10 bg-red-100 text-red-500 rounded-full flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-red-800 text-lg mb-1">Gagal Memproses Reservasi</h4>
                    <p class="text-red-600 text-sm leading-relaxed">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <form action="{{ route('pasien.buat-janji.store') }}" method="POST" x-data="{
                untuk_siapa: '{{ $oldReservasi ? ($oldReservasi->hubungan === 'Diri Sendiri' ? 'diri_sendiri' : 'orang_lain') : 'diri_sendiri' }}',
                cabang: '{{ $oldReservasi->cabang ?? '' }}',
                tanggal: '{{ $oldReservasi->tanggal ?? '' }}',
                jam: '{{ $oldReservasi->jam ?? '' }}',
                dokter: '{{ $oldReservasi->dokter_nama ?? '' }}',
                dokters: [],
                loading: false,
                showConfirmSubmit: false,
                
                riwayatPasien: {{ json_encode($riwayatPasienLain ?? []) }},
                namaSearch: '{{ $oldReservasi->nama_pasien ?? '' }}',
                jenis_kelamin_pasien: '{{ $oldReservasi->jenis_kelamin_pasien ?? 'Laki-laki' }}',
                tanggal_lahir_pasien: '{{ $oldReservasi->tanggal_lahir_pasien ?? '' }}',
                hubungan: '{{ $oldReservasi->hubungan ?? '' }}',

                checkAutoFill() {
                    let found = this.riwayatPasien.find(p => p.nama_pasien === this.namaSearch);
                    if(found) {
                        this.jenis_kelamin_pasien = found.jenis_kelamin_pasien || 'Laki-laki';
                        this.tanggal_lahir_pasien = found.tanggal_lahir_pasien || '';
                        this.hubungan = found.hubungan || '';
                    }
                },
                
                init() {
                    const urlParams = new URLSearchParams(window.location.search);
                    if (urlParams.has('cabang')) {
                        this.cabang = urlParams.get('cabang');
                    }
                    if (urlParams.has('dokter')) {
                        this.dokter = urlParams.get('dokter');
                    }
                    
                    if (this.cabang && this.tanggal && this.jam) {
                        this.fetchDokters();
                    }
                },

                fetchDokters() {
                    if (this.cabang && this.tanggal && this.jam) {
                        this.loading = true;
                        fetch('/pasien/api/available-doctors?cabang=' + this.cabang + '&tanggal=' + this.tanggal + '&jam=' + this.jam)
                            .then(res => res.json())
                            .then(data => {
                                this.dokters = data;
                                // Re-select doctor if we are rescheduling
                                if (this.dokter) {
                                     // nothing to do, x-model handles it if found in list
                                }
                                this.loading = false;
                            })
                            .catch(() => {
                                this.loading = false;
                            });
                    } else {
                        this.dokters = [];
                        this.dokter = '';
                    }
                }
            }">
            @csrf

            @if($oldReservasi)
                <input type="hidden" name="id_reservasi" value="{{ $oldReservasi->id_reservasi }}">
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <!-- LEFT COLUMN: Selections -->
                <div class="lg:col-span-7 space-y-6">
                    <!-- SECTION 0: Identitas Pasien -->
                    <div
                        class="bg-white rounded-3xl p-6 md:p-8 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                        <h3
                            class="font-bold text-lg text-slate-800 border-b border-slate-100 pb-3 mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Siapa yang akan berobat?
                        </h3>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <label class="relative flex flex-col p-4 border-2 rounded-2xl cursor-pointer transition-all"
                                :class="untuk_siapa === 'diri_sendiri' ? 'border-primary bg-blue-50/50' : 'border-slate-100 hover:border-slate-200'">
                                <input type="radio" name="untuk_siapa" value="diri_sendiri" x-model="untuk_siapa"
                                    class="absolute opacity-0">
                                <span class="text-sm font-bold"
                                    :class="untuk_siapa === 'diri_sendiri' ? 'text-primary' : 'text-slate-600'">Diri
                                    Sendiri</span>
                                <span class="text-[10px] text-slate-400 mt-1">Gunakan data profil saya</span>
                            </label>
                            <label class="relative flex flex-col p-4 border-2 rounded-2xl cursor-pointer transition-all"
                                :class="untuk_siapa === 'orang_lain' ? 'border-primary bg-blue-50/50' : 'border-slate-100 hover:border-slate-200'">
                                <input type="radio" name="untuk_siapa" value="orang_lain" x-model="untuk_siapa"
                                    class="absolute opacity-0">
                                <span class="text-sm font-bold"
                                    :class="untuk_siapa === 'orang_lain' ? 'text-primary' : 'text-slate-600'">Orang
                                    Lain</span>
                                <span class="text-[10px] text-slate-400 mt-1">Daftarkan keluarga/teman</span>
                            </label>
                        </div>

                        <!-- Data Diri Sendiri (Readonly) -->
                        <div x-show="untuk_siapa === 'diri_sendiri'" x-transition
                            class="space-y-4 pt-2 border-t border-slate-50 mt-4">
                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Nama
                                    Lengkap Pasien</label>
                                <input type="text" value="{{ auth()->user()->nama }}"
                                    class="block w-full px-4 py-3 bg-slate-100 border border-slate-200 rounded-xl text-slate-500 text-sm cursor-not-allowed"
                                    readonly>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Jenis
                                        Kelamin</label>
                                    <input type="text"
                                        value="{{ auth()->user()->pasien->jenis_kelamin ?? 'Belum diisi' }}"
                                        class="block w-full px-4 py-3 bg-slate-100 border border-slate-200 rounded-xl text-slate-500 text-sm cursor-not-allowed"
                                        readonly>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Tanggal
                                        Lahir</label>
                                    @if(auth()->user()->pasien && auth()->user()->pasien->tanggal_lahir)
                                        <input type="date" value="{{ auth()->user()->pasien->tanggal_lahir }}"
                                            class="block w-full px-4 py-3 bg-slate-100 border border-slate-200 rounded-xl text-slate-500 text-sm cursor-not-allowed"
                                            readonly>
                                    @else
                                        <input type="text" value="Belum diisi"
                                            class="block w-full px-4 py-3 bg-slate-100 border border-slate-200 rounded-xl text-slate-500 text-sm cursor-not-allowed"
                                            readonly>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Hubungan</label>
                                <input type="text" value="Diri Sendiri"
                                    class="block w-full px-4 py-3 bg-slate-100 border border-slate-200 rounded-xl text-slate-500 text-sm cursor-not-allowed"
                                    readonly>
                            </div>
                            @if(!auth()->user()->pasien || !auth()->user()->pasien->tanggal_lahir)
                                <p class="text-xs text-orange-500 mt-1 italic">* Anda belum melengkapi profil medis dasar.
                                    <a href="/pasien/profil/lengkapi" class="underline font-bold">Lengkapi Profil</a>
                                </p>
                            @endif
                        </div>

                        <!-- Data Orang Lain (Conditional) -->
                        <div x-show="untuk_siapa === 'orang_lain'" x-transition
                            class="space-y-4 pt-2 border-t border-slate-50 mt-4">
                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Nama
                                    Lengkap Pasien</label>
                                <input type="text" name="nama_pasien" x-model="namaSearch" @input="checkAutoFill()"
                                    list="riwayat-pasien-list" autocomplete="off" placeholder="Masukkan nama pasien"
                                    class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-primary focus:border-primary text-sm transition-colors outline-none">
                                <datalist id="riwayat-pasien-list">
                                    @foreach($riwayatPasienLain as $pasien)
                                        <option value="{{ $pasien->nama_pasien }}">{{ $pasien->hubungan }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Jenis
                                        Kelamin</label>
                                    <select name="jenis_kelamin_pasien" x-model="jenis_kelamin_pasien"
                                        class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-primary focus:border-primary text-sm transition-colors outline-none cursor-pointer">
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Tanggal
                                        Lahir</label>
                                    <input type="date" name="tanggal_lahir_pasien" x-model="tanggal_lahir_pasien"
                                        class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-primary focus:border-primary text-sm transition-colors outline-none">
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Hubungan</label>
                                <input type="text" name="hubungan" x-model="hubungan"
                                    placeholder="Contoh: Anak, Istri, Suami, Ayah, Ibu, dll."
                                    class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-primary focus:border-primary text-sm transition-colors outline-none">
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-3xl p-6 md:p-8 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                        <!-- STEP 1: Pilih Cabang & Jadwal -->
                        <div class="mb-8">
                            <h3
                                class="font-bold text-lg text-slate-800 border-b border-slate-100 pb-3 mb-6 flex items-center gap-2">
                                <span
                                    class="w-7 h-7 rounded-full bg-primary text-white flex items-center justify-center text-xs">1</span>
                                Pilih Lokasi & Waktu
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <!-- Cabang -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-bold text-slate-700 mb-2 text-[13px]">Cabang
                                        Klinik</label>
                                    <select name="cabang" x-model="cabang" @change="fetchDokters()"
                                        class="block w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-primary focus:border-primary text-sm transition-colors outline-none cursor-pointer">
                                        <option value="">Pilih Area Cabang</option>
                                        <option value="Slawi">Klinik Slawi</option>
                                        <option value="Tegal">Klinik Tegal</option>
                                        <option value="Brebes">Klinik Brebes</option>
                                    </select>
                                </div>

                                <!-- Tanggal -->
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2 text-[13px]">Tanggal
                                        Reservasi</label>
                                    <input type="date" name="tanggal" x-model="tanggal" @change="fetchDokters()" min="{{ date('Y-m-d') }}"
                                        class="block w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-primary focus:border-primary text-sm transition-colors outline-none cursor-pointer">
                                </div>

                                <!-- Jam -->
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2 text-[13px]">Sesi
                                        Waktu</label>
                                    <select name="jam" x-model="jam" @change="fetchDokters()"
                                        class="block w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-primary focus:border-primary text-sm transition-colors outline-none cursor-pointer">
                                        <option value="">Pilih Sesi Jam</option>
                                        <option value="Pagi">Sesi Pagi (07:00 - 13:00)</option>
                                        <option value="Siang">Sesi Siang (13:00 - 17:00)</option>
                                        <option value="Sore">Sesi Sore/Malam (17:00 - 21:00)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 2: Pilih Dokter -->
                        <div>
                            <h3
                                class="font-bold text-lg text-slate-800 border-b border-slate-100 pb-3 mb-6 flex items-center gap-2">
                                <span
                                    class="w-7 h-7 rounded-full bg-primary text-white flex items-center justify-center text-xs">2</span>
                                Pilih Dokter Gigi
                            </h3>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2 text-[13px]">Dokter Spesialis
                                    (Berdasarkan Jadwal)</label>
                                <div class="relative">
                                    <select name="dokter" x-model="dokter"
                                        class="block w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-primary focus:border-primary text-sm transition-colors outline-none cursor-pointer disabled:opacity-60"
                                        :disabled="!cabang || !tanggal || !jam || loading">
                                        <template x-if="!cabang || !tanggal || !jam">
                                            <option value="">Lengkapi data di atas terlebih dahulu</option>
                                        </template>
                                        <template x-if="cabang && tanggal && jam && loading">
                                            <option value="">Mencari dokter tersedia...</option>
                                        </template>
                                        <template x-if="cabang && tanggal && jam && !loading && dokters.length === 0">
                                            <option value="">Jadwal tidak ditemukan</option>
                                        </template>
                                        <template x-if="cabang && tanggal && jam && !loading && dokters.length > 0">
                                            <option value="">-- Klik untuk memilih dokter --</option>
                                        </template>

                                        <template x-for="d in dokters" :key="d.id">
                                            <option :value="d.dokter_nama" x-text="d.dokter_nama">
                                            </option>
                                        </template>
                                    </select>
                                </div>
                                <p class="mt-3 text-[11px] text-slate-400 italic">*Pilihan dokter hanya akan muncul jika
                                    jadwal tersedia pada sesi yang dipilih.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN: Details & Submit -->
                <div class="lg:col-span-5 space-y-6">
                    <div
                        class="bg-white rounded-3xl p-6 md:p-8 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] h-full flex flex-col">
                        <h3
                            class="font-bold text-lg text-slate-800 border-b border-slate-100 pb-3 mb-6 flex items-center gap-2">
                            <span
                                class="w-7 h-7 rounded-full bg-primary text-white flex items-center justify-center text-xs">3</span>
                            Detail Keluhan
                        </h3>

                        <div class="flex-1">
                            <label class="block text-sm font-bold text-slate-700 mb-2 text-[13px]">Tuliskan Keluhan atau
                                Keperluan Medis</label>
                            <textarea name="keluhan" rows="8"
                                class="block w-full px-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-primary focus:border-primary text-sm transition-colors outline-none resize-none"
                                placeholder="Contoh: Sakit gigi geraham saat makan panas/dingin, atau ingin pembersihan karang gigi (scaling).">{{ $oldReservasi->keluhan ?? '' }}</textarea>
                        </div>

                        <div class="mt-8 space-y-3">
                            <button type="button" @click="showConfirmSubmit = true"
                                class="w-full py-4 text-white bg-primary font-bold text-lg rounded-xl hover:bg-blue-600 transition-all shadow-[0_8px_20px_rgb(14,165,233,0.3)] active:scale-[0.98]">
                                Kirim Reservasi
                            </button>

                            <!-- Modal Konfirmasi Kirim Reservasi -->
                            <template x-teleport="body">
                                <div x-show="showConfirmSubmit" x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                    class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                                    style="display: none;">

                                    <div @click.away="showConfirmSubmit = false" x-show="showConfirmSubmit"
                                        x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                        x-transition:leave="transition ease-in duration-200"
                                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                                        class="bg-white rounded-3xl p-8 max-w-sm w-full shadow-2xl border border-slate-100 text-center relative overflow-hidden">

                                        <div class="w-20 h-20 bg-blue-50 text-primary rounded-full flex items-center justify-center mx-auto mb-6">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>

                                        <h3 class="font-bold text-xl text-slate-800 mb-3">Konfirmasi Reservasi</h3>
                                        <p class="text-slate-500 text-sm mb-8 leading-relaxed">Apakah Anda yakin data reservasi sudah benar dan ingin mengirimkannya sekarang?</p>

                                        <div class="grid grid-cols-2 gap-4">
                                            <button @click="showConfirmSubmit = false" type="button" class="px-6 py-3 rounded-2xl text-sm font-bold text-slate-500 bg-slate-100 hover:bg-slate-200 transition-colors">
                                                Cek Lagi
                                            </button>
                                            <button type="button" @click="$el.closest('body').querySelector('form[action=\'{{ route('pasien.buat-janji.store') }}\']').submit()" class="px-6 py-3 rounded-2xl text-sm font-bold text-white bg-primary hover:bg-blue-600 transition-all shadow-lg shadow-blue-100">
                                                Ya, Kirim
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <a href="/pasien/dashboard"
                                class="w-full py-4 text-slate-500 font-bold text-sm rounded-xl hover:bg-slate-50 transition-colors block text-center border border-transparent hover:border-slate-100">
                                Kembali ke Dashboard
                            </a>
                        </div>
                    </div>

                    <!-- Info Card -->
                    <div class="bg-blue-50 rounded-2xl p-5 border border-blue-100">
                        <div class="flex gap-3">
                            <svg class="w-5 h-5 text-primary shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-xs text-slate-600 leading-relaxed font-medium">Data reservasi Anda akan
                                langsung terdaftar di sistem cabang tujuan. Pastikan Anda datang 15 menit sebelum sesi
                                dimulai untuk proses check-in.</p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <!-- FOOTER -->
    <footer class="mt-auto border-t border-slate-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-sm text-slate-500 font-medium">
            <p>© 2026 Maxilla Dental Care.</p>
        </div>
    </footer>

</body>

</html>