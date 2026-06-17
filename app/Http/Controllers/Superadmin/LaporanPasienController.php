<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class LaporanPasienController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $cabang = $request->get('cabang', 'semua');
        $search = $request->get('search', '');
        $startDate = $request->get('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->toDateString());

        // Base query
        $query = Reservasi::with([
            'user',
            'rekamMedis',
            'transaksi'
        ]);

        // Filter by cabang (case-insensitive in DB or handled by strtolower)
        if ($cabang !== 'semua') {
            $query->where('cabang', 'like', $cabang);
        }

        // Filter by date range
        $query->whereDate('tanggal', '>=', $startDate)
              ->whereDate('tanggal', '<=', $endDate);

        // Get the data
        $riwayatPasien = $query->orderBy('tanggal', 'desc')->get();

        // Get distinct cabang list
        $cabangList = Reservasi::pluck('cabang')->filter()->map(function($c) { 
            return ucfirst(strtolower($c)); 
        })->unique()->sort()->values();

        // Calculate statistics
        $totalKunjungan = $riwayatPasien->count();
        $pasienUmum = $riwayatPasien->filter(function ($r) {
            return $r->transaksi?->metode_pembayaran === 'Umum' || $r->transaksi?->metode_pembayaran === 'Mandiri';
        })->count();
        
        $pasienBPJS = $riwayatPasien->filter(function ($r) {
            return strpos($r->transaksi?->metode_pembayaran ?? '', 'BPJS') !== false || $r->transaksi?->metode_pembayaran === 'Peserta BPJS';
        })->count();

        // Calculate cancellation/no-show rate
        $totalBatal = Reservasi::whereDate('tanggal', '>=', $startDate)
                               ->whereDate('tanggal', '<=', $endDate)
                               ->when($cabang !== 'semua', function ($q) use ($cabang) {
                                   return $q->where('cabang', $cabang);
                               })
                               ->where('status', 'Batal')
                               ->count();
        
        $totalAllVisits = Reservasi::whereDate('tanggal', '>=', $startDate)
                                   ->whereDate('tanggal', '<=', $endDate)
                                   ->when($cabang !== 'semua', function ($q) use ($cabang) {
                                       return $q->where('cabang', $cabang);
                                   })
                                   ->count();
        
        $cancelRate = $totalAllVisits > 0 ? round(($totalBatal / $totalAllVisits) * 100, 1) : 0;

        // Data for charts
        $pasienPerCabang = [];
        $trenKunjungan = [];
        $statusReservasi = [];

        foreach ($riwayatPasien as $res) {
            $cbg = ucfirst(strtolower($res->cabang ?? 'Unknown'));
            $date = \Carbon\Carbon::parse($res->tanggal)->format('Y-m-d');
            $status = $res->status ?? 'Unknown';

            // Pasien per cabang
            if (!isset($pasienPerCabang[$cbg])) {
                $pasienPerCabang[$cbg] = 0;
            }
            $pasienPerCabang[$cbg]++;

            // Tren Kunjungan
            if (!isset($trenKunjungan[$date])) {
                $trenKunjungan[$date] = 0;
            }
            $trenKunjungan[$date]++;

            // Status Reservasi
            if (!isset($statusReservasi[$status])) {
                $statusReservasi[$status] = 0;
            }
            $statusReservasi[$status]++;
        }

        // Sort tren by date
        ksort($trenKunjungan);

        return view('superadmin.arsip_laporan.laporan-pasien', [
            'riwayatPasien' => $riwayatPasien,
            'cabangList' => $cabangList,
            'totalKunjungan' => $totalKunjungan,
            'pasienUmum' => $pasienUmum,
            'pasienBPJS' => $pasienBPJS,
            'cancelRate' => $cancelRate,
            'cabang' => $cabang,
            'search' => $search,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'pasienPerCabang' => $pasienPerCabang,
            'trenKunjungan' => $trenKunjungan,
            'statusReservasi' => $statusReservasi
        ]);
    }
}
