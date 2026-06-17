@extends('layouts.pos')

@section('title', 'POS Kasir')

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
                <div class="w-20 h-20 mx-auto mb-6 rounded-3xl flex items-center justify-center shadow-lg bg-blue-100 text-blue-600 shadow-blue-500/20">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                
                <h3 class="text-2xl font-black text-slate-800 mb-3" x-text="modalTitle"></h3>
                <p class="text-slate-500 font-medium leading-relaxed" x-text="modalMessage"></p>
            </div>
            
            <div class="p-6 bg-slate-50 flex gap-3">
                <button x-show="!isAlertOnly" @click="showModal = false" class="flex-1 py-4 bg-white border border-slate-200 text-slate-400 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-slate-100 hover:text-slate-600 transition-all">
                    Batal
                </button>
                <button @click="confirmAction()" class="flex-1 py-4 text-white rounded-2xl font-black uppercase tracking-widest text-xs shadow-lg transition-all active:scale-95 bg-blue-600 hover:bg-blue-700 shadow-blue-500/20">
                    <span x-show="!isAlertOnly">Ya, Lanjutkan</span>
                    <span x-show="isAlertOnly">OK Mengerti</span>
                </button>
            </div>
        </div>
    </div>

    <!-- KASIR LAYOUT -->
    <div class="w-[380px] bg-white border-r border-slate-200 flex flex-col h-full shrink-0 shadow-[4px_0_24px_rgba(0,0,0,0.02)] z-10">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-black text-slate-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Antrian Kasir
                </h2>
                <span class="bg-blue-100 text-blue-700 text-[10px] font-black px-2 py-1 rounded-lg border border-blue-200 uppercase tracking-tighter">{{ $antrianKasir->where('status', 'Menunggu Pembayaran')->count() }} AKTIF</span>
            </div>

            <!-- Search Box -->
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" 
                    x-model="searchQuery" 
                    placeholder="Cari nama pasien..." 
                    class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-bold placeholder:text-slate-400 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none">
            </div>
        </div>

        <div class="flex-1 overflow-y-auto p-4 space-y-3 custom-scrollbar bg-slate-50/30">
            @forelse($antrianKasir as $reservasi)
                @php
                    $total_obat = 0;
                    foreach ($reservasi->rekamMedis->resepObats as $resep) {
                        if ($resep->obat) {
                            $total_obat += ($resep->obat->harga * $resep->jumlah);
                        }
                    }
                    
                    $biaya_tindakan = $reservasi->rekamMedis->biaya_tindakan ?? 0;
                    $grand_total = $total_obat + $biaya_tindakan;
                    
                    $dataPasien = [
                        'id' => $reservasi->id_reservasi,
                        'id_transaksi' => $reservasi->transaksi->id_transaksi ?? null,
                        'nama' => $reservasi->nama_pasien ?? ($reservasi->user->nama ?? 'Pasien'),
                        'hubungan' => $reservasi->hubungan,
                        'status' => $reservasi->status,
                        'planning' => $reservasi->rekamMedis->planning ?? 'Tindakan Medis',
                        'total_obat' => $total_obat,
                        'biaya_tindakan' => $biaya_tindakan,
                        'resep' => $reservasi->rekamMedis->resepObats->map(fn($r) => [
                            'nama' => $r->obat->nama_obat,
                            'jumlah' => $r->jumlah,
                            'harga' => $r->obat->harga,
                            'subtotal' => $r->obat->harga * $r->jumlah
                        ])
                    ];
                @endphp
                <button @click="selectPasien({{ json_encode($dataPasien) }})" 
                    data-transaksi-id="{{ $reservasi->transaksi->id_transaksi ?? '' }}"
                    x-show="searchQuery === '' || '{{ strtolower($reservasi->nama_pasien ?? ($reservasi->user->nama ?? 'Pasien')) }}'.includes(searchQuery.toLowerCase())"
                    :class="selectedPasien?.id === {{ $reservasi->id_reservasi }} ? 'ring-2 ring-blue-500 bg-blue-50 border-transparent shadow-lg shadow-blue-500/10' : 'bg-white border-slate-200 hover:border-blue-300 hover:shadow-md'"
                    class="w-full text-left p-5 rounded-2xl border transition-all duration-300 group relative overflow-hidden {{ $reservasi->status === 'Selesai' ? 'opacity-70 bg-slate-50/50' : '' }}">
                    
                    <div x-show="selectedPasien?.id === {{ $reservasi->id_reservasi }}" class="absolute left-0 top-0 bottom-0 w-1.5 bg-blue-500 rounded-l-2xl"></div>
                    
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-bold text-slate-800 group-hover:text-blue-700 transition-colors">
                            {{ $reservasi->nama_pasien ?? ($reservasi->user->nama ?? 'Pasien') }}
                        </h3>
                        @if($reservasi->status === 'Selesai')
                            <span class="text-[9px] font-black text-blue-600 bg-blue-50 px-2 py-1 rounded-full border border-blue-100 uppercase tracking-tighter italic">Lunas</span>
                        @else
                            <span class="text-[10px] font-black text-slate-400 bg-slate-50 px-2 py-0.5 rounded-md border border-slate-100">#{{ $reservasi->id_reservasi }}</span>
                        @endif
                    </div>
                    <div class="mt-4 flex justify-between items-end">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Total Tagihan</span>
                        <span class="text-sm font-black text-slate-700">Rp {{ number_format($grand_total, 0, ',', '.') }}</span>
                    </div>
                </button>
            @empty
                <div class="text-center py-20 px-6">
                    <p class="text-sm font-bold text-slate-400 italic">Antrian Kasir Kosong.</p>
                </div>
            @endforelse
            
            <div x-show="searchQuery !== '' && document.querySelectorAll('button[x-show*=\'includes\']:not([style*=\'display: none\'])').length === 0" 
                class="text-center py-20 px-6" style="display: none;">
                <p class="text-sm font-bold text-slate-400">Pasien tidak ditemukan</p>
            </div>
        </div>
    </div>

    <div class="flex-1 bg-[#fbfcfd] overflow-y-auto p-8 md:p-12 custom-scrollbar">
        <div x-show="!selectedPasien" class="h-full flex flex-col items-center justify-center text-center max-w-md mx-auto" x-transition>
            <div class="w-24 h-24 bg-white rounded-3xl rotate-12 flex items-center justify-center text-slate-200 shadow-xl border border-slate-100 mb-8">
                <svg class="w-12 h-12 -rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <h2 class="text-2xl font-black text-slate-800 mb-2">POS Kasir</h2>
            <p class="text-slate-400 font-medium">Pilih pasien di sebelah kiri untuk memproses pembayaran dan mencetak struk.</p>
        </div>

        <div x-show="selectedPasien" style="display: none;" class="max-w-5xl mx-auto" x-transition>
            <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-slate-100 overflow-hidden">
                <div class="p-10 bg-gradient-to-br from-white to-slate-50/50 border-b border-slate-100 flex justify-between items-center">
                    <div>
                        <template x-if="selectedPasien?.status === 'Menunggu Pembayaran'">
                            <span class="bg-blue-600 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest shadow-lg shadow-blue-200 mb-4 inline-block">Proses Pembayaran</span>
                        </template>
                        <template x-if="selectedPasien?.status === 'Selesai'">
                            <span class="bg-slate-800 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest shadow-lg shadow-slate-200 mb-4 inline-block">Transaksi Selesai / Lunas</span>
                        </template>
                        <h2 class="text-4xl font-black text-slate-800 tracking-tight flex items-center gap-3">
                            <span x-text="selectedPasien?.nama"></span>
                        </h2>
                    </div>
                    <button @click="selectedPasien = null" class="w-12 h-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-red-500 hover:shadow-lg transition-all active:scale-95">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-5 divide-y lg:divide-y-0 lg:divide-x divide-slate-100">
                    <div class="lg:col-span-3 p-10">
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-3">
                            Item Tagihan
                            <div class="h-px flex-1 bg-slate-100"></div>
                        </h3>
                        <div class="space-y-4">
                            <!-- Tindakan -->
                            <template x-if="Number(selectedPasien?.biaya_tindakan) > 0">
                                <div class="flex justify-between items-center bg-blue-50/30 p-4 rounded-2xl border border-blue-100/50">
                                    <div>
                                        <p class="font-black text-blue-800 text-[15px]" x-text="selectedPasien?.planning"></p>
                                        <p class="text-xs font-bold text-blue-400">Jasa Medis / Tindakan</p>
                                    </div>
                                    <span class="font-black text-blue-700" x-text="formatRupiah(selectedPasien?.biaya_tindakan)"></span>
                                </div>
                            </template>

                            <template x-for="item in selectedPasien?.resep">
                                <div class="flex justify-between items-center bg-slate-50/50 p-4 rounded-2xl border border-slate-50">
                                    <div>
                                        <p class="font-black text-slate-800 text-[15px]" x-text="item.nama"></p>
                                        <p class="text-xs font-bold text-slate-400" x-text="item.jumlah + ' PCS x ' + formatRupiah(item.harga)"></p>
                                    </div>
                                    <span class="font-black text-slate-700" x-text="formatRupiah(item.subtotal)"></span>
                                </div>
                            </template>
                        </div>
                        <div class="mt-8 pt-8 border-t border-dashed border-slate-200 space-y-3 px-4">
                            <div class="flex justify-between items-center text-slate-500">
                                <span class="text-xs font-bold uppercase tracking-widest">Total Biaya Obat</span>
                                <span class="text-sm font-black" x-text="formatRupiah(selectedPasien?.total_obat || 0)"></span>
                            </div>
                            <div class="flex justify-between items-center text-slate-500">
                                <span class="text-xs font-bold uppercase tracking-widest">Total Biaya Tindakan</span>
                                <span class="text-sm font-black" x-text="formatRupiah(selectedPasien?.biaya_tindakan || 0)"></span>
                            </div>
                            <div class="flex justify-between items-center pt-3 border-t border-slate-100">
                                <span class="text-xs font-black text-slate-800 uppercase tracking-widest">Total Tagihan</span>
                                <span class="text-2xl font-black text-blue-600" x-text="formatRupiah(Number(selectedPasien?.total_obat || 0) + Number(selectedPasien?.biaya_tindakan || 0))"></span>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-2 p-10 bg-slate-50/30">
                        <div x-show="selectedPasien?.status === 'Menunggu Pembayaran'">
                            <form :id="'form-bayar-' + selectedPasien?.id" :action="'/kasir/proses-bayar/' + selectedPasien?.id" method="POST">
                                @csrf
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-xs font-black text-blue-600 uppercase tracking-widest mb-3">Biaya Tindakan (Rp)</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                                <span class="text-slate-400 font-black">Rp</span>
                                            </div>
                                            <div class="w-full pl-12 pr-5 py-4 rounded-2xl border-slate-200 bg-slate-50 font-black text-2xl text-slate-700 flex items-center">
                                                <span x-text="Number(inputTindakan).toLocaleString('id-ID')"></span>
                                            </div>
                                            <input type="hidden" name="total_tindakan" :value="inputTindakan">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-black text-blue-600 uppercase tracking-widest mb-3">
                                            Metode Bayar
                                        </label>

                                        <input type="text"
                                            value="Cash / Tunai"
                                            readonly
                                            class="w-full px-5 py-4 rounded-2xl border-slate-200 font-black text-slate-700 bg-slate-100 shadow-sm">

                                        <input type="hidden"
                                            name="metode_pembayaran"
                                            value="Cash">
                                    </div>

                                    <div x-show="metodeBayar === 'Cash'" x-transition>
                                        <label class="block text-xs font-black text-blue-600 uppercase tracking-widest mb-3">Jumlah Bayar (Rp)</label>
                                        <div class="relative mb-4">
                                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                                <span class="text-slate-400 font-black">Rp</span>
                                            </div>
                                            <input type="text" 
                                                :value="formatRibuan(jumlahBayar)"
                                                @input="jumlahBayar = $event.target.value.replace(/[^0-9]/g, '')"
                                                class="w-full pl-12 pr-5 py-4 rounded-2xl border-slate-200 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 font-black text-2xl transition-all shadow-sm" 
                                                placeholder="0">
                                        </div>
                                        
                                        <div class="flex justify-between items-center px-4 py-3 bg-emerald-50 rounded-2xl border border-emerald-100">
                                            <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Kembalian</span>
                                            <span class="text-xl font-black text-emerald-700" x-text="formatRupiah(hitungKembalian())"></span>
                                        </div>
                                    </div>

                                    <input type="hidden" name="jumlah_bayar" :value="jumlahBayar">
                                    <input type="hidden" name="kembalian" :value="hitungKembalian()">

                                    <div class="bg-slate-900 rounded-[2rem] p-8 text-white shadow-2xl shadow-slate-900/30 mt-10 relative overflow-hidden">
                                        <div class="relative z-10">
                                            <p class="text-[10px] font-black text-blue-400 uppercase tracking-[0.3em] mb-2">Total Pembayaran</p>
                                            <h3 class="text-4xl font-black tracking-tight mb-8" x-text="formatRupiah(Number(selectedPasien?.total_obat || 0) + Number(inputTindakan || 0))"></h3>
                                            <button type="button" 
                                                @click="triggerConfirm('info', 'Konfirmasi Pembayaran', 'Proses transaksi untuk ' + selectedPasien?.nama + ' sebesar ' + formatRupiah(Number(selectedPasien?.total_obat || 0) + Number(inputTindakan || 0)) + '?', 'form-bayar-' + selectedPasien?.id)"
                                                class="w-full py-5 bg-blue-600 hover:bg-blue-500 text-white rounded-2xl font-black uppercase tracking-[0.2em] text-xs transition-all shadow-xl shadow-blue-600/20 active:scale-95 flex items-center justify-center gap-3">
                                                Proses Transaksi
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div x-show="selectedPasien?.status === 'Selesai'" class="h-full flex flex-col items-center justify-center text-center p-6">
                            <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mb-6 shadow-lg shadow-emerald-500/10">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <h4 class="text-2xl font-black text-slate-800 mb-2">Pembayaran Lunas</h4>
                            <p class="text-slate-400 font-medium mb-8 uppercase tracking-widest text-xs">Transaksi telah selesai diproses.</p>
                            <div class="flex flex-col gap-3 w-full">
                                <button @click="triggerStruk(selectedPasien?.id_transaksi)" class="w-full py-4 bg-slate-800 text-white rounded-2xl font-black uppercase tracking-widest text-xs shadow-xl transition-all hover:bg-slate-700 active:scale-95 flex items-center justify-center gap-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                    Cetak Struk
                                </button>
                                <button @click="kirimStruk(selectedPasien?.id_transaksi)" class="w-full py-4 bg-blue-600 text-white rounded-2xl font-black uppercase tracking-widest text-xs shadow-xl transition-all hover:bg-blue-700 active:scale-95 flex items-center justify-center gap-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    Kirim ke Email
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="fixed bottom-10 right-10 z-[60]">
        <div class="bg-white border-l-4 border-blue-600 px-8 py-5 rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.1)] flex items-center gap-4 animate-slide-up">
            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
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
            inputTindakan: 0,
            jumlahBayar: 0,
            metodeBayar: 'Cash',
            searchQuery: '',
            
            showModal: false,
            modalType: 'info',
            modalTitle: '',
            modalMessage: '',
            targetFormId: null,

            selectPasien(pasien) {
                this.selectedPasien = pasien;
                this.inputTindakan = pasien.biaya_tindakan || 0;
                this.jumlahBayar = ''; // Kosongkan agar kasir mengetik manual
            },

            hitungKembalian() {
                let total = Number(this.selectedPasien?.total_obat || 0) + Number(this.inputTindakan || 0);
                return Math.max(0, this.jumlahBayar - total);
            },

            formatRupiah(number) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(number);
            },

            formatRibuan(number) {
                if (!number) return '';
                return parseInt(number, 10).toLocaleString('id-ID');
            },

            isAlertOnly: false,

            triggerConfirm(type, title, message, formId) {
                this.modalType = type;
                this.modalTitle = title;
                this.modalMessage = message;
                this.targetFormId = formId;
                this.isAlertOnly = false;
                this.showModal = true;
            },

            triggerAlert(title, message) {
                this.modalType = 'info';
                this.modalTitle = title;
                this.modalMessage = message;
                this.targetFormId = null;
                this.isAlertOnly = true;
                this.showModal = true;
            },

            confirmAction() {
                if (this.isAlertOnly) {
                    this.showModal = false;
                    return;
                }
                if (this.targetFormId) {
                    document.getElementById(this.targetFormId).submit();
                }
                this.showModal = false;
            },

            triggerStruk(transaksiId) {
                if (transaksiId) {
                    window.open("/kasir/cetak-struk/" + transaksiId, "_blank", "width=400,height=600");
                } else {
                    this.triggerAlert('Informasi', 'Data transaksi tidak ditemukan.');
                }
            },
            kirimStruk(transaksiId) {
                if (!transaksiId) {
                    this.triggerAlert('Informasi', 'Data transaksi tidak ditemukan.');
                    return;
                }
                
                const btnOriginalText = document.activeElement.innerHTML;
                document.activeElement.innerHTML = '<span class="animate-pulse">Mengirim...</span>';
                
                fetch(`/kasir/kirim-struk/${transaksiId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    document.activeElement.innerHTML = btnOriginalText;
                    if (data.success) {
                        this.triggerAlert('Berhasil', data.message);
                    } else {
                        this.triggerAlert('Error', data.message);
                    }
                })
                .catch(err => {
                    document.activeElement.innerHTML = btnOriginalText;
                    this.triggerAlert('Kesalahan', 'Terjadi kesalahan koneksi.');
                });
            },
            init() {
                // Jika baru saja menyelesaikan transaksi, pilih otomatis pasien tersebut
                @if(session('cetak_struk_id'))
                    setTimeout(() => {
                        const btn = document.querySelector(`button[data-transaksi-id="{{ session('cetak_struk_id') }}"]`);
                        if(btn) btn.click();
                    }, 100);
                @endif
            }
        }
    }

    @if(session('cetak_struk_id'))
        // Mencoba otomatis membuka popup struk (mungkin diblokir oleh popup blocker browser)
        window.open("{{ route('kasir.cetak-struk', session('cetak_struk_id')) }}", "_blank", "width=400,height=600");
    @endif
</script>
@endpush
