<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class LaporanPembayaranController extends Controller
{
    public function index(Request $request)
    {
        $cabang = $request->input('cabang');
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Transaksi::with(['reservasi.user', 'reservasi']);

        // Filter cabang
        if ($cabang && $cabang !== 'semua') {
            $query->whereHas('reservasi', function ($q) use ($cabang) {
                $q->where('cabang', 'like', $cabang);
            });
        }

        // Filter tanggal
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $pembayaran = $query->orderByDesc('created_at')->get();

        // Hitung statistik
        $totalTransaksi = $pembayaran->count();
        $totalNominal = $pembayaran->sum('total_bayar');
        $rataRata = $totalTransaksi > 0 ? $totalNominal / $totalTransaksi : 0;

        // Get list cabang
        $cabangList = Reservasi::pluck('cabang')->filter()->map(function($c) { 
            return ucfirst(strtolower($c)); 
        })->unique()->sort()->values();

        // Data for charts
        $pendapatanPerCabang = [];
        $trenPendapatan = [];
        $metodePembayaran = [];

        foreach ($pembayaran as $trx) {
            $cbg = ucfirst(strtolower($trx->reservasi->cabang ?? 'Unknown'));
            $date = \Carbon\Carbon::parse($trx->created_at)->format('Y-m-d');
            $metode = $trx->metode_pembayaran ?? 'Unknown';

            // Pendapatan per cabang
            if (!isset($pendapatanPerCabang[$cbg])) {
                $pendapatanPerCabang[$cbg] = 0;
            }
            $pendapatanPerCabang[$cbg] += $trx->total_bayar;

            // Tren Pendapatan
            if (!isset($trenPendapatan[$date])) {
                $trenPendapatan[$date] = 0;
            }
            $trenPendapatan[$date] += $trx->total_bayar;

            // Metode Pembayaran
            if (!isset($metodePembayaran[$metode])) {
                $metodePembayaran[$metode] = 0;
            }
            $metodePembayaran[$metode]++;
        }

        // Sort tren by date
        ksort($trenPendapatan);

        return view('superadmin.arsip_laporan.laporan-pembayaran', compact(
            'pembayaran',
            'cabangList',
            'totalTransaksi',
            'totalNominal',
            'rataRata',
            'cabang',
            'search',
            'startDate',
            'endDate',
            'pendapatanPerCabang',
            'trenPendapatan',
            'metodePembayaran'
        ));
    }
}
