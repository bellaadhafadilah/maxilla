@extends('layouts.dokter')

@section('title', 'Riwayat Pemeriksaan')

@section('content')
<form method="GET" action="{{ route('dokter.riwayat') }}" class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-5 relative z-10">
    <div>
        <h1 class="font-heading text-3xl font-bold text-slate-800 tracking-tight">Riwayat Pemeriksaan</h1>
        <p class="text-slate-500 mt-1 text-sm">Lihat histori seluruh pasien yang pernah Anda tangani.</p>
    </div>
    <div class="flex gap-3 items-center relative flex-wrap">
        <div class="relative w-full sm:w-48">
            <label for="tanggal_awal" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Dari Tanggal</label>
            <input type="date" name="tanggal_awal" id="tanggal_awal" value="{{ request('tanggal_awal') }}" class="w-full pl-3 pr-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 active:scale-[0.98] transition-all bg-white shadow-sm">
        </div>
        <div class="relative w-full sm:w-48">
            <label for="tanggal_akhir" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Sampai Tanggal</label>
            <input type="date" name="tanggal_akhir" id="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="w-full pl-3 pr-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 active:scale-[0.98] transition-all bg-white shadow-sm">
        </div>
        <div class="relative w-full sm:w-64">
            <label for="nama" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Cari Pasien</label>
            <div class="absolute inset-y-0 left-0 pl-3 pt-6 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" name="nama" id="nama" value="{{ request('nama') }}" placeholder="Ketik nama pasien..." class="pl-10 pr-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 active:scale-[0.98] transition-all bg-white shadow-sm w-full">
        </div>

        <div class="flex items-center gap-2 mt-5">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-xl text-sm shadow-sm transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Terapkan
            </button>
            @if(request('tanggal_awal') || request('tanggal_akhir') || request('nama'))
                <a href="{{ route('dokter.riwayat') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold py-2 px-4 rounded-xl text-sm transition-colors">
                    Reset
                </a>
            @endif
        </div>
    </div>
</form>

<div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-8">
    <div class="p-6 border-b border-slate-100 bg-white">
        <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            Rekam Medis (Selesai)
        </h2>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-black text-slate-500 uppercase tracking-widest">
                    <th class="px-6 py-4">Tanggal / Waktu</th>
                    <th class="px-6 py-4">Nama Pasien</th>
                    <th class="px-6 py-4">Diagnosa Dasar</th>
                    <th class="px-6 py-4">Tindakan Khusus</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100" id="riwayatTableBody">
                @forelse($riwayats as $riwayat)
                @php
                    $searchText = strtolower(sprintf('%s %s %s %s %s', $riwayat->nama_pasien ?? ($riwayat->user->nama ?? ''), $riwayat->rekamMedis->assesment ?? '', $riwayat->rekamMedis->planning ?? '', $riwayat->dokter_nama ?? '', $riwayat->cabang ?? ''));
                @endphp
                <tr class="hover:bg-slate-50/50 transition-colors" data-search="{{ $searchText }}" data-date="{{ $riwayat->tanggal }}">
                    <td class="px-6 py-4">
                        <span class="font-bold text-[13px] text-slate-800 block">{{ \Carbon\Carbon::parse($riwayat->tanggal)->translatedFormat('d M Y') }}</span>
                        <span class="text-[11px] text-slate-500">{{ substr($riwayat->jam, 0, 5) }} WIB</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">{{ strtoupper(substr(($riwayat->nama_pasien ?? ($riwayat->user->nama ?? 'P')),0,1)) }}</div>
                            <div>
                                <div class="font-bold text-[14px] text-slate-800">{{ $riwayat->nama_pasien ?? ($riwayat->user->nama ?? 'Pasien Anonim') }}</div>
                                <div class="text-[11px] text-slate-400">{{ $riwayat->dokter_nama ?? '-' }} • <span class="font-bold text-[11px] text-slate-600">{{ $riwayat->cabang ?? '-' }}</span></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-block px-3 py-1 rounded-full bg-amber-50 text-amber-700 font-bold text-sm">{{ \Illuminate\Support\Str::limit($riwayat->rekamMedis->assesment ?? '-', 60) }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-[13px] text-slate-600">{{ \Illuminate\Support\Str::limit($riwayat->rekamMedis->planning ?? '-', 80) }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('dokter.rekam-medis.show', $riwayat->id_reservasi) }}" class="inline-block p-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition-colors shadow-sm" title="Lihat Rekam Medis">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-slate-500 text-sm">
                        Belum ada riwayat pemeriksaan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection


