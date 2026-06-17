@extends('layouts.dokter')

@section('title', 'Pengaturan Profil')

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="{ 
        editMode: false, 
        showPassword: false,
        showPasswordConfirm: false,
        form: {
            nama: '{{ $user->nama }}',
            email: '{{ $user->email }}',
            no_wa: '{{ $user->no_wa }}'
        }
    }">

    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl p-8 text-white shadow-lg relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-6">
            
            <!-- Foto Profil Section -->
            <div class="relative group" x-data="{
                photoPreview: '{{ $user->foto ? Storage::url($user->foto) : '' }}',
                handlePhotoUpload(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.photoPreview = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                }
            }">
                <div class="w-24 h-24 rounded-full bg-white text-blue-600 flex items-center justify-center text-4xl font-bold shadow-xl border-4 border-white/20 overflow-hidden relative">
                    <template x-if="photoPreview">
                        <img :src="photoPreview" alt="Foto Profil" class="w-full h-full object-cover">
                    </template>
                    <template x-if="!photoPreview">
                        <span>{{ substr($user->nama ?? 'D', 0, 1) }}</span>
                    </template>
                </div>
                
                <template x-if="editMode">
                    <label for="foto" class="absolute bottom-0 right-0 bg-white text-blue-600 p-1.5 rounded-full shadow-lg border border-slate-200 cursor-pointer hover:bg-slate-50 transition-colors z-10" title="Ubah Foto">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </label>
                </template>
                
                <!-- Input type file disembunyikan di dalam form, akan di-trigger oleh label ini -->
            </div>
            <div class="text-center md:text-left flex-1">
                <h1 class="text-3xl font-black tracking-tight mb-2" x-text="form.nama"></h1>
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-blue-100 text-sm font-medium">
                    <div class="flex items-center gap-1.5 bg-white/10 px-3 py-1.5 rounded-full backdrop-blur-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Dokter Gigi
                    </div>
                    @if($user->cabang)
                    <div class="flex items-center gap-1.5 bg-white/10 px-3 py-1.5 rounded-full backdrop-blur-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Cabang {{ $user->cabang }}
                    </div>
                    @endif
                </div>
            </div>
            <div class="mt-4 md:mt-0">
                <button type="button" @click="editMode = !editMode" 
                    class="bg-white/20 hover:bg-white/30 text-white px-6 py-2.5 rounded-2xl font-bold transition-all backdrop-blur-md border border-white/30 shadow-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    <span x-text="editMode ? 'Batal Edit' : 'Edit Profil'"></span>
                </button>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 text-emerald-600 border border-emerald-200 p-4 rounded-2xl flex items-center gap-3 shadow-sm" x-data="{ show: true }" x-show="show" x-transition>
        <div class="bg-emerald-100 p-2 rounded-xl">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <p class="font-bold text-sm flex-1">{{ session('success') }}</p>
        <button @click="show = false" class="text-emerald-400 hover:text-emerald-600 p-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-50 text-red-600 border border-red-200 p-4 rounded-2xl shadow-sm">
        <div class="flex items-center gap-3 mb-2">
            <div class="bg-red-100 p-2 rounded-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <p class="font-bold text-sm">Gagal memperbarui profil</p>
        </div>
        <ul class="list-disc list-inside text-sm pl-11 space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Profile Form Card -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="border-b border-slate-100 px-6 py-5 flex items-center justify-between bg-slate-50/50">
            <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Informasi Pribadi
            </h2>
        </div>

        <form action="{{ route('dokter.profil.update') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8">
            @csrf
            
            <!-- Input Foto Disembunyikan, terhubung dengan AlpineJS di atas -->
            <input type="file" id="foto" name="foto" accept="image/jpeg,image/png,image/jpg" class="hidden" @change="handlePhotoUpload">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Data Diri Section -->
                <div class="space-y-6">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Data Diri</h3>
                    
                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap & Gelar</label>
                        <template x-if="!editMode">
                            <div class="px-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-slate-600 font-medium text-sm flex items-center gap-3">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <span x-text="form.nama"></span>
                            </div>
                        </template>
                        <template x-if="editMode">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <input type="text" name="nama" x-model="form.nama" required
                                    class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 text-slate-800 text-sm font-medium rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none" placeholder="Masukkan nama lengkap">
                            </div>
                        </template>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Email</label>
                        <template x-if="!editMode">
                            <div class="px-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-slate-600 font-medium text-sm flex items-center gap-3">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <span x-text="form.email"></span>
                            </div>
                        </template>
                        <template x-if="editMode">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <input type="email" name="email" x-model="form.email" required
                                    class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 text-slate-800 text-sm font-medium rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none" placeholder="Masukkan alamat email">
                            </div>
                        </template>
                    </div>

                    <!-- Nomor HP/WhatsApp -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nomor HP/WhatsApp</label>
                        <template x-if="!editMode">
                            <div class="px-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-slate-600 font-medium text-sm flex items-center gap-3">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                <span x-text="form.no_wa || '-'"></span>
                            </div>
                        </template>
                        <template x-if="editMode">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                                <input type="text" name="no_wa" x-model="form.no_wa"
                                    class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 text-slate-800 text-sm font-medium rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none" placeholder="Contoh: 081234567890">
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Keamanan Section -->
                <div class="space-y-6">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Keamanan Akun</h3>
                    
                    <template x-if="!editMode">
                        <div class="bg-slate-50 border border-slate-100 p-5 rounded-2xl flex flex-col items-center justify-center text-center h-48">
                            <div class="w-12 h-12 bg-slate-200 text-slate-400 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <p class="text-sm font-medium text-slate-500 mb-1">Kata Sandi Anda Dilindungi</p>
                            <p class="text-xs text-slate-400">Klik "Edit Profil" untuk mengubah kata sandi.</p>
                        </div>
                    </template>

                    <template x-if="editMode">
                        <div class="space-y-6 bg-slate-50 border border-slate-100 p-6 rounded-3xl">
                            <div class="bg-blue-50 border border-blue-100 p-3 rounded-xl flex items-start gap-3 mb-4">
                                <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-xs font-medium text-blue-700 leading-relaxed">Kosongkan kolom kata sandi di bawah jika Anda tidak ingin mengubahnya.</p>
                            </div>

                            <!-- Password Baru -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Kata Sandi Baru</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    </div>
                                    <input :type="showPassword ? 'text' : 'password'" name="password"
                                        class="w-full pl-11 pr-12 py-3 bg-white border border-slate-200 text-slate-800 text-sm font-medium rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none" placeholder="Masukkan kata sandi baru">
                                    <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-blue-500">
                                        <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 015.002-5.5m5.424 0c1.23.473 2.333 1.168 3.25 2.05-1.274 4.057-5.064 7-9.542 7a10.046 10.046 0 01-1.373-.095M15 12a3 3 0 11-6 0 3 3 0 016 0zM3 3l18 18"></path></svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Konfirmasi Password -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Konfirmasi Kata Sandi Baru</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                    </div>
                                    <input :type="showPasswordConfirm ? 'text' : 'password'" name="password_confirmation"
                                        class="w-full pl-11 pr-12 py-3 bg-white border border-slate-200 text-slate-800 text-sm font-medium rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none" placeholder="Ulangi kata sandi baru">
                                    <button type="button" @click="showPasswordConfirm = !showPasswordConfirm" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-blue-500">
                                        <svg x-show="!showPasswordConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        <svg x-show="showPasswordConfirm" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 015.002-5.5m5.424 0c1.23.473 2.333 1.168 3.25 2.05-1.274 4.057-5.064 7-9.542 7a10.046 10.046 0 01-1.373-.095M15 12a3 3 0 11-6 0 3 3 0 016 0zM3 3l18 18"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Action Buttons -->
            <template x-if="editMode">
                <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-end gap-4" x-transition>
                    <button type="button" @click="editMode = false" 
                        class="px-6 py-3 rounded-2xl text-sm font-bold text-slate-500 bg-slate-100 hover:bg-slate-200 transition-colors">
                        Batal
                    </button>
                    <button type="submit" 
                        class="px-8 py-3 rounded-2xl text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </template>
        </form>
    </div>
</div>
@endsection
