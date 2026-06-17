@extends('layouts.dashboard')

@section('title', 'Pengaturan Landing Page')

@section('content')
<form action="{{ route('superadmin.pengaturan-web.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
<div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-5 relative z-10">
    <div>
        <!-- <h1 class="font-heading text-3xl font-bold text-slate-800 tracking-tight">Pengaturan Konten Landing Page</h1>
        <p class="text-slate-500 mt-1 text-sm">Sesuaikan konten website utama berdasarkan modul komponen yang ada di halaman depan publik.</p> -->
        @if(session('success'))
            <div class="mt-3 px-4 py-2 bg-emerald-50 text-emerald-700 rounded-lg text-sm font-bold border border-emerald-200">
                ✅ {{ session('success') }}
            </div>
        @endif
    </div>
    <button type="submit" class="px-5 py-2.5 bg-emerald-600 text-white rounded-xl text-sm font-bold hover:bg-emerald-700 transition-all shadow-[0_4px_12px_rgba(16,185,129,0.25)] hover:shadow-[0_6px_16px_rgba(16,185,129,0.35)] flex items-center gap-2 active:scale-95">
        <svg class="w-5 h-5 border-2 border-emerald-400 rounded-full bg-emerald-700/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        Simpan Perubahan
    </button>
</div>

