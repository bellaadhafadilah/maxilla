@extends('layouts.dashboard')

@section('title', 'Manajemen Admin Cabang')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-5 relative z-10">

        <a href="/superadmin/pengguna/admin/create"
            class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition-all shadow-[0_4px_12px_rgba(79,70,229,0.25)] hover:shadow-[0_6px_16px_rgba(79,70,229,0.35)] flex items-center gap-2 active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
            Tambah Admin Baru
        </a>
    </div>

    <!-- ========================================== -->
    <!-- KPI STATS -->
    <!-- ========================================== -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg"><svg class="w-5 h-5" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg></div>
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Total Admin Aktif</p>
            </div>
            <h3 class="text-3xl font-black text-slate-800">{{ $stats['total_active'] }} <span
                    class="text-xs font-medium text-slate-500 ml-1">Orang</span></h3>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm relative overflow-hidden">
            <div class="absolute right-0 top-0 w-1.5 h-full bg-emerald-500"></div>
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg"><svg class="w-5 h-5" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg></div>
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Online Saat Ini</p>
            </div>
            <h3 class="text-3xl font-black text-slate-800">{{ $stats['online_now'] }} <span
                    class="text-xs font-medium text-emerald-600 ml-1 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100 animate-pulse">Live</span>
            </h3>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-amber-50 text-amber-600 rounded-lg"><svg class="w-5 h-5" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg></div>
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Membutuhkan Rotasi</p>
            </div>
            <h3 class="text-3xl font-black text-slate-800">{{ $stats['needs_rotation'] }}</h3>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- TABLE VIEW -->
    <!-- ========================================== -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mb-8">
        <!-- Toolbar -->
        <form action="{{ url('/superadmin/pengguna/admin') }}" method="GET" class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white">
            <div class="relative max-w-sm w-full">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5 outline-none transition-all"
                    placeholder="Cari nama admin...">
                <button type="submit" class="hidden"></button>
            </div>
            <div class="flex items-center gap-2">
                <select name="cabang" onchange="this.form.submit()"
                    class="bg-white border border-slate-200 text-slate-600 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 outline-none font-medium cursor-pointer hover:bg-slate-50 transition-colors">
                    <option value="">Semua Cabang</option>
                    <option value="slawi" {{ request('cabang') == 'slawi' ? 'selected' : '' }}>Maxilla Slawi</option>
                    <option value="tegal" {{ request('cabang') == 'tegal' ? 'selected' : '' }}>Maxilla Tegal</option>
                    <option value="brebes" {{ request('cabang') == 'brebes' ? 'selected' : '' }}>Maxilla Brebes</option>
                </select>
            </div>
        </form>

        @if(session('success'))
            <div
                class="mx-5 mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- The actual table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr
                        class="bg-slate-50 border-b border-slate-200 text-[11px] font-black text-slate-500 uppercase tracking-widest">
                        <th class="px-6 py-4">Profil Admin</th>
                        <th class="px-6 py-4">Cabang Penempatan</th>
                        <th class="px-6 py-4">Sesi Terakhir (Login)</th>
                        <th class="px-6 py-4">Status Akun</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @if(count($admins) > 0)
                        @foreach($admins as $admin)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <img class="w-10 h-10 rounded-full border-2 border-white shadow-sm bg-indigo-100 object-cover"
                                            src="https://ui-avatars.com/api/?name={{ urlencode($admin->nama) }}&background=e0e7ff&color=4338ca"
                                            alt="Avatar">
                                        <div>
                                            <h4 class="font-bold text-[14px] text-slate-800">{{ $admin->nama }}</h4>
                                            <p class="text-[11px] text-slate-500 font-medium mt-0.5">{{ $admin->no_wa }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-slate-700 text-[12px] font-bold shadow-sm">
                                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                            </path>
                                        </svg>
                                        Maxilla {{ ucfirst($admin->cabang) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span
                                            class="font-bold text-[13px] text-slate-800">{{ $admin->last_login_at ?? 'Belum pernah login' }}</span>
                                        <span class="text-[11px] text-slate-400 font-medium">IP:
                                            {{ $admin->last_login_ip ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full {{ $admin->is_active ? 'bg-emerald-50 border-emerald-100 text-emerald-700' : 'bg-red-50 border-red-100 text-red-700' }} text-[11px] font-bold">
                                        <span
                                            class="w-1.5 h-1.5 rounded-full {{ $admin->is_active ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                        {{ $admin->is_active ? 'Aktif' : 'Non-aktif' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('superadmin.admin.show', $admin->id_user) }}"
                                            class="p-1.5 text-slate-500 hover:bg-slate-100 rounded-lg transition-colors border border-transparent hover:border-slate-200"
                                            title="Detail Admin">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('superadmin.admin.edit', $admin->id_user) }}"
                                            class="p-1.5 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors border border-transparent hover:border-indigo-100"
                                            title="Edit Data">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg>
                                        </a>
                                        <button type="button" onclick="openToggleStatusModal('{{ route('superadmin.admin.toggle-status', $admin->id_user) }}', '{{ $admin->nama }}', {{ $admin->is_active ? 'true' : 'false' }})"
                                            class="p-1.5 {{ $admin->is_active ? 'text-amber-500 hover:bg-amber-50 hover:border-amber-100' : 'text-emerald-500 hover:bg-emerald-50 hover:border-emerald-100' }} rounded-lg transition-colors border border-transparent"
                                            title="{{ $admin->is_active ? 'Blokir Akun' : 'Aktifkan Akun' }}">
                                            @if($admin->is_active)
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
                                            onclick="openDeleteModal('{{ route('superadmin.admin.destroy', $admin->id_user) }}', '{{ $admin->nama }}')"
                                            class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition-colors border border-transparent hover:border-red-100"
                                            title="Hapus Akun">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="p-3 bg-slate-50 rounded-full mb-3">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h4 class="text-slate-800 font-bold">Belum ada data admin</h4>
                                    <p class="text-slate-500 text-sm mt-1">Silakan tambahkan admin baru dengan menekan tombol di
                                        atas.</p>
                                </div>
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
            <div
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-slate-200">
                <div class="bg-white p-6 pt-8">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-50 mb-4">
                        <svg class="h-8 w-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                    <div class="text-center">
                        <h3 class="text-xl font-black text-slate-800" id="modal-title">Hapus Akun Admin?</h3>
                        <div class="mt-3">
                            <p class="text-sm text-slate-500 leading-relaxed">
                                Anda akan menghapus akun <span id="adminNameDisplay"
                                    class="font-bold text-slate-800"></span> secara permanen. Tindakan ini tidak dapat
                                dibatalkan.
                            </p>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-slate-50 px-6 py-4 flex flex-col-reverse sm:flex-row justify-end gap-3 border-t border-slate-100">
                    <button type="button" onclick="closeDeleteModal()"
                        class="w-full sm:w-auto px-6 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-200 transition-all border border-slate-200 bg-white">
                        Batal
                    </button>
                    <form id="deleteForm" method="POST" class="w-full sm:w-auto">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full px-6 py-2.5 bg-red-600 text-white rounded-xl text-sm font-bold hover:bg-red-700 transition-all shadow-lg hover:shadow-red-200 active:scale-95">
                            Ya, Hapus Akun
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
                                <span id="toggleModalDesc"></span> akun <span id="toggleAdminNameDisplay" class="font-bold text-slate-800"></span>?
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
    function openDeleteModal(actionUrl, adminName) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        const nameDisplay = document.getElementById('adminNameDisplay');

        form.action = actionUrl;
        nameDisplay.textContent = adminName;

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto'; // Restore scrolling
    }

    function openToggleStatusModal(actionUrl, adminName, isActive) {
        const modal = document.getElementById('toggleStatusModal');
        const form = document.getElementById('toggleStatusForm');
        const nameDisplay = document.getElementById('toggleAdminNameDisplay');
        const title = document.getElementById('toggleModalTitle');
        const desc = document.getElementById('toggleModalDesc');
        const iconBg = document.getElementById('toggleModalIconBg');
        const icon = document.getElementById('toggleModalIcon');
        const btn = document.getElementById('toggleSubmitBtn');

        form.action = actionUrl;
        nameDisplay.textContent = adminName;

        if (isActive) {
            title.textContent = 'Blokir Akun Admin?';
            desc.textContent = 'Anda yakin ingin memblokir';
            iconBg.className = 'mx-auto flex h-16 w-16 items-center justify-center rounded-full mb-4 bg-amber-50 text-amber-500';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>';
            btn.className = 'w-full px-6 py-2.5 text-white rounded-xl text-sm font-bold transition-all shadow-lg active:scale-95 bg-amber-500 hover:bg-amber-600 hover:shadow-amber-200';
            btn.textContent = 'Ya, Blokir Akun';
        } else {
            title.textContent = 'Aktifkan Akun Admin?';
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

    // Close on escape key
    window.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeDeleteModal();
            closeToggleStatusModal();
        }
    });
</script>