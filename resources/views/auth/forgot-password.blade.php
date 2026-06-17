<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Sandi | Maxilla Dental Care</title>
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
            <a href="{{ route('login') }}"
                class="absolute top-8 left-8 flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-primary transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Login
            </a>

            <div class="w-full max-w-md mt-10 lg:mt-0">
                <!-- Logo -->
                <div class="flex items-center gap-2 mb-10">
                    <img src="{{ asset('image/logo-maxilla.png') }}" alt="Logo Maxilla Dental Care" class="h-10 w-auto">
                    <span class="font-heading font-bold text-xl tracking-tight text-secondary">Maxilla <span
                            class="text-primary">Dental Care</span></span>
                </div>

                <div>
                    <h2 class="font-heading text-3xl font-bold text-secondary mb-2">Lupa Sandi?</h2>
                    <p class="text-slate-500 mb-8">Masukkan alamat email Anda yang terdaftar, dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.</p>
                </div>

                <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
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

                    @if(session('status'))
                        <div
                            class="bg-emerald-50 text-emerald-600 p-4 rounded-xl text-sm border border-emerald-100 mb-4 flex items-start gap-2">
                            <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span>{{ session('status') }}</span>
                        </div>
                    @endif

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email Terdaftar</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                    </path>
                                </svg>
                            </div>
                            <input type="email" id="email" name="email"
                                class="block w-full pl-10 pr-3 py-3.5 border border-slate-200 rounded-xl focus:ring-primary focus:border-primary bg-slate-50 focus:bg-white transition-colors sm:text-sm"
                                placeholder="contoh@email.com" value="{{ old('email') }}" required autofocus>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="pt-4 space-y-3">
                        <button type="submit"
                            class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-primary/30 text-sm font-bold text-white bg-primary hover:bg-blue-600 transform hover:-translate-y-0.5 transition-all outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            Kirim Tautan Reset Sandi
                        </button>
                    </div>
                </form>

            </div>
        </div>

        <!-- Right Section: Banner -->
        <div class="hidden lg:flex w-1/2 bg-surface items-center justify-center relative overflow-hidden">
            <div class="absolute inset-0 bg-primary/5 mix-blend-multiply pointer-events-none"></div>
            
            <div class="z-10 relative text-center px-12">
                <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h4 class="font-heading font-bold text-2xl text-secondary mb-3">Akses Terjamin Aman</h4>
                <p class="text-slate-500 max-w-sm mx-auto leading-relaxed">Privasi dan data akun Anda dilindungi dengan standar keamanan.</p>
            </div>
        </div>
    </div>

</body>
</html>
