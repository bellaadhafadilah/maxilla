@extends('layouts.admin')

@section('title', 'Booking Manual')

@section('content')

<div class="max-w-5xl mx-auto">

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">
            Booking Manual
        </h1>
        <p class="text-slate-500">
            Tambahkan reservasi pasien secara manual.
        </p>
    </div>

    <a href="{{ route('admin.booking.index') }}"
        class="px-4 py-2 bg-slate-100 rounded-xl text-slate-700 font-semibold">
        Kembali
    </a>
</div>

<form action="{{ route('admin.booking.store') }}"
    method="POST"
    id="formBooking"
    @submit.prevent="confirmSubmit()"
    x-data="{
        tanggal:'',
        jam:'',
        dokter:'',
        dokters:[],
        loading:false,
        showDokterModal:false,
        nik:'',
        nama_pasien:'',
        jenis_kelamin_pasien:'Laki-laki',
        tanggal_lahir_pasien:'',
        alamat:'',
        riwayat_penyakit:'',
        alergi_obat:'',
        hubungan:'Diri Sendiri',
        email:'',
        no_wa:'',

        fetchDokters() {
            if(this.tanggal && this.jam){
                this.loading = true;
                fetch('/admin/api/available-doctors?tanggal='
                    + this.tanggal +
                    '&jam=' + this.jam)
                .then(res => res.json())
                .then(data => {
                    this.dokters = data;
                    this.loading = false;
                })
                .catch(() => {
                    this.loading = false;
                });
            }
        },

        searchNik() {
            if(this.nik.length === 16) {
                fetch('/admin/api/search-patient-by-nik?nik=' + this.nik)
                .then(res => res.json())
                .then(data => {
                    if (data) {
                        this.nama_pasien = data.nama;
                        this.jenis_kelamin_pasien = data.jenis_kelamin;
                        this.tanggal_lahir_pasien = data.tanggal_lahir;
                        this.alamat = data.alamat;
                        this.riwayat_penyakit = data.riwayat_penyakit;
                        this.alergi_obat = data.alergi_obat;
                    }
                });
            }
        },

        confirmSubmit() {
            Swal.fire({
                title: 'Konfirmasi Data',
                text: 'Apakah data yang dimasukkan sudah benar?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-6 py-2',
                    cancelButton: 'rounded-xl px-6 py-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formBooking').submit();
                }
            })
        }
    }">

    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">

            <h3 class="font-bold text-lg mb-5 text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Data Pasien
            </h3>

            <div class="space-y-4">

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        NIK (Nomor Induk Kependudukan)
                    </label>
                    <input type="text"
                        name="nik"
                        x-model="nik"
                        @input="nik = $event.target.value.replace(/[^0-9]/g, ''); searchNik()"
                        minlength="16"
                        maxlength="16"
                        pattern="[0-9]{16}"
                        title="NIK harus terdiri dari 16 digit angka"
                        required
                        placeholder="Masukkan 16 digit NIK"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Nama Pasien
                    </label>
                    <input type="text"
                        name="nama_pasien"
                        x-model="nama_pasien"
                        required
                        placeholder="Nama lengkap pasien"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Email <span class="text-xs text-slate-400 font-normal">(Opsional)</span>
                        </label>
                        <input type="email"
                            name="email"
                            x-model="email"
                            placeholder="Contoh: pasien@email.com"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            No. WhatsApp <span class="text-xs text-slate-400 font-normal">(Opsional)</span>
                        </label>
                        <input type="text"
                            name="no_wa"
                            x-model="no_wa"
                            placeholder="Contoh: 08123456789"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Jenis Kelamin
                        </label>
                        <select name="jenis_kelamin_pasien"
                            x-model="jenis_kelamin_pasien"
                            required
                            class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all cursor-pointer">
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Tanggal Lahir
                        </label>
                        <input type="date"
                            name="tanggal_lahir_pasien"
                            x-model="tanggal_lahir_pasien"
                            max="{{ now()->subYears(4)->format('Y-m-d') }}"
                            required
                            class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all cursor-pointer">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Alamat Domisili
                    </label>
                    <textarea name="alamat"
                        x-model="alamat"
                        required
                        rows="2"
                        placeholder="Alamat lengkap tempat tinggal"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all resize-none"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Riwayat Penyakit (Opsional)
                        </label>
                        <input type="text"
                            name="riwayat_penyakit"
                            x-model="riwayat_penyakit"
                            placeholder="Contoh: Asma, Diabetes, dll"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Alergi Obat (Opsional)
                        </label>
                        <input type="text"
                            name="alergi_obat"
                            x-model="alergi_obat"
                            placeholder="Contoh: Penicillin, dll"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                    </div>
                </div>

                <input type="hidden" name="hubungan" value="Diri Sendiri">

            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">

            <h3 class="font-bold text-lg mb-5 text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Jadwal Kunjungan
            </h3>

            <div class="space-y-4">

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Cabang
                    </label>
                    <input type="text"
                        readonly
                        value="{{ auth()->user()->cabang }}"
                        class="w-full bg-slate-100 border border-slate-200 text-slate-500 font-bold rounded-xl px-4 py-3 cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Tanggal Reservasi
                    </label>
                    <input type="date"
                        name="tanggal"
                        x-model="tanggal"
                        @change="fetchDokters()"
                        min="{{ now()->format('Y-m-d') }}"
                        required
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all cursor-pointer">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Sesi
                    </label>
                    <select name="jam"
                        x-model="jam"
                        @change="fetchDokters()"
                        required
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all cursor-pointer">
                        <option value="">Pilih Sesi</option>
                        <option value="Pagi">Pagi</option>
                        <option value="Siang">Siang</option>
                        <option value="Sore">Sore</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Dokter
                    </label>
                    <div class="relative">
                        <!-- Hidden input to store value for form submission -->
                        <input type="hidden" name="dokter" x-model="dokter" required>
                        
                        <!-- Visible trigger button/input -->
                        <button type="button"
                            @click="if(tanggal && jam && !loading) showDokterModal = true"
                            :disabled="!tanggal || !jam || loading"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all cursor-pointer text-left bg-white disabled:bg-slate-50 disabled:text-slate-400 flex justify-between items-center">
                            <span x-text="dokter ? dokter : (loading ? 'Mencari dokter...' : 'Pilih Dokter')"></span>
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                    </div>

                    <!-- Modal Pilih Dokter -->
                    <template x-teleport="body">
                        <div x-show="showDokterModal" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                            style="display: none;">

                            <div @click.away="showDokterModal = false" x-show="showDokterModal"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                                class="bg-white rounded-3xl p-6 max-w-md w-full shadow-2xl border border-slate-100 relative overflow-hidden flex flex-col max-h-[90vh]">
                                
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="font-bold text-xl text-slate-800">Pilih Dokter</h3>
                                    <button type="button" @click="showDokterModal = false" class="text-slate-400 hover:text-slate-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>

                                <div class="overflow-y-auto space-y-3 pr-2 flex-1">
                                    <template x-if="dokters.length === 0">
                                        <div class="text-center p-6 text-slate-500">
                                            Tidak ada dokter yang tersedia pada jadwal tersebut.
                                        </div>
                                    </template>
                                    <template x-for="d in dokters" :key="d.id">
                                        <button type="button"
                                            @click="if(d.sisa_kuota > 0) { dokter = d.dokter_nama; showDokterModal = false; }"
                                            :disabled="d.sisa_kuota <= 0"
                                            class="w-full text-left p-4 rounded-2xl border-2 flex items-center gap-4 transition-all"
                                            :class="dokter === d.dokter_nama ? 'border-blue-500 bg-blue-50' : (d.sisa_kuota > 0 ? 'border-slate-100 hover:border-blue-200 cursor-pointer' : 'border-slate-100 bg-slate-50 opacity-60 cursor-not-allowed')">
                                            
                                            <div class="shrink-0 w-12 h-12 rounded-full overflow-hidden bg-slate-200 border border-slate-300">
                                                <template x-if="d.foto">
                                                    <img :src="d.foto" alt="Foto Dokter" class="w-full h-full object-cover">
                                                </template>
                                                <template x-if="!d.foto">
                                                    <div class="w-full h-full flex items-center justify-center text-slate-400 font-bold text-lg bg-blue-100 text-blue-600">
                                                        <span x-text="d.dokter_nama.replace('Drg. ', '').replace('drg. ', '').replace('Dr. ', '').replace('dr. ', '').charAt(0)"></span>
                                                    </div>
                                                </template>
                                            </div>
                                            
                                            <div class="flex-1">
                                                <div class="font-bold text-slate-800 text-base" x-text="d.dokter_nama"></div>
                                                <div class="text-xs font-semibold mt-1"
                                                    :class="d.sisa_kuota > 0 ? (d.sisa_kuota <= 3 ? 'text-orange-500' : 'text-green-500') : 'text-red-500'">
                                                    Sisa Kuota: <span x-text="d.sisa_kuota"></span>/<span x-text="d.kuota_awal"></span>
                                                    <template x-if="d.sisa_kuota <= 0">
                                                        <span> (Penuh)</span>
                                                    </template>
                                                </div>
                                            </div>

                                            <div class="shrink-0 text-blue-500" x-show="dokter === d.dokter_nama">
                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                            </div>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

            </div>
        </div>

    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm mt-6">

        <h3 class="font-bold text-lg mb-5 text-slate-800 flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
            Keluhan
        </h3>

        <textarea name="keluhan"
            rows="5"
            placeholder="Tuliskan keluhan pasien"
            class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all resize-none"></textarea>

    </div>

    <div class="mt-6 flex justify-end">
        <button type="submit"
            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 transition-colors text-white rounded-xl font-semibold shadow-lg shadow-blue-500/20 active:scale-95">
            Simpan Booking
        </button>
    </div>

</form>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
