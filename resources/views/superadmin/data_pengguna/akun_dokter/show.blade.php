@extends('layouts.dashboard')

@section('title', 'Detail Dokter')

@section('content')
    <div class="mb-6 flex items-center gap-4 relative z-10">
        <a href="{{ route('superadmin.dokter.index') }}"
            class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50 hover:text-blue-600 transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        <div>
            <h1 class="font-heading text-3xl font-bold text-slate-800 tracking-tight">Detail Dokter</h1>
            <p class="text-slate-500 mt-1 text-sm">Informasi lengkap akun dokter.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 max-w-6xl">
        <div class="lg:col-span-1">
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-8 flex flex-col items-center text-center">
                <img class="w-32 h-32 rounded-full border-4 border-slate-50 shadow-md bg-blue-100 object-cover mb-4"
                    src="https://ui-avatars.com/api/?name={{ urlencode($dokter->nama) }}&background=dbeafe&color=1d4ed8&size=128"
                    alt="Avatar">
                <h2 class="text-xl font-black text-slate-800">{{ $dokter->nama }}</h2>
                <p class="text-blue-600 font-bold text-sm mt-1 uppercase tracking-wider">Dokter Multi Cabang</p>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Profil Dokter</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-slate-400 text-xs uppercase font-black">Email</p>
                        <p class="font-bold text-slate-800">{{ $dokter->email }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs uppercase font-black">WhatsApp</p>
                        <p class="font-bold text-slate-800">{{ $dokter->no_wa }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs uppercase font-black">Penempatan</p>
                        <p class="font-bold text-slate-800">Multi Cabang</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs uppercase font-black">Status</p>
                        <p class="font-bold {{ $dokter->is_active ? 'text-emerald-600' : 'text-red-600' }}">
                            {{ $dokter->is_active ? 'Aktif' : 'Non-aktif' }}</p>
                    </div>
                </div>
            </div>

            <!-- <div class="flex items-center justify-end gap-3">
                <form action="{{ route('superadmin.dokter.destroy', $dokter->id_user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun dokter ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-2.5 border border-red-200 text-red-600 rounded-xl text-sm font-bold hover:bg-red-50 transition-all">Hapus Akun</button>
                </form>
                <a href="{{ route('superadmin.dokter.edit', $dokter->id_user) }}" class="px-8 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-bold hover:bg-blue-700 transition-all shadow-md">Edit Profil</a>
            </div> -->
        </div>
    </div>
@endsection