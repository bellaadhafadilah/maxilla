@extends('layouts.dashboard')

@section('title', 'Manajemen Akun Dokter')

@section('content')

    <style>
        .dokter-wrap {
            font-family: 'DM Sans', sans-serif;
        }

        .card-stat {
            background: #fff;
            border: 1px solid #e8edf3;
            border-radius: 14px;
            padding: 1.25rem 1.5rem;
            transition: box-shadow .2s, transform .2s;
        }

        .card-stat:hover {
            box-shadow: 0 6px 24px rgba(37, 99, 235, .08);
            transform: translateY(-2px);
        }

        .stat-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #94a3b8;
            margin-bottom: .5rem;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: #1e293b;
            line-height: 1;
        }

        .stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .main-card {
            background: #fff;
            border: 1px solid #e8edf3;
            border-radius: 16px;
            overflow: hidden;
        }

        .search-bar {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            flex-wrap: wrap;
        }

        .search-input-wrap {
            flex: 1;
            min-width: 200px;
            display: flex;
            align-items: center;
            gap: .5rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: .5rem .9rem;
        }

        .search-input-wrap svg {
            color: #94a3b8;
            flex-shrink: 0;
        }

        .search-input-wrap input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 13px;
            color: #334155;
            width: 100%;
        }

        .search-input-wrap input::placeholder {
            color: #94a3b8;
        }

        .filter-select {
            padding: .5rem .9rem;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 13px;
            color: #334155;
            background: #f8fafc;
            outline: none;
            cursor: pointer;
        }

        .tbl {
            width: 100%;
            border-collapse: collapse;
        }

        .tbl thead tr {
            background: #f8fafc;
            border-bottom: 1px solid #e8edf3;
        }

        .tbl thead th {
            padding: .85rem 1.25rem;
            font-size: 10.5px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #94a3b8;
            text-align: left;
            white-space: nowrap;
        }

        .tbl tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: background .15s;
        }

        .tbl tbody tr:last-child {
            border-bottom: none;
        }

        .tbl tbody tr:hover {
            background: #f8fafc;
        }

        .tbl td {
            padding: 1rem 1.25rem;
            vertical-align: middle;
        }

        .avatar-wrap {
            position: relative;
            display: inline-block;
        }

        .avatar-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #e8edf3;
            object-fit: cover;
        }

        .online-dot {
            position: absolute;
            bottom: 1px;
            right: 1px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #10b981;
            border: 2px solid #fff;
        }

        .dokter-name {
            font-weight: 700;
            font-size: 14px;
            color: #1e293b;
        }

        .dokter-email {
            font-size: 11.5px;
            color: #94a3b8;
            margin-top: 2px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            border: 1px solid transparent;
        }

        .badge-active {
            background: #ecfdf5;
            color: #059669;
            border-color: #a7f3d0;
        }

        .badge-inactive {
            background: #fef2f2;
            color: #dc2626;
            border-color: #fecaca;
        }

        .badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            padding: 3px 9px;
            font-size: 11px;
            font-weight: 600;
        }

        .action-group {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid transparent;
            cursor: pointer;
            text-decoration: none;
            transition: background .15s, border-color .15s, transform .1s;
        }

        .btn-action:active {
            transform: scale(.96);
        }

        .btn-view {
            color: #475569;
            background: #f1f5f9;
            border-color: #e2e8f0;
        }

        .btn-view:hover {
            background: #e2e8f0;
        }

        .btn-edit {
            color: #2563eb;
            background: #eff6ff;
            border-color: #bfdbfe;
        }

        .btn-edit:hover {
            background: #dbeafe;
        }

        .btn-delete {
            color: #dc2626;
            background: #fef2f2;
            border-color: #fecaca;
            border: none;
            cursor: pointer;
        }

        .btn-delete:hover {
            background: #fee2e2;
        }

        .empty-state {
            padding: 4rem 1rem;
            text-align: center;
            color: #94a3b8;
        }

        .empty-state svg {
            margin: 0 auto 1rem;
            display: block;
            opacity: .3;
        }

        .alert-success {
            margin: 1.25rem;
            padding: .9rem 1.1rem;
            background: #ecfdf5;
            border: 1px solid #6ee7b7;
            color: #065f46;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1.75rem;
        }

        .page-title {
            font-size: 1.65rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -.02em;
        }

        .page-sub {
            font-size: 13px;
            color: #94a3b8;
            margin-top: 3px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: .6rem 1.25rem;
            background: #2563eb;
            color: #fff;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            transition: background .15s, box-shadow .15s, transform .1s;
            box-shadow: 0 4px 14px rgba(37, 99, 235, .25);
            white-space: nowrap;
        }

        .btn-primary:hover {
            background: #1d4ed8;
            box-shadow: 0 6px 20px rgba(37, 99, 235, .35);
        }

        .btn-primary:active {
            transform: scale(.97);
        }

        .table-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid #f1f5f9;
            font-size: 12px;
            color: #94a3b8;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        @media (max-width: 768px) {

            .tbl thead th:nth-child(2),
            .tbl tbody td:nth-child(2) {
                display: none;
            }

            .page-title {
                font-size: 1.3rem;
            }

            .stat-value {
                font-size: 1.6rem;
            }
        }

        @media (max-width: 520px) {

            .tbl thead th:nth-child(3),
            .tbl tbody td:nth-child(3) {
                display: none;
            }
        }

        #rowCount {
            transition: opacity .2s;
        }
    </style>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700;800&display=swap" rel="stylesheet">

    <div class="dokter-wrap">

        {{-- Header --}}
        <div class="page-header">
            <a href="{{ route('superadmin.dokter.create') }}" class="btn-primary">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Dokter Baru
            </a>
        </div>

        {{-- Stats --}}
        <div
            style="display:grid; grid-template-columns:repeat(auto-fit,minmax(170px,1fr)); gap:1rem; margin-bottom:1.75rem;">
            <div class="card-stat">
                <div class="stat-icon" style="background:#eff6ff;">
                    <svg width="18" height="18" fill="none" stroke="#2563eb" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m6-5a4 4 0 11-8 0 4 4 0 018 0zm6 3a3 3 0 11-6 0 3 3 0 016 0zM3 17a3 3 0 110-6 3 3 0 010 6z" />
                    </svg>
                </div>
                <div class="stat-label">Total Dokter</div>
                <div class="stat-value">{{ $stats['total_dokter'] }}</div>
            </div>
            <div class="card-stat">
                <div class="stat-icon" style="background:#ecfdf5;">
                    <svg width="18" height="18" fill="none" stroke="#059669" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="stat-label">Akun Aktif</div>
                <div class="stat-value">{{ $stats['total_active'] }}</div>
            </div>
            <div class="card-stat">
                <div class="stat-icon" style="background:#fef9c3;">
                    <svg width="18" height="18" fill="none" stroke="#ca8a04" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.636 18.364A9 9 0 1118.364 5.636M12 8v4l3 3" />
                    </svg>
                </div>
                <div class="stat-label">Online Saat Ini</div>
                <div class="stat-value">{{ $stats['online_now'] }}</div>
            </div>
        </div>

        {{-- Main Table Card --}}
        <div class="main-card">

            @if(session('success'))
                <div class="alert-success">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Search & Filter bar --}}
            <div class="search-bar">
                <div class="search-input-wrap">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z" />
                    </svg>
                    <input type="text" id="searchInput" placeholder="Cari nama atau email dokter..."
                        oninput="filterTable()">
                </div>
                <select class="filter-select" id="statusFilter" onchange="filterTable()">
                    <option value="">Semua Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="non-aktif">Non-aktif</option>
                </select>
            </div>

            {{-- Table --}}
            <div style="overflow-x:auto;">
                <table class="tbl" id="dokterTable">
                    <thead>
                        <tr>
                            <th>Profil Dokter</th>
                            <th>Penempatan</th>
                            <th>Status</th>
                            <th style="text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="dokterBody">
                        @forelse($dokters as $dokter)
                            <tr class="dokter-row" data-name="{{ strtolower($dokter->nama) }}"
                                data-email="{{ strtolower($dokter->email) }}"
                                data-status="{{ $dokter->is_active ? 'aktif' : 'non-aktif' }}">

                                <td>
                                    <div style="display:flex; align-items:center; gap:12px;">
                                        <div class="avatar-wrap">
                                            @if($dokter->foto)
                                                <img class="avatar-img" src="{{ Storage::url($dokter->foto) }}" alt="Foto {{ $dokter->nama }}">
                                            @else
                                                <img class="avatar-img"
                                                    src="https://ui-avatars.com/api/?name={{ urlencode($dokter->nama) }}&background=dbeafe&color=1d4ed8"
                                                    alt="Avatar {{ $dokter->nama }}">
                                            @endif
                                            @if($dokter->is_active)
                                                <span class="online-dot"></span>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="dokter-name">{{ $dokter->nama }}</div>
                                            <div class="dokter-email">{{ $dokter->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="chip">
                                        <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Multi Cabang
                                    </span>
                                </td>

                                <td>
                                    <span class="badge {{ $dokter->is_active ? 'badge-active' : 'badge-inactive' }}">
                                        <span class="badge-dot"></span>
                                        {{ $dokter->is_active ? 'Aktif' : 'Non-aktif' }}
                                    </span>
                                </td>

                                <td>
                                    <div class="action-group">
                                        <a href="{{ route('superadmin.dokter.show', $dokter->id_user) }}"
                                            class="btn-action btn-view" title="Lihat Detail">
                                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                                <circle cx="12" cy="12" r="3" />
                                            </svg>
                                            Lihat
                                        </a>
                                        <a href="{{ route('superadmin.dokter.edit', $dokter->id_user) }}"
                                            class="btn-action btn-edit" title="Edit">
                                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('superadmin.dokter.toggle-status', $dokter->id_user) }}" method="POST" class="inline" x-data="{ showToggleConfirm: false }" x-ref="toggleForm">
                                            @csrf
                                            @method('PATCH')
                                            <button type="button" @click="showToggleConfirm = true"
                                                class="btn-action {{ $dokter->is_active ? 'text-amber-600 bg-amber-50 hover:bg-amber-100' : 'text-emerald-600 bg-emerald-50 hover:bg-emerald-100' }}"
                                                title="{{ $dokter->is_active ? 'Blokir Akun' : 'Aktifkan Akun' }}">
                                                @if($dokter->is_active)
                                                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                </svg>
                                                Blokir
                                                @else
                                                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Aktifkan
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

                                                        @if($dokter->is_active)
                                                        <div class="w-20 h-20 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-6">
                                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                            </svg>
                                                        </div>
                                                        <h3 class="font-bold text-xl text-slate-800 mb-3">Blokir Akun Dokter?</h3>
                                                        <p class="text-slate-500 text-sm mb-8 leading-relaxed">Apakah Anda yakin ingin memblokir akun <span class="font-bold text-slate-800">{{ $dokter->nama }}</span>?</p>
                                                        @else
                                                        <div class="w-20 h-20 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6">
                                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                        </div>
                                                        <h3 class="font-bold text-xl text-slate-800 mb-3">Aktifkan Akun Dokter?</h3>
                                                        <p class="text-slate-500 text-sm mb-8 leading-relaxed">Apakah Anda yakin ingin mengaktifkan kembali akun <span class="font-bold text-slate-800">{{ $dokter->nama }}</span>?</p>
                                                        @endif

                                                        <div class="grid grid-cols-2 gap-4">
                                                            <button @click="showToggleConfirm = false" type="button" class="px-6 py-3 rounded-2xl text-sm font-bold text-slate-500 bg-slate-100 hover:bg-slate-200 transition-colors">
                                                                Batal
                                                            </button>
                                                            <button type="button" @click="$refs.toggleForm.submit()" class="px-6 py-3 rounded-2xl text-sm font-bold text-white {{ $dokter->is_active ? 'bg-amber-500 hover:bg-amber-600 shadow-amber-100' : 'bg-emerald-500 hover:bg-emerald-600 shadow-emerald-100' }} transition-all shadow-lg">
                                                                Ya, Lanjutkan
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </form>
                                        <form action="{{ route('superadmin.dokter.destroy', $dokter->id_user) }}" method="POST" x-data="{ showDeleteConfirm: false }" x-ref="deleteForm">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" @click="showDeleteConfirm = true" class="btn-action btn-delete" title="Hapus">
                                                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Hapus
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
                                <td colspan="4">
                                    <div class="empty-state">
                                        <svg width="48" height="48" fill="none" stroke="#94a3b8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m6-5a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                        <p style="font-weight:600; font-size:14px; color:#64748b;">Belum ada akun dokter.</p>
                                        <p style="font-size:12px; color:#94a3b8; margin-top:4px;">Mulai dengan menambah dokter
                                            baru.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer --}}
            <div class="table-footer">
                <span id="rowCount"></span>
                <span>Data diperbarui secara real-time</span>
            </div>
        </div>

    </div>

    <script>
        function filterTable() {
            const q = document.getElementById('searchInput').value.toLowerCase();
            const st = document.getElementById('statusFilter').value;
            const rows = document.querySelectorAll('.dokter-row');
            let visible = 0;

            rows.forEach(row => {
                const name = row.dataset.name || '';
                const email = row.dataset.email || '';
                const status = row.dataset.status || '';
                const matchQ = !q || name.includes(q) || email.includes(q);
                const matchSt = !st || status === st;
                const show = matchQ && matchSt;
                row.style.display = show ? '' : 'none';
                if (show) visible++;
            });

            const total = rows.length;
            const el = document.getElementById('rowCount');
            if (el) {
                el.textContent = visible === total
                    ? `Menampilkan ${total} dokter`
                    : `Menampilkan ${visible} dari ${total} dokter`;
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            filterTable();
        });
    </script>

@endsection