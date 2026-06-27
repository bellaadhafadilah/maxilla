<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Status Verifikasi' }} | Maxilla Dental Care</title>
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

    <div class="min-h-screen flex items-center justify-center p-6 bg-slate-50">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 text-center border border-slate-100">
            <!-- Logo -->
            <div class="flex justify-center mb-8">
                <img src="{{ asset('image/logo-maxilla.png') }}" alt="Logo Maxilla Dental Care" class="h-12 w-auto">
            </div>

            @if($status === 'success')
                <!-- Success Icon -->
                <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="font-heading text-2xl font-bold text-secondary mb-3">{{ $heading_success ?? 'Verifikasi Berhasil!' }}</h2>
            @else
                <!-- Error Icon -->
                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <h2 class="font-heading text-2xl font-bold text-secondary mb-3">{{ $heading_error ?? 'Verifikasi Gagal' }}</h2>
            @endif

            <p class="text-slate-500 mb-8">{{ $message }}</p>

            <a href="{{ url($redirect_url) }}"
                class="inline-flex w-full justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white transition-all outline-none focus:ring-2 focus:ring-offset-2 {{ $status === 'success' ? 'bg-primary hover:bg-blue-600 shadow-primary/30 focus:ring-primary' : 'bg-red-500 hover:bg-red-600 shadow-red-500/30 focus:ring-red-500' }}">
                {{ $button_text }}
            </a>
        </div>
    </div>

</body>

</html>
