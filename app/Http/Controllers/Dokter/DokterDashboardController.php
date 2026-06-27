<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DokterDashboardController extends Controller
{
    /**
     * Display the doctor's dashboard.
     */
    public function index()
    {
        $stats = $this->getStats();
        return view('dokter.dashboard', compact('stats'));
    }

    /**
     * Get real-time stats for API.
     */
    public function getRealtimeStats()
    {
        return response()->json([
            'stats' => $this->getStats(),
            'timestamp' => now()->translatedFormat('H:i:s')
        ]);
    }

    /**
     * Internal helper to calculate stats.
     */
    private function getStats()
    {
        $namaDokter = \Illuminate\Support\Facades\Auth::user()->nama;
        $namaTanpaGelar = trim(preg_replace('/^(drg\.|dr\.)\s*/i', '', $namaDokter));

        $total = \App\Models\Reservasi::where('dokter_nama', 'like', "%{$namaTanpaGelar}%")
            ->whereDate('tanggal', today())
            ->count();

        $selesai = \App\Models\Reservasi::where('dokter_nama', 'like', "%{$namaTanpaGelar}%")
            ->whereDate('tanggal', today())
            ->whereIn('status', ['Selesai', 'Menunggu Pembayaran', 'Menunggu Obat'])
            ->count();

        $menunggu = \App\Models\Reservasi::where('dokter_nama', 'like', "%{$namaTanpaGelar}%")
            ->whereDate('tanggal', today())
            ->where('status', 'Menunggu Antrian')
            ->count();

        return [
            'total' => $total,
            'selesai' => $selesai,
            'menunggu' => $menunggu
        ];
    }
    public function jadwal()
    {
        $namaDokter = \Illuminate\Support\Facades\Auth::user()->nama;
        $namaTanpaGelar = trim(preg_replace('/^(drg\.|dr\.)\s*/i', '', $namaDokter));

        $jadwals = \App\Models\JadwalDokter::where('dokter_nama', 'like', "%{$namaTanpaGelar}%")->get();
        return view('dokter.jadwal.index', compact('jadwals'));
    }

    public function antrian()
    {
        $namaDokter = \Illuminate\Support\Facades\Auth::user()->nama;
        $namaTanpaGelar = trim(preg_replace('/^(drg\.|dr\.)\s*/i', '', $namaDokter));

        $antrians = \App\Models\Reservasi::with('user.pasien')
            ->where('dokter_nama', 'like', "%{$namaTanpaGelar}%")
            ->whereDate('tanggal', today())
            ->whereIn('status', ['Menunggu Antrian', 'Diperiksa', 'Menunggu Obat'])
            ->orderBy('jam', 'asc')
            ->get();
            
        return view('dokter.antrian.index', compact('antrians'));
    }

    public function riwayat(Request $request)
    {
        $namaDokter = \Illuminate\Support\Facades\Auth::user()->nama;
        $namaTanpaGelar = trim(preg_replace('/^(drg\.|dr\.)\s*/i', '', $namaDokter));

        $tanggal_awal = $request->query('tanggal_awal');
        $tanggal_akhir = $request->query('tanggal_akhir');
        $nama = $request->query('nama');

        $query = \App\Models\Reservasi::with('rekamMedis', 'user.pasien')
            ->where('dokter_nama', 'like', "%{$namaTanpaGelar}%")
            ->whereIn('status', ['Selesai', 'Menunggu Pembayaran', 'Menunggu Obat']);

        if ($tanggal_awal && $tanggal_akhir) {
            $query->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir]);
        }

        if ($nama) {
            $query->where('nama_pasien', 'like', '%' . $nama . '%');
        }

        $riwayats = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->get();

        return view('dokter.riwayat.index', compact('riwayats', 'tanggal_awal', 'tanggal_akhir', 'nama'));
    }

    public function profil()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        return view('dokter.profil.index', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id_user . ',id_user',
            'no_wa' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->no_wa = $request->no_wa;

        if ($request->hasFile('foto')) {
            // Delete old photo if it exists
            if ($user->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->foto)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->foto);
            }

            // Store new photo
            $path = $request->file('foto')->store('foto_profil', 'public');
            $user->foto = $path;
        }

        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('dokter.profil')->with('success', 'Profil berhasil diperbarui!');
    }
}
