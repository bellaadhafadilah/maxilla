@extends('layouts.dashboard')

@section('title', 'Data Akun ' . $roleLabel)

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-end justify-between gap-5 relative z-10">
    <div>
        <h1 class="font-heading text-3xl font-bold text-slate-800 tracking-tight">Akun {{ $roleLabel }}</h1>
        <p class="text-slate-500 mt-1 text-sm">Manajemen akses dan data akun {{ strtolower($roleLabel) }} di semua cabang.</p>
    </div>
    <a href="{{ route('superadmin.' . $roleSlug . '.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all active:scale-95">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
        Tambah Akun {{ $roleLabel }}
    </a>
</div>

@if(session('success'))
<div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3 animate-fade-in">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
    <span class="font-bold text-sm">{{ session('success') }}</span>
</div>
@endif

<div class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-6 py-4 text-xs font-black text-slate-500 uppercase tracking-widest">Data {{ $roleLabel }}</th>
                    <th class="px-6 py-4 text-xs font-black text-slate-500 uppercase tracking-widest">Kontak</th>
                    <th class="px-6 py-4 text-xs font-black text-slate-500 uppercase tracking-widest text-center">Cabang</th>
                    <th class="px-6 py-4 text-xs font-black text-slate-500 uppercase tracking-widest text-center">Status</th>
                    <th class="px-6 py-4 text-xs font-black text-slate-500 uppercase tracking-widest text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($staffs as $staff)
                <tr class="hover:bg-slate-50 transition-colors group">
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center text-slate-500 font-bold group-hover:from-blue-500 group-hover:to-indigo-500 group-hover:text-white transition-all shadow-sm">
                                {{ substr($staff->nama, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800">{{ $staff->nama }}</h3>
                                <p class="text-xs text-slate-400 font-medium">{{ $staff->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-slate-700">{{ $staff->no_wa }}</span>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">WhatsApp / HP</span>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <span class="inline-flex px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-black border border-blue-100 uppercase tracking-tighter">
                            {{ $staff->cabang }}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-center">
                        @if($staff->is_active)
                            <span class="inline-flex items-center gap-1.5 text-emerald-600 font-black text-[10px] uppercase">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Aktif
                            </span>
                        @else
                            <span class="text-slate-400 font-black text-[10px] uppercase italic">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('superadmin.' . $roleSlug . '.edit', $staff->id_user) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('superadmin.' . $roleSlug . '.toggle-status', $staff->id_user) }}" method="POST" class="inline" x-data="{ showToggleConfirm: false }" x-ref="toggleForm">
                                @csrf
                                @method('PATCH')
                                <button type="button" @click="showToggleConfirm = true"
                                    class="p-2 {{ $staff->is_active ? 'text-amber-500 hover:text-amber-600 hover:bg-amber-50' : 'text-emerald-500 hover:text-emerald-600 hover:bg-emerald-50' }} rounded-lg transition-all"
                                    title="{{ $staff->is_active ? 'Blokir Akun' : 'Aktifkan Akun' }}">
                                    @if($staff->is_active)
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                    </svg>
                                    @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    @endif
                                </button>

                                <!-- Modal Konfirmasi Status -->
                                <template x-teleport="body">
                                    <div x-show="showToggleConfirm" x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                        x-transition:leave="transition ease-in duration-200"
                                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                        class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                                        style="display: none;">

                                        <div @click.away="showToggleConfirm = false" x-show="showToggleConfirm"
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                            x-transition:leave="transition ease-in duration-200"
                                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                                            class="bg-white rounded-3xl p-8 max-w-sm w-full shadow-2xl border border-slate-100 text-center relative overflow-hidden">

                                            @if($staff->is_active)
                                            <div class="w-20 h-20 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-6">
                                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                </svg>
                                            </div>
                                            <h3 class="font-bold text-xl text-slate-800 mb-3">Blokir Akun {{ $roleLabel }}?</h3>
                                            <p class="text-slate-500 text-sm mb-8 leading-relaxed">Apakah Anda yakin ingin memblokir akun <span class="font-bold text-slate-800">{{ $staff->nama }}</span>?</p>
                                            @else
                                            <div class="w-20 h-20 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6">
                                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <h3 class="font-bold text-xl text-slate-800 mb-3">Aktifkan Akun {{ $roleLabel }}?</h3>
                                            <p class="text-slate-500 text-sm mb-8 leading-relaxed">Apakah Anda yakin ingin mengaktifkan kembali akun <span class="font-bold text-slate-800">{{ $staff->nama }}</span>?</p>
                                            @endif

                                            <div class="grid grid-cols-2 gap-4">
                                                <button @click="showToggleConfirm = false" type="button" class="px-6 py-3 rounded-2xl text-sm font-bold text-slate-500 bg-slate-100 hover:bg-slate-200 transition-colors">
                                                    Batal
                                                </button>
                                                <button type="button" @click="$refs.toggleForm.submit()" class="px-6 py-3 rounded-2xl text-sm font-bold text-white {{ $staff->is_active ? 'bg-amber-500 hover:bg-amber-600 shadow-amber-100' : 'bg-emerald-500 hover:bg-emerald-600 shadow-emerald-100' }} transition-all shadow-lg">
                                                    Ya, Lanjutkan
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </form>
                            <form action="{{ route('superadmin.' . $roleSlug . '.destroy', $staff->id_user) }}" method="POST" class="inline" x-data="{ showDeleteConfirm: false }" x-ref="deleteForm">
                                @csrf
                                @method('DELETE')
                                <button type="button" @click="showDeleteConfirm = true" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>

                                <!-- Modal Konfirmasi Hapus -->
                                <template x-teleport="body">
                                    <div x-show="showDeleteConfirm" x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                        x-transition:leave="transition ease-in duration-200"
                                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                        class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                                        style="display: none;">

                                        <div @click.away="showDeleteConfirm = false" x-show="showDeleteConfirm"
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                            x-transition:leave="transition ease-in duration-200"
                                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                                            class="bg-white rounded-3xl p-8 max-w-sm w-full shadow-2xl border border-slate-100 text-center relative overflow-hidden">

                                            <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </div>

                                            <h3 class="font-bold text-xl text-slate-800 mb-3">Konfirmasi Hapus</h3>
                                            <p class="text-slate-500 text-sm mb-8 leading-relaxed">Apakah Anda yakin ingin menghapus akun ini secara permanen?</p>

                                            <div class="grid grid-cols-2 gap-4">
                                                <button @click="showDeleteConfirm = false" type="button" class="px-6 py-3 rounded-2xl text-sm font-bold text-slate-500 bg-slate-100 hover:bg-slate-200 transition-colors">
                                                    Batal
                                                </button>
                                                <button type="button" @click="$refs.deleteForm.submit()" class="px-6 py-3 rounded-2xl text-sm font-bold text-white bg-red-500 hover:bg-red-600 transition-all shadow-lg shadow-red-100">
                                                    Ya, Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <p class="text-slate-400 font-bold">Belum ada akun {{ strtolower($roleLabel) }}.</p>
                            <p class="text-xs text-slate-300 mt-1">Klik tombol "Tambah" untuk membuat akun baru.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
