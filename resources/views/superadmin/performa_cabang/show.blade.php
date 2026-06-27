@extends('layouts.dashboard')

@section('title', 'Performa Cabang - ' . $cabangMeta['nama'])

@section('content')
    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-5 relative z-10">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('superadmin.dashboard') }}"
                    class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-100/80 text-slate-500 hover:bg-slate-200 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <span
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-{{ $cabangMeta['warna'] }}-50 text-{{ $cabangMeta['warna'] }}-700 text-[11px] font-black uppercase tracking-widest border border-{{ $cabangMeta['warna'] }}-100 shadow-sm">
                    Detail Performa Cabang
                </span>
            </div>
            <!-- <h1 class="font-heading text-3xl font-bold text-slate-800 tracking-tight">{{ $cabangMeta['nama'] }}</h1> -->
        </div>

        <div class="flex items-center gap-3">
            <!-- Date Filter Mock -->
            <button
                class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl text-sm font-semibold hover:border-slate-300 hover:bg-slate-50 transition-all shadow-sm flex items-center gap-2 active:scale-95">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Hari Ini (Live)
            </button>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- ROW 1: INFORMASI UMUM CABANG -->
    <!-- ========================================== -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-8 relative overflow-hidden group">
        <!-- Decor Graphic -->
        <svg class="absolute -right-20 -bottom-20 w-80 h-80 text-blue-50/50 group-hover:scale-105 transition-transform duration-700"
            fill="currentColor" viewBox="0 0 24 24">
            <path
                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
            </path>
        </svg>

        <div class="flex flex-col md:flex-row gap-8 relative z-10">
            <!-- Identity -->
            <div class="flex items-start gap-5 min-w-[300px]">
                <div
                    class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-{{ $cabangMeta['warna'] }}-600 to-{{ $cabangMeta['warna'] }}-400 flex items-center justify-center text-white shadow-lg shadow-blue-500/30 shrink-0">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-800 leading-tight">{{ $cabangMeta['nama'] }}</h2>
                    <p class="text-[13px] text-slate-500 mt-1 max-w-[250px] leading-relaxed">{{ $cabangMeta['alamat'] }}</p>
                    <div class="flex gap-2 mt-3">
                        <span
                            class="px-2.5 py-1 rounded-md bg-emerald-100 border border-emerald-200 text-emerald-700 text-[10px] font-black uppercase tracking-wider flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Buka/Aktif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Meta Details -->
            <div class="flex-1 grid grid-cols-2 lg:grid-cols-4 gap-6 self-center border-l border-slate-100 pl-8">
                <div>
                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1.5">No. Telepon</p>
                    <p class="text-[15px] font-bold text-slate-700">{{ $cabangMeta['telp'] }}</p>
                </div>
                <div>
                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Jam Buka</p>
                    <p class="text-[15px] font-bold text-slate-700">07.00 - 21.00 <span
                            class="text-[12px] text-emerald-500 font-medium">WIB</span></p>
                </div>
                <div>
                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Email Cabang</p>
                    <p class="text-[15px] font-bold text-slate-700">{{ $adminEmail }}</p>
                </div>
                <div>
                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Total Dokter</p>
                    <p class="text-[15px] font-bold text-slate-700">{{ count($doctorList) }} <span class="text-xs font-normal text-slate-500">Orang</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- ROW 2: STATISTIK HARI INI (5 KOTAK) -->
    <!-- ========================================== -->
    <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        Pantauan Langsung (Hari Ini)
    </h2>
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">

        <!-- Box 1 -->
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm hover:border-blue-300 transition-colors">
            <div class="flex justify-between items-start mb-2">
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Total Booking</p>
                <div class="p-1.5 bg-slate-100 text-slate-500 rounded-lg"><svg class="w-4 h-4" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg></div>
            </div>
            <h3 class="font-heading text-3xl font-black text-slate-800">{{ $statsToday['booking'] }}</h3>
        </div>

        <!-- Box 2 -->
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm hover:border-emerald-300 transition-colors">
            <div class="flex justify-between items-start mb-2">
                <p class="text-[11px] font-black text-emerald-600 uppercase tracking-widest">Pasien Hadir</p>
                <div class="p-1.5 bg-emerald-50 text-emerald-600 rounded-lg"><svg class="w-4 h-4" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                    </svg></div>
            </div>
            <h3 class="font-heading text-3xl font-black text-slate-800">{{ $statsToday['hadir'] }}</h3>
            <p class="text-[10px] text-slate-400 font-bold mt-1">{{ $statsToday['hadir_rate'] }}% Dari Booking</p>
        </div>

        <!-- Box 3 -->
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm hover:border-amber-300 transition-colors">
            <div class="flex justify-between items-start mb-2">
                <p class="text-[11px] font-black text-amber-600 uppercase tracking-widest">Menunggu</p>
                <div class="p-1.5 bg-amber-50 text-amber-600 rounded-lg"><svg class="w-4 h-4" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg></div>
            </div>
            <h3 class="font-heading text-3xl font-black text-slate-800">{{ $statsToday['menunggu'] }}</h3>
            @if($statsToday['menunggu'] > 0)
                <p class="text-[10px] text-amber-600 font-bold mt-1 animate-pulse">Sedang di ruang tunggu</p>
            @else
                <p class="text-[10px] text-slate-400 font-bold mt-1">Antrean Kosong</p>
            @endif
        </div>

        <!-- Box 4 -->
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm hover:border-rose-300 transition-colors">
            <div class="flex justify-between items-start mb-2">
                <p class="text-[11px] font-black text-rose-500 uppercase tracking-widest">Tidak Hadir</p>
                <div class="p-1.5 bg-rose-50 text-rose-500 rounded-lg"><svg class="w-4 h-4" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg></div>
            </div>
            <h3 class="font-heading text-3xl font-black text-slate-800">{{ $statsToday['batal'] }}</h3>
            <p class="text-[10px] text-slate-400 font-bold mt-1">Batal/Terlewat</p>
        </div>

        <!-- Box 5 -->
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm hover:border-indigo-300 transition-colors">
            <div class="flex justify-between items-start mb-2">
                <p class="text-[11px] font-black text-indigo-500 uppercase tracking-widest">Jadwal Shift Dokter</p>
                <div class="p-1.5 bg-indigo-50 text-indigo-500 rounded-lg"><svg class="w-4 h-4" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg></div>
            </div>
            <h3 class="font-heading text-3xl font-black text-slate-800">{{ count($schedulesToday) }} <span
                    class="text-[14px] font-bold text-slate-400">Shift</span></h3>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- ROW 3: SPLIT SECTION (SHIFT DOCTORS vs MTHLY STATS) -->
    <!-- ========================================== -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">

        <!-- LEFT: Antrian Per Dokter (Hari Ini) -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm overflow-hidden flex flex-col">
            <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                    Antrian Per Dokter (Hari Ini)
                </div>
                <span
                    class="inline-flex px-2.5 py-1 bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-wider rounded-lg border border-indigo-100">Live</span>
            </h2>

            <div class="space-y-5 flex-1 p-1 max-h-[400px] overflow-y-auto">
                @forelse($schedulesToday as $jadwal)
                    @php
                        $colors = ['blue', 'rose', 'emerald', 'amber', 'purple'];
                        $color = $colors[$loop->index % count($colors)];

                        $opacityClass = $jadwal->shift_status === 'belum_mulai' ? 'opacity-60 hover:opacity-100' : '';
                    @endphp
                    <div
                        class="p-4 rounded-xl border border-slate-100 hover:border-slate-200 bg-slate-50/30 transition-colors {{ $opacityClass }}">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full border-2 border-white shadow-sm bg-{{ $color }}-100 text-{{ $color }}-700 flex items-center justify-center font-bold text-sm shrink-0">
                                    {{ strtoupper(substr(str_replace(['Drg. ', 'drg. '], '', $jadwal->dokter_nama), 0, 2)) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-[14px] text-slate-800 leading-tight">{{ $jadwal->dokter_nama }}
                                    </h4>
                                    <p class="text-[12px] text-slate-500 font-medium">Shift
                                        {{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}
                                    </p>
                                </div>
                            </div>
                            @if($jadwal->shift_status === 'berjalan')
                                <span
                                    class="px-2 py-0.5 bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest rounded animate-pulse">Berjalan</span>
                            @elseif($jadwal->shift_status === 'selesai')
                                <span
                                    class="px-2 py-0.5 bg-slate-100 text-slate-500 text-[10px] font-black uppercase tracking-widest rounded">Selesai</span>
                            @else
                                <span class="text-[11px] font-medium text-slate-400">Belum Mulai</span>
                            @endif
                        </div>
                        <!-- Progress & Stats -->
                        <div>
                            <div class="flex justify-between text-[11px] font-bold text-slate-500 mb-1.5 px-0.5">
                                <span class="text-emerald-600">Terlayani: {{ $jadwal->terlayani }}</span>
                                <span class="text-amber-500">Menunggu: {{ $jadwal->menunggu }}</span>
                                <span class="text-slate-400">Total: {{ $jadwal->antrian }}</span>
                            </div>
                            <div class="w-full bg-slate-200 rounded-full h-2.5 overflow-hidden flex">
                                <div class="bg-emerald-500 h-2.5" style="width: {{ $jadwal->p_terlayani }}%"></div>
                                <div class="bg-amber-400 h-2.5" style="width: {{ $jadwal->p_menunggu }}%"></div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="flex flex-col items-center justify-center p-8 text-center bg-slate-50 border border-dashed border-slate-200 rounded-xl">
                        <p class="text-slate-500 font-bold mb-1">Tidak ada jadwal dokter</p>
                        <p class="text-xs text-slate-400">Belum ada dokter yang bertugas hari ini pada cabang ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- RIGHT: Statistik Bulanan Cabang -->
        <div
            class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex flex-col relative overflow-hidden group">
            <!-- Floating decors -->
            <svg class="absolute -right-10 -top-10 w-40 h-40 text-slate-50/80 group-hover:rotate-12 transition-transform duration-700 pointer-events-none"
                fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 21a9 9 0 100-18 9 9 0 000 18zm0-16a7 7 0 110 14 7 7 0 010-14z"></path>
            </svg>

            <div class="flex items-center justify-between mb-6 relative z-10">
                <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    Statistik Bulanan
                </h2>
                <div
                    class="px-3 py-1 bg-slate-100 rounded-lg text-[11px] font-black uppercase text-slate-500 tracking-wider">
                    {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 flex-1 relative z-10">
                <!-- Big Stat Full Width -->
                <div
                    class="col-span-2 p-5 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl text-white shadow-[0_4px_12px_rgba(37,99,235,0.25)] flex items-center justify-between">
                    <div>
                        <p class="text-[12px] font-bold text-blue-100 uppercase tracking-widest mb-1">Total Kunjungan Cabang
                        </p>
                        <h3 class="text-3xl font-black">{{ $monthStats['total_kunjungan'] }} <span
                                class="text-sm font-medium text-blue-200">Pasien</span></h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-white/20 flex flex-col items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                </div>

                <!-- Small Stats -->
                <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Poli Umum (Estimasi)</p>
                    <div class="flex items-end gap-2 text-slate-800">
                        <h3 class="text-2xl font-black">{{ $monthStats['umum'] }}</h3>
                        <span class="text-xs font-bold text-slate-400 mb-1">orang</span>
                    </div>
                </div>

                <div class="p-4 bg-rose-50 border border-rose-100 rounded-xl">
                    <p class="text-[10px] font-bold text-rose-600 uppercase tracking-widest mb-1">No-Show Rate</p>
                    <div class="flex items-end gap-2 text-rose-800">
                        <h3 class="text-2xl font-black">{{ $monthStats['batal'] }}</h3>
                        <span
                            class="text-[11px] font-black text-rose-500 bg-rose-100 px-1.5 py-0.5 rounded mb-1">({{ $monthStats['no_show_rate'] }}%)</span>
                    </div>
                </div>

                <div class="p-4 bg-indigo-50 border border-indigo-100 rounded-xl">
                    <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest mb-1">Dokter Tersibuk</p>
                    <h3 class="text-base font-bold text-indigo-800 mt-[5px] truncate">{{ $monthStats['dokter_tersibuk'] }}
                    </h3>
                    <p class="text-[10px] font-medium text-indigo-600 mt-1">{{ $monthStats['dokter_tersibuk_qty'] }} Pasien
                        Ditangani</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- ROW 4: GRAFIK KUNJUNGAN CABANG (APEX) -->
    <!-- ========================================== -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col mb-8 overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 relative z-10">
            <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                </svg>
                Grafik Kunjungan (Harian Bulan Ini) - Simulated
            </h2>

            <div class="inline-flex bg-slate-100 p-1 rounded-xl">
                <button
                    class="px-3 py-1.5 text-[11px] font-bold uppercase tracking-wider rounded-lg transition-all bg-white shadow text-indigo-700">Maret
                    (Ini)</button>
                <button
                    class="px-3 py-1.5 text-[11px] font-bold uppercase tracking-wider rounded-lg transition-all text-slate-500 hover:text-slate-700">Februari
                    (Lalu)</button>
            </div>
        </div>

        <div class="w-full relative min-h-[290px]">
            <div id="branchVisitChart" class="w-full h-full -ml-3"></div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- ROW 5: DAFTAR DOKTER DI CABANG (TABLE) -->
    <!-- ========================================== -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mb-8">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-white">
            <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
                Daftar Dokter Regulater {{ $cabangMeta['nama'] }}
            </h2>
            <a href="{{ route('superadmin.jadwal.index', ['cabang' => $cabang]) }}"
                class="text-[13px] font-bold text-indigo-600 hover:bg-slate-50 px-3 py-1.5 rounded-lg border border-transparent hover:border-slate-200 transition-all">Lihat
                Jadwal Penuh &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr
                        class="bg-slate-50/70 border-b border-slate-200 text-[11px] font-black text-slate-400 uppercase tracking-widest">
                        <th class="px-6 py-4">Nama Dokter</th>
                        <th class="px-6 py-4">Sesi Shift Terakhir</th>
                        <th class="px-6 py-4">Total Pasien (Bulan Ini)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($doctorList as $dokter)
                        @php
                            $colors = ['indigo', 'emerald', 'sky', 'rose', 'amber'];
                            $color = $colors[$loop->index % count($colors)];
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full border-2 border-white shadow-sm bg-{{ $color }}-100 text-{{ $color }}-700 flex items-center justify-center font-bold text-xs shrink-0">
                                        {{ strtoupper(substr(str_replace(['Drg. ', 'drg. '], '', $dokter['nama']), 0, 2)) }}
                                    </div>
                                    <span class="font-bold text-[14px] text-slate-800">{{ $dokter['nama'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-slate-100 text-slate-600 text-[12px] font-bold">{{ $dokter['shift_label'] }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="text-[14px] font-black text-slate-800">{{ $dokter['total_pasien_bln'] }} <span
                                            class="text-[12px] font-bold text-slate-400 ml-1">Pasien</span></span>
                                    @if($dokter['is_tersibuk'] && $dokter['total_pasien_bln'] > 0)
                                        <span
                                            class="px-1.5 py-0.5 bg-yellow-100 text-yellow-700 text-[10px] font-black uppercase rounded shadow-sm border border-yellow-200">Tersibuk</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-slate-500 font-medium">Belum ada dokter terdaftar
                                di cabang ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ApexChart Logic -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var options = {
                series: [{
                    name: 'Kunjungan Harian',
                    type: 'area', // Creates the shaded area below line
                    data: [12, 18, 14, 25, 20, 32, 28, 35, 30, 42, 38, 45, 40]
                }, {
                    name: 'Rata-rata Bulan Lalu',
                    type: 'line',
                    data: [15, 15, 15, 22, 22, 22, 28, 28, 28, 32, 32, 32, 38]
                }],
                chart: {
                    height: 300,
                    type: 'line',
                    parentHeightOffset: 0,
                    toolbar: { show: false },
                    fontFamily: 'Arial, Helvetica, sans-serif' // Fallback to safe font
                },
                colors: ['#4f46e5', '#94a3b8'], // Indigo 600, Slate 400
                dataLabels: { enabled: false },
                stroke: {
                    curve: ['smooth', 'stepline'], // Area is smooth, benchmark line is step
                    width: [3, 2],
                    dashArray: [0, 6] // Benchmark line is dashed
                },
                fill: {
                    type: ['gradient', 'solid'],
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.3,
                        opacityTo: 0.0,
                        stops: [0, 95, 100]
                    }
                },
                xaxis: {
                    categories: ['1 Mar', '3 Mar', '5 Mar', '7 Mar', '10 Mar', '12 Mar', '14 Mar', '17 Mar', '19 Mar', '22 Mar', '24 Mar', '26 Mar', '28 Mar'],
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: {
                        style: { colors: '#64748b', fontSize: '11px', fontWeight: 600 }
                    }
                },
                yaxis: {
                    labels: {
                        style: { colors: '#64748b', fontSize: '11px', fontWeight: 600 }
                    }
                },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4,
                    xaxis: { lines: { show: false } },
                    yaxis: { lines: { show: true } }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    itemMargin: { horizontal: 10, vertical: 0 },
                    fontSize: '12px',
                    fontWeight: 600,
                    markers: { radius: 12 }
                },
                tooltip: { theme: 'light' }
            };

            var chart = new ApexCharts(document.querySelector("#branchVisitChart"), options);
            chart.render();
        });
    </script>
@endsection