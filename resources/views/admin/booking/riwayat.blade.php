@extends('layouts.admin')

@section('title', 'Riwayat Reservasi')

@section('content')
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-5 relative z-10">
        <div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Riwayat Reservasi</h1>
            <p class="text-slate-500 text-sm mt-1">Data reservasi yang telah selesai, dibatalkan, atau kadaluarsa di Cabang {{ auth()->user()->cabang }}</p>
        </div>
        <div class="flex gap-3">
            <button onclick="window.location.reload()"
                class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-50 transition-all flex items-center gap-2 active:scale-95 shadow-sm">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                    </path>
                </svg>
                Refresh Data
            </button>
        </div>
    </div>

    {{-- FILTER FORM --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm mb-8">
        <form action="{{ route('admin.booking.riwayat') }}" method="GET"
            class="flex flex-col md:flex-row items-end gap-4">
            
            <div class="w-full md:w-1/4">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Cari Nama Pasien</label>
                <input type="text" name="nama" value="{{ request('nama') }}" placeholder="Ketik nama pasien..."
                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
            </div>
            
            <div class="w-full md:w-1/4">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Mulai</label>
                <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}"
                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
            </div>
            
            <div class="w-full md:w-1/4">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
            </div>
            
            <div class="w-full md:w-auto flex flex-1 gap-2">
                <button type="submit"
                    class="px-6 py-2.5 bg-blue-600 text-white font-bold text-sm rounded-xl hover:bg-blue-700 transition-colors shadow-sm w-full md:w-auto flex-1">
                    Terapkan Filter
                </button>
                <a href="{{ route('admin.booking.riwayat') }}"
                    class="px-6 py-2.5 bg-slate-100 text-slate-600 font-bold text-sm rounded-xl hover:bg-slate-200 transition-colors shadow-sm w-full md:w-auto text-center flex items-center justify-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- LIST --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="py-4 px-5 text-xs font-bold text-slate-500 uppercase tracking-wider">Pasien & ID</th>
                        <th class="py-4 px-5 text-xs font-bold text-slate-500 uppercase tracking-wider">Waktu Reservasi</th>
                        <th class="py-4 px-5 text-xs font-bold text-slate-500 uppercase tracking-wider">Dokter</th>
                        <th class="py-4 px-5 text-xs font-bold text-slate-500 uppercase tracking-wider">Keluhan</th>
                        <th class="py-4 px-5 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($reservasis as $res)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-5">
                                <p class="text-sm font-bold text-slate-800">{{ $res->nama_pasien ?? ($res->user->nama ?? 'Tidak Diketahui') }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-xs font-mono bg-slate-100 text-slate-500 px-2 py-0.5 rounded-md border border-slate-200">
                                        {{ $res->id_reservasi }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-4 px-5">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-700">
                                        {{ \Carbon\Carbon::parse($res->tanggal)->translatedFormat('d M Y') }}
                                    </span>
                                    <span class="text-xs text-slate-500 mt-0.5">{{ $res->jam }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-5">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold shrink-0">
                                        {{ substr($res->dokter_nama ?? 'D', 0, 1) }}
                                    </div>
                                    <span class="text-sm font-bold text-slate-700">{{ $res->dokter_nama ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-5">
                                <p class="text-xs text-slate-600 line-clamp-2 max-w-xs">{{ $res->keluhan ?? '-' }}</p>
                            </td>
                            <td class="py-4 px-5">
                                @if(strtolower($res->status) === 'selesai')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Selesai
                                    </span>
                                @elseif(strtolower($res->status) === 'dibatalkan')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-red-600 border border-red-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                        Dibatalkan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                                        {{ ucfirst($res->status) }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 mb-4">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-bold text-slate-700 mb-1">Belum ada riwayat</h3>
                                <p class="text-xs text-slate-500">Data riwayat reservasi kosong untuk filter ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
