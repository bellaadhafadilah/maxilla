@extends('layouts.dashboard')

@section('title', 'Laporan Kunjungan Pasien')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-5 relative z-10">
    <div>
        <h1 class="font-heading text-3xl font-bold text-slate-800 tracking-tight">Laporan Kunjungan Pasien</h1>
        <p class="text-slate-500 mt-1 text-sm">Rekapitulasi total pasien per cabang dan layanan bedasarkan periode tanggal.</p>
    </div>
    <!-- <div class="flex gap-2 relative">
        <button class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-50 transition-all flex items-center gap-2 active:scale-95 shadow-sm group">
            <svg class="w-5 h-5 text-indigo-500 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
            Export PDF
        </button>
        <button class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition-all shadow-[0_4px_12px_rgba(79,70,229,0.25)] hover:shadow-[0_6px_16px_rgba(79,70,229,0.35)] flex items-center gap-2 active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            Buat Laporan Baru
        </button>
    </div> -->
</div>

<!-- ========================================== -->
<!-- FILTER BAR -->
<!-- ========================================== -->
<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mb-8 p-5">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1.5">Cabang Klinik</label>
            <select name="cabang" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 outline-none font-medium cursor-pointer">
                <option value="semua" {{ $cabang === 'semua' ? 'selected' : '' }}>Semua Cabang (Kumulatif)</option>
                @foreach ($cabangList as $cab)
                    <option value="{{ $cab }}" {{ $cabang === $cab ? 'selected' : '' }}>Cabang {{ $cab }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1.5">Mulai Tanggal</label>
            <input type="date" name="start_date" value="{{ $startDate }}" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl p-2.5 outline-none">
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1.5">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ $endDate }}" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl p-2.5 outline-none">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="flex-1 px-5 py-2.5 bg-slate-800 text-white rounded-xl text-sm font-bold hover:bg-slate-900 transition-colors shadow-sm focus:ring-2 focus:ring-slate-300 active:scale-95">Terapkan Filter</button>
            @if ($cabang !== 'semua' || $startDate || $endDate)
                <a href="/superadmin/laporan/pasien" class="flex-1 px-5 py-2.5 bg-slate-200 text-slate-700 rounded-xl text-sm font-bold hover:bg-slate-300 transition-colors shadow-sm active:scale-95 text-center">Reset</a>
            @endif
        </div>
    </form>
</div>

<!-- ========================================== -->
<!-- KPI STATS -->
<!-- ========================================== -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
    <div class="bg-indigo-600 rounded-xl p-5 shadow-lg text-white">
        <p class="text-xs font-bold text-indigo-200 uppercase tracking-widest mb-1">Total Kunjungan</p>
        <h3 class="text-4xl font-black">{{ $totalKunjungan }}</h3>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
        <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Tingkat Batal</p>
        <h3 class="text-3xl font-black text-slate-800 text-rose-500">{{ $cancelRate }}%</h3>
    </div>
</div>

<!-- ========================================== -->
<!-- CHARTS DASHBOARD -->
<!-- ========================================== -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-8">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <h3 class="text-sm font-bold text-slate-700 mb-4 uppercase tracking-wider">Status Reservasi</h3>
        <div class="h-64">
            <canvas id="statusChart"></canvas>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <h3 class="text-sm font-bold text-slate-700 mb-4 uppercase tracking-wider">Pasien Per Cabang</h3>
        <div class="h-64 flex justify-center">
            <canvas id="cabangPieChart"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 lg:col-span-2">
        <h3 class="text-sm font-bold text-slate-700 mb-4 uppercase tracking-wider">Tren Kunjungan Harian</h3>
        <div class="h-72">
            <canvas id="trenKunjunganChart"></canvas>
        </div>
    </div>
</div>



<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data dari Controller
        const dataStatus = @json($statusReservasi ?? []);
        const dataCabang = @json($pasienPerCabang ?? []);
        const dataTren = @json($trenKunjungan ?? []);

        // 1. Chart Status (Bar)
        const ctxStatus = document.getElementById('statusChart').getContext('2d');
        new Chart(ctxStatus, {
            type: 'bar',
            data: {
                labels: Object.keys(dataStatus),
                datasets: [{
                    label: 'Jumlah Pasien',
                    data: Object.values(dataStatus),
                    backgroundColor: ['#10b981', '#f43f5e', '#64748b', '#f59e0b', '#3b82f6'],
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });

        // 2. Chart Cabang (Doughnut)
        const ctxCabang = document.getElementById('cabangPieChart').getContext('2d');
        new Chart(ctxCabang, {
            type: 'doughnut',
            data: {
                labels: Object.keys(dataCabang),
                datasets: [{
                    data: Object.values(dataCabang),
                    backgroundColor: ['#4f46e5', '#06b6d4', '#10b981', '#f59e0b'],
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
        const ctxTren = document.getElementById('trenKunjunganChart').getContext('2d');
        new Chart(ctxTren, {
            type: 'line',
            data: {
                labels: Object.keys(dataTren),
                datasets: [{
                    label: 'Kunjungan Harian',
                    data: Object.values(dataTren),
                    borderColor: '#06b6d4',
                    backgroundColor: 'rgba(6, 182, 212, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: '#06b6d4'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    });
</script>

@endsection
