    <!-- Navbar / Header -->
    @include('landing_page.header')    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden blob-bg" x-data="{ showPanduanModal: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Text Content -->
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-sky-100 text-primary font-medium text-sm mb-6">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                        </span>
                        {{ $setting->hero_badge ?? 'Sistem Manajemen Antrian Real-Time' }}
                    </div>
                    <h1 class="font-heading text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight text-secondary mb-6">
                        {{ $setting->hero_headline ?? 'Perawatan Gigi Terbaik & Modern' }}
                    </h1>
                    <p class="text-lg text-slate-600 mb-8 leading-relaxed">
                        {{ $setting->hero_subheadline ?? 'Nikmati kemudahan layanan rawat gigi di Maxilla Dental Care. Sistem cerdas kami memberikan Anda jadwal pasti dan estimasi waktu tunggu real-time tanpa perlu antre berlama-lama di klinik.' }}
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="/login" class="px-8 py-3.5 rounded-full bg-secondary hover:bg-slate-800 text-white text-base font-medium transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center gap-2">
                            {{ $setting->hero_button1_text ?? 'Booking Sekarang' }}
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                        <a href="#" @click.prevent="showPanduanModal = true" class="px-8 py-3.5 rounded-full bg-white text-slate-700 border border-slate-200 hover:border-primary hover:text-primary text-base font-medium transition-all flex items-center gap-2 shadow-sm cursor-pointer">
                            {{ $setting->hero_button2_text ?? 'Lihat Panduan' }}
                        </a>
                    </div>
                    
                    <div class="mt-10 flex flex-wrap items-center gap-6 text-sm font-medium text-slate-500">
                        @if(is_array($setting->hero_checkmarks) && count($setting->hero_checkmarks) > 0)
                            @foreach($setting->hero_checkmarks as $check)
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                {{ $check }}
                            </div>
                            @endforeach
                        @else
                            <!-- Default bila pengaturan kosong -->
                            @foreach(['Slawi', 'Tegal', 'Brebes'] as $defCheck)
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                {{ $defCheck }}
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Hero Image/Mockup -->
                <div class="relative lg:-mr-10">
                    <div class="absolute inset-0 bg-gradient-to-tr from-primary to-blue-300 rounded-[2.5rem] transform rotate-3 scale-105 opacity-20 blur-xl"></div>
                    <div class="glass-panel rounded-[2rem] p-6 shadow-2xl relative">
                        <!-- Simulated App UI -->
                        <div class="bg-slate-50 rounded-2xl overflow-hidden border border-slate-100">
                            <div class="bg-white p-5 border-b border-slate-100">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="font-heading font-semibold text-lg text-secondary">Jam Operasional</h3>
                                    <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Buka</span>
                                </div>
                                <div class="flex items-end justify-between">
                                    <div>
                                        <p class="text-[10px] uppercase font-bold text-slate-400 mb-1">Senin - Sabtu</p>
                                        <p class="text-xl font-heading font-bold text-primary italic">07:00 - 21:00 <span class="text-xs font-normal text-slate-400">WIB</span></p>
                                    </div>
                                    <div class="text-right border-l border-slate-100 pl-4">
                                        <p class="text-[10px] uppercase font-bold text-slate-400 mb-1">Minggu / Libur</p>
                                        <p class="text-xl font-bold text-secondary italic">08:00 - 21:00 <span class="text-xs font-normal text-slate-400">WIB</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-5 bg-sky-50">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 rounded-full bg-white shadow flex items-center justify-center shrink-0">
                                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-secondary text-base">Semua Cabang Maxilla</p>
                                        <p class="text-xs text-slate-500 mb-2">Slawi • Tegal • Brebes</p>
                                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-white border border-slate-200 text-xs text-slate-600">
                                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Informasi Jadwal Serentak
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Panduan Booking -->
        <div x-show="showPanduanModal" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                
                <!-- Background overlay -->
                <div x-show="showPanduanModal" x-transition.opacity class="fixed inset-0 bg-secondary/80 backdrop-blur-sm transition-opacity" @click="showPanduanModal = false" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal Panel -->
                <div x-show="showPanduanModal" 
                    x-transition:enter="ease-out duration-300" 
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                    x-transition:leave="ease-in duration-200" 
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                    class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full border border-slate-100">
                    
                    <!-- Header -->
                    <div class="bg-surface px-6 py-4 flex justify-between items-center border-b border-slate-100">
                        <h3 class="text-lg leading-6 font-heading font-bold text-secondary flex items-center gap-2" id="modal-title">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Panduan Reservasi Online
                        </h3>
                        <button type="button" @click="showPanduanModal = false" class="bg-white rounded-full p-1.5 text-slate-400 hover:text-slate-600 hover:bg-slate-100 focus:outline-none transition-colors">
                            <span class="sr-only">Tutup</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Content -->
                    <div class="p-6 sm:p-8">
                        <div class="space-y-6">
                            <!-- Step 1 -->
                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-primary font-bold">1</div>
                                </div>
                                <div>
                                    <h4 class="text-base font-bold text-slate-800">Daftar Akun / Login</h4>
                                    <p class="mt-1 text-sm text-slate-600">Klik tombol "Booking Sekarang" untuk masuk ke dalam dasbor. Jika Anda adalah pasien baru, Anda dapat mendaftarkan diri secara mandiri (GRATIS) dalam 1 menit menggunakan NIK untuk keperluan rekam medis elektronik.</p>
                                </div>
                            </div>
                            <!-- Step 2 -->
                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-primary font-bold">2</div>
                                </div>
                                <div>
                                    <h4 class="text-base font-bold text-slate-800">Lengkapi Profil Kesehatan</h4>
                                    <p class="mt-1 text-sm text-slate-600">Bagi pengguna baru, kami hanya akan sekali saja menanyakan Alamat Domisili, Tanggal Lahir, dan Jenis Kelamin untuk menyelaraskan kartu tanda pendaftaran fisik di rumah sakit nantinya.</p>
                                </div>
                            </div>
                            <!-- Step 3 -->
                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-primary font-bold">3</div>
                                </div>
                                <div>
                                    <h4 class="text-base font-bold text-slate-800">Mulai Reservasi Booking Antrian</h4>
                                    <p class="mt-1 text-sm text-slate-600">Buka menu dasbor <b>Buat Reservasi</b>, pilih cabang (Slawi / Tegal / Brebes), tentukan dokter, tanggal dan jam yang sesuai, beserta keluhan utama.</p>
                                </div>
                            </div>
                            <!-- Step 4 -->
                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-primary font-bold">4</div>
                                </div>
                                <div>
                                    <h4 class="text-base font-bold text-slate-800">Pantau Antrian Real-Time</h4>
                                    <p class="mt-1 text-sm text-slate-600">Anda akan langsung mendapat nomor antrian otomatis secara digital. Anda bisa memantau sisa antrian yang sedang dalam panggilan melalui layar HP sehingga Anda tidak bosan *menunggu* berjam-jam luring di klinik.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-gray-50 px-6 py-4 flex justify-between items-center rounded-b-2xl border-t border-slate-100">
                        <p class="text-xs text-slate-500 font-medium">*Pusat layanan informasi medis / pertanyaan: <br> <span class="font-bold text-slate-700">Call Center: {{ $setting->kontak_telepon ?? '0812-3456-7890' }} | {{ $setting->kontak_email ?? 'halo@maxilladental.com' }}</span></p>
                        <button type="button" @click="showPanduanModal = false" class="w-full sm:w-auto inline-flex justify-center rounded-xl border border-transparent shadow-[0_4px_10px_rgb(203,213,225,0.4)] px-6 py-2.5 bg-slate-200 hover:bg-slate-300 text-base font-bold text-slate-700 hover:text-slate-800 focus:outline-none transition-colors">
                            Tutup Panduan
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </section>
