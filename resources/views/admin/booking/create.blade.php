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

    x-data="{
        tanggal:'',
        jam:'',
        dokter:'',
        dokters:[],
        loading:false,
        nik:'',
        nama_pasien:'',
        jenis_kelamin_pasien:'Laki-laki',
        tanggal_lahir_pasien:'',
        alamat:'',
        riwayat_penyakit:'',
        alergi_obat:'',
        hubungan:'Diri Sendiri',

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
                    <select name="dokter"
                        x-model="dokter"
                        required
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all cursor-pointer disabled:bg-slate-50 disabled:text-slate-400"
                        :disabled="!tanggal || !jam || loading">
                        <option value="">Pilih Dokter</option>
                        <template x-for="d in dokters">
                            <option :value="d.dokter_nama" x-text="d.dokter_nama"></option>
                        </template>
                    </select>
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

@endsection
