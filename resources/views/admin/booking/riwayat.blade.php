@extends('layouts.admin')

@section('title', 'Riwayat Reservasi')

@section('content')
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-5 relative z-10">
        <div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Riwayat Reservasi</h1>
            <p class="text-slate-500 text-sm mt-1">Data reservasi yang telah selesai, dibatalkan, atau kadaluarsa di Cabang {{ auth()->user()->cabang }}</p>
        </div>
        <div class="flex gap-3">
            <button onclick="window.location.reload()"
                class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-50 transition-all flex items-center gap-2 active:scale-95 shadow-sm">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                    </path>
                </svg>
                Refresh Data
            </button>
        </div>
    </div>

    {{-- FILTER FORM --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm mb-8">
        <form action="{{ route('admin.booking.riwayat') }}" method="GET"
            class="flex flex-col md:flex-row items-end gap-4">
            
            <div class="w-full md:w-1/4">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Cari Nama Pasien</label>
                <input type="text" name="nama" value="{{ request('nama') }}" placeholder="Ketik nama pasien..."
                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
            </div>
            
            <div class="w-full md:w-1/4">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Mulai</label>
                <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}"
                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
            </div>
            
            <div class="w-full md:w-1/4">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
            </div>
            
            <div class="w-full md:w-auto flex flex-1 gap-2">
                <button type="submit"
                    class="px-6 py-2.5 bg-blue-600 text-white font-bold text-sm rounded-xl hover:bg-blue-700 transition-colors shadow-sm w-full md:w-auto flex-1">
                    Terapkan Filter
                </button>
                <a href="{{ route('admin.booking.riwayat') }}"
                    class="px-6 py-2.5 bg-slate-100 text-slate-600 font-bold text-sm rounded-xl hover:bg-slate-200 transition-colors shadow-sm w-full md:w-auto text-center flex items-center justify-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <!-- Total -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-0.5">Total Data</p>
                <p class="text-2xl font-black text-slate-800">{{ $stats['total'] }}</p>
            </div>
        </div>

        <!-- Selesai -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-0.5">Selesai</p>
                <p class="text-2xl font-black text-slate-800">{{ $stats['selesai'] }}</p>
            </div>
        </div>

        <!-- Dibatalkan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-0.5">Dibatalkan</p>
                <p class="text-2xl font-black text-slate-800">{{ $stats['dibatalkan'] }}</p>
            </div>
        </div>

        <!-- Kadaluarsa -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-0.5">Kadaluarsa</p>
                <p class="text-2xl font-black text-slate-800">{{ $stats['kadaluarsa'] }}</p>
            </div>
        </div>
    </div>

    {{-- ANALISIS CHARTS --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Tren Kunjungan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                Tren Kunjungan Pasien
            </h3>
            <div id="chartTrenKunjungan" class="w-full h-64"></div>
        </div>

        <!-- Keluhan Tersering -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                Top 5 Keluhan Tersering
            </h3>
            <div id="chartKeluhanTersering" class="w-full h-64"></div>
        </div>

        <!-- Distribusi Status -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                Distribusi Status Reservasi
            </h3>
            <div id="chartDistribusiStatus" class="w-full h-64 flex justify-center items-center"></div>
        </div>
    </div>

    {{-- LIST --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="py-4 px-5 text-xs font-bold text-slate-500 uppercase tracking-wider">Pasien & ID</th>
                        <th class="py-4 px-5 text-xs font-bold text-slate-500 uppercase tracking-wider">Waktu Reservasi</th>
                        <th class="py-4 px-5 text-xs font-bold text-slate-500 uppercase tracking-wider">Dokter</th>
                        <th class="py-4 px-5 text-xs font-bold text-slate-500 uppercase tracking-wider">Keluhan</th>
                        <th class="py-4 px-5 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($reservasis as $res)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-5">
                                <p class="text-sm font-bold text-slate-800">{{ $res->nama_pasien ?? ($res->user->nama ?? 'Tidak Diketahui') }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-xs font-mono bg-slate-100 text-slate-500 px-2 py-0.5 rounded-md border border-slate-200">
                                        {{ $res->id_reservasi }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-4 px-5">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-700">
                                        {{ \Carbon\Carbon::parse($res->tanggal)->translatedFormat('d M Y') }}
                                    </span>
                                    <span class="text-xs text-slate-500 mt-0.5">{{ $res->jam }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-5">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold shrink-0">
                                        {{ substr($res->dokter_nama ?? 'D', 0, 1) }}
                                    </div>
                                    <span class="text-sm font-bold text-slate-700">{{ $res->dokter_nama ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-5">
                                <p class="text-xs text-slate-600 line-clamp-2 max-w-xs">{{ $res->keluhan ?? '-' }}</p>
                            </td>
                            <td class="py-4 px-5">
                                @if(strtolower($res->status) === 'selesai')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Selesai
                                    </span>
                                @elseif(strtolower($res->status) === 'dibatalkan')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-red-600 border border-red-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                        Dibatalkan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                                        {{ ucfirst($res->status) }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 mb-4">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-bold text-slate-700 mb-1">Belum ada riwayat</h3>
                                <p class="text-xs text-slate-500">Data riwayat reservasi kosong untuk filter ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // 1. Tren Kunjungan Pasien (Line/Area Chart)
    var chartDates = {!! json_encode($chartDates) !!};
    var chartCounts = {!! json_encode($chartCounts) !!};

    var optionsTren = {
        series: [{
            name: 'Jumlah Kunjungan',
            data: chartCounts
        }],
        chart: {
            type: 'area',
            height: 250,
            toolbar: { show: false },
            fontFamily: 'inherit'
        },
        colors: ['#3b82f6'], // blue-500
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                opacityTo: 0.05,
                stops: [0, 90, 100]
            }
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 3 },
        xaxis: {
            categories: chartDates,
            tooltip: { enabled: false },
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        yaxis: {
            labels: {
                formatter: function (val) { return Math.round(val); }
            }
        },
        grid: {
            borderColor: '#f1f5f9',
            strokeDashArray: 4,
            yaxis: { lines: { show: true } }
        }
    };
    var chartTren = new ApexCharts(document.querySelector("#chartTrenKunjungan"), optionsTren);
    chartTren.render();

    // 2. Distribusi Status (Doughnut Chart)
    var statsSelesai = {{ $stats['selesai'] }};
    var statsBatal = {{ $stats['dibatalkan'] }};
    var statsKadaluarsa = {{ $stats['kadaluarsa'] }};

    var optionsDistribusi = {
        series: [statsSelesai, statsBatal, statsKadaluarsa],
        chart: {
            type: 'donut',
            height: 250,
            fontFamily: 'inherit'
        },
        labels: ['Selesai', 'Dibatalkan', 'Kadaluarsa'],
        colors: ['#10b981', '#ef4444', '#f59e0b'], // emerald, red, amber
        plotOptions: {
            pie: {
                donut: {
                    size: '70%',
                    labels: {
                        show: true,
                        name: { show: true },
                        value: { show: true, fontWeight: 'bold' },
                        total: {
                            show: true,
                            showAlways: true,
                            label: 'Total',
                            fontWeight: 'bold',
                            color: '#64748b'
                        }
                    }
                }
            }
        },
        dataLabels: { enabled: false },
        legend: {
            position: 'bottom',
            markers: { radius: 12 }
        },
        stroke: { show: false }
    };

    var chartDistribusi = new ApexCharts(document.querySelector("#chartDistribusiStatus"), optionsDistribusi);
    chartDistribusi.render();
    // 3. Keluhan Tersering (Bar Chart)
    var keluhanLabels = {!! json_encode($chartKeluhanLabels) !!};
    var keluhanCounts = {!! json_encode($chartKeluhanCounts) !!};

    var optionsKeluhan = {
        series: [{
            name: 'Jumlah Pasien',
            data: keluhanCounts
        }],
        chart: {
            type: 'bar',
            height: 250,
            toolbar: { show: false },
            fontFamily: 'inherit'
        },
        colors: ['#6366f1'], // indigo-500
        plotOptions: {
            bar: {
                horizontal: true,
                borderRadius: 4,
                distributed: true, // Use multiple colors if desired
            }
        },
        dataLabels: {
            enabled: true,
            textAnchor: 'start',
            style: {
                colors: ['#fff']
            },
            formatter: function (val, opt) {
                return val
            },
            offsetX: 0
        },
        xaxis: {
            categories: keluhanLabels,
            labels: { show: false },
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        yaxis: {
            labels: {
                show: true,
                style: {
                    colors: '#64748b',
                    fontWeight: 600
                }
            }
        },
        grid: { show: false },
        legend: { show: false }
    };

    if(keluhanLabels.length > 0) {
        var chartKeluhan = new ApexCharts(document.querySelector("#chartKeluhanTersering"), optionsKeluhan);
        chartKeluhan.render();
    } else {
        document.querySelector("#chartKeluhanTersering").innerHTML = '<div class="h-full flex items-center justify-center text-xs text-slate-400">Data keluhan belum tersedia</div>';
    }

});
</script>
@endpush
