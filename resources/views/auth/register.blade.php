<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pasien | Maxilla Dental Care</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'], heading: ['Poppins', 'sans-serif'] },
                    colors: { primary: '#0ea5e9', secondary: '#0f172a', surface: '#f8fafc' }
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased text-slate-800 bg-white">

<div class="min-h-screen flex">
    <!-- Left Section: Branding/Illustration -->
    <div class="hidden lg:flex lg:w-5/12 relative bg-primary items-center justify-center overflow-hidden flex-col p-12">
        <!-- Decoration -->
        <div class="absolute top-[10%] right-[-20%] w-[30rem] h-[30rem] rounded-full bg-white/10 blur-3xl"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[25rem] h-[25rem] rounded-full bg-blue-800/30 blur-3xl"></div>
        
        <div class="relative z-10 w-full max-w-md text-white">
            <div class="flex items-center gap-2 mb-12">
                <img src="{{ asset('image/logo-maxilla.png') }}" alt="Logo Maxilla Dental Care" class="h-10 w-auto">
                <span class="font-heading font-bold text-xl tracking-tight">Maxilla Dental Care</span>
            </div>

            <h1 class="font-heading text-4xl font-bold leading-snug mb-6">Mulai Perjalanan Senyum Sehat Anda.</h1>
            <p class="text-blue-100 text-lg leading-relaxed mb-10 font-light">
                Pendaftaran hanya membutuhkan waktu satu menit. Setelah itu Anda memegang kendali penuh atas reservasi dan jadwal antrean di seluruh cabang kami.
            </p>

            <ul class="space-y-4 text-sm font-medium">
                <li class="flex items-center gap-3">
                    <div class="w-7 h-7 rounded-full bg-blue-400/40 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    Booking Cabang Terdekat Lebih Mudah
                </li>
                <li class="flex items-center gap-3">
                    <div class="w-7 h-7 rounded-full bg-blue-400/40 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    Notifikasi Estimasi Panggilan Real-Time
                </li>
                <li class="flex items-center gap-3">
                    <div class="w-7 h-7 rounded-full bg-blue-400/40 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    Riwayat Medis & Perawatan Terekam Aman
                </li>
            </ul>
        </div>
    </div>

    <!-- Right Section: Form -->
    <div class="w-full lg:w-7/12 flex items-center justify-center p-6 sm:p-12 lg:p-16 relative bg-slate-50/50">
        <!-- Back Button -->
        <a href="/" class="absolute top-8 right-8 hidden sm:flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-primary transition-colors">
            Halaman Utama
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </a>
        <a href="/" class="absolute top-6 left-6 block sm:hidden flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-primary transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>

        <div class="w-full max-w-xl bg-white p-8 sm:p-10 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 mt-8 sm:mt-0">
            <!-- Mobile Logo -->
            <div class="flex lg:hidden items-center gap-2 mb-8">
                <img src="{{ asset('image/logo-maxilla.png') }}" alt="Logo Maxilla Dental Care" class="h-10 w-auto">
                <span class="font-heading font-bold text-xl tracking-tight text-secondary">Maxilla <span class="text-primary">Dental Care</span></span>
            </div>

            @if($errors->any())
                <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm border border-red-100 mb-6 flex items-start gap-2">
                    <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            @if(session('registered_email'))
            <div class="text-center" x-data="countdownTimer()">
                <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <h2 class="font-heading text-2xl font-bold text-secondary mb-3">Verifikasi Email Anda</h2>
                <p class="text-slate-500 mb-6 text-sm leading-relaxed">
                    Kami telah mengirimkan link verifikasi ke <span class="font-bold text-slate-800">{{ session('registered_email') }}</span>.<br>
                    Silakan klik link pada email tersebut untuk memverifikasi akun Anda.
                </p>
                
                @if(session('resent'))
                <div class="bg-emerald-50 text-emerald-600 text-sm p-3 rounded-xl mb-6 border border-emerald-100 font-medium">
                    Link verifikasi baru telah dikirimkan!
                </div>
                @endif

                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 mb-6">
                    <p class="text-sm text-slate-600 mb-2">Belum menerima email?</p>
                    
                    <!-- Countdown state -->
                    <p x-show="timeLeft > 0" class="text-sm font-medium text-slate-500">
                        Tunggu <span class="font-bold text-primary" x-text="formattedTime"></span> untuk mengirim ulang
                    </p>
                    
                    <!-- Resend form -->
                    <form x-show="timeLeft <= 0" action="{{ route('verification.resend') }}" method="POST" class="inline" style="display: none;">
                        @csrf
                        <input type="hidden" name="email" value="{{ session('registered_email') }}">
                        <button type="submit" class="text-sm font-bold text-primary hover:text-blue-700 underline underline-offset-2">
                            Kirim Ulang Link Verifikasi
                        </button>
                    </form>
                </div>

                <a href="{{ route('login') }}" class="inline-block w-full py-3.5 px-4 rounded-xl font-bold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 transition-colors">
                    Kembali ke Halaman Login
                </a>
            </div>

            <script>
                document.addEventListener('alpine:init', () => {
                    Alpine.data('countdownTimer', () => ({
                        timeLeft: 120, // 2 minutes
                        timer: null,
                        pollTimer: null,
                        email: '{{ session('registered_email') }}',
                        
                        init() {
                            this.startTimer();
                            this.startPolling();
                        },
                        
                        startTimer() {
                            this.timer = setInterval(() => {
                                if (this.timeLeft > 0) {
                                    this.timeLeft--;
                                } else {
                                    clearInterval(this.timer);
                                }
                            }, 1000);
                        },

                        startPolling() {
                            this.pollTimer = setInterval(() => {
                                fetch(`/email/check-verification?email=${encodeURIComponent(this.email)}`)
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data.verified) {
                                            clearInterval(this.pollTimer);
                                            clearInterval(this.timer);
                                            window.location.href = "{{ route('login') }}";
                                        }
                                    })
                                    .catch(err => console.error(err));
                            }, 3000); // Cek setiap 3 detik
                        },
                        
                        get formattedTime() {
                            let m = Math.floor(this.timeLeft / 60);
                            let s = this.timeLeft % 60;
                            return `${m}:${s.toString().padStart(2, '0')}`;
                        }
                    }))
                })
            </script>
            @else
            <div class="mb-8 lg:text-left">
                <h2 class="font-heading text-3xl font-bold text-secondary mb-2">Buat Akun Pasien</h2>
                <p class="text-slate-500 font-light text-sm">Daftar sekarang untuk kemudahan reservasi di klinik kami.</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf
                
                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap</label>
                    <div class="relative">
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="block w-full px-4 py-3 border @error('name') border-red-500 @else border-slate-200 @enderror rounded-xl focus:ring-primary focus:border-primary bg-slate-50 focus:bg-white transition-colors sm:text-sm" placeholder="Sesuai KTP" required>
                    </div>
                    @error('name')
                        <p class="text-red-500 text-[11px] font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Alamat Email</label>
                    <div class="relative">
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="block w-full px-4 py-3 border @error('email') border-red-500 @else border-slate-200 @enderror rounded-xl focus:ring-primary focus:border-primary bg-slate-50 focus:bg-white transition-colors sm:text-sm" placeholder="email@contoh.com" required>
                    </div>
                    @error('email')
                        <p class="text-red-500 text-[11px] font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" class="block w-full px-4 py-3 border @error('password') border-red-500 @else border-slate-200 @enderror rounded-xl focus:ring-primary focus:border-primary bg-slate-50 focus:bg-white transition-colors sm:text-sm" placeholder="Minimal 8 karakter" required>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-[11px] font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1.5">Ulangi Password</label>
                        <div class="relative">
                            <input type="password" id="password_confirmation" name="password_confirmation" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-primary focus:border-primary bg-slate-50 focus:bg-white transition-colors sm:text-sm" placeholder="Ketik ulang password" required>
                        </div>
                    </div>
                </div>

                <!-- Terms -->
                <div class="flex items-start mt-4 pt-2">
                    <div class="flex items-center h-5">
                        <input id="terms" name="terms" type="checkbox" required class="h-4 w-4 rounded border-slate-300 text-primary focus:ring-primary cursor-pointer">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="font-medium text-slate-600 cursor-pointer">Saya menyetujui <a href="#" class="text-primary hover:underline hover:text-blue-700">Syarat & Ketentuan</a> serta <a href="#" class="text-primary hover:underline hover:text-blue-700">Kebijakan Privasi</a>.</label>
                    </div>
                </div>

                <!-- Submit -->
                <div class="pt-4 space-y-3">
                    <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-primary/30 text-sm font-bold text-white bg-primary hover:bg-blue-600 transform hover:-translate-y-0.5 transition-all outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Daftar Menjadi Pasien
                    </button>
                    
                    <div class="relative flex items-center justify-center py-2">
                        <div class="border-t border-slate-200 w-full absolute"></div>
                        <span class="bg-white px-4 text-xs font-medium text-slate-400 relative z-10 uppercase tracking-widest">Atau</span>
                    </div>

                    <a href="{{ route('auth.google') }}" class="w-full flex justify-center items-center py-3.5 px-4 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 bg-white hover:bg-slate-50 transform hover:-translate-y-0.5 transition-all shadow-sm">
                        <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                        Daftar dengan Google
                    </a>
                </div>
            </form>

            <div class="mt-8 text-center bg-slate-50 py-4 rounded-xl border border-slate-100">
                <p class="text-sm text-slate-600">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="font-bold text-primary hover:text-blue-700 transition-colors ml-1">Masuk Sekarang</a>
                </p>
            </div>
            @endif
        </div>
    </div>
</div>

</body>
</html>
