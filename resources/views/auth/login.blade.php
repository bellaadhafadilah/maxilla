<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | Maxilla Dental Care</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700&display=swap"
        rel="stylesheet">
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
        <!-- Left Section: Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 lg:p-24 relative">
            <!-- Back Button -->
            <a href="/"
                class="absolute top-8 left-8 flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-primary transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>

            <div class="w-full max-w-md mt-10 lg:mt-0">
                <!-- Logo -->
                <div class="flex items-center gap-2 mb-10">
                    <img src="{{ asset('image/logo-maxilla.png') }}" alt="Logo Maxilla Dental Care" class="h-10 w-auto">
                    <span class="font-heading font-bold text-xl tracking-tight text-secondary">Maxilla <span
                            class="text-primary">Dental Care</span></span>
                </div>

                <div>
                    <h2 class="font-heading text-3xl font-bold text-secondary mb-2">Selamat Datang!</h2>
                    <p class="text-slate-500 mb-8">Masuk ke akun Anda untuk memesan jadwal atau melihat nomor antrian
                        hari ini.</p>
                </div>

                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf

                    @if($errors->any())
                        <div
                            class="bg-red-50 text-red-600 p-4 rounded-xl text-sm border border-red-100 mb-4 flex items-start gap-2">
                            <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    @if(session('success'))
                        <div
                            class="bg-emerald-50 text-emerald-600 p-4 rounded-xl text-sm border border-emerald-100 mb-4 flex items-start gap-2">
                            <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Email/No. HP -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                    </path>
                                </svg>
                            </div>
                            <input type="text" id="email" name="email"
                                class="block w-full pl-10 pr-3 py-3.5 border border-slate-200 rounded-xl focus:ring-primary focus:border-primary bg-slate-50 focus:bg-white transition-colors sm:text-sm"
                                placeholder="contoh@email.com atau 0812..." required>
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                            <a href="{{ route('password.request') }}"
                                class="text-sm font-medium text-primary hover:text-blue-700 transition-colors">Lupa
                                sandi?</a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                            <input type="password" id="password" name="password"
                                class="block w-full pl-10 pr-12 py-3.5 border border-slate-200 rounded-xl focus:ring-primary focus:border-primary bg-slate-50 focus:bg-white transition-colors sm:text-sm"
                                placeholder="Masukkan password Anda" required>
                            <button type="button"
                                onclick="const p = document.getElementById('password'); const e = document.getElementById('eye-icon'); if(p.type === 'password'){ p.type = 'text'; e.innerHTML = '<path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21\'></path>'; } else { p.type = 'password'; e.innerHTML = '<path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M15 12a3 3 0 11-6 0 3 3 0 016 0z\'></path><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z\'></path>'; }"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                <svg id="eye-icon" class="h-5 w-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                            class="h-4 w-4 rounded border-slate-300 text-primary focus:ring-primary">
                        <label for="remember" class="ml-2 block text-sm text-slate-600">
                            Ingat saya (Biarkan saya tetap masuk)
                        </label>
                    </div>

                    <!-- Submit -->
                    <div class="pt-4 space-y-3">
                        <button type="submit"
                            class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-primary/30 text-sm font-bold text-white bg-primary hover:bg-blue-600 transform hover:-translate-y-0.5 transition-all outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            Masuk ke Sistem
                        </button>

                        <div class="relative flex items-center justify-center py-2">
                            <div class="border-t border-slate-200 w-full absolute"></div>
                            <span
                                class="bg-white px-4 text-xs font-medium text-slate-400 relative z-10 uppercase tracking-widest">Atau</span>
                        </div>

                        <a href="{{ route('auth.google') }}"
                            class="w-full flex justify-center items-center py-3.5 px-4 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 bg-white hover:bg-slate-50 transform hover:-translate-y-0.5 transition-all shadow-sm">
                            <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                    fill="#4285F4" />
                                <path
                                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                    fill="#34A853" />
                                <path
                                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                                    fill="#FBBC05" />
                                <path
                                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                    fill="#EA4335" />
                            </svg>
                            Masuk dengan Google
                        </a>
                    </div>
                </form>

                <div class="mt-8 text-center bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <p class="text-sm text-slate-600">
                        Belum punya akun pasien?
                        <a href="/register"
                            class="font-bold text-primary hover:text-blue-700 transition-colors ml-1">Daftar
                            Sekarang</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Section: Branding/Illustration -->
        <div
            class="hidden lg:flex lg:w-1/2 relative bg-primary items-center justify-center overflow-hidden flex-col p-12">
            <!-- Decoration -->
            <div class="absolute top-[-10%] right-[-5%] w-96 h-96 rounded-full bg-white/10 blur-3xl"></div>
            <div class="absolute bottom-[-10%] left-[-5%] w-96 h-96 rounded-full bg-blue-800/30 blur-3xl"></div>

            <div class="relative z-10 w-full max-w-lg text-white">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-heading text-4xl font-bold mb-6 leading-snug">Pantau Estimasi Anda secara Real-Time.
                </h3>
                <p class="text-blue-100 text-lg leading-relaxed mb-10 font-light">
                    Kehadiran Anda sangat berarti, demikian pula waktu Anda. Melalui sistem kami, Anda bisa
                    mengetahui secara persis kapan akan dipanggil masuk ke ruangan dokter.
                </p>
            </div>
        </div>
    </div>

</body>

</html>