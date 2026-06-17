@extends('layouts.pos')

@section('title', 'Antrian Obat')

@section('content')
<div class="flex-1 flex h-full overflow-hidden relative" x-data="staffApp()">
    
    <!-- CUSTOM CONFIRMATION MODAL -->
    <div x-show="showModal" 
        class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="display: none;">
        
        <div class="bg-white rounded-[2.5rem] shadow-2xl max-w-md w-full overflow-hidden transform transition-all"
            @click.away="showModal = false"
            x-show="showModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-8 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100">
            
            <div class="p-8 text-center">
                <div class="w-20 h-20 mx-auto mb-6 rounded-3xl flex items-center justify-center shadow-lg bg-emerald-100 text-emerald-600 shadow-emerald-500/20">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                </div>
                
                <h3 class="text-2xl font-black text-slate-800 mb-3" x-text="modalTitle"></h3>
                <p class="text-slate-500 font-medium leading-relaxed" x-text="modalMessage"></p>
            </div>
            
            <div class="p-6 bg-slate-50 flex gap-3">
                <button @click="showModal = false" class="flex-1 py-4 bg-white border border-slate-200 text-slate-400 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-slate-100 hover:text-slate-600 transition-all">
                    Batal
                </button>
                <button @click="confirmAction()" class="flex-1 py-4 text-white rounded-2xl font-black uppercase tracking-widest text-xs shadow-lg transition-all active:scale-95 bg-emerald-600 hover:bg-emerald-700 shadow-emerald-500/20">
                    Ya, Lanjutkan
                </button>
            </div>
        </div>
    </div>

    <!-- LEFT COLUMN: QUEUE LIST (APOTEKER) -->
    <div class="w-[380px] bg-white border-r border-slate-200 flex flex-col h-full shrink-0 shadow-[4px_0_24px_rgba(0,0,0,0.02)] z-10">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-black text-slate-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Antrian Obat
                </h2>
                <span class="bg-emerald-100 text-emerald-700 text-[10px] font-black px-2 py-1 rounded-lg border border-emerald-200 uppercase">{{ $antrianObat->where('status', 'Menunggu Obat')->count() }} AKTIF</span>
            </div>
            
            <!-- Search Box -->
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400 group-focus-within:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" 
                    x-model="searchQuery" 
                    placeholder="Cari nama pasien..." 
                    class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-bold placeholder:text-slate-400 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none">
            </div>
        </div>

        <div class="flex-1 overflow-y-auto p-4 space-y-3 custom-scrollbar bg-slate-50/30">
            @forelse($antrianObat as $reservasi)
                @php
                    $dataPasien = [
                        'id' => $reservasi->id_reservasi,
                        'nama' => $reservasi->nama_pasien ?? ($reservasi->user->nama ?? 'Pasien'),
                        'hubungan' => $reservasi->hubungan,
                        'dokter' => $reservasi->dokter_nama,
                        'status' => $reservasi->status,
                        'resep' => $reservasi->rekamMedis->resepObats->map(fn($r) => [
                            'nama' => $r->obat->nama_obat,
                            'jumlah' => $r->jumlah,
                            'aturan' => $r->aturan_pakai
                        ])
                    ];
                @endphp
                <button @click="selectPasien({{ json_encode($dataPasien) }})" 
                    x-show="searchQuery === '' || '{{ strtolower($reservasi->nama_pasien ?? ($reservasi->user->nama ?? 'Pasien')) }}'.includes(searchQuery.toLowerCase())"
                    :class="selectedPasien?.id === {{ $reservasi->id_reservasi }} ? 'ring-2 ring-emerald-500 bg-emerald-50 border-transparent shadow-lg shadow-emerald-500/10' : 'bg-white border-slate-200 hover:border-emerald-300 hover:shadow-md'"
                    class="w-full text-left p-5 rounded-2xl border transition-all duration-300 group relative overflow-hidden {{ in_array($reservasi->status, ['Menunggu Pembayaran', 'Selesai']) ? 'opacity-70 bg-slate-50/50' : '' }}">
                    
                    <div x-show="selectedPasien?.id === {{ $reservasi->id_reservasi }}" class="absolute left-0 top-0 bottom-0 w-1.5 bg-emerald-500 rounded-l-2xl"></div>
                    
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-bold text-slate-800 group-hover:text-emerald-700 transition-colors">
                            {{ $reservasi->nama_pasien ?? ($reservasi->user->nama ?? 'Pasien') }}
                        </h3>
                        @if($reservasi->status === 'Menunggu Pembayaran')
                            <span class="text-[9px] font-black text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full border border-emerald-100 uppercase tracking-tighter">Sudah Diserahkan</span>
                        @elseif($reservasi->status === 'Selesai')
                            <span class="text-[9px] font-black text-blue-600 bg-blue-50 px-2 py-1 rounded-full border border-blue-100 uppercase tracking-tighter">Selesai</span>
                        @else
                            <span class="text-[10px] font-black text-slate-400 bg-slate-50 px-2 py-0.5 rounded-md border border-slate-100">#{{ $reservasi->id_reservasi }}</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2 mt-3">
                        <div class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-[10px] font-bold text-slate-500">D</div>
                        <span class="text-xs font-bold text-slate-500">{{ $reservasi->dokter_nama }}</span>
                    </div>
                </button>
            @empty
                <div class="text-center py-20 px-6">
                    <p class="text-sm font-bold text-slate-400">Antrian Kosong</p>
                </div>
            @endforelse
            
            <div x-show="searchQuery !== '' && document.querySelectorAll('button[x-show*=\'includes\']:not([style*=\'display: none\'])').length === 0" 
                class="text-center py-20 px-6" style="display: none;">
                <p class="text-sm font-bold text-slate-400">Pasien tidak ditemukan</p>
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN: WORKSPACE (APOTEKER) -->
    <div class="flex-1 bg-[#fbfcfd] overflow-y-auto p-8 md:p-12 custom-scrollbar">
        <div x-show="!selectedPasien" class="h-full flex flex-col items-center justify-center text-center max-w-md mx-auto" x-transition>
            <div class="w-24 h-24 bg-white rounded-3xl rotate-12 flex items-center justify-center text-slate-200 shadow-xl border border-slate-100 mb-8">
                <svg class="w-12 h-12 -rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <h2 class="text-2xl font-black text-slate-800 mb-2">Siap Melayani</h2>
            <p class="text-slate-400 font-medium">Pilih salah satu pasien di daftar antrian sebelah kiri untuk melihat resep obat.</p>
        </div>

        <div x-show="selectedPasien" style="display: none;" class="max-w-4xl mx-auto" x-transition>
            <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-slate-100 overflow-hidden">
                <!-- Detail Header -->
                <div class="p-10 bg-gradient-to-br from-white to-slate-50/50 border-b border-slate-100 relative">
                    <div class="flex justify-between items-start relative z-10">
                        <div>
                            <template x-if="selectedPasien?.status === 'Menunggu Obat'">
                                <span class="bg-emerald-600 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest shadow-lg shadow-emerald-200 mb-4 inline-block">Proses Penyiapan</span>
                            </template>
                            <template x-if="selectedPasien?.status === 'Menunggu Pembayaran'">
                                <span class="bg-slate-500 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest shadow-lg shadow-slate-200 mb-4 inline-block text-center">Sudah Diserahkan & Menunggu Pembayaran</span>
                            </template>
                            <template x-if="selectedPasien?.status === 'Selesai'">
                                <span class="bg-blue-600 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest shadow-lg shadow-blue-200 mb-4 inline-block text-center">Transaksi Selesai</span>
                            </template>
                            <h2 class="text-4xl font-black text-slate-800 tracking-tight flex items-center gap-3">
                                <span x-text="selectedPasien?.nama"></span>
                            </h2>
                            <div class="flex items-center gap-4 mt-3 text-slate-500 font-bold">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    <span x-text="selectedPasien?.dokter"></span>
                                </div>
                                <div class="w-1 h-1 rounded-full bg-slate-300"></div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                    <span x-text="'ID #' + selectedPasien?.id"></span>
                                </div>
                            </div>
                        </div>
                        <button @click="selectedPasien = null" class="w-12 h-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-red-500 hover:shadow-lg transition-all active:scale-95">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>

                <div class="p-10">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-8 flex items-center gap-3">
                        Rincian Resep Obat
                        <div class="h-px flex-1 bg-slate-100"></div>
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <template x-for="item in selectedPasien?.resep">
                            <div class="bg-white border border-slate-100 p-6 rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.02)] hover:border-emerald-200 hover:shadow-xl hover:shadow-emerald-500/5 transition-all group">
                                <div class="flex justify-between items-start mb-4">
                                    <h4 class="font-black text-slate-800 text-lg group-hover:text-emerald-700 transition-colors" x-text="item.nama"></h4>
                                    <span class="bg-emerald-50 text-emerald-600 px-3 py-1 rounded-xl text-xs font-black" x-text="item.jumlah + ' PCS'"></span>
                                </div>
                                <div class="flex items-center gap-2 text-slate-500">
                                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p class="text-sm font-bold italic" x-text="item.aturan"></p>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="mt-12 flex flex-col items-center" x-show="selectedPasien?.status === 'Menunggu Obat'">
                        <div class="w-full h-px bg-slate-100 mb-8"></div>
                        <form :id="'form-serah-' + selectedPasien?.id" :action="'/apoteker/serahkan-obat/' + selectedPasien?.id" method="POST" class="w-full max-w-sm">
                            @csrf
                            <button type="button" 
                                @click="triggerConfirm('success', 'Konfirmasi Penyerahan', 'Apakah semua obat sudah disiapkan dan siap diserahkan ke ' + selectedPasien?.nama + '?', 'form-serah-' + selectedPasien?.id)"
                                class="w-full py-5 bg-emerald-600 text-white rounded-[2rem] font-black uppercase tracking-[0.2em] text-sm shadow-[0_15px_30px_rgba(16,185,129,0.3)] hover:bg-emerald-700 hover:shadow-[0_20px_40px_rgba(16,185,129,0.4)] hover:-translate-y-1 transition-all active:scale-95 flex items-center justify-center gap-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                Selesaikan & Serahkan
                            </button>
                        </form>
                    </div>

                    <div class="mt-12 flex flex-col items-center" x-show="selectedPasien?.status === 'Menunggu Pembayaran'">
                        <div class="w-full h-px bg-slate-100 mb-8"></div>
                        <div class="bg-slate-50 border-2 border-dashed border-slate-200 p-8 rounded-[2rem] text-center w-full">
                            <p class="font-black text-slate-400 uppercase tracking-widest text-sm mb-2 italic">Tugas Selesai</p>
                            <p class="text-slate-500 font-medium">Obat telah diserahkan. Pasien saat ini sedang dalam proses administrasi di Kasir.</p>
                        </div>
                    </div>

                    <div class="mt-12 flex flex-col items-center" x-show="selectedPasien?.status === 'Selesai'">
                        <div class="w-full h-px bg-slate-100 mb-8"></div>
                        <div class="bg-blue-50 border-2 border-dashed border-blue-200 p-8 rounded-[2rem] text-center w-full">
                            <p class="font-black text-blue-400 uppercase tracking-widest text-sm mb-2 italic">Transaksi Lunas</p>
                            <p class="text-blue-500 font-medium">Transaksi telah selesai dan lunas di kasir. Pelayanan hari ini telah ditutup.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="fixed bottom-10 right-10 z-[60]">
        <div class="bg-white border-l-4 border-emerald-600 px-8 py-5 rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.1)] flex items-center gap-4 animate-slide-up">
            <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Berhasil</p>
                <p class="text-sm font-black text-slate-800">{{ session('success') }}</p>
            </div>
        </div>
    </div>
@endif

<style>
    @keyframes slide-up {
        from { transform: translateY(100%); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .animate-slide-up { animation: slide-up 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>

@endsection

@push('scripts')
<script>
    function staffApp() {
        return {
            selectedPasien: null,
            searchQuery: '',
            
            showModal: false,
            modalType: 'info',
            modalTitle: '',
            modalMessage: '',
            targetFormId: null,

            selectPasien(pasien) {
                this.selectedPasien = pasien;
            },

            formatRupiah(number) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(number);
            },

            triggerConfirm(type, title, message, formId) {
                this.modalType = type;
                this.modalTitle = title;
                this.modalMessage = message;
                this.targetFormId = formId;
                this.showModal = true;
            },

            confirmAction() {
                if (this.targetFormId) {
                    document.getElementById(this.targetFormId).submit();
                }
                this.showModal = false;
            }
        }
    }
</script>
@endpush
