    <!-- Cabang & Dokter -->
    <section id="cabang" class="py-20 bg-white" x-data="{ showModal: false, activeBranch: null }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
                <div class="max-w-xl">
                    <h3 class="font-heading text-3xl font-bold text-secondary mb-4">{{ $setting->cabang_judul ?? 'Tersebar di 3 Kota Besar' }}</h3>
                    <p class="text-slate-600">{{ $setting->cabang_subjudul ?? 'Kami siap memberikan pelayanan terbaik dengan tenaga medis profesional di berbagai wilayah.' }}</p>
                </div>
                <!-- <a href="#" class="px-6 py-2.5 rounded-full border border-slate-300 hover:border-primary text-secondary hover:text-primary transition-colors font-medium text-sm">Lihat Semua Cabang</a> -->
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @if(isset($setting) && is_array($setting->cabang_list) && count($setting->cabang_list) > 0)
                    @php
                        $cabang_images = [
                            'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&q=80&w=800',
                            'https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&q=80&w=800',
                            'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&q=80&w=800'
                        ];
                    @endphp
                    @foreach($setting->cabang_list as $index => $cabang)
                    <div class="rounded-2xl overflow-hidden border border-slate-200 group flex flex-col">
                        <div class="h-48 bg-slate-200 relative overflow-hidden">
                            <img src="{{ $cabang_images[$index % 3] }}" alt="Klinik {{ $cabang['name'] ?? '' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <h4 class="absolute bottom-4 left-5 text-white font-heading font-bold text-xl">{{ $cabang['name'] ?? '' }}</h4>
                        </div>
                        <div class="p-6 flex flex-col flex-1">
                            <div class="flex items-start gap-3 mb-4">
                                <svg class="w-5 h-5 text-slate-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <p class="text-slate-600 text-sm">{{ $cabang['address'] ?? '' }}</p>
                            </div>
                            @php
                                $cabangName = strtolower($cabang['name'] ?? '');
                                $waNumber = '6281234567890';
                                $waTemplate = 'Halo Maxilla Dental Care, saya ingin bertanya tentang layanan Anda.';
                                
                                if (str_contains($cabangName, 'tegal')) { 
                                    $waNumber = $setting->wa_tegal ?? '6281234567890'; 
                                    $waTemplate = $setting->wa_template_tegal ?? 'Halo Maxilla Dental Care Tegal, saya ingin bertanya tentang layanan Anda.';
                                } elseif (str_contains($cabangName, 'slawi')) { 
                                    $waNumber = $setting->wa_slawi ?? '6281234567891'; 
                                    $waTemplate = $setting->wa_template_slawi ?? 'Halo Maxilla Dental Care Slawi, saya ingin bertanya tentang layanan Anda.';
                                } elseif (str_contains($cabangName, 'brebes')) { 
                                    $waNumber = $setting->wa_brebes ?? '6281234567892'; 
                                    $waTemplate = $setting->wa_template_brebes ?? 'Halo Maxilla Dental Care Brebes, saya ingin bertanya tentang layanan Anda.';
                                }
                                
                                $waUrl = "https://wa.me/{$waNumber}?text=" . urlencode($waTemplate);
                            @endphp
                            <div class="mt-auto pt-2 flex items-center gap-2">
                                <button @click.prevent="showModal = true; activeBranch = '{{ Str::slug(Str::remove('Maxilla Dental Care', $cabang['name'] ?? '')) }}'" class="block w-full text-center px-4 py-2 bg-sky-50 hover:bg-sky-100 text-primary font-bold rounded-lg transition-colors">
                                    Detail Cabang
                                </button>
                                <a href="{{ $waUrl }}" target="_blank" class="flex items-center justify-center w-10 h-10 shrink-0 bg-green-50 text-green-600 hover:bg-green-100 hover:text-green-700 rounded-lg transition-colors" title="Hubungi WA Admin">
                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564c.173.087.289.129.332.202.043.073.043.423-.101.827z"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- Cabang Slawi -->
                    <div class="rounded-2xl overflow-hidden border border-slate-200 group flex flex-col">
                        <div class="h-48 bg-slate-200 relative overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&q=80&w=800" alt="Klinik Slawi" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <h4 class="absolute bottom-4 left-5 text-white font-heading font-bold text-xl">Maxilla Dental Care Slawi</h4>
                        </div>
                        <div class="p-6 flex flex-col flex-1">
                            <div class="flex items-start gap-3 mb-4">
                                <svg class="w-5 h-5 text-slate-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <p class="text-slate-600 text-sm">Jl. Letjen Suprapto, Slawi, Kab. Tegal</p>
                            </div>
                            @php
                                $waTextSlawi = urlencode($setting->wa_template_slawi ?? 'Halo Maxilla Dental Care Slawi, saya ingin bertanya tentang layanan Anda.');
                            @endphp
                            <div class="mt-auto pt-2 flex items-center gap-2">
                                <button @click.prevent="showModal = true; activeBranch = 'slawi'" class="block w-full text-center px-4 py-2 bg-sky-50 hover:bg-sky-100 text-primary font-bold rounded-lg transition-colors">
                                    Detail Cabang
                                </button>
                                <a href="https://wa.me/{{ $setting->wa_slawi ?? '6281234567891' }}?text={{ $waTextSlawi }}" target="_blank" class="flex items-center justify-center w-10 h-10 shrink-0 bg-green-50 text-green-600 hover:bg-green-100 hover:text-green-700 rounded-lg transition-colors" title="Hubungi WA Admin Slawi">
                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564c.173.087.289.129.332.202.043.073.043.423-.101.827z"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Cabang Tegal -->
                    <div class="rounded-2xl overflow-hidden border border-slate-200 group flex flex-col">
                        <div class="h-48 bg-slate-200 relative overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&q=80&w=800" alt="Klinik Tegal" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <h4 class="absolute bottom-4 left-5 text-white font-heading font-bold text-xl">Maxilla Dental Care Tegal</h4>
                        </div>
                        <div class="p-6 flex flex-col flex-1">
                            <div class="flex items-start gap-3 mb-4">
                                <svg class="w-5 h-5 text-slate-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <p class="text-slate-600 text-sm">Jl. Kapten Sudibyo, Randugunting, Kec. Tegal Sel., Kota Tegal, Jawa Tengah</p>
                            </div>
                            @php
                                $waTextTegal = urlencode($setting->wa_template_tegal ?? 'Halo Maxilla Dental Care Tegal, saya ingin bertanya tentang layanan Anda.');
                            @endphp
                            <div class="mt-auto pt-2 flex items-center gap-2">
                                <button @click.prevent="showModal = true; activeBranch = 'tegal'" class="block w-full text-center px-4 py-2 bg-sky-50 hover:bg-sky-100 text-primary font-bold rounded-lg transition-colors">
                                    Detail Cabang
                                </button>
                                <a href="https://wa.me/{{ $setting->wa_tegal ?? '6281234567890' }}?text={{ $waTextTegal }}" target="_blank" class="flex items-center justify-center w-10 h-10 shrink-0 bg-green-50 text-green-600 hover:bg-green-100 hover:text-green-700 rounded-lg transition-colors" title="Hubungi WA Admin Tegal">
                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564c.173.087.289.129.332.202.043.073.043.423-.101.827z"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Cabang Brebes -->
                    <div class="rounded-2xl overflow-hidden border border-slate-200 group flex flex-col">
                        <div class="h-48 bg-slate-200 relative overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&q=80&w=800" alt="Klinik Brebes" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <h4 class="absolute bottom-4 left-5 text-white font-heading font-bold text-xl">Maxilla Dental Care Brebes</h4>
                        </div>
                        <div class="p-6 flex flex-col flex-1">
                            <div class="flex items-start gap-3 mb-4">
                                <svg class="w-5 h-5 text-slate-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <p class="text-slate-600 text-sm">Jl. Jend. Sudirman, Brebes, Kec. Brebes, Kabupaten Brebes, Jawa Tengah</p>
                            </div>
                            @php
                                $waTextBrebes = urlencode($setting->wa_template_brebes ?? 'Halo Maxilla Dental Care Brebes, saya ingin bertanya tentang layanan Anda.');
                            @endphp
                            <div class="mt-auto pt-2 flex items-center gap-2">
                                <button @click.prevent="showModal = true; activeBranch = 'brebes'" class="block w-full text-center px-4 py-2 bg-sky-50 hover:bg-sky-100 text-primary font-bold rounded-lg transition-colors">
                                    Detail Cabang
                                </button>
                                <a href="https://wa.me/{{ $setting->wa_brebes ?? '6281234567892' }}?text={{ $waTextBrebes }}" target="_blank" class="flex items-center justify-center w-10 h-10 shrink-0 bg-green-50 text-green-600 hover:bg-green-100 hover:text-green-700 rounded-lg transition-colors" title="Hubungi WA Admin Brebes">
                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564c.173.087.289.129.332.202.043.073.043.423-.101.827z"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Render Komponen Modal Detail -->
        @include('landing_page.cabang.detail')

    </section>
