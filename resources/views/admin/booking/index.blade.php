@extends('layouts.admin')

@section('title', 'Manajemen Booking & Antrian')

@section('content')
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-5 relative z-10">

        <div class="flex gap-3">
    <a href="{{ route('booking.create') }}"
        class="px-5 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-bold hover:bg-blue-700 transition-all flex items-center gap-2 shadow-sm">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 4v16m8-8H4"></path>
        </svg>
        Booking Manual
    </a>

    <button onclick="window.location.reload()"
        class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-50 transition-all flex items-center gap-2 active:scale-95 shadow-sm">
        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
            </path>
        </svg>
        Refresh Antrean
    </button>
</div>
    </div>

    {{-- ==========================================--}}
    {{-- FLASH MESSAGES --}}
    {{-- ==========================================--}}
    @if(session('success'))
        <div id="flash-success"
            class="mb-6 flex items-center gap-3 px-5 py-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl shadow-sm">
            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
            </svg>
            <span class="text-sm font-bold">{{ session('success') }}</span>
            <button onclick="document.getElementById('flash-success').remove()"
                class="ml-auto text-emerald-400 hover:text-emerald-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    @endif
    @if(session('error'))
        <div id="flash-error"
            class="mb-6 flex items-center gap-3 px-5 py-4 bg-red-50 border border-red-200 text-red-800 rounded-2xl shadow-sm">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-sm font-bold">{{ session('error') }}</span>
            <button onclick="document.getElementById('flash-error').remove()" class="ml-auto text-red-400 hover:text-red-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    @endif

    {{-- ==========================================--}}
    {{-- QUEUE MINI STATS --}}
    {{-- ==========================================--}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Total Booking
                </p>
                <h3 class="text-2xl font-black text-slate-800 tracking-tight">
                    {{ str_pad($stats['total'] ?? 0, 2, '0', STR_PAD_LEFT) }} Pasien
                </h3>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Menunggu</p>
                <h3 class="text-2xl font-black text-slate-800 tracking-tight">
                    {{ str_pad($stats['menunggu'] ?? 0, 2, '0', STR_PAD_LEFT) }} Pasien
                </h3>
            </div>
        </div>
        <div
            class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm flex items-center gap-4 border-l-4 border-l-emerald-500">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Selesai
                    Tindakan</p>
                <h3 class="text-2xl font-black text-slate-800 tracking-tight">
                    {{ str_pad($stats['selesai'] ?? 0, 2, '0', STR_PAD_LEFT) }} Pasien
                </h3>
            </div>
        </div>
    </div>

    {{-- ==========================================--}}
    {{-- BOOKING TABLE --}}
    {{-- ==========================================--}}
    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
        <!-- Search & Filter -->
        <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-white gap-4">
            <div class="relative max-w-sm w-full">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" id="searchInput"
                    class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block w-full pl-10 p-3 outline-none transition-all"
                    placeholder="Cari Kode Antrean atau Nama Pasien...">
            </div>
            <div class="flex items-center gap-3">
                <form method="GET" action="{{ route('admin.booking.index') }}" class="flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-400">DARI</span>
                    <input type="date" name="tanggal_awal" value="{{ $tanggal_awal }}" 
                        onchange="this.form.submit()"
                        class="bg-white border border-slate-200 text-slate-600 text-[13px] font-bold rounded-xl p-2.5 outline-none cursor-pointer hover:bg-slate-50 transition-all focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    <span class="text-xs font-bold text-slate-400">SAMPAI</span>
                    <input type="date" name="tanggal_akhir" value="{{ $tanggal_akhir }}" 
                        onchange="this.form.submit()"
                        class="bg-white border border-slate-200 text-slate-600 text-[13px] font-bold rounded-xl p-2.5 outline-none cursor-pointer hover:bg-slate-50 transition-all focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </form>
                <select id="statusFilter"
                    class="bg-white border border-slate-200 text-slate-600 text-[13px] font-bold rounded-xl p-3 outline-none cursor-pointer hover:bg-slate-50 transition-all border-r-8 border-transparent">
                    <option value="">Semua Status</option>
                    <option value="menunggu">Menunggu</option>
                    <option value="hadir">Hadir</option>
                    <option value="menunggu antrian">Menunggu Antrian</option>
                    <option value="diperiksa">Diperiksa</option>
                    <option value="menunggu obat">Menunggu Obat</option>
                    <option value="menunggu pembayaran">Menunggu Pembayaran</option>
                    <option value="selesai">Selesai</option>
                    <option value="ditangguhkan">Ditangguhkan</option>
                    <option value="kadaluarsa">Kadaluarsa</option>
                </select>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-slate-50/80 border-b border-slate-100 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">
                        <th class="px-8 py-5">Kode / Jam</th>
                        <th class="px-8 py-5">Identitas Pasien</th>
                        <th class="px-8 py-5">Layanan & Dokter</th>
                        <th class="px-8 py-5 text-center">Status Kehadiran</th>
                        <th class="px-8 py-5 text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-slate-50/50 transition-all group" data-name="{{ strtolower($booking['pasien']) }}"
                            data-kode="{{ strtolower($booking['no_antrian']) }}"
                            data-status="{{ strtolower($booking['status']) }}">
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="text-base font-black text-slate-800">{{ $booking['no_antrian'] }}</span>
                                    <span
                                        class="text-xs font-bold text-slate-400 mt-0.5 tracking-tighter">{{ $booking['waktu'] }}
                                        WIB</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-slate-700 font-bold text-[15px]">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 font-black text-xs border border-slate-200">
                                        {{ substr($booking['pasien'], 0, 1) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span
                                            class="truncate max-w-[130px] inline-block leading-tight">{{ $booking['pasien'] }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex flex-col items-start gap-1.5">
                                    <span
                                        class="px-2.5 py-1 bg-blue-50 text-blue-600 rounded-md text-[10px] font-black uppercase tracking-wider border border-blue-100">
                                        {{ $booking['poli'] }}
                                    </span>
                                    <span
                                        class="text-[11px] font-bold text-slate-500 flex items-center gap-1.5 truncate max-w-[150px]">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        {{ $booking['dokter'] }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex justify-center">
                                    @php $status = $booking['status']; @endphp

                                    @if($status == 'menunggu')
                                        <span
                                            class="flex items-center gap-2 px-3 py-1 bg-slate-50 text-slate-500 rounded-full text-[11px] font-black uppercase border border-slate-200 leading-none">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                            Belum Check-In
                                        </span>
                                    @elseif($status == 'hadir')
                                        <span
                                            class="flex items-center gap-2 px-3 py-1 bg-orange-50 text-orange-600 rounded-full text-[11px] font-black uppercase border border-orange-100 leading-none">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                                            Menunggu (Hadir)
                                        </span>
                                    @elseif($status == 'diperiksa' || $status == 'menunggu antrian')
                                        <span
                                            class="flex items-center gap-2 px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[11px] font-black uppercase border border-blue-100 leading-none">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                            Diperiksa
                                        </span>
                                    @elseif($status == 'menunggu obat')
                                        <span
                                            class="flex items-center gap-2 px-3 py-1 bg-purple-50 text-purple-600 rounded-full text-[11px] font-black uppercase border border-purple-100 leading-none">
                                            <span class="w-1.5 h-1.5 rounded-full bg-purple-500 animate-pulse"></span>
                                            Menunggu Obat
                                        </span>
                                    @elseif($status == 'menunggu pembayaran')
                                        <span
                                            class="flex items-center gap-2 px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-[11px] font-black uppercase border border-amber-100 leading-none">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                            Menunggu Bayar
                                        </span>
                                    @elseif($status == 'kadaluarsa')
                                        <span
                                            class="flex items-center gap-2 px-3 py-1 bg-red-50 text-red-600 rounded-full text-[11px] font-black uppercase border border-red-100 leading-none">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            Kadaluarsa
                                        </span>
                                    @elseif($status == 'ditangguhkan')
                                        <span
                                            class="flex items-center gap-2 px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-[11px] font-black uppercase border border-slate-200 leading-none">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Ditangguhkan
                                        </span>
                                    @elseif(in_array(strtolower($status), ['batal', 'dibatalkan']))
                                        <span
                                            class="flex items-center gap-2 px-3 py-1 bg-red-50 text-red-600 rounded-full text-[11px] font-black uppercase border border-red-100 leading-none">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            Batal
                                        </span>
                                    @else
                                        <span
                                            class="flex items-center gap-2 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[11px] font-black uppercase border border-emerald-100 leading-none">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Selesai
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    @if($status == 'menunggu')
                                        @if($booking['hubungan'] === 'Booking Manual')
                                            {{-- Booking manual: admin bisa check-in secara manual --}}
                                            <form id="form-checkin-{{ $booking['id'] }}" method="POST"
                                                action="{{ route('admin.booking.checkin', $booking['id']) }}">
                                                @csrf
                                                <button type="submit"
                                                    class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-black shadow-lg shadow-emerald-100 hover:shadow-emerald-200 transition-all active:scale-95 border border-emerald-500">
                                                    Check-In
                                                </button>
                                            </form>
                                        @else
                                            {{-- Pasien punya akun (booking online): tombol Panggil Poli dinonaktifkan (abu-abu) --}}
                                            <button disabled
                                                class="px-4 py-2 bg-slate-100 text-slate-400 rounded-xl text-xs font-black cursor-not-allowed border border-slate-200">
                                                Panggil Poli
                                            </button>
                                        @endif
                                    @elseif($status == 'hadir')
                                        {{-- Pasien sudah hadir, admin bisa panggil poli --}}
                                        <form id="form-panggil-{{ $booking['id'] }}" method="POST"
                                            action="{{ route('admin.booking.panggil-poli', $booking['id']) }}"
                                            x-data="{ showConfirm: false }">
                                            @csrf
                                            <button type="button"
                                                class="px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-black shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all active:scale-95"
                                                @click="showConfirm = true">
                                                Panggil Poli
                                            </button>

                                            <!-- Modal Konfirmasi Alpine -->
                                            <template x-teleport="body">
                                                <div x-show="showConfirm"
                                                    class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/40 backdrop-blur-sm"
                                                    style="display: none;" x-transition.opacity>
                                                    <div @click.away="showConfirm = false" x-show="showConfirm"
                                                        x-transition:enter="transition ease-out duration-300"
                                                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                        x-transition:leave="transition ease-in duration-200"
                                                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                        class="bg-white rounded-3xl shadow-2xl w-full max-w-sm p-6 relative mx-4">

                                                        <div
                                                            class="absolute -top-10 left-1/2 -translate-x-1/2 w-20 h-20 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center border-4 border-white shadow-sm">
                                                            <svg class="w-10 h-10" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z">
                                                                </path>
                                                            </svg>
                                                        </div>

                                                        <div class="mt-8 text-center">
                                                            <h3 class="text-xl font-bold text-slate-800 mb-2 tracking-tight">Panggil
                                                                Pasien?</h3>
                                                            <p class="text-sm text-slate-500 mb-8 leading-relaxed">Anda akan
                                                                memanggil pasien <strong
                                                                    class="text-slate-800 font-bold">{{ $booking['pasien'] }}</strong>
                                                                ke poli <strong
                                                                    class="text-slate-800 font-bold">{{ $booking['dokter'] }}</strong>.
                                                            </p>

                                                            <div class="flex gap-3">
                                                                <button type="button" @click="showConfirm = false"
                                                                    class="flex-1 py-3 px-4 bg-slate-100 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-200 transition-colors">Batal</button>
                                                                <button type="submit" form="form-panggil-{{ $booking['id'] }}"
                                                                    class="flex-1 py-3 px-4 bg-blue-600 text-white rounded-xl font-bold text-sm hover:bg-blue-700 transition-colors shadow-lg shadow-blue-200">Ya,
                                                                    Panggil</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </form>

                                        <form id="form-lewati-{{ $booking['id'] }}" method="POST" action="{{ route('admin.booking.lewati-poli', $booking['id']) }}" x-data="{ showConfirmLewati: false }">
                                            @csrf
                                            <button type="button" @click="showConfirmLewati = true" class="px-3 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-black hover:bg-slate-200 transition-all border border-slate-200 ml-2">
                                                Lewati
                                            </button>

                                            <!-- Modal Konfirmasi Lewati Alpine -->
                                            <template x-teleport="body">
                                                <div x-show="showConfirmLewati"
                                                    class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/40 backdrop-blur-sm"
                                                    style="display: none;" x-transition.opacity>
                                                    <div @click.away="showConfirmLewati = false" x-show="showConfirmLewati"
                                                        x-transition:enter="transition ease-out duration-300"
                                                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                        x-transition:leave="transition ease-in duration-200"
                                                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                        class="bg-white rounded-3xl shadow-2xl w-full max-w-sm p-6 relative mx-4">

                                                        <div
                                                            class="absolute -top-10 left-1/2 -translate-x-1/2 w-20 h-20 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center border-4 border-white shadow-sm">
                                                            <svg class="w-10 h-10" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                                                </path>
                                                            </svg>
                                                        </div>

                                                        <div class="mt-8 text-center">
                                                            <h3 class="text-xl font-bold text-slate-800 mb-2 tracking-tight">Lewati Pasien?</h3>
                                                            <p class="text-sm text-slate-500 mb-8 leading-relaxed">Anda yakin ingin menangguhkan (melewati) pasien <strong
                                                                    class="text-slate-800 font-bold">{{ $booking['pasien'] }}</strong>?</p>

                                                            <div class="flex gap-3">
                                                                <button type="button" @click="showConfirmLewati = false"
                                                                    class="flex-1 py-3 px-4 bg-slate-100 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-200 transition-colors">Batal</button>
                                                                <button type="submit" form="form-lewati-{{ $booking['id'] }}"
                                                                    class="flex-1 py-3 px-4 bg-amber-500 text-white rounded-xl font-bold text-sm hover:bg-amber-600 transition-colors shadow-lg shadow-amber-200">Ya, Lewati</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </form>
                                    @elseif($status == 'diperiksa' || $status == 'menunggu antrian')
                                        {{-- Sudah dipanggil, sedang diperiksa dokter --}}
                                        <span
                                            class="px-4 py-2 bg-blue-50 text-blue-500 rounded-xl text-xs font-black border border-blue-100">
                                            Sudah Dipanggil
                                        </span>
                                        <form id="form-lewati-{{ $booking['id'] }}" method="POST" action="{{ route('admin.booking.lewati-poli', $booking['id']) }}" x-data="{ showConfirmLewati: false }">
                                            @csrf
                                            <button type="button" @click="showConfirmLewati = true" class="px-3 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-black hover:bg-slate-200 transition-all border border-slate-200 ml-2">
                                                Lewati
                                            </button>

                                            <!-- Modal Konfirmasi Lewati Alpine -->
                                            <template x-teleport="body">
                                                <div x-show="showConfirmLewati"
                                                    class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/40 backdrop-blur-sm"
                                                    style="display: none;" x-transition.opacity>
                                                    <div @click.away="showConfirmLewati = false" x-show="showConfirmLewati"
                                                        x-transition:enter="transition ease-out duration-300"
                                                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                        x-transition:leave="transition ease-in duration-200"
                                                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                        class="bg-white rounded-3xl shadow-2xl w-full max-w-sm p-6 relative mx-4">

                                                        <div
                                                            class="absolute -top-10 left-1/2 -translate-x-1/2 w-20 h-20 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center border-4 border-white shadow-sm">
                                                            <svg class="w-10 h-10" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                                                </path>
                                                            </svg>
                                                        </div>

                                                        <div class="mt-8 text-center">
                                                            <h3 class="text-xl font-bold text-slate-800 mb-2 tracking-tight">Lewati Pasien?</h3>
                                                            <p class="text-sm text-slate-500 mb-8 leading-relaxed">Anda yakin ingin menangguhkan (melewati) pasien <strong
                                                                    class="text-slate-800 font-bold">{{ $booking['pasien'] }}</strong>?</p>

                                                            <div class="flex gap-3">
                                                                <button type="button" @click="showConfirmLewati = false"
                                                                    class="flex-1 py-3 px-4 bg-slate-100 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-200 transition-colors">Batal</button>
                                                                <button type="submit" form="form-lewati-{{ $booking['id'] }}"
                                                                    class="flex-1 py-3 px-4 bg-amber-500 text-white rounded-xl font-bold text-sm hover:bg-amber-600 transition-colors shadow-lg shadow-amber-200">Ya, Lewati</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </form>
                                    @elseif($status == 'menunggu obat')
                                        <span
                                            class="px-4 py-2 bg-purple-50 text-purple-500 rounded-xl text-xs font-black border border-purple-100">
                                            Di Apotek
                                        </span>
                                    @elseif($status == 'menunggu pembayaran')
                                        <span
                                            class="px-4 py-2 bg-amber-50 text-amber-500 rounded-xl text-xs font-black border border-amber-100">
                                            Di Kasir
                                        </span>
                                    @elseif($status == 'kadaluarsa')
                                        <span
                                            class="px-4 py-2 bg-red-50 text-red-500 rounded-xl text-xs font-black border border-red-100">
                                            Expired
                                        </span>
                                    @elseif($status == 'ditangguhkan')
                                        <form id="form-kembalikan-{{ $booking['id'] }}" method="POST" action="{{ route('admin.booking.kembalikan-antrian', $booking['id']) }}" x-data="{ showConfirmKembalikan: false }">
                                            @csrf
                                            <button type="button" @click="showConfirmKembalikan = true" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-black shadow-lg shadow-emerald-100 hover:shadow-emerald-200 transition-all active:scale-95 border border-emerald-500">
                                                Kembalikan Antrean
                                            </button>

                                            <!-- Modal Konfirmasi Kembalikan Alpine -->
                                            <template x-teleport="body">
                                                <div x-show="showConfirmKembalikan"
                                                    class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/40 backdrop-blur-sm"
                                                    style="display: none;" x-transition.opacity>
                                                    <div @click.away="showConfirmKembalikan = false" x-show="showConfirmKembalikan"
                                                        x-transition:enter="transition ease-out duration-300"
                                                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                        x-transition:leave="transition ease-in duration-200"
                                                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                        class="bg-white rounded-3xl shadow-2xl w-full max-w-sm p-6 relative mx-4">

                                                        <div
                                                            class="absolute -top-10 left-1/2 -translate-x-1/2 w-20 h-20 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center border-4 border-white shadow-sm">
                                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                            </svg>
                                                        </div>

                                                        <div class="mt-8 text-center">
                                                            <h3 class="text-xl font-bold text-slate-800 mb-2 tracking-tight">Kembalikan Antrean?</h3>
                                                            <p class="text-sm text-slate-500 mb-8 leading-relaxed">Anda yakin ingin mengembalikan antrean pasien <strong
                                                                    class="text-slate-800 font-bold">{{ $booking['pasien'] }}</strong>?</p>

                                                            <div class="flex gap-3">
                                                                <button type="button" @click="showConfirmKembalikan = false"
                                                                    class="flex-1 py-3 px-4 bg-slate-100 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-200 transition-colors">Batal</button>
                                                                <button type="submit" form="form-kembalikan-{{ $booking['id'] }}"
                                                                    class="flex-1 py-3 px-4 bg-emerald-600 text-white rounded-xl font-bold text-sm hover:bg-emerald-700 transition-colors shadow-lg shadow-emerald-200">Ya, Kembalikan</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </form>
                                    @elseif(in_array(strtolower($status), ['batal', 'dibatalkan']))
                                        <span class="px-4 py-2 bg-red-50 text-red-500 rounded-xl text-xs font-black border border-red-100">
                                            Dibatalkan
                                        </span>
                                    @else
                                        <span class="px-4 py-2 bg-emerald-50 text-emerald-500 rounded-xl text-xs font-black">✓
                                            Selesai</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-16 text-center text-slate-400 text-sm">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-12 h-12 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                        </path>
                                    </svg>
                                    <span class="font-bold">Belum ada booking hari ini.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function filterTable() {
            const q = document.getElementById('searchInput').value.toLowerCase();
            const status = document.getElementById('statusFilter').value.toLowerCase();
            
            document.querySelectorAll('tbody tr[data-name]').forEach(row => {
                const name = row.dataset.name || '';
                const kode = row.dataset.kode || '';
                const rowStatus = row.dataset.status || '';
                
                const matchSearch = q === '' || name.includes(q) || kode.includes(q);
                const matchStatus = status === '' || rowStatus === status;
                
                row.style.display = (matchSearch && matchStatus) ? '' : 'none';
            });
        }

        document.getElementById('searchInput').addEventListener('input', filterTable);
        document.getElementById('statusFilter').addEventListener('change', filterTable);
    </script>
@endsection