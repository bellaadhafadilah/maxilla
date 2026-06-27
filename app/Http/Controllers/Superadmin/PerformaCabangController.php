<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\JadwalDokter;
use App\Models\User;
use Carbon\Carbon;

class PerformaCabangController extends Controller
{
    public function show($slug)
    {
        $allowedCabang = ['slawi', 'tegal', 'brebes'];
        
        if (!in_array(strtolower($slug), $allowedCabang)) {
            abort(404);
        }

        $cabang = strtolower($slug);
        $today = Carbon::today();
        $hariIni = Carbon::now()->locale('id')->translatedFormat('l');

        // Full Metadata Cabang (Simulation for physical variables)
        $meta = [
            'slawi' => [
                'nama' => 'Maxilla Slawi',
                'alamat' => 'Jl. Jend. Sudirman No. 45, Komplek Ruko A, Kec. Slawi, Kab. Tegal.',
                'telp' => '(0283) 456-7890',
                'kapasitas' => 45,
                'rating' => 4.8,
                'reviews' => 210,
                'warna' => 'indigo' // For UI decor
            ],
            'tegal' => [
                'nama' => 'Maxilla Tegal',
                'alamat' => 'Jl. AR. Hakim No. 12, Panggung, Kec. Tegal Timur, Kota Tegal.',
                'telp' => '(0283) 321-6543',
                'kapasitas' => 50,
                'rating' => 4.9,
                'reviews' => 315,
                'warna' => 'sky'
            ],
            'brebes' => [
                'nama' => 'Maxilla Brebes',
                'alamat' => 'Jl. Veteran No. 89, Brebes Wetan, Kec. Brebes, Kab. Brebes.',
                'telp' => '(0283) 678-1234',
                'kapasitas' => 40,
                'rating' => 4.7,
                'reviews' => 180,
                'warna' => 'emerald'
            ]
        ];

        $cabangMeta = $meta[$cabang];

        // Fetch admin email
        $admin = User::where('role', 'admin')
                     ->where('cabang', $cabang)
                     ->where('is_active', true)
                     ->orderBy('id_user')
                     ->first();
        $adminEmail = $admin ? $admin->email : 'Belum ada admin';

        // 1. Fetch Today Stats
        $reservationsToday = Reservasi::where('cabang', $cabang)
                                      ->whereDate('tanggal', $today)
                                      ->get();
                                      
        $totalBooking = $reservationsToday->count();
        $selesai = $reservationsToday->where('status', 'Selesai')->count();
        $menunggu = $reservationsToday->whereIn('status', ['Menunggu', 'Diproses'])->count();
        $batal = $reservationsToday->filter(function($r) { return strtolower($r->status) == 'dibatalkan'; })->count();
        
        $hadir = $selesai + $menunggu; // roughly
        $hadirRate = $totalBooking > 0 ? round(($hadir / $totalBooking) * 100) : 0;

        $statsToday = [
            'booking' => $totalBooking,
            'hadir' => $hadir,
            'hadir_rate' => $hadirRate,
            'menunggu' => $menunggu,
            'batal' => $batal
        ];

        // 2. Scheduled Doctors Today + Queue Breakdown
        $schedulesToday = JadwalDokter::where('cabang', $cabang)
                                      ->where('hari', $hariIni)
                                      ->orderBy('jam_mulai')
                                      ->get();

        foreach ($schedulesToday as $jadwal) {
            $dokRes = $reservationsToday->where('dokter_nama', $jadwal->dokter_nama);
            
            $jadwal->terlayani = $dokRes->where('status', 'Selesai')->count();
            $jadwal->menunggu = $dokRes->whereIn('status', ['Menunggu', 'Diproses'])->count();
            $jadwal->antrian = $dokRes->count();
            
            // simple progress percentages
            $p_terlayani = $jadwal->antrian > 0 ? ($jadwal->terlayani / $jadwal->antrian) * 100 : 0;
            $p_menunggu = $jadwal->antrian > 0 ? ($jadwal->menunggu / $jadwal->antrian) * 100 : 0;

            $jadwal->p_terlayani = min(100, $p_terlayani);
            $jadwal->p_menunggu = min(100 - $jadwal->p_terlayani, $p_menunggu);
            
            // Check status (belum mulai, berjalan, selesai)
            $now = Carbon::now();
            $start = Carbon::parse($jadwal->jam_mulai);
            $end = Carbon::parse($jadwal->jam_selesai);
            
            if ($now->lt($start)) {
                $jadwal->shift_status = 'belum_mulai';
            } elseif ($now->gt($end)) {
                $jadwal->shift_status = 'selesai';
            } else {
                $jadwal->shift_status = 'berjalan';
            }
        }

        // 3. Monthly Stats
        $monthlyReservations = Reservasi::where('cabang', $cabang)
                                        ->whereMonth('tanggal', Carbon::now()->month)
                                        ->whereYear('tanggal', Carbon::now()->year)
                                        ->get();

        $totalKunjunganBln = $monthlyReservations->count();
        $totalBatalBln = $monthlyReservations->filter(function($r) { return strtolower($r->status) == 'batal'; })->count();
        $dokterTersibukBln = $monthlyReservations->groupBy('dokter_nama')->map->count()->sortDesc()->keys()->first() ?? '-';
        $dokterTersibukCount = $monthlyReservations->groupBy('dokter_nama')->map->count()->sortDesc()->first() ?? 0;

        $monthStats = [
            'total_kunjungan' => $totalKunjunganBln,
            'umum' => (int)($totalKunjunganBln * 0.65), // Approx
            'bpjs' => (int)($totalKunjunganBln * 0.35),
            'batal' => $totalBatalBln,
            'no_show_rate' => $totalKunjunganBln > 0 ? round(($totalBatalBln / $totalKunjunganBln) * 100, 1) : 0,
            'dokter_tersibuk' => $dokterTersibukBln,
            'dokter_tersibuk_qty' => $dokterTersibukCount
        ];

        // 4. All doctors assigned to this branch
        $allDoctors = JadwalDokter::where('cabang', $cabang)
                                  ->get()
                                  ->groupBy('dokter_nama');
        
        $doctorList = [];
        foreach ($allDoctors as $nama => $schedules) {
            $shiftLabel = $schedules->first()->hari . ' (' . substr($schedules->first()->jam_mulai, 0, 5) . ' - ' . substr($schedules->first()->jam_selesai, 0, 5) . ')';
            
            // Count total patients for this doctor this month in this branch
            $pasienCount = $monthlyReservations->where('dokter_nama', $nama)->count();
            
            $doctorList[] = [
                'nama' => $nama,
                'shift_label' => $shiftLabel,
                'total_pasien_bln' => $pasienCount,
                'is_tersibuk' => ($nama === $dokterTersibukBln)
            ];
        }

        return view('superadmin.performa_cabang.show', compact('cabang', 'cabangMeta', 'statsToday', 'schedulesToday', 'monthStats', 'doctorList', 'adminEmail'));
    }
}
