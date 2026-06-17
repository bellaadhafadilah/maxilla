<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminPasienController extends Controller
{
    /**
     * Display a listing of patients.
     */
    public function index()
    {
        $pasiens = User::where('role', 'pasien')
            ->where('email', 'not like', '%@maxilla.com')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Dynamic Stats
        $stats = [
            'total_pasien' => User::where('role', 'pasien')->where('email', 'not like', '%@maxilla.com')->count(),
            'akses_bpjs' => User::where('role', 'pasien')->where('email', 'not like', '%@maxilla.com')->where('tipe_pasien', 'bpjs')->count(),
            'new_this_month' => User::where('role', 'pasien')->where('email', 'not like', '%@maxilla.com')
                ->where('created_at', '>=', now()->startOfMonth())
                ->count(),
            'kunjungan_terakhir' => User::where('role', 'pasien')->where('email', 'not like', '%@maxilla.com')
                ->where('created_at', '>=', now()->subDays(30))
                ->count(),
            'daftar_hitam' => 0 // Placeholder
        ];

        return view('superadmin.data_pengguna.akun_pasien.index', compact('pasiens', 'stats'));
    }

    /**
     * Display the specified patient.
     */
    public function show($id)
    {
        $pasien = User::where('role', 'pasien')->findOrFail($id);
        $kunjungans = \App\Models\Reservasi::where('id_user', $id)
                        ->where('status', 'Selesai')
                        ->orderBy('tanggal', 'desc')
                        ->get();
        return view('superadmin.data_pengguna.akun_pasien.show', compact('pasien', 'kunjungans'));
    }

    /**
     * Remove the specified patient from storage.
     */
    public function destroy($id)
    {
        $pasien = User::where('role', 'pasien')->findOrFail($id);
        $nama = $pasien->nama;
        $pasien->delete();

        return redirect()->route('superadmin.pasien.index')->with('success', "Akun pasien $nama berhasil dihapus.");
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        if ($user->role !== 'pasien') {
            abort(403);
        }
        $user->is_active = !$user->is_active;
        $user->save();

        $statusText = $user->is_active ? 'diaktifkan' : 'dinonaktifkan (diblokir)';
        return redirect()->back()->with('success', "Akun pasien berhasil {$statusText}.");
    }
}
