@extends('layouts.dokter')

@section('title', 'Antrian Hari Ini')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-5 relative z-10">
    <div>
        <h1 class="font-heading text-3xl font-black text-slate-800 tracking-tight">Antrian Hari Ini</h1>
        <p class="text-slate-500 mt-1.5 text-sm">Daftar pasien yang terdaftar di shift Anda hari ini.</p>
    </div>
    <div class="flex gap-2">
        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-50 text-blue-700 text-xs font-bold border border-blue-100 shadow-sm animate-pulse">
            <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
            Sedang Berlangsung
        </span>
    </div>
</div>

@php
    $totalCount = $antrians->count();
    $diperiksaCount = $antrians->where('status', 'Diperiksa')->count();
    $menungguCount = $antrians->filter(fn($a) => $a->status == 'Menunggu Antrian' || strtolower($a->status) == 'hadir')->count();
    $selesaiCount = $antrians->filter(fn($a) => in_array(strtolower($a->status), ['selesai', 'menunggu obat', 'menunggu pembayaran']))->count();
@endphp

<!-- Stats Grid -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <!-- Stat 1 -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-between group">
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Antrean</p>
            <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $totalCount }}</h3>
        </div>
        <div class="p-3 bg-blue-50 text-blue-600 rounded-xl group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
    </div>

    <!-- Stat 2 -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-between group">
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Sedang Diperiksa</p>
            <h3 class="text-2xl font-black text-indigo-600 mt-1">{{ $diperiksaCount }}</h3>
        </div>
        <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
        </div>
    </div>

    <!-- Stat 3 -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-between group">
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Menunggu</p>
            <h3 class="text-2xl font-black text-amber-500 mt-1">{{ $menungguCount }}</h3>
        </div>
        <div class="p-3 bg-amber-50 text-amber-600 rounded-xl group-hover:bg-amber-600 group-hover:text-white transition-all duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>

    <!-- Stat 4 -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-between group">
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Selesai Tindakan</p>
            <h3 class="text-2xl font-black text-emerald-600 mt-1">{{ $selesaiCount }}</h3>
        </div>
        <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>
</div>

