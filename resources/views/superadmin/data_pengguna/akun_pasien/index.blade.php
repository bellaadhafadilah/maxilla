@extends('layouts.dashboard')

@section('title', 'Database Pasien')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-5 relative z-10">
    <div>
        <h1 class="font-heading text-3xl font-bold text-slate-800 tracking-tight">Database Pasien (Terpusat)</h1>
        <p class="text-slate-500 mt-1 text-sm">Sentralisasi data rekam medis, NIK, dan histori kunjungan pasien klinik.</p>
    </div>
    <div class="flex gap-2">
        
    </div>
</div>

@if(session('success'))
<div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium flex items-center gap-3">
    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    {{ session('success') }}
</div>
@endif

<!-- ========================================== -->
<!-- KPI STATS -->
<!-- ========================================== -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
        <div class="flex items-center gap-3 mb-2">
            <div class="p-2 bg-blue-50 text-blue-600 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Total Pasien</p>
        </div>
        <h3 class="text-3xl font-black text-slate-800">{{ number_format($stats['total_pasien']) }}</h3>
        <p class="text-[10px] font-bold text-blue-500 mt-1">+{{ $stats['new_this_month'] ?? 0 }} bulan ini</p>
    </div>
    
    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
        <div class="flex items-center gap-3 mb-2">
            <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Pendaftaran Baru</p>
        </div>
        <h3 class="text-3xl font-black text-slate-800">{{ $stats['kunjungan_terakhir'] }}</h3>
        <p class="text-[10px] font-bold text-slate-400 mt-1">Dalam 30 Hari Terakhir</p>
    </div>
   
</div>

