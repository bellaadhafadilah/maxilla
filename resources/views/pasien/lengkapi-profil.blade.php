<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lengkapi Profil Medis | Maxilla Dental Care</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Inter'], heading: ['Poppins'] }, colors: { primary: '#0ea5e9', secondary: '#0f172a' } } }
        }
    </script>
</head>
<body class="font-sans antialiased text-slate-800 bg-slate-50 min-h-screen flex flex-col">

    <!-- TOP NAVIGATION BAR -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-20">
            <div class="flex items-center gap-3">
                <img src="{{ asset('image/logo-maxilla.png') }}" alt="Logo" class="h-8 w-auto">
                <span class="font-heading font-bold text-xl tracking-tight text-secondary">Maxilla <span class="text-primary hidden sm:inline">Dental Care</span></span>
            </div>
            <nav class="hidden md:flex items-center gap-8">
                <a href="/pasien/dashboard" class="text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors py-7">Beranda</a>
                <a href="/pasien/riwayat" class="text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors py-7">Riwayat Reservasi</a>
                <a href="#" class="text-sm font-bold text-primary border-b-2 border-primary py-7">Profil</a>
            </nav>
            <div class="flex items-center gap-4">
                <a href="/pasien/dashboard" class="text-sm font-bold text-slate-500 hover:text-slate-800 transition-colors">Kembali ke Dashboard</a>
            </div>
        </div>
    </header>

    <main class="flex-1 w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
            <div class="mb-8">
                <h1 class="font-heading text-2xl font-bold text-slate-800 mb-2">Lengkapi Informasi Dasar Anda</h1>
                <p class="text-slate-500 text-sm">Informasi usia, alamat, dan jenis kelamin Anda diperlukan oleh dokter dan sistem klinik untuk mempersiapkan rekam medis (Kardex) pertama kalinya.</p>
            </div>

            <form action="{{ route('pasien.profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <!-- Data Akun Dasar -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama', auth()->user()->nama ?? '') }}" class="block w-full px-4 py-3 border @error('nama') border-red-500 @else border-slate-200 @enderror rounded-xl focus:ring-primary focus:border-primary text-sm bg-slate-50 focus:bg-white transition-colors outline-none" required>
                        @error('nama')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" class="block w-full px-4 py-3 border @error('email') border-red-500 @else border-slate-200 @enderror rounded-xl focus:ring-primary focus:border-primary text-sm bg-slate-50 focus:bg-white transition-colors outline-none cursor-not-allowed text-slate-400" readonly>
                        <p class="text-xs text-slate-400 mt-1 italic">*Email digunakan untuk login, tidak dapat diubah</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">No. KTP (NIK)</label>
                        <input type="text" name="nik" value="{{ old('nik', auth()->user()->nik ?? '') }}" class="block w-full px-4 py-3 border @error('nik') border-red-500 @else border-slate-200 @enderror rounded-xl focus:ring-primary focus:border-primary text-sm bg-slate-50 focus:bg-white transition-colors outline-none" placeholder="16 Digit NIK" required minlength="16" maxlength="16" pattern="[0-9]{16}" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        @error('nik')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">No. WhatsApp / HP</label>
                        <input type="text" name="no_wa" value="{{ old('no_wa', auth()->user()->no_wa ?? '') }}" class="block w-full px-4 py-3 border @error('no_wa') border-red-500 @else border-slate-200 @enderror rounded-xl focus:ring-primary focus:border-primary text-sm bg-slate-50 focus:bg-white transition-colors outline-none" placeholder="Contoh: 08123456789" required>
                        @error('no_wa')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Alamat Domisili -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Lengkap / Domisili Saat Ini</label>
                    <textarea name="alamat" rows="3" class="block w-full px-4 py-3 border @error('alamat') border-red-500 @else border-slate-200 @enderror rounded-xl focus:ring-primary focus:border-primary text-sm bg-slate-50 focus:bg-white transition-colors outline-none resize-none" placeholder="Masukkan alamat lengkap sesuai dengan domisili terdekat dengan cabang klinik." required>{{ old('alamat', auth()->user()->pasien->alamat ?? '') }}</textarea>
                    @error('alamat')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Jenis Kelamin -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Jenis Kelamin</label>
                        <select name="gender" class="block w-full px-4 py-3 border @error('gender') border-red-500 @else border-slate-200 @enderror rounded-xl focus:ring-primary focus:border-primary text-sm bg-slate-50 focus:bg-white transition-colors outline-none cursor-pointer" required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L" {{ old('gender', (auth()->user()->pasien->jenis_kelamin ?? '') == 'Laki-laki' ? 'L' : ((auth()->user()->pasien->jenis_kelamin ?? '') == 'Perempuan' ? 'P' : '')) == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                            <option value="P" {{ old('gender', (auth()->user()->pasien->jenis_kelamin ?? '') == 'Laki-laki' ? 'L' : ((auth()->user()->pasien->jenis_kelamin ?? '') == 'Perempuan' ? 'P' : '')) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir_input" name="tanggal_lahir" value="{{ old('tanggal_lahir', auth()->user()->pasien->tanggal_lahir ?? '') }}" max="{{ now()->subYears(4)->format('Y-m-d') }}" class="block w-full px-4 py-3 border @error('tanggal_lahir') border-red-500 @else border-slate-200 @enderror rounded-xl focus:ring-primary focus:border-primary text-sm bg-slate-50 focus:bg-white transition-colors outline-none cursor-pointer" required>
                        @error('tanggal_lahir')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Riwayat Penyakit (Opsional) -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Riwayat Penyakit (Opsional)</label>
                        <textarea name="riwayat_penyakit" rows="2" class="block w-full px-4 py-3 border @error('riwayat_penyakit') border-red-500 @else border-slate-200 @enderror rounded-xl focus:ring-primary focus:border-primary text-sm bg-slate-50 focus:bg-white transition-colors outline-none resize-none" placeholder="Contoh: Hipertensi, Diabetes, Asma, dll (Kosongkan jika tidak ada)">{{ old('riwayat_penyakit', auth()->user()->pasien->riwayat_penyakit ?? '') }}</textarea>
                        @error('riwayat_penyakit')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alergi Obat (Opsional) -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Alergi Obat (Opsional)</label>
                        <textarea name="alergi_obat" rows="2" class="block w-full px-4 py-3 border @error('alergi_obat') border-red-500 @else border-slate-200 @enderror rounded-xl focus:ring-primary focus:border-primary text-sm bg-slate-50 focus:bg-white transition-colors outline-none resize-none" placeholder="Contoh: Amoxicillin, Ibuprofen, dll (Kosongkan jika tidak ada)">{{ old('alergi_obat', auth()->user()->pasien->alergi_obat ?? '') }}</textarea>
                        @error('alergi_obat')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Foto Profil (Opsional) -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Unggah Foto Profil (Opsional)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-xl bg-slate-50 hover:bg-slate-100 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-slate-600 justify-center">
                                <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-bold text-primary hover:text-blue-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary">
                                    <span>Upload foto Anda</span>
                                    <input id="file-upload" name="file-upload" type="file" class="sr-only" accept="image/png, image/jpeg, image/jpg">
                                </label>
                                <p class="pl-1">atau tarik lepas kesini</p>
                            </div>
                            <p class="text-xs text-slate-500">PNG, JPG maksimal 2MB</p>
                            @error('file-upload')
                                <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100">
                    <button type="submit" id="submit_btn" class="w-full sm:w-auto px-8 py-3.5 bg-green-500 text-white font-bold rounded-xl hover:bg-green-600 transition-colors shadow-[0_4px_10px_rgb(34,197,94,0.3)] disabled:opacity-50 disabled:cursor-not-allowed">
                        Simpan & Lengkapi Profil
                    </button>
                    <a href="/pasien/dashboard" class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-3 px-8 py-3.5 bg-slate-100 text-slate-700 font-bold rounded-xl hover:bg-slate-200 transition-colors inline-block text-center border border-slate-200">
                        Nanti Saja
                    </a>
                </div>
            </form>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tglInput = document.getElementById('tanggal_lahir_input');
            const submitBtn = document.getElementById('submit_btn');
            
            // Batas maksimal 4 tahun lalu
            const maxDateStr = '{{ now()->subYears(4)->format("Y-m-d") }}';
            const maxDate = new Date(maxDateStr);

            if(tglInput) {
                tglInput.addEventListener('input', function() {
                    if(this.value) {
                        const selectedDate = new Date(this.value);
                        if(selectedDate > maxDate) {
                            submitBtn.disabled = true;
                        } else {
                            submitBtn.disabled = false;
                        }
                    }
                });
                
                // Trigger check on load
                tglInput.dispatchEvent(new Event('input'));
            }
        });
    </script>
</body>
</html>