<div class="bg-white border border-slate-200 rounded-3xl shadow-[0_4px_25px_rgba(0,0,0,0.02)] overflow-hidden mb-8">
    <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-blue-50/30 via-white to-white gap-4">
        <h2 class="text-lg font-bold text-slate-800 flex items-center gap-3">
            <span class="p-2 bg-blue-50 text-blue-600 rounded-xl border border-blue-100/50">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </span>
            Daftar Antrian Pasien
        </h2>
    </div>
    
    <!-- Desktop View: Table -->
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">
                    <th class="px-8 py-5 w-36">No / Jam</th>
                    <th class="px-8 py-5">Identitas & Keluhan</th>
                    <th class="px-8 py-5 text-center">Status</th>
                    <th class="px-8 py-5 text-right w-64">Tindakan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($antrians as $index => $antrian)
                <tr class="{{ $antrian->status == 'Diperiksa' ? 'bg-blue-50/20 hover:bg-blue-50/40' : 'hover:bg-slate-50/40' }} transition-all duration-200 group">
                    <td class="px-8 py-6 align-top pt-8">
                        <div class="flex flex-col border-l-4 {{ $antrian->status == 'Diperiksa' ? 'border-blue-600 pl-3' : 'border-transparent pl-3' }} transition-all">
                            <span class="text-lg font-black tracking-tight {{ $antrian->status == 'Diperiksa' ? 'text-blue-600' : 'text-slate-800' }}">A{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <span class="text-xs font-bold text-slate-400 mt-1 tracking-tighter">{{ substr($antrian->jam, 0, 5) }} WIB</span>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full {{ $antrian->status == 'Diperiksa' ? 'bg-gradient-to-tr from-blue-600 to-indigo-500 text-white' : 'bg-slate-100 text-slate-500 border border-slate-200' }} flex items-center justify-center font-black text-sm shrink-0 shadow-sm">
                                @php
                                    $nama_pasien = $antrian->nama_pasien ?? ($antrian->user->nama ?? 'P');
                                @endphp
                                {{ substr($nama_pasien, 0, 1) }}
                            </div>
                            <div class="flex flex-col w-full">
                                <span class="text-[15px] font-bold text-slate-800 leading-tight">
                                    {{ $nama_pasien }}
                                </span>
                                
                                <div class="mt-2.5 flex items-start gap-2 bg-slate-50 border border-slate-200/60 rounded-xl p-3 w-full max-w-lg shadow-sm">
                                    <svg class="w-4 h-4 text-amber-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    <span class="text-xs text-slate-600 leading-relaxed font-medium">{{ $antrian->keluhan ?? 'Tidak ada keluhan yang dicatat.' }}</span>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6 text-center align-top pt-8">
                        <div class="flex justify-center">
                            @if($antrian->status == 'Diperiksa')
                                <span class="flex items-center gap-2 px-3.5 py-1.5 bg-blue-600 text-white rounded-full text-[10px] font-black uppercase tracking-wider leading-none shadow-md shadow-blue-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-ping"></span>
                                    Diperiksa
                                </span>
                            @elseif($antrian->status == 'Menunggu Antrian' || strtolower($antrian->status) == 'hadir')
                                <span class="flex items-center gap-2 px-3.5 py-1.5 bg-amber-500 text-white rounded-full text-[10px] font-black uppercase tracking-wider leading-none shadow-md shadow-amber-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                                    Menunggu
                                </span>
                            @elseif(in_array(strtolower($antrian->status), ['selesai', 'menunggu obat', 'menunggu pembayaran']))
                                <span class="flex items-center gap-2 px-3.5 py-1.5 bg-emerald-500 text-white rounded-full text-[10px] font-black uppercase tracking-wider leading-none shadow-md shadow-emerald-100">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3.5" d="M5 13l4 4L19 7"></path></svg>
                                    Selesai
                                </span>
                            @elseif(in_array(strtolower($antrian->status), ['batal', 'dibatalkan']))
                                <span class="flex items-center gap-2 px-3.5 py-1.5 bg-red-50 text-red-600 rounded-full text-[10px] font-black uppercase tracking-wider leading-none border border-red-100">
                                    <svg class="w-3 h-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Batal
                                </span>
                            @else
                                <span class="flex items-center gap-2 px-3.5 py-1.5 bg-slate-100 text-slate-600 rounded-full text-[10px] font-black uppercase tracking-wider leading-none border border-slate-200">
                                    {{ $antrian->status }}
                                </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-8 py-6 text-right align-top pt-7">
                        @if($antrian->status == 'Menunggu Antrian' || strtolower($antrian->status) == 'hadir' || $antrian->status == 'Diperiksa')
                            <a href="{{ route('dokter.rekam-medis.create', $antrian->id_reservasi) }}" 
                               class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-r {{ $antrian->status == 'Diperiksa' ? 'from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-blue-200' : 'from-slate-800 to-slate-900 hover:from-black hover:to-slate-900 shadow-slate-200' }} text-white rounded-2xl text-xs font-black shadow-lg transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0 group/btn">
                                <svg class="w-4 h-4 text-blue-200 group-hover/btn:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                {{ $antrian->status == 'Diperiksa' ? 'ISI REKAM MEDIS' : 'PERIKSA PASIEN' }}
                            </a>
                        @else
                            <a href="{{ route('dokter.rekam-medis.show', $antrian->id_reservasi) }}" 
                               class="inline-flex items-center gap-2 px-5 py-3 bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-blue-600 hover:border-blue-500 rounded-2xl text-xs font-black shadow-sm transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                LIHAT DATA
                            </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-8 py-16 text-center text-slate-400">
                        <div class="flex flex-col items-center gap-3">
                            <div class="p-4 bg-slate-50 text-slate-300 rounded-2xl">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </div>
                            <span class="font-bold text-sm text-slate-400">Tidak ada pasien dalam antrian hari ini.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile View: Card List -->
    <div class="block md:hidden">
        <div class="divide-y divide-slate-100">
            @forelse($antrians as $index => $antrian)
            <div class="p-5 {{ $antrian->status == 'Diperiksa' ? 'bg-blue-50/10' : '' }} flex flex-col gap-4">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full {{ $antrian->status == 'Diperiksa' ? 'bg-gradient-to-tr from-blue-600 to-indigo-500 text-white' : 'bg-slate-100 text-slate-500 border border-slate-200' }} flex items-center justify-center font-black text-sm shrink-0 shadow-sm">
                            {{ substr($antrian->nama_pasien ?? ($antrian->user->nama ?? 'P'), 0, 1) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-sm leading-tight">{{ $antrian->nama_pasien ?? ($antrian->user->nama ?? 'P') }}</h4>
                            <p class="text-xs text-slate-400 font-medium mt-0.5">{{ substr($antrian->jam, 0, 5) }} WIB</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-1.5">
                        <span class="px-2.5 py-1 bg-slate-100 border border-slate-200 text-slate-700 rounded-lg text-[10px] font-black uppercase tracking-wider">
                            A{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                        </span>
                        
                        @if($antrian->status == 'Diperiksa')
                            <span class="flex items-center gap-1.5 px-2 py-0.5 bg-blue-600 text-white rounded-md text-[9px] font-black uppercase tracking-wider leading-none shadow-sm shadow-blue-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-white animate-ping"></span>
                                Diperiksa
                            </span>
                        @elseif($antrian->status == 'Menunggu Antrian' || strtolower($antrian->status) == 'hadir')
                            <span class="flex items-center gap-1.5 px-2 py-0.5 bg-amber-500 text-white rounded-md text-[9px] font-black uppercase tracking-wider leading-none shadow-sm shadow-amber-100">
                                <span class="w-1 h-1 rounded-full bg-white animate-pulse"></span>
                                Menunggu
                            </span>
                        @elseif(in_array(strtolower($antrian->status), ['selesai', 'menunggu obat', 'menunggu pembayaran']))
                            <span class="flex items-center gap-1.5 px-2 py-0.5 bg-emerald-500 text-white rounded-md text-[9px] font-black uppercase tracking-wider leading-none shadow-sm shadow-emerald-100">
                                Selesai
                            </span>
                        @elseif(in_array(strtolower($antrian->status), ['batal', 'dibatalkan']))
                            <span class="flex items-center gap-1.5 px-2 py-0.5 bg-red-50 text-red-600 rounded-md text-[9px] font-black uppercase tracking-wider leading-none border border-red-100">
                                Batal
                            </span>
                        @else
                            <span class="flex items-center gap-1.5 px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md text-[9px] font-black uppercase tracking-wider leading-none border border-slate-200">
                                {{ $antrian->status }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Complaint -->
                <div class="flex items-start gap-2 bg-slate-50 border border-slate-200/60 rounded-xl p-3 shadow-sm">
                    <svg class="w-4 h-4 text-amber-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <span class="text-xs text-slate-600 leading-relaxed font-medium">{{ $antrian->keluhan ?? 'Tidak ada keluhan yang dicatat.' }}</span>
                </div>

                <!-- Actions -->
                <div>
                    @if($antrian->status == 'Menunggu Antrian' || strtolower($antrian->status) == 'hadir' || $antrian->status == 'Diperiksa')
                        <a href="{{ route('dokter.rekam-medis.create', $antrian->id_reservasi) }}" 
                           class="w-full text-center inline-flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r {{ $antrian->status == 'Diperiksa' ? 'from-blue-600 to-indigo-600' : 'from-slate-800 to-slate-900' }} text-white rounded-2xl text-xs font-black shadow-lg transition-all duration-200 active:scale-[0.98]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            {{ $antrian->status == 'Diperiksa' ? 'ISI REKAM MEDIS' : 'PERIKSA PASIEN' }}
                        </a>
                    @else
                        <a href="{{ route('dokter.rekam-medis.show', $antrian->id_reservasi) }}" 
                           class="w-full text-center inline-flex items-center justify-center gap-2 px-4 py-3 bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-blue-600 rounded-2xl text-xs font-black shadow-sm transition-all duration-200 active:scale-[0.98]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            LIHAT DATA
                        </a>
                    @endif
                </div>
            </div>
            @empty
            <div class="px-8 py-16 text-center text-slate-400">
                <div class="flex flex-col items-center gap-3">
                    <div class="p-4 bg-slate-50 text-slate-300 rounded-2xl">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <span class="font-bold text-sm text-slate-400">Tidak ada pasien dalam antrian hari ini.</span>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

