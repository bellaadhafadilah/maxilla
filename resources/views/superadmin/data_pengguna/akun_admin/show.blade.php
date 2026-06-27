@extends('layouts.dashboard')

@section('title', 'Detail Admin')

@section('content')
    <div class="mb-6 flex items-center gap-4 relative z-10">
        <a href="/superadmin/pengguna/admin"
            class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50 hover:text-indigo-600 transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        <div>
            <h1 class="font-heading text-3xl font-bold text-slate-800 tracking-tight">Detail Admin</h1>
            <p class="text-slate-500 mt-1 text-sm">Informasi lengkap profil dan riwayat akses staf administrasi.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 max-w-6xl">
        <!-- LEFT COLUMN: AVATAR & BASIC INFO -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-8 flex flex-col items-center text-center">
                <img class="w-32 h-32 rounded-full border-4 border-slate-50 shadow-md bg-indigo-100 object-cover mb-4"
                    src="https://ui-avatars.com/api/?name={{ urlencode($admin->nama) }}&background=e0e7ff&color=4338ca&size=128"
                    alt="Avatar">
                <h2 class="text-xl font-black text-slate-800">{{ $admin->nama }}</h2>
                <p class="text-indigo-600 font-bold text-sm mt-1 uppercase tracking-wider">Admin
                    {{ ucfirst($admin->cabang) }}</p>

                <div class="mt-6 w-full pt-6 border-t border-slate-100">
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full {{ $admin->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }} text-[11px] font-bold">
                        <span
                            class="w-1.5 h-1.5 rounded-full {{ $admin->is_active ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                        Akun {{ $admin->is_active ? 'Aktif' : 'Non-aktif' }}
                    </span>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
                <h3 class="font-bold text-slate-800 text-sm mb-4 border-b border-slate-50 pb-2 flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Informasi Kontak
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase font-black text-slate-400 tracking-widest">WhatsApp</p>
                            <p class="text-sm font-bold text-slate-700">{{ $admin->no_wa }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase font-black text-slate-400 tracking-widest">Email</p>
                            <p class="text-sm font-bold text-slate-700">{{ $admin->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: ACTIVITY & PENEMPATAN -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                    Detail Penempatan & Akses
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <p class="text-[10px] uppercase font-black text-slate-400 tracking-widest mb-1">Cabang Aktif</p>
                        <p class="text-lg font-bold text-slate-800">Maxilla {{ ucfirst($admin->cabang) }}</p>
                        <p class="text-xs text-slate-500 mt-1 italic">Bertanggung jawab atas operasional harian cabang.</p>
                    </div>

                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <p class="text-[10px] uppercase font-black text-slate-400 tracking-widest mb-1">Terdaftar Sejak</p>
                        <p class="text-lg font-bold text-slate-800">{{ $admin->created_at->translatedFormat('d F Y') }}</p>
                        <p class="text-xs text-slate-500 mt-1">ID Pengguna: #{{ $admin->id_user }}</p>
                    </div>
                </div>

                <div class="mt-8">
                    <h4 class="font-bold text-slate-800 text-sm mb-4">Aktivitas Login Terakhir</h4>
                    <div class="overflow-hidden border border-slate-100 rounded-xl">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-slate-50 text-slate-500 text-[11px] font-black uppercase tracking-wider">
                                <tr>
                                    <th class="px-4 py-3">Waktu Akses</th>
                                    <th class="px-4 py-3">Alamat IP</th>
                                    <th class="px-4 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                <tr>
                                    <td class="px-4 py-4 font-medium text-slate-700">
                                        {{ $admin->last_login_at ?? 'Belum pernah login' }}</td>
                                    <td class="px-4 py-4 text-slate-500">{{ $admin->last_login_ip ?? '-' }}</td>
                                    <td class="px-4 py-4">
                                        @if($admin->last_login_at)
                                            <span class="text-emerald-600 font-bold flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Berhasil
                                            </span>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">

                <a href="{{ route('superadmin.admin.edit', $admin->id_user) }}"
                    class="px-8 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition-all shadow-md flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    Edit Profil
                </a>
            </div>
        </div>
    </div>
@endsection