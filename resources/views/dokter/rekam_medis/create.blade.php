@extends('layouts.dokter')

@section('title', 'Input Rekam Medis')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-end justify-between gap-5 relative z-10">
    <div>
        <h1 class="font-heading text-3xl font-bold text-slate-800 tracking-tight">Pemeriksaan Pasien</h1>
        <p class="text-slate-500 mt-1 text-sm">Input data rekam medis dan resep obat untuk pasien.</p>
    </div>
    <a href="{{ route('dokter.antrian') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 text-slate-700 rounded-lg text-sm font-bold border border-slate-200 hover:bg-slate-200 transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Antrian
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Informasi Pasien -->
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-5 pointer-events-none">
                <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3">Data Pasien</h3>
            <div class="space-y-4 relative z-10">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase">Nama Pasien</p>
                    <p class="font-medium text-slate-700">
                        {{ $reservasi->nama_pasien ?? ($reservasi->user->nama ?? '-') }}
                        @if($reservasi->hubungan && $reservasi->hubungan !== 'Diri Sendiri')
                            <span class="text-[10px] font-bold text-primary bg-blue-50 px-2 py-0.5 rounded-full ml-1">{{ $reservasi->hubungan }}</span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase">Nomor RM</p>
                    <p class="font-medium text-slate-700">{{ $reservasi->user->no_rm ?? 'Belum ada' }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase">Usia / Jenis Kelamin</p>
                    <p class="font-medium text-slate-700">
                        @php
                            $tanggalLahir = $reservasi->tanggal_lahir_pasien ?? ($reservasi->user->pasien->tanggal_lahir ?? null);
                            $gender = $reservasi->jenis_kelamin_pasien ?? ($reservasi->user->pasien->jenis_kelamin ?? '-');
                            $usia = $tanggalLahir ? \Carbon\Carbon::parse($tanggalLahir)->age . ' Tahun' : '-';
                        @endphp
                        {{ $usia }} / {{ $gender }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase">Keluhan Saat Reservasi</p>
                    <div class="mt-1 p-3 bg-red-50 rounded-lg border border-red-100 text-red-700 text-sm">
                        {{ $reservasi->keluhan ?? 'Tidak ada keluhan yang dicatat saat reservasi.' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Pemeriksaan Sebelumnya -->
        @if($riwayatSebelumnya->isNotEmpty())
        <div class="bg-white rounded-2xl border border-blue-100 shadow-sm overflow-hidden"
             x-data="{ expanded: false }">
            <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-blue-100 flex items-center justify-between cursor-pointer"
                 @click="expanded = !expanded">
                <div class="flex items-center gap-2.5">
                    <span class="p-1.5 bg-blue-600 text-white rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </span>
                    <div>
                        <h3 class="text-sm font-black text-slate-800 leading-tight">Riwayat Sebelumnya</h3>
                        <p class="text-[10px] text-blue-600 font-bold">{{ $riwayatSebelumnya->count() }} kunjungan ditemukan</p>
                    </div>
                </div>
                <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>

            <div x-show="expanded" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="divide-y divide-slate-100 max-h-[60vh] overflow-y-auto">
                    @foreach($riwayatSebelumnya as $riwayat)
                    @php $rm = $riwayat->rekamMedis; @endphp
                    <div class="p-4" x-data="{ detailOpen: false }">
                        <!-- Ringkasan Kunjungan -->
                        <div class="flex items-start justify-between gap-2 cursor-pointer" @click="detailOpen = !detailOpen">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-xs font-black text-slate-700">
                                        {{ \Carbon\Carbon::parse($riwayat->tanggal)->translatedFormat('d M Y') }}
                                    </span>
                                    <span class="px-2 py-0.5 bg-blue-50 text-blue-700 rounded-md text-[10px] font-black border border-blue-100">
                                        {{ $riwayat->cabang }}
                                    </span>
                                </div>
                                <p class="text-[11px] text-slate-500 font-medium mt-0.5">{{ $riwayat->dokter_nama }}</p>
                                @if($rm && $rm->assesment)
                                    <p class="text-[11px] text-amber-700 font-bold mt-1.5 bg-amber-50 border border-amber-100 rounded-lg px-2 py-1 line-clamp-2">
                                        🦷 {{ $rm->assesment }}
                                    </p>
                                @endif
                            </div>
                            <svg class="w-3.5 h-3.5 text-slate-400 mt-1 shrink-0 transition-transform duration-200" :class="detailOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                        </div>

                        <!-- Detail Lengkap Kunjungan -->
                        <div x-show="detailOpen" x-transition style="display: none;" class="mt-3 space-y-3">
                            @if($rm)
                            <!-- SOAP -->
                            <div class="bg-slate-50 rounded-xl border border-slate-100 p-3 space-y-2 text-xs">
                                @if($rm->subjective)
                                <div class="flex gap-2">
                                    <span class="w-5 h-5 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-[10px] font-black shrink-0 mt-0.5">S</span>
                                    <p class="text-slate-600 leading-relaxed"><span class="font-bold text-slate-700">Subjective:</span> {{ $rm->subjective }}</p>
                                </div>
                                @endif
                                @if($rm->objective)
                                <div class="flex gap-2">
                                    <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-[10px] font-black shrink-0 mt-0.5">O</span>
                                    <p class="text-slate-600 leading-relaxed"><span class="font-bold text-slate-700">Objective:</span> {{ $rm->objective }}</p>
                                </div>
                                @endif
                                @if($rm->assesment)
                                <div class="flex gap-2">
                                    <span class="w-5 h-5 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center text-[10px] font-black shrink-0 mt-0.5">A</span>
                                    <p class="text-slate-600 leading-relaxed"><span class="font-bold text-slate-700">Diagnosa:</span> {{ $rm->assesment }}</p>
                                </div>
                                @endif
                                @if($rm->planning)
                                <div class="flex gap-2">
                                    <span class="w-5 h-5 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-[10px] font-black shrink-0 mt-0.5">P</span>
                                    <p class="text-slate-600 leading-relaxed"><span class="font-bold text-slate-700">Tindakan:</span> {{ $rm->planning }}</p>
                                </div>
                                @endif
                                @if($rm->keterangan)
                                <div class="pt-2 border-t border-slate-100 text-slate-500 italic text-[11px]">
                                    📝 {{ $rm->keterangan }}
                                </div>
                                @endif
                            </div>

                            <!-- Odontogram Mini Read-only -->
                            @if($rm->odontogram && count($rm->odontogram) > 0)
                            <div class="bg-white border border-slate-200 rounded-xl p-3">
                                <p class="text-[10px] font-black text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <svg class="w-3 h-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16A8 8 0 0010 2z"/></svg>
                                    Odontogram Kunjungan Ini
                                </p>
                                <div class="flex gap-2 text-[9px] font-bold mb-2 flex-wrap">
                                    <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-sm bg-red-500 inline-block"></span>Karies</span>
                                    <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-sm bg-blue-500 inline-block"></span>Tambalan</span>
                                    <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-sm bg-slate-400 inline-block"></span>Cabut</span>
                                </div>
                                @php
                                    $odonto = $rm->odontogram;
                                    $stateColors = [
                                        1 => ['bg' => 'bg-red-500', 'label' => 'K'],
                                        2 => ['bg' => 'bg-blue-500', 'label' => 'T'],
                                        3 => ['bg' => 'bg-slate-400', 'label' => 'X'],
                                    ];
                                    $allTeeth = [
                                        'top' => [18,17,16,15,14,13,12,11,21,22,23,24,25,26,27,28],
                                        'topChild' => [55,54,53,52,51,61,62,63,64,65],
                                        'bottomChild' => [85,84,83,82,81,71,72,73,74,75],
                                        'bottom' => [48,47,46,45,44,43,42,41,31,32,33,34,35,36,37,38],
                                    ];
                                    $affectedTeeth = array_keys($odonto);
                                @endphp
                                <div class="overflow-x-auto">
                                    <div class="min-w-[260px] space-y-1.5">
                                        @foreach($allTeeth as $row => $teeth)
                                        <div class="flex gap-0.5 flex-wrap justify-center">
                                            @foreach($teeth as $tooth)
                                                @php
                                                    $state = isset($odonto[(string)$tooth]) ? (int)$odonto[(string)$tooth] : 0;
                                                    $colorCfg = $state > 0 ? $stateColors[$state] : null;
                                                @endphp
                                                <div class="flex flex-col items-center gap-0.5 group/tooth" title="Gigi {{ $tooth }}{{ $state > 0 ? ': ' . ['','Karies','Tambalan','Hilang/Cabut'][$state] : '' }}">
                                                    @if($row === 'top' || $row === 'topChild')
                                                        <span class="text-[7px] text-slate-400 font-bold leading-none">{{ $tooth }}</span>
                                                    @endif
                                                    <div class="w-4 h-4 {{ $colorCfg ? $colorCfg['bg'] . ' border-0' : 'bg-white border border-slate-300' }} rounded-sm flex items-center justify-center text-[8px] font-black {{ $colorCfg ? 'text-white' : 'text-transparent' }}">
                                                        {{ $colorCfg ? $colorCfg['label'] : '' }}
                                                    </div>
                                                    @if($row === 'bottom' || $row === 'bottomChild')
                                                        <span class="text-[7px] text-slate-400 font-bold leading-none">{{ $tooth }}</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                        @if($row === 'topChild')
                                            <div class="border-t border-dashed border-slate-300 my-1"></div>
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Resep Obat -->
                            @if($rm->resepObats && $rm->resepObats->count() > 0)
                            <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-3">
                                <p class="text-[10px] font-black text-emerald-700 uppercase tracking-wider mb-2">💊 Resep Obat</p>
                                <div class="space-y-1">
                                    @foreach($rm->resepObats as $resep)
                                    <div class="flex items-center justify-between gap-2 text-[11px]">
                                        <span class="font-bold text-slate-700">{{ $resep->obat->nama_obat ?? '-' }}</span>
                                        <span class="text-slate-500">{{ $resep->jumlah }}x &bull; {{ $resep->aturan_pakai }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @else
        {{-- Pasien baru / belum ada riwayat --}}
        <div class="bg-slate-50 rounded-2xl border border-dashed border-slate-200 p-5 text-center">
            <div class="flex flex-col items-center gap-2">
                <span class="p-2.5 bg-white rounded-xl border border-slate-200 text-slate-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </span>
                <p class="text-xs font-bold text-slate-400">Tidak ada riwayat</p>
                <p class="text-[11px] text-slate-400">Pasien ini belum pernah periksa sebelumnya.</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Form Rekam Medis & Resep -->
    <div class="lg:col-span-2">
        <form id="form-rekam-medis" action="{{ route('dokter.rekam-medis.store', $reservasi->id_reservasi) }}" method="POST" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            @csrf
            
            @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-xl text-sm font-medium">
                {{ session('error') }}
            </div>
            @endif

            <h3 class="text-lg font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Rekam Medis (E-RM)
            </h3>
            
            <div class="space-y-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        <label class="flex items-center gap-2 text-sm font-bold text-slate-700 mb-2">
                            <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs">S</span>
                            Subjective (Keluhan Utama) <span class="text-red-500">*</span>
                        </label>
                        <textarea name="subjective" rows="3" required class="w-full rounded-xl border-slate-200 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-3 transition-colors hover:border-blue-300 outline-none resize-none" placeholder="Deskripsikan keluhan utama yang dirasakan pasien di sini...">{{ old('subjective') }}</textarea>
                        @error('subjective') <p class="text-xs text-red-500 font-medium mt-1.5">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        <label class="flex items-center gap-2 text-sm font-bold text-slate-700 mb-2">
                            <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs">O</span>
                            Objective (Pemeriksaan Fisik) <span class="text-red-500">*</span>
                        </label>
                        <textarea name="objective" rows="3" required class="w-full rounded-xl border-slate-200 bg-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm p-3 transition-colors hover:border-emerald-300 outline-none resize-none" placeholder="Tuliskan hasil pemeriksaan fisik/klinis di sini...">{{ old('objective') }}</textarea>
                        @error('objective') <p class="text-xs text-red-500 font-medium mt-1.5">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        <label class="flex items-center gap-2 text-sm font-bold text-slate-700 mb-2">
                            <span class="w-6 h-6 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center text-xs">A</span>
                            Assesment (Diagnosa) <span class="text-red-500">*</span>
                        </label>
                        <textarea name="assesment" rows="2" required class="w-full rounded-xl border-slate-200 bg-white shadow-sm focus:border-amber-500 focus:ring-amber-500 text-sm p-3 transition-colors hover:border-amber-300 outline-none resize-none" placeholder="Misal: Karies Dentin, Pulpitis Reversibel, dll...">{{ old('assesment') }}</textarea>
                        @error('assesment') <p class="text-xs text-red-500 font-medium mt-1.5">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        <label class="flex items-center gap-2 text-sm font-bold text-slate-700 mb-2">
                            <span class="w-6 h-6 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-xs">P</span>
                            Planning (Tindakan/Perawatan) <span class="text-red-500">*</span>
                        </label>
                        <textarea name="planning" rows="2" required class="w-full rounded-xl border-slate-200 bg-white shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm p-3 transition-colors hover:border-purple-300 outline-none resize-none" placeholder="Tindakan medis atau perawatan yang dilakukan...">{{ old('planning') }}</textarea>
                        @error('planning') <p class="text-xs text-red-500 font-medium mt-1.5">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-6 bg-slate-800 rounded-2xl p-6 shadow-lg shadow-slate-200 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10 pointer-events-none">
                        <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="relative z-10 max-w-sm" x-data="{ 
                        biayaRaw: '{{ old('biaya_tindakan', '') }}',
                        formatRupiah(val) {
                            let number_string = val.toString().replace(/[^0-9]/g, '');
                            return number_string ? parseInt(number_string, 10).toLocaleString('id-ID') : '';
                        }
                    }">
                        <label class="block text-sm font-bold text-slate-300 mb-2 uppercase tracking-wider">Biaya Tindakan Medis <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-slate-400 font-bold text-lg">Rp</span>
                            </div>
                            <input type="hidden" name="biaya_tindakan" :value="biayaRaw || 0">
                            <input type="text" 
                                :value="formatRupiah(biayaRaw)"
                                @input="biayaRaw = $event.target.value.replace(/[^0-9]/g, '')"
                                required 
                                class="w-full pl-12 pr-4 py-3 rounded-xl border-0 bg-white/10 text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 text-xl font-bold transition-all" 
                                placeholder="0">
                        </div>
                        <p class="text-[11px] text-slate-400 mt-2 font-medium">Masukkan nominal biaya untuk seluruh tindakan. Kasir akan menjumlahkannya dengan obat.</p>
                        @error('biaya_tindakan') <p class="text-xs text-red-400 mt-1.5 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Odontogram -->
                <div class="mt-8 border border-slate-200 rounded-xl p-5 bg-slate-50">
                    <div class="flex items-center justify-between mb-4">
                        <label class="block text-sm font-bold text-slate-700">Odontogram</label>
                        <div class="flex gap-3 text-[10px] font-bold text-slate-500 uppercase">
                            <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-white border border-slate-300"></span> Normal</span>
                            <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-red-500"></span> Karies</span>
                            <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-blue-500"></span> Tambalan</span>
                            <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-slate-400"></span> Hilang/Cabut</span>
                        </div>
                    </div>
                    
                    <input type="hidden" name="odontogram" id="odontogram-input" value="{}">
                    <p class="text-xs text-slate-500 mb-4 text-center">Klik pada kotak gigi untuk mengubah kondisi (Normal -> Karies -> Tambalan -> Hilang).</p>

                    <div class="overflow-x-auto pb-4">
                        <div class="min-w-[600px] flex flex-col items-center gap-4 select-none">
                            <!-- Top Adult (18-11 | 21-28) -->
                            <div class="flex gap-8">
                                <div class="flex gap-1">
                                    @foreach([18,17,16,15,14,13,12,11] as $tooth)
                                        <div class="flex flex-col items-center gap-1">
                                            <span class="text-[10px] font-bold text-slate-400">{{ $tooth }}</span>
                                            <div class="tooth-box w-8 h-8 bg-white border-2 border-slate-300 rounded cursor-pointer flex items-center justify-center text-xs font-bold transition-colors hover:border-blue-400" data-tooth="{{ $tooth }}" data-state="0"></div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="flex gap-1">
                                    @foreach([21,22,23,24,25,26,27,28] as $tooth)
                                        <div class="flex flex-col items-center gap-1">
                                            <span class="text-[10px] font-bold text-slate-400">{{ $tooth }}</span>
                                            <div class="tooth-box w-8 h-8 bg-white border-2 border-slate-300 rounded cursor-pointer flex items-center justify-center text-xs font-bold transition-colors hover:border-blue-400" data-tooth="{{ $tooth }}" data-state="0"></div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <!-- Top Child (55-51 | 61-65) -->
                            <div class="flex gap-8">
                                <div class="flex gap-1">
                                    @foreach([55,54,53,52,51] as $tooth)
                                        <div class="flex flex-col items-center gap-1">
                                            <span class="text-[10px] font-bold text-slate-400">{{ $tooth }}</span>
                                            <div class="tooth-box w-7 h-7 bg-white border-2 border-slate-300 rounded cursor-pointer flex items-center justify-center text-xs font-bold transition-colors hover:border-blue-400" data-tooth="{{ $tooth }}" data-state="0"></div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="flex gap-1">
                                    @foreach([61,62,63,64,65] as $tooth)
                                        <div class="flex flex-col items-center gap-1">
                                            <span class="text-[10px] font-bold text-slate-400">{{ $tooth }}</span>
                                            <div class="tooth-box w-7 h-7 bg-white border-2 border-slate-300 rounded cursor-pointer flex items-center justify-center text-xs font-bold transition-colors hover:border-blue-400" data-tooth="{{ $tooth }}" data-state="0"></div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="w-full border-t-2 border-slate-300 my-2 relative">
                                <div class="absolute left-1/2 -top-3 w-6 h-6 bg-slate-50 flex items-center justify-center -translate-x-1/2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path></svg>
                                </div>
                            </div>

                            <!-- Bottom Child (85-81 | 71-75) -->
                            <div class="flex gap-8">
                                <div class="flex gap-1">
                                    @foreach([85,84,83,82,81] as $tooth)
                                        <div class="flex flex-col items-center gap-1">
                                            <div class="tooth-box w-7 h-7 bg-white border-2 border-slate-300 rounded cursor-pointer flex items-center justify-center text-xs font-bold transition-colors hover:border-blue-400" data-tooth="{{ $tooth }}" data-state="0"></div>
                                            <span class="text-[10px] font-bold text-slate-400">{{ $tooth }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="flex gap-1">
                                    @foreach([71,72,73,74,75] as $tooth)
                                        <div class="flex flex-col items-center gap-1">
                                            <div class="tooth-box w-7 h-7 bg-white border-2 border-slate-300 rounded cursor-pointer flex items-center justify-center text-xs font-bold transition-colors hover:border-blue-400" data-tooth="{{ $tooth }}" data-state="0"></div>
                                            <span class="text-[10px] font-bold text-slate-400">{{ $tooth }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Bottom Adult (48-41 | 31-38) -->
                            <div class="flex gap-8">
                                <div class="flex gap-1">
                                    @foreach([48,47,46,45,44,43,42,41] as $tooth)
                                        <div class="flex flex-col items-center gap-1">
                                            <div class="tooth-box w-8 h-8 bg-white border-2 border-slate-300 rounded cursor-pointer flex items-center justify-center text-xs font-bold transition-colors hover:border-blue-400" data-tooth="{{ $tooth }}" data-state="0"></div>
                                            <span class="text-[10px] font-bold text-slate-400">{{ $tooth }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="flex gap-1">
                                    @foreach([31,32,33,34,35,36,37,38] as $tooth)
                                        <div class="flex flex-col items-center gap-1">
                                            <div class="tooth-box w-8 h-8 bg-white border-2 border-slate-300 rounded cursor-pointer flex items-center justify-center text-xs font-bold transition-colors hover:border-blue-400" data-tooth="{{ $tooth }}" data-state="0"></div>
                                            <span class="text-[10px] font-bold text-slate-400">{{ $tooth }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                    <label class="flex items-center gap-2 text-sm font-bold text-slate-700 mb-2">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Keterangan Tambahan
                    </label>
                    <textarea name="keterangan" rows="2" class="w-full rounded-xl border-slate-200 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-3 transition-colors hover:border-blue-300 outline-none resize-none" placeholder="Catatan untuk kunjungan berikutnya, resep obat luar, keluhan alergi, dll...">{{ old('keterangan') }}</textarea>
                </div>
            </div>

        <div x-data="{
            rows: [{ id: Date.now(), obat_id: '', obat_name: '-- Tanpa Obat / Pilih Obat --', jumlah: 1, aturan: '', maxStok: 0 }],
            obats: [
                @foreach($obats as $obat)
                    { id: '{{ $obat->id_obat }}', name: '{{ addslashes($obat->nama_obat) }} (Stok: {{ $obat->stok }})', stok: {{ $obat->stok }} },
                @endforeach
            ],
            addRow() {
                this.rows.push({ id: Date.now(), obat_id: '', obat_name: '-- Tanpa Obat / Pilih Obat --', jumlah: 1, aturan: '', maxStok: 0 });
            },
            removeRow(id) {
                if (this.rows.length > 1) {
                    this.rows = this.rows.filter(r => r.id !== id);
                } else {
                    alert('Minimal satu baris obat (bisa dibiarkan kosong jika tidak meresepkan).');
                }
            },
            get isSubmitDisabled() {
                return this.rows.some(r => r.obat_id !== '' && parseInt(r.jumlah || 0) > r.maxStok);
            },
            submitForm() {
                if (this.isSubmitDisabled) return;
                
                const form = document.getElementById('form-rekam-medis');
                if (!form.reportValidity()) return;

                Swal.fire({
                    title: 'Konfirmasi Rekam Medis',
                    text: 'Apakah data rekam medis dan resep obat sudah benar?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#2563eb',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText: 'Cek Kembali'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        }">
            <div class="flex items-center justify-between mb-4 border-b border-slate-100 pb-3">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-500 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    Resep Obat
                </h3>
                <button type="button" @click="addRow()" class="flex items-center gap-1.5 text-xs bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-xl font-bold transition-all active:scale-95">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Obat
                </button>
            </div>

            <div class="space-y-4 mb-8">
                <template x-for="(row, index) in rows" :key="row.id">
                    <div class="obat-row flex flex-col md:flex-row items-start md:items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100 relative group">
                        
                        <div class="flex-1 w-full" x-data="{
                            open: false,
                            search: '',
                            get filteredOptions() {
                                if (this.search === '') return obats;
                                return obats.filter(i => i.name.toLowerCase().includes(this.search.toLowerCase()));
                            },
                            selectOption(opt) {
                                if (!opt) {
                                    row.obat_id = '';
                                    row.obat_name = '-- Tanpa Obat / Pilih Obat --';
                                    row.maxStok = 0;
                                } else {
                                    row.obat_id = opt.id;
                                    row.obat_name = opt.name;
                                    row.maxStok = opt.stok;
                                }
                                this.open = false;
                                this.search = '';
                            }
                        }">
                            <label class="block text-[11px] font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Pilih Obat</label>
                            <input type="hidden" name="id_obat[]" :value="row.obat_id">
                            
                            <div class="relative">
                                <button type="button" @click="open = true" class="w-full text-left rounded-xl border-slate-200 bg-white shadow-sm text-sm p-3 focus:border-emerald-500 focus:ring-emerald-500 transition-colors cursor-pointer outline-none border flex justify-between items-center">
                                    <span x-text="row.obat_name" :class="row.obat_id === '' ? 'text-slate-500' : 'text-slate-800 font-bold'"></span>
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                
                                <div class="fixed-teleport-fallback">
                                    <div x-show="open" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/40 backdrop-blur-sm" x-transition.opacity>
                                        <div @click.away="open = false" x-show="open"
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                            x-transition:leave="transition ease-in duration-200"
                                            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                            class="bg-white rounded-3xl shadow-2xl w-full max-w-lg flex flex-col relative mx-4 max-h-[80vh]">
                                            
                                            <div class="p-4 border-b border-slate-100 flex items-center justify-between">
                                                <h3 class="font-bold text-slate-800">Pilih Obat</h3>
                                                <button type="button" @click="open = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </div>

                                            <div class="p-4 border-b border-slate-100 bg-slate-50">
                                                <div class="relative">
                                                    <input type="text" x-model="search" placeholder="Cari nama obat..." class="w-full text-sm pl-10 pr-4 py-3 rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 outline-none transition-colors shadow-sm" @click.stop>
                                                    <svg class="w-5 h-5 text-slate-400 absolute left-3 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                                </div>
                                            </div>

                                            <div class="overflow-y-auto custom-scrollbar flex-1 p-2">
                                                <div @click="selectOption(null)" class="px-4 py-3 text-sm text-slate-500 hover:bg-emerald-50 hover:text-emerald-700 rounded-xl cursor-pointer transition-colors flex items-center gap-2 mb-1">
                                                    -- Tanpa Obat / Kosongkan --
                                                </div>
                                                <template x-for="opt in filteredOptions" :key="opt.id">
                                                    <div @click="selectOption(opt)" 
                                                         class="px-4 py-3 text-sm text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 rounded-xl cursor-pointer transition-colors font-medium flex items-center justify-between mb-1"
                                                         :class="row.obat_id === opt.id ? 'bg-emerald-50 text-emerald-700' : ''">
                                                        <span x-text="opt.name"></span>
                                                        <svg x-show="row.obat_id === opt.id" class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    </div>
                                                </template>
                                                <div x-show="filteredOptions.length === 0" class="px-4 py-8 text-sm text-center text-slate-400 italic flex flex-col items-center gap-3">
                                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    Obat tidak ditemukan
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-full md:w-28">
                            <label class="block text-[11px] font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Jumlah</label>
                            <input type="number" name="jumlah_obat[]" min="1" x-model="row.jumlah" class="w-full rounded-xl border-slate-200 bg-white shadow-sm text-sm p-3 focus:border-emerald-500 focus:ring-emerald-500 transition-colors outline-none text-center font-bold">
                            <p x-show="row.obat_id !== '' && parseInt(row.jumlah || 0) > row.maxStok" class="text-xs text-red-500 mt-1 absolute font-bold" x-cloak>Stok hanya <span x-text="row.maxStok"></span></p>
                        </div>
                        <div class="flex-1 w-full">
                            <label class="block text-[11px] font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Aturan Pakai</label>
                            <input type="text" name="aturan_pakai[]" x-model="row.aturan" placeholder="Misal: 3x1 Sesudah Makan" class="w-full rounded-xl border-slate-200 bg-white shadow-sm text-sm p-3 focus:border-emerald-500 focus:ring-emerald-500 transition-colors outline-none">
                        </div>
                        <div class="pt-6 md:pt-5 w-full md:w-auto flex justify-end">
                            <button type="button" @click="removeRow(row.id)" class="flex items-center justify-center w-10 h-10 bg-white border border-red-100 text-red-500 hover:text-white hover:bg-red-500 hover:border-red-500 rounded-xl transition-all shadow-sm active:scale-95">
                                <svg class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="button" @click="submitForm()" :disabled="isSubmitDisabled" :class="isSubmitDisabled ? 'bg-slate-400 cursor-not-allowed opacity-70' : 'bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-200 active:scale-95'" class="px-6 py-3 text-white font-bold rounded-xl transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan & Selesai Diperiksa
                </button>
            </div>
        </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Odontogram Logic ---
        const odontogramInput = document.getElementById('odontogram-input');
        let odontogramState = {};
        
        // Define states
        // 0: Normal, 1: Karies, 2: Tambalan, 3: Hilang
        const states = {
            0: { class: 'bg-white', text: '', border: 'border-slate-300', textClass: 'text-transparent' },
            1: { class: 'bg-red-500', text: '', border: 'border-red-600', textClass: 'text-white' },
            2: { class: 'bg-blue-500', text: '', border: 'border-blue-600', textClass: 'text-white' },
            3: { class: 'bg-slate-300', text: 'X', border: 'border-slate-400', textClass: 'text-slate-600' }
        };

        const updateToothUI = (toothBox, state) => {
            const stateConfig = states[state];
            
            // Remove all possible classes
            toothBox.classList.remove('bg-white', 'bg-red-500', 'bg-blue-500', 'bg-slate-300', 'border-slate-300', 'border-red-600', 'border-blue-600', 'border-slate-400', 'text-transparent', 'text-white', 'text-slate-600');
            
            // Add new classes
            toothBox.classList.add(stateConfig.class, stateConfig.border, stateConfig.textClass);
            toothBox.textContent = stateConfig.text;
        };

        const updateHiddenInput = () => {
            odontogramInput.value = JSON.stringify(odontogramState);
        };

        document.querySelectorAll('.tooth-box').forEach(box => {
            box.addEventListener('click', function() {
                let currentState = parseInt(this.getAttribute('data-state'));
                let tooth = this.getAttribute('data-tooth');
                
                // Cycle through 0 -> 1 -> 2 -> 3 -> 0
                let nextState = (currentState + 1) % Object.keys(states).length;
                
                this.setAttribute('data-state', nextState);
                updateToothUI(this, nextState);
                
                if (nextState === 0) {
                    delete odontogramState[tooth];
                } else {
                    odontogramState[tooth] = nextState;
                }
                
                updateHiddenInput();
            });
        });
    });
</script>
@endpush
