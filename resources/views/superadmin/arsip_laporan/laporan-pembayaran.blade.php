@extends('layouts.dashboard')

@section('title', 'Laporan Pembayaran')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-5 relative z-10">
    <div>
        <h1 class="font-heading text-3xl font-bold text-slate-800 tracking-tight">Laporan Pembayaran</h1>
        <p class="text-slate-500 mt-1 text-sm">Rekapitulasi transaksi pembayaran pasien berdasarkan periode tanggal, cabang, dan nama pasien.</p>
    </div>
    <div class="flex gap-2 relative">
        <!-- <button class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-50 transition-all flex items-center gap-2 active:scale-95 shadow-sm group">
            <svg class="w-5 h-5 text-indigo-500 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
            Export PDF
        </button> -->
    </div>
</div>

<!-- ========================================== -->
<!-- FILTER BAR -->
<!-- ========================================== -->
<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mb-8 p-5">
    <form action="{{ route('superadmin.laporan-pembayaran') }}" method="GET" class="flex flex-col lg:flex-row lg:items-end w-full gap-4">
        <div class="w-full lg:w-1/3">
            <label class="block text-xs font-bold text-slate-500 mb-1.5">Cabang Klinik</label>
            <select name="cabang" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 outline-none font-medium cursor-pointer">
                <option value="semua" {{ $cabang === 'semua' || !$cabang ? 'selected' : '' }}>Semua Cabang</option>
                @foreach($cabangList as $cb)
                    <option value="{{ $cb }}" {{ $cabang === $cb ? 'selected' : '' }}>Cabang {{ $cb }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-full lg:w-1/3">
            <label class="block text-xs font-bold text-slate-500 mb-1.5">Dari Tanggal</label>
            <input type="date" name="start_date" value="{{ old('start_date', $startDate ?? '') }}" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 outline-none font-medium">
        </div>
        <div class="w-full lg:w-1/3">
            <label class="block text-xs font-bold text-slate-500 mb-1.5">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ old('end_date', $endDate ?? '') }}" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 outline-none font-medium">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition-all shadow-[0_4px_12px_rgba(79,70,229,0.25)] active:scale-95">
                Filter
            </button>
            @if(($cabang && $cabang !== 'semua') || $startDate || $endDate)
                <a href="{{ route('superadmin.laporan-pembayaran') }}" class="px-6 py-2.5 bg-slate-100 text-slate-700 rounded-xl text-sm font-bold hover:bg-slate-200 transition-all active:scale-95">
                    Reset
                </a>
            @endif
        </div>
    </form>
</div>

<!-- ========================================== -->
<!-- KPI STATS -->
<!-- ========================================== -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    <div class="bg-indigo-600 rounded-xl p-5 shadow-lg text-white relative overflow-hidden">
        <div class="absolute -right-4 -bottom-4 opacity-10"><svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg></div>
        <div class="relative z-10">
            <p class="text-xs font-bold text-indigo-200 uppercase tracking-widest mb-1">Total Transaksi</p>
            <h3 class="text-4xl font-black">{{ $totalTransaksi }}</h3>
            <p class="text-[12px] font-medium text-indigo-300 mt-2">{{ $cabang && $cabang !== 'semua' ? 'Cabang ' . $cabang : 'Semua Cabang' }}</p>
        </div>
    </div>
    
    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
        <div class="flex items-center gap-3 mb-2">
            <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Total Nominal</p>
        </div>
        <h3 class="text-3xl font-black text-slate-800">Rp {{ number_format($totalNominal, 0, ',', '.') }}</h3>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
        <div class="flex items-center gap-3 mb-2">
            <div class="p-2 bg-blue-50 text-blue-600 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg></div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Rata-rata Transaksi</p>
        </div>
        <h3 class="text-3xl font-black text-slate-800">Rp {{ number_format($rataRata, 0, ',', '.') }}</h3>
    </div>
</div>

<!-- ========================================== -->
<!-- CHARTS DASHBOARD -->
<!-- ========================================== -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-8">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <h3 class="text-sm font-bold text-slate-700 mb-4 uppercase tracking-wider">Pendapatan Per Cabang</h3>
        <div class="h-64">
            <canvas id="cabangChart"></canvas>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <h3 class="text-sm font-bold text-slate-700 mb-4 uppercase tracking-wider">Metode Pembayaran</h3>
        <div class="h-64 flex justify-center">
            <canvas id="metodeChart"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 lg:col-span-2">
        <h3 class="text-sm font-bold text-slate-700 mb-4 uppercase tracking-wider">Tren Pendapatan</h3>
        <div class="h-72">
            <canvas id="trenChart"></canvas>
        </div>
    </div>
</div>



<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data dari Controller
        const dataCabang = @json($pendapatanPerCabang ?? []);
        const dataTren = @json($trenPendapatan ?? []);
        const dataMetode = @json($metodePembayaran ?? []);

        const formatRupiah = (value) => {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(value);
        };

        // 1. Chart Cabang (Bar)
        const ctxCabang = document.getElementById('cabangChart').getContext('2d');
        new Chart(ctxCabang, {
            type: 'bar',
            data: {
                labels: Object.keys(dataCabang),
                datasets: [{
                    label: 'Total Pendapatan',
                    data: Object.values(dataCabang),
                    backgroundColor: ['#4f46e5', '#06b6d4', '#10b981', '#f59e0b', '#ef4444'],
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return formatRupiah(context.raw);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value / 1000) + 'k';
                            }
                        }
                    }
                }
            }
        });

        // 2. Chart Metode Pembayaran (Doughnut)
        const ctxMetode = document.getElementById('metodeChart').getContext('2d');
        new Chart(ctxMetode, {
            type: 'doughnut',
            data: {
                labels: Object.keys(dataMetode).map(k => k.charAt(0).toUpperCase() + k.slice(1)),
                datasets: [{
                    data: Object.values(dataMetode),
                    backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                },
                cutout: '70%'
            }
        });

        // 3. Chart Tren (Line)
        const ctxTren = document.getElementById('trenChart').getContext('2d');
        new Chart(ctxTren, {
            type: 'line',
            data: {
                labels: Object.keys(dataTren),
                datasets: [{
                    label: 'Pendapatan Harian',
                    data: Object.values(dataTren),
                    borderColor: '#4f46e5',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: '#4f46e5'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return formatRupiah(context.raw);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value / 1000) + 'k';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