<!-- ========================================== -->
<!-- SETTINGS PANELS (TABS) ALIGNED TO LANDING_PAGE VIEWS -->
<!-- ========================================== -->
<div x-data="{ tab: 'header' }" class="flex flex-col lg:flex-row gap-6 mb-8">
    
    <!-- LEFT SIDEBAR: Pilihan Kategori Berdasarkan Komponen Landing Page -->
    <div class="w-full lg:w-[280px] shrink-0">
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden flex flex-col p-2 space-y-1">
            <button type="button" @click="tab = 'header'" :class="tab === 'header' ? 'bg-blue-50 text-blue-700 font-bold border-blue-200' : 'text-slate-500 font-medium hover:bg-slate-50 border-transparent'" class="w-full text-left px-4 py-3 rounded-xl border text-[13px] transition-colors flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" :class="tab === 'header' ? 'text-blue-500' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                1. Landing
            </button>
            <button type="button" @click="tab = 'solusi'" :class="tab === 'solusi' ? 'bg-blue-50 text-blue-700 font-bold border-blue-200' : 'text-slate-500 font-medium hover:bg-slate-50 border-transparent'" class="w-full text-left px-4 py-3 rounded-xl border text-[13px] transition-colors flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" :class="tab === 'solusi' ? 'text-blue-500' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                2. Solusi
            </button>
            <button type="button" @click="tab = 'estimasi'" :class="tab === 'estimasi' ? 'bg-blue-50 text-blue-700 font-bold border-blue-200' : 'text-slate-500 font-medium hover:bg-slate-50 border-transparent'" class="w-full text-left px-4 py-3 rounded-xl border text-[13px] transition-colors flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" :class="tab === 'estimasi' ? 'text-blue-500' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                3. Cara Kerja Estimasi
            </button>
            <button type="button" @click="tab = 'alur'" :class="tab === 'alur' ? 'bg-blue-50 text-blue-700 font-bold border-blue-200' : 'text-slate-500 font-medium hover:bg-slate-50 border-transparent'" class="w-full text-left px-4 py-3 rounded-xl border text-[13px] transition-colors flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" :class="tab === 'alur' ? 'text-blue-500' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                4. Alur Pasien
            </button>
            <button type="button" @click="tab = 'cabang'" :class="tab === 'cabang' ? 'bg-blue-50 text-blue-700 font-bold border-blue-200' : 'text-slate-500 font-medium hover:bg-slate-50 border-transparent'" class="w-full text-left px-4 py-3 rounded-xl border text-[13px] transition-colors flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" :class="tab === 'cabang' ? 'text-blue-500' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                5. Cabang
            </button>
            <button type="button" @click="tab = 'footer'" :class="tab === 'footer' ? 'bg-blue-50 text-blue-700 font-bold border-blue-200' : 'text-slate-500 font-medium hover:bg-slate-50 border-transparent'" class="w-full text-left px-4 py-3 rounded-xl border text-[13px] transition-colors flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" :class="tab === 'footer' ? 'text-blue-500' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                6. Footer & Kontak
            </button>
            <hr class="border-slate-100 my-1">
            <a href="/" target="_blank" class="w-full text-left px-4 py-3 rounded-xl bg-orange-50 text-orange-600 font-bold border border-orange-200 hover:bg-orange-100 text-[13px] transition-colors flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                Preview Tampilan (Live)
            </a>
        </div>
    </div>

    <!-- RIGHT CONTENT: Area Form Dinamis -->
    <div class="flex-1">
        
        <!-- 1: HEADER & LANDING -->
        <div x-show="tab === 'header'" x-transition.opacity.duration.300ms class="space-y-6">
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-blue-500"></div>
                <h3 class="font-bold text-lg text-slate-800 mb-2">Modul: header.blade.php & landing.blade.php</h3>
                <p class="text-xs font-medium text-slate-500 mb-4 pb-4 border-b border-slate-100">Panel navigasi atas dan elemen Hero utama (Gambar Latar, Tagline, dan Selamat Datang).</p>
                
                <div class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="w-full">
                            <label class="block text-sm font-bold text-slate-700 mb-1.5">Teks Badge (Label Kecil)</label>
                            <input type="text" name="hero_badge" value="{{ $setting->hero_badge ?? 'Sistem Manajemen Antrian Real-Time' }}" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 outline-none" placeholder="Sistem Manajemen Antrian Real-Time">
                        </div>
                        <div class="w-full">
                            <label class="block text-sm font-bold text-slate-700 mb-1.5">Teks Judul Utama (Hero Headline)</label>
                            <input type="text" name="hero_headline" value="{{ $setting->hero_headline ?? 'Perawatan Gigi Terbaik & Modern' }}" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 outline-none" placeholder="Perawatan Gigi Terbaik & Modern">
                        </div>
                        <div class="w-full md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-1.5">Teks Deskripsi Singkat (Hero Sub-Headline)</label>
                            <textarea name="hero_subheadline" rows="3" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 outline-none" placeholder="Nikmati kemudahan layanan rawat gigi di Maxilla Dental Care...">{{ $setting->hero_subheadline ?? 'Nikmati kemudahan layanan rawat gigi di Maxilla Dental Care. Sistem cerdas kami memberikan Anda jadwal pasti dan estimasi waktu tunggu real-time tanpa perlu antre berlama-lama di klinik.' }}</textarea>
                        </div>
                        <div class="w-full">
                            <label class="block text-sm font-bold text-slate-700 mb-1.5">Logo Navbar</label>
                            <input type="file" name="logo_navbar" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors">
                            @if($setting->logo_navbar)
                            <div class="mt-2 text-xs text-emerald-600 font-medium font-mono flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> 
                                Logo Aktif (Tersimpan)
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-slate-100 grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="w-full">
                            <label class="block text-sm font-bold text-slate-700 mb-1.5">Teks Tombol Aksi 1 (Gelap)</label>
                            <input type="text" name="hero_button1_text" value="{{ $setting->hero_button1_text ?? 'Booking Sekarang' }}" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 outline-none" placeholder="Booking Sekarang">
                        </div>
                        <div class="w-full">
                            <label class="block text-sm font-bold text-slate-700 mb-1.5">Teks Tombol Aksi 2 (Terang)</label>
                            <input type="text" name="hero_button2_text" value="{{ $setting->hero_button2_text ?? 'Lihat Panduan' }}" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 outline-none" placeholder="Lihat Panduan">
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-slate-100">
                        <div class="flex justify-between items-center mb-3">
                            <label class="block text-sm font-bold text-slate-700">Daftar Poin Ceklis Hijau (Bawah Tombol)</label>
                            <button type="button" onclick="addHeroCheckmark()" class="px-3 py-1 bg-green-50 text-green-600 rounded-lg text-xs font-bold hover:bg-green-100">+ Tambah Ceklis</button>
                        </div>
                        <div class="space-y-3" id="hero-checkmark-container">
                            @if(is_array($setting->hero_checkmarks) && count($setting->hero_checkmarks) > 0)
                                @foreach($setting->hero_checkmarks as $check)
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    <input type="text" name="hero_checkmarks[]" value="{{ $check }}" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:border-green-500 focus:ring-1 outline-none">
                                    <button type="button" onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 font-bold text-xl px-2">&times;</button>
                                </div>
                                @endforeach
                            @else
                                <!-- Default checks if empty -->
                                @foreach(['Slawi', 'Tegal', 'Brebes'] as $defCheck)
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    <input type="text" name="hero_checkmarks[]" value="{{ $defCheck }}" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:border-green-500 focus:ring-1 outline-none">
                                    <button type="button" onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 font-bold text-xl px-2">&times;</button>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        <script>
                            function addHeroCheckmark() {
                                const html = `
                                <div class="flex items-center gap-3 mt-3">
                                    <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    <input type="text" name="hero_checkmarks[]" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:border-green-500 focus:ring-1 outline-none" placeholder="Nama Lokasi / Fitur">
                                    <button type="button" onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 font-bold text-xl px-2">&times;</button>
                                </div>`;
                                document.getElementById('hero-checkmark-container').insertAdjacentHTML('beforeend', html);
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2: SOLUSI -->
        <div x-show="tab === 'solusi'" x-transition.opacity.duration.300ms class="space-y-6" style="display: none;">
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-blue-500"></div>
                <div class="flex justify-between items-start mb-4 pb-4 border-b border-slate-100">
                    <div x-show="tab === 'solusi'" class="p-0" x-cloak>
                        <h2 class="text-xl font-bold text-slate-800 mb-6 border-b border-slate-100 pb-4">Modul: solusi.blade.php</h2>
                        <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="w-full">
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Teks Badge Sesi Solusi</label>
                                <input type="text" name="solusi_badge" value="{{ $setting->solusi_badge ?? 'MENGAPA MAXILLA DENTAL CARE?' }}" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 outline-none">
                            </div>
                            <div class="w-full">
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Judul Utama Solusi</label>
                                <input type="text" name="solusi_judul" value="{{ $setting->solusi_judul ?? 'Selamat Tinggal Antrian Manual' }}" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 outline-none">
                            </div>
                            <div class="w-full md:col-span-2 mb-4">
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Deskripsi Paragraf Solusi</label>
                                <textarea name="solusi_deskripsi" rows="3" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 outline-none" placeholder="Maksud dari bagian layanan solutif ini...">{{ $setting->solusi_deskripsi ?? 'Solusi Cerdas Operasional Klinik. Sebelumnya pasien tidak mengetahui jam pasti dilayani sehingga terjadi penumpukan di ruang tunggu.' }}</textarea>
                            </div>
                        </div>

                        <div class="mb-4 bg-slate-50 p-4 border border-slate-100 rounded-xl">
                            <p class="text-xs text-slate-500 font-medium mb-3">Sesi di bawah ini berisi daftar layanan atau keunggulan klinik (Card Grid).</p>
                        </div>
                    </div>
                    <button type="button" onclick="addLayanan()" class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-100">+ Tambah Layanan</button>
                </div>
                
                <div class="space-y-3" id="layanan-container">
                    @if(is_array($setting->layanan_medis))
                        @foreach($setting->layanan_medis as $index => $layanan)
                        <div class="flex flex-col sm:flex-row gap-4 border border-slate-200 p-3 rounded-xl hover:bg-slate-50 transition-colors">
                            <div class="flex-1">
                                <input type="text" name="layanan_titles[]" value="{{ $layanan['title'] ?? '' }}" class="w-full font-bold text-sm text-slate-800 bg-transparent border-b border-dashed border-slate-300 focus:border-blue-500 outline-none pb-1 mb-2" placeholder="Judul Layanan (Misal: Ortodonti)">
                                <input type="text" name="layanan_descs[]" value="{{ $layanan['desc'] ?? '' }}" class="w-full text-xs text-slate-500 bg-transparent border-b border-dashed border-slate-300 focus:border-blue-500 outline-none pb-1" placeholder="Deskripsi Singkat Layanan">
                            </div>
                            <button type="button" onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 px-2 flex items-center shrink-0 text-xs font-bold bg-red-50 rounded-lg">Hapus</button>
                        </div>
                        @endforeach
                    @endif
                </div>
                <script>
                    function addLayanan() {
                        const html = `
                        <div class="flex flex-col sm:flex-row gap-4 border border-slate-200 p-3 rounded-xl hover:bg-slate-50 transition-colors">
                            <div class="flex-1">
                                <input type="text" name="layanan_titles[]" class="w-full font-bold text-sm text-slate-800 bg-transparent border-b border-dashed border-slate-300 focus:border-blue-500 outline-none pb-1 mb-2" placeholder="Judul Layanan">
                                <input type="text" name="layanan_descs[]" class="w-full text-xs text-slate-500 bg-transparent border-b border-dashed border-slate-300 focus:border-blue-500 outline-none pb-1" placeholder="Deskripsi Singkat">
                            </div>
                            <button type="button" onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 px-2 flex items-center shrink-0 text-xs font-bold bg-red-50 rounded-lg">Hapus</button>
                        </div>`;
                        document.getElementById('layanan-container').insertAdjacentHTML('beforeend', html);
                    }
                </script>
            </div>
        </div>

        <!-- 3: ESTIMASI -->
        <div x-show="tab === 'estimasi'" x-transition.opacity.duration.300ms class="space-y-6" style="display: none;">
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-blue-500"></div>
                <div class="flex justify-between items-start mb-4 pb-4 border-b border-slate-100">
                    <div x-show="tab === 'estimasi'" class="p-0" x-cloak>
                        <h2 class="text-xl font-bold text-slate-800 mb-6 border-b border-slate-100 pb-4">Modul: estimasi.blade.php</h2>
                        <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="w-full">
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Teks Badge (SMART QUEUE)</label>
                                <input type="text" name="estimasi_badge" value="{{ $setting->estimasi_badge ?? 'SMART QUEUE SYSTEM' }}" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 outline-none">
                            </div>
                            <div class="w-full">
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Judul Sesi Estimasi</label>
                                <input type="text" name="estimasi_judul" value="{{ $setting->estimasi_judul ?? 'Estimasi Waktu Tunggu Otomatis & Presisi' }}" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 outline-none">
                            </div>
                            <div class="w-full md:col-span-2 mb-4">
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Paragraf Penjelasan Sistem Reservasi</label>
                                <textarea name="estimasi_deskripsi" rows="3" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 outline-none" placeholder="Penjelasan mengenai estimasi...">{{ $setting->estimasi_deskripsi ?? 'Sistem kami tidak sekadar membagi jam buka. Algoritma kami secara cerdas menghitung durasi historis setiap jenis tindakan dari masing-masing dokter bedah mulut.' }}</textarea>
                            </div>
                        </div>

                        <div class="mb-4 bg-slate-50 p-4 border border-slate-100 rounded-xl">
                            <p class="text-xs text-slate-500 font-medium mb-3">Sesi di bawah ini berisi tabel harga standar / promo (Price list).</p>
                        </div>
                    </div>
                    <button type="button" onclick="addEstimasi()" class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-100">+ Tambah Harga</button>
                </div>
                
                <table class="w-full text-left text-sm" id="tabel-estimasi">
                    <thead><tr class="text-slate-500 border-b"><th class="py-2">Nama Tindakan</th><th>Harga (Mulai dari)</th><th>Aksi</th></tr></thead>
                        @if(is_array($setting->estimasi_harga))
                            @foreach($setting->estimasi_harga as $estimasi)
                            <tr class="border-b border-slate-100">
                                <td class="py-3 font-bold text-slate-700">
                                    <input type="text" name="estimasi_names[]" value="{{ $estimasi['name'] ?? '' }}" class="w-full text-sm bg-transparent border-b border-dashed border-slate-300 focus:border-blue-500 outline-none pb-1" placeholder="Nama Tindakan">
                                </td>
                                <td class="text-emerald-600 font-bold">
                                    <input type="text" name="estimasi_prices[]" value="{{ $estimasi['price'] ?? '' }}" class="w-full text-sm bg-transparent border-b border-dashed border-emerald-300 focus:border-emerald-500 outline-none pb-1" placeholder="Rp ...">
                                </td>
                                <td><button type="button" onclick="this.closest('tr').remove()" class="text-red-500 text-xs font-bold hover:underline">Hapus</button></td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <script>
                    function addEstimasi() {
                        const html = `
                            <tr class="border-b border-slate-100">
                                <td class="py-3 font-bold text-slate-700">
                                    <input type="text" name="estimasi_names[]" class="w-full text-sm bg-transparent border-b border-dashed border-slate-300 focus:border-blue-500 outline-none pb-1" placeholder="Nama Tindakan">
                                </td>
                                <td class="text-emerald-600 font-bold">
                                    <input type="text" name="estimasi_prices[]" class="w-full text-sm bg-transparent border-b border-dashed border-emerald-300 focus:border-emerald-500 outline-none pb-1" placeholder="Rp ...">
                                </td>
                                <td><button type="button" onclick="this.closest('tr').remove()" class="text-red-500 text-xs font-bold hover:underline">Hapus</button></td>
                            </tr>`;
                        document.querySelector('#tabel-estimasi tbody').insertAdjacentHTML('beforeend', html);
                    }
                <h4 class="font-bold text-slate-800 mt-8 mb-4 border-b border-slate-100 pb-2">Daftar Langkah Waktu Tunggu (Estimasi Steps)</h4>
                <div class="space-y-3 mt-4" id="estimasi-step-container">
                    @if(is_array($setting->estimasi_steps) && count($setting->estimasi_steps) > 0)
                        @foreach($setting->estimasi_steps as $step)
                        <div class="flex gap-4 items-center bg-slate-50 p-3 rounded-xl border border-slate-200">
                            <div class="flex-1 space-y-2">
                                <input type="text" name="estimasi_step_titles[]" value="{{ $step['title'] ?? '' }}" class="w-full border border-slate-200 rounded-lg px-3 py-1.5 text-sm font-bold" placeholder="Judul Langkah">
                                <textarea name="estimasi_step_descs[]" class="w-full border border-slate-200 rounded-lg px-3 py-1.5 text-xs text-slate-600" rows="2" placeholder="Deskripsi Langkah">{{ $step['desc'] ?? '' }}</textarea>
                            </div>
                            <button type="button" onclick="this.parentElement.remove()" class="text-red-500 font-bold text-xs hover:bg-red-50 px-2 py-6 rounded-md">X</button>
                        </div>
                        @endforeach
                    @else
                        <!-- Defaults -->
                        @php
                            $def_est_steps = [
                                ['title' => 'Dokter Mencatat Waktu Praktek', 'desc' => 'Saat melayani pasien, dokter menggunakan timer kami untuk mencatat durasi pelayanan secara riil.'],
                                ['title' => 'Sistem Memperbarui Rata-rata', 'desc' => 'Rata-rata kecepatan pelayanan dokter tersebut diupdate otomatis tiap kali ada pasien yang selesai.'],
                                ['title' => 'Jam Antrian Menyesuaikan', 'desc' => 'Pasien yang sedang menunggu akan menerima pembaruan jadwalnya secara dinamis. Anda tahu persis kapan harus berangkat!'],
                            ];
                        @endphp
                        @foreach($def_est_steps as $step)
                        <div class="flex gap-4 items-center bg-slate-50 p-3 rounded-xl border border-slate-200">
                            <div class="flex-1 space-y-2">
                                <input type="text" name="estimasi_step_titles[]" value="{{ $step['title'] }}" class="w-full border border-slate-200 rounded-lg px-3 py-1.5 text-sm font-bold" placeholder="Judul Langkah">
                                <textarea name="estimasi_step_descs[]" class="w-full border border-slate-200 rounded-lg px-3 py-1.5 text-xs text-slate-600" rows="2" placeholder="Deskripsi Langkah">{{ $step['desc'] }}</textarea>
                            </div>
                            <button type="button" onclick="this.parentElement.remove()" class="text-red-500 font-bold text-xs hover:bg-red-50 px-2 py-6 rounded-md">X</button>
                        </div>
                        @endforeach
                    @endif
                </div>
                <button type="button" onclick="addEstimasiStep()" class="mt-4 px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-100">+ Tambah Langkah Estimasi</button>

                <script>
                    function addEstimasiStep() {
                        const html = `
                        <div class="flex gap-4 items-center bg-slate-50 p-3 rounded-xl border border-slate-200 mt-3">
                            <div class="flex-1 space-y-2">
                                <input type="text" name="estimasi_step_titles[]" class="w-full border border-slate-200 rounded-lg px-3 py-1.5 text-sm font-bold" placeholder="Judul Langkah">
                                <textarea name="estimasi_step_descs[]" class="w-full border border-slate-200 rounded-lg px-3 py-1.5 text-xs text-slate-600" rows="2" placeholder="Deskripsi Langkah"></textarea>
                            </div>
                            <button type="button" onclick="this.parentElement.remove()" class="text-red-500 font-bold text-xs hover:bg-red-50 px-2 py-6 rounded-md">X</button>
                        </div>`;
                        document.getElementById('estimasi-step-container').insertAdjacentHTML('beforeend', html);
                    }
                </script>
            </div>
        </div>

        <!-- 4: ALUR -->
        <div x-show="tab === 'alur'" x-transition.opacity.duration.300ms class="space-y-6" style="display: none;">
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-blue-500"></div>
                <h3 class="font-bold text-lg text-slate-800 mb-1">Modul: alur.blade.php</h3>
                <div class="flex justify-between items-start mb-4 pb-4 border-b border-slate-100">
                    <p class="text-xs font-medium text-slate-500">Langkah-langkah pendaftaran / Flow periksa yang tayang di infografis.</p>
                    <button type="button" onclick="addAlur()" class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-100">+ Tambah Langkah</button>
                </div>
                
                <div class="space-y-4" id="alur-container">
                    @if(is_array($setting->alur_pasien) && count($setting->alur_pasien) > 0)
                        @foreach($setting->alur_pasien as $index => $alur)
                        <div class="flex gap-4 items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center shrink-0">{{ $index + 1 }}</div>
                            <div class="flex-1 space-y-2">
                                <input type="text" name="alur_titles[]" value="{{ is_array($alur) ? ($alur['title'] ?? '') : ('Langkah '.($index + 1)) }}" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm font-bold" placeholder="Judul Alur">
                                <textarea name="alur_descs[]" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-xs text-slate-600" rows="2" placeholder="Deskripsi Alur...">{{ is_array($alur) ? ($alur['desc'] ?? '') : $alur }}</textarea>
                            </div>
                            <button type="button" onclick="this.parentElement.remove()" class="text-red-500 font-bold text-xs mt-2">X</button>
                        </div>
                        @endforeach
                    @else
                        <!-- Default Alur -->
                        @php
                            $def_alurs = [
                                ['title' => 'Registrasi & Login', 'desc' => 'Buat akun untuk merekam riwayat medis dasar Anda. Pasien baru dapat mendaftar dalam waktu kurang dari dua menit.'],
                                ['title' => 'Pilih & Booking Jadwal', 'desc' => 'Tentukan Cabang (Slawi, Tegal, Brebes), pilih dokter, lalu booking sesi pengobatan Anda kapan saja maksimal h-14.'],
                                ['title' => 'Pantau & Datang (H-Hari)', 'desc' => 'Lihat nomor antrean aktual dan datang ke klinik sesuai Estimasi Waktu Tunggu yang diberikan notifikasi.'],
                            ];
                        @endphp
                        @foreach($def_alurs as $index => $alur)
                        <div class="flex gap-4 items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center shrink-0">{{ $index + 1 }}</div>
                            <div class="flex-1 space-y-2">
                                <input type="text" name="alur_titles[]" value="{{ $alur['title'] }}" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm font-bold" placeholder="Judul Alur">
                                <textarea name="alur_descs[]" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-xs text-slate-600" rows="2" placeholder="Deskripsi Alur...">{{ $alur['desc'] }}</textarea>
                            </div>
                            <button type="button" onclick="this.parentElement.remove()" class="text-red-500 font-bold text-xs mt-2">X</button>
                        </div>
                        @endforeach
                    @endif
                </div>
                <script>
                    function addAlur() {
                        const html = `
                        <div class="flex gap-4 items-center mt-4">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center shrink-0">#</div>
                            <div class="flex-1 space-y-2">
                                <input type="text" name="alur_titles[]" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm font-bold" placeholder="Judul Alur Baru">
                                <textarea name="alur_descs[]" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-xs text-slate-600" rows="2" placeholder="Deskripsi Alur..."></textarea>
                            </div>
                            <button type="button" onclick="this.parentElement.remove()" class="text-red-500 font-bold text-xs mt-2">X</button>
                        </div>`;
                        document.getElementById('alur-container').insertAdjacentHTML('beforeend', html);
                    }
                </script>
            </div>
        </div>

        <!-- 5: CABANG -->
        <div x-show="tab === 'cabang'" x-transition.opacity.duration.300ms class="space-y-6" style="display: none;">
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-blue-500"></div>
                <h3 class="font-bold text-lg text-slate-800 mb-1">Modul: cabang.blade.php</h3>
                <p class="text-xs font-medium text-slate-500 mb-4 pb-4 border-b border-slate-100">Informasi geolokasi (Peta) dan daftar cabang yang tampil ke publik.</p>
                
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Teks Sub-Judul Cabang</label>
                        <textarea name="cabang_subjudul" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm">{{ $setting->cabang_subjudul }}</textarea>
                    </div>
                    <div class="bg-blue-50 rounded-xl p-4 border border-blue-200 mt-6">
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="font-bold text-blue-900 text-sm">Daftar Cabang Tampil di Landing</h4>
                            <button type="button" onclick="addCabang()" class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs font-bold hover:bg-blue-200">+ Tambah Cabang</button>
                        </div>
                        <div class="space-y-3" id="cabang-container">
                            @if(is_array($setting->cabang_list) && count($setting->cabang_list) > 0)
                                @foreach($setting->cabang_list as $cabang)
                                <div class="p-3 bg-white border border-blue-100 rounded-xl relative">
                                    <button type="button" onclick="this.parentElement.remove()" class="absolute top-2 right-2 text-red-400 hover:text-red-600 font-bold text-lg">&times;</button>
                                    <div class="pr-6 space-y-2">
                                        <input type="text" name="cabang_names[]" value="{{ $cabang['name'] ?? '' }}" class="w-full border-b border-dashed border-slate-300 text-sm font-bold text-slate-800 pb-1 outline-none" placeholder="Nama Klinik Cabang (Cth: Maxilla Slawi)">
                                        <input type="text" name="cabang_addresses[]" value="{{ $cabang['address'] ?? '' }}" class="w-full border-b border-dashed border-slate-300 text-xs text-slate-600 pb-1 outline-none" placeholder="Alamat Singkat...">
                                        <div class="grid grid-cols-3 gap-2 mt-2">
                                            <div><label class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Latitude</label><input type="text" name="cabang_lats[]" value="{{ $cabang['lat'] ?? '' }}" class="w-full border border-slate-200 rounded px-2 py-1 text-xs outline-none focus:border-blue-500" placeholder="-6.8814515"></div>
                                            <div><label class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Longitude</label><input type="text" name="cabang_lngs[]" value="{{ $cabang['lng'] ?? '' }}" class="w-full border border-slate-200 rounded px-2 py-1 text-xs outline-none focus:border-blue-500" placeholder="109.1362035"></div>
                                            <div><label class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Radius (Km)</label><input type="number" step="0.1" name="cabang_radius[]" value="{{ $cabang['radius'] ?? 0.1 }}" class="w-full border border-slate-200 rounded px-2 py-1 text-xs outline-none focus:border-blue-500" placeholder="0.1"></div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <!-- Defaults -->
                                @php
                                    $def_cabangs = [
                                        ['name' => 'Maxilla Dental Care Slawi', 'address' => 'Jl. Letjen Suprapto, Slawi, Kab. Tegal', 'lat' => '-6.9810035', 'lng' => '109.1292166', 'radius' => 0.1],
                                        ['name' => 'Maxilla Dental Care Tegal', 'address' => 'Jl. Kapten Sudibyo, Randugunting, Kec. Tegal Sel., Kota Tegal, Jawa Tengah', 'lat' => '-6.8814515', 'lng' => '109.1362035', 'radius' => 0.1],
                                        ['name' => 'Maxilla Dental Care Brebes', 'address' => 'Jl. Jend. Sudirman, Brebes, Kec. Brebes, Kabupaten Brebes, Jawa Tengah', 'lat' => '-6.8805365', 'lng' => '109.0390418', 'radius' => 0.1],
                                    ];
                                @endphp
                                @foreach($def_cabangs as $cabang)
                                <div class="p-3 bg-white border border-blue-100 rounded-xl relative">
                                    <button type="button" onclick="this.parentElement.remove()" class="absolute top-2 right-2 text-red-400 hover:text-red-600 font-bold text-lg">&times;</button>
                                    <div class="pr-6 space-y-2">
                                        <input type="text" name="cabang_names[]" value="{{ $cabang['name'] }}" class="w-full border-b border-dashed border-slate-300 text-sm font-bold text-slate-800 pb-1 outline-none">
                                        <input type="text" name="cabang_addresses[]" value="{{ $cabang['address'] }}" class="w-full border-b border-dashed border-slate-300 text-xs text-slate-600 pb-1 outline-none">
                                        <div class="grid grid-cols-3 gap-2 mt-2">
                                            <div><label class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Latitude</label><input type="text" name="cabang_lats[]" value="{{ $cabang['lat'] }}" class="w-full border border-slate-200 rounded px-2 py-1 text-xs outline-none focus:border-blue-500"></div>
                                            <div><label class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Longitude</label><input type="text" name="cabang_lngs[]" value="{{ $cabang['lng'] }}" class="w-full border border-slate-200 rounded px-2 py-1 text-xs outline-none focus:border-blue-500"></div>
                                            <div><label class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Radius (Km)</label><input type="number" step="0.1" name="cabang_radius[]" value="{{ $cabang['radius'] }}" class="w-full border border-slate-200 rounded px-2 py-1 text-xs outline-none focus:border-blue-500"></div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                
                <script>
                    function addCabang() {
                        const html = `
                        <div class="p-3 bg-white border border-blue-100 rounded-xl relative mt-3">
                            <button type="button" onclick="this.parentElement.remove()" class="absolute top-2 right-2 text-red-400 hover:text-red-600 font-bold text-lg">&times;</button>
                            <div class="pr-6 space-y-2">
                                <input type="text" name="cabang_names[]" class="w-full border-b border-dashed border-slate-300 text-sm font-bold text-slate-800 pb-1 outline-none" placeholder="Klinik Cabang...">
                                <input type="text" name="cabang_addresses[]" class="w-full border-b border-dashed border-slate-300 text-xs text-slate-600 pb-1 outline-none" placeholder="Alamat Lengkap...">
                                <div class="grid grid-cols-3 gap-2 mt-2">
                                    <div><label class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Latitude</label><input type="text" name="cabang_lats[]" class="w-full border border-slate-200 rounded px-2 py-1 text-xs outline-none focus:border-blue-500" placeholder="-6.8814515"></div>
                                    <div><label class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Longitude</label><input type="text" name="cabang_lngs[]" class="w-full border border-slate-200 rounded px-2 py-1 text-xs outline-none focus:border-blue-500" placeholder="109.1362035"></div>
                                    <div><label class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Radius (Km)</label><input type="number" step="0.1" name="cabang_radius[]" value="0.1" class="w-full border border-slate-200 rounded px-2 py-1 text-xs outline-none focus:border-blue-500"></div>
                                </div>
                            </div>
                        </div>`;
                        document.getElementById('cabang-container').insertAdjacentHTML('beforeend', html);
                    }
                </script>
            </div>
        </div>

        <!-- 6: FOOTER -->
        <div x-show="tab === 'footer'" x-transition.opacity.duration.300ms class="space-y-6" style="display: none;">
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-blue-500"></div>
                <h3 class="font-bold text-lg text-slate-800 mb-1">Modul: footer.blade.php</h3>
                <p class="text-xs font-medium text-slate-500 mb-4 pb-4 border-b border-slate-100">Teks hak cipta, logo bawah, sosial media, dan informasi kontak publik.</p>
                <h2 class="text-xl font-bold text-slate-800 mb-6 border-b border-slate-100 pb-4">Modul: footer.blade.php</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div class="w-full md:col-span-2">
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Teks Deskripsi Footer (Bawah Logo)</label>
                                <textarea name="footer_deskripsi" rows="2" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 outline-none" placeholder="Informasi Pemesanan...">{{ $setting->footer_deskripsi ?? 'Informasi Pemesanan dan Manajemen Antrian Maxilla Dental Care. Hubungi kami untuk bantuan lebih lanjut.' }}</textarea>
                            </div>
                            <div class="w-full">
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Nomor Ponsel (WhatsApp/CS)</label>
                            <input type="text" name="kontak_telepon" value="{{ $setting->kontak_telepon }}" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm" placeholder="0819 1234 5678">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1.5">Email Informasi</label>
                            <input type="email" name="kontak_email" value="{{ $setting->kontak_email }}" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm" placeholder="halo@maxilladental.com">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Teks Copyright (Bawah)</label>
                        <input type="text" name="teks_copyright" value="{{ $setting->teks_copyright }}" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm" placeholder="© 2026 Klinik Maxilla. All Rights Reserved.">
                    </div>
                </div>

                <!-- Bantuan WA Admin -->
                <h4 class="font-bold text-slate-800 mt-8 mb-4 border-b border-slate-100 pb-2">Bantuan Admin (WhatsApp)</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">No. WA Admin Tegal</label>
                        <input type="text" name="wa_tegal" value="{{ $setting->wa_tegal }}" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm mb-3" placeholder="6281234567890">
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Template Pesan Tegal</label>
                        <textarea name="wa_template_tegal" rows="2" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 outline-none" placeholder="Halo Maxilla Dental Care Tegal...">{{ $setting->wa_template_tegal ?? 'Halo Maxilla Dental Care Tegal, saya ingin bertanya tentang layanan Anda.' }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">No. WA Admin Slawi</label>
                        <input type="text" name="wa_slawi" value="{{ $setting->wa_slawi }}" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm mb-3" placeholder="6281234567891">
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Template Pesan Slawi</label>
                        <textarea name="wa_template_slawi" rows="2" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 outline-none" placeholder="Halo Maxilla Dental Care Slawi...">{{ $setting->wa_template_slawi ?? 'Halo Maxilla Dental Care Slawi, saya ingin bertanya tentang layanan Anda.' }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">No. WA Admin Brebes</label>
                        <input type="text" name="wa_brebes" value="{{ $setting->wa_brebes }}" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm mb-3" placeholder="6281234567892">
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Template Pesan Brebes</label>
                        <textarea name="wa_template_brebes" rows="2" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 outline-none" placeholder="Halo Maxilla Dental Care Brebes...">{{ $setting->wa_template_brebes ?? 'Halo Maxilla Dental Care Brebes, saya ingin bertanya tentang layanan Anda.' }}</textarea>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</form>
@endsection