<!-- ========================================== -->
<!-- TABLE VIEW -->
<!-- ========================================== -->
<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mb-8">
    <!-- Toolbar -->
    <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white">
        <div class="relative max-w-sm w-full">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" id="searchInput" class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 outline-none transition-all" placeholder="Cari nama pasien...">
        </div>
    </div>

    <!-- The actual table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-black text-slate-500 uppercase tracking-widest">
                    <th class="px-6 py-4">Pasien</th>
                    <th class="px-6 py-4">Kontak</th>
                    <th class="px-6 py-4">Status Akun</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @if(count($pasiens) > 0)
                    @foreach($pasiens as $pasien)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                @if($pasien->foto)
                                    <img src="{{ Storage::url($pasien->foto) }}" alt="Foto {{ $pasien->nama }}" class="w-10 h-10 rounded-full object-cover shadow-sm ring-2 ring-white">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-500 to-purple-500 text-white flex items-center justify-center font-bold text-sm shadow-sm ring-2 ring-white">
                                        {{ strtoupper(substr($pasien->nama, 0, 2)) }}
                                    </div>
                                @endif
                                <div>
                                    <h4 class="font-bold text-[14px] text-slate-800">{{ $pasien->nama }}</h4>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-medium text-[13px] text-slate-700">{{ $pasien->no_wa }}</span>
                                <span class="text-[11px] text-slate-400 font-medium">
                                    {{ $pasien->jenis_kelamin ?? '-' }} • {{ $pasien->alamat ? Str::limit($pasien->alamat, 20) : '-' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-bold text-[13px] {{ $pasien->is_active ? 'text-emerald-600' : 'text-rose-500' }}">
                                    {{ $pasien->is_active ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                                <span class="text-[11px] text-slate-400 font-medium italic">Terdaftar: {{ $pasien->created_at->format('d M Y') }}</span>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('superadmin.pasien.show', $pasien->id_user) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors border border-transparent hover:border-blue-100" title="Lihat Profil">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                                <button type="button" onclick="openToggleStatusModal('{{ route('superadmin.pasien.toggle-status', $pasien->id_user) }}', '{{ $pasien->nama }}', {{ $pasien->is_active ? 'true' : 'false' }})"
                                    class="p-1.5 {{ $pasien->is_active ? 'text-amber-500 hover:bg-amber-50 hover:border-amber-100' : 'text-emerald-500 hover:bg-emerald-50 hover:border-emerald-100' }} rounded-lg transition-colors border border-transparent"
                                    title="{{ $pasien->is_active ? 'Blokir Akun' : 'Aktifkan Akun' }}">
                                    @if($pasien->is_active)
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                    </svg>
                                    @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    @endif
                                </button>
                                <button type="button" 
                                        onclick="openDeleteModal('{{ route('superadmin.pasien.destroy', $pasien->id_user) }}', '{{ $pasien->nama }}')"
                                        class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition-colors border border-transparent hover:border-red-100" 
                                        title="Hapus Akun">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                            Belum ada data pasien terdaftar.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    
</div>
@endsection

<!-- MODAL KONFIRMASI HAPUS -->
<div id="deleteModal" class="fixed inset-0 z-[999] hidden">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
    <div class="fixed inset-0 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-slate-200">
                <div class="bg-white p-6 pt-8">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-50 mb-4">
                        <svg class="h-8 w-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div class="text-center">
                        <h3 class="text-xl font-black text-slate-800" id="modal-title">Hapus Akun Pasien?</h3>
                        <div class="mt-3">
                            <p class="text-sm text-slate-500 leading-relaxed">
                                Anda akan menghapus akun <span id="pasienNameDisplay" class="font-bold text-slate-800"></span> secara permanen. Seluruh data rekam medis yang tertaut akan terputus.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 px-6 py-4 flex flex-col-reverse sm:flex-row justify-end gap-3 border-t border-slate-100">
                    <button type="button" onclick="closeDeleteModal()" class="w-full sm:w-auto px-6 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-200 transition-all border border-slate-200 bg-white">
                        Batal
                    </button>
                    <form id="deleteForm" method="POST" class="w-full sm:w-auto">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-6 py-2.5 bg-red-600 text-white rounded-xl text-sm font-bold hover:bg-red-700 transition-all shadow-lg hover:shadow-red-200 active:scale-95">
                            Ya, Hapus Pasien
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<!-- MODAL KONFIRMASI STATUS -->
<div id="toggleStatusModal" class="fixed inset-0 z-[999] hidden">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
    <div class="fixed inset-0 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-slate-200">
                <div class="bg-white p-6 pt-8">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full mb-4" id="toggleModalIconBg">
                        <svg class="h-8 w-8" id="toggleModalIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24"></svg>
                    </div>
                    <div class="text-center">
                        <h3 class="text-xl font-black text-slate-800" id="toggleModalTitle">Ubah Status Akun?</h3>
                        <div class="mt-3">
                            <p class="text-sm text-slate-500 leading-relaxed">
                                <span id="toggleModalDesc"></span> akun <span id="togglePasienNameDisplay" class="font-bold text-slate-800"></span>?
                            </p>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-slate-50 px-6 py-4 flex flex-col-reverse sm:flex-row justify-end gap-3 border-t border-slate-100">
                    <button type="button" onclick="closeToggleStatusModal()"
                        class="w-full sm:w-auto px-6 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-200 transition-all border border-slate-200 bg-white">
                        Batal
                    </button>
                    <form id="toggleStatusForm" method="POST" class="w-full sm:w-auto">
                        @csrf
                        @method('PATCH')
                        <button type="submit" id="toggleSubmitBtn"
                            class="w-full px-6 py-2.5 text-white rounded-xl text-sm font-bold transition-all shadow-lg active:scale-95">
                            Ya, Lanjutkan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openToggleStatusModal(actionUrl, pasienName, isActive) {
        const modal = document.getElementById('toggleStatusModal');
        const form = document.getElementById('toggleStatusForm');
        const nameDisplay = document.getElementById('togglePasienNameDisplay');
        const title = document.getElementById('toggleModalTitle');
        const desc = document.getElementById('toggleModalDesc');
        const iconBg = document.getElementById('toggleModalIconBg');
        const icon = document.getElementById('toggleModalIcon');
        const btn = document.getElementById('toggleSubmitBtn');

        form.action = actionUrl;
        nameDisplay.textContent = pasienName;

        if (isActive) {
            title.textContent = 'Blokir Akun Pasien?';
            desc.textContent = 'Anda yakin ingin memblokir';
            iconBg.className = 'mx-auto flex h-16 w-16 items-center justify-center rounded-full mb-4 bg-amber-50 text-amber-500';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>';
            btn.className = 'w-full px-6 py-2.5 text-white rounded-xl text-sm font-bold transition-all shadow-lg active:scale-95 bg-amber-500 hover:bg-amber-600 hover:shadow-amber-200';
            btn.textContent = 'Ya, Blokir Akun';
        } else {
            title.textContent = 'Aktifkan Akun Pasien?';
            desc.textContent = 'Anda yakin ingin mengaktifkan kembali';
            iconBg.className = 'mx-auto flex h-16 w-16 items-center justify-center rounded-full mb-4 bg-emerald-50 text-emerald-500';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
            btn.className = 'w-full px-6 py-2.5 text-white rounded-xl text-sm font-bold transition-all shadow-lg active:scale-95 bg-emerald-500 hover:bg-emerald-600 hover:shadow-emerald-200';
            btn.textContent = 'Ya, Aktifkan Akun';
        }

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeToggleStatusModal() {
        const modal = document.getElementById('toggleStatusModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function openDeleteModal(actionUrl, name) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        const nameDisplay = document.getElementById('pasienNameDisplay');
        
        form.action = actionUrl;
        nameDisplay.textContent = name;
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    window.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeDeleteModal();
            closeToggleStatusModal();
        }
    });

    // Fungsi Filter Cari Nama Pasien
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const tableRows = document.querySelectorAll('tbody tr.group');

                tableRows.forEach(row => {
                    const nameElement = row.querySelector('h4');
                    if (nameElement) {
                        const name = nameElement.textContent.toLowerCase();
                        if (name.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    }
                });
            });
        }
    });
</script>
