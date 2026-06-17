<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AkunDokterController extends Controller
{
    public function index()
    {
        $dokters = User::where('role', 'dokter')->orderBy('nama')->get();

        $stats = [
            'total_dokter' => User::where('role', 'dokter')->count(),
            'total_active' => User::where('role', 'dokter')->where('is_active', true)->count(),
            'online_now' => User::where('role', 'dokter')
                ->where('last_login_at', '>=', now()->subMinutes(15))
                ->count(),
        ];

        return view('superadmin.data_pengguna.akun_dokter.index', compact('dokters', 'stats'));
    }

    public function create()
    {
        // Ambil nama dokter yang sudah punya akun, buang gelarnya dan jadikan huruf kecil
        $existingDoctorNames = User::where('role', 'dokter')->pluck('nama')->map(function($name) {
            return strtolower(trim(preg_replace('/^(drg\.|dr\.|drg|dr)\s+/i', '', $name)));
        })->toArray();

        $scheduledDoctors = \App\Models\JadwalDokter::all()->pluck('dokter_nama')->unique();
        
        // Filter jadwal dokter: buang gelar dan jadikan huruf kecil untuk dicocokkan
        $availableDokters = $scheduledDoctors->reject(function($name) use ($existingDoctorNames) {
            $normalizedName = strtolower(trim(preg_replace('/^(drg\.|dr\.|drg|dr)\s+/i', '', $name)));
            return in_array($normalizedName, $existingDoctorNames);
        })->values();

        return view('superadmin.data_pengguna.akun_dokter.create', compact('availableDokters'));
    }

    public function store(Request $request)
    {
        if (!$request->has('no_wa') && $request->has('no_hp')) {
            $request->merge(['no_wa' => $request->no_hp]);
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_wa' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'nama' => $validated['nama'],
            'no_wa' => $validated['no_wa'],
            'cabang' => null,
            'email' => $validated['email'],
            'role' => 'dokter',
            'password' => Hash::make($validated['password']),
            'is_active' => true,
        ]);

        return redirect()->route('superadmin.dokter.index')->with('success', 'Akun dokter berhasil ditambahkan.');
    }

    public function show($id)
    {
        $dokter = User::where('role', 'dokter')->findOrFail($id);
        return view('superadmin.data_pengguna.akun_dokter.show', compact('dokter'));
    }

    public function edit($id)
    {
        $dokter = User::where('role', 'dokter')->findOrFail($id);
        return view('superadmin.data_pengguna.akun_dokter.edit', compact('dokter'));
    }

    public function update(Request $request, $id)
    {
        $dokter = User::where('role', 'dokter')->findOrFail($id);

        if (!$request->has('no_wa') && $request->has('no_hp')) {
            $request->merge(['no_wa' => $request->no_hp]);
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_wa' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id . ',id_user',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'nama' => $validated['nama'],
            'no_wa' => $validated['no_wa'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $dokter->update($data);

        return redirect()->route('superadmin.dokter.index')->with('success', 'Data dokter berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $dokter = User::where('role', 'dokter')->findOrFail($id);
        $dokter->delete();

        return redirect()->route('superadmin.dokter.index')
            ->with('success', 'Akun dokter berhasil dihapus');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        if ($user->role !== 'dokter') {
            abort(403);
        }
        $user->is_active = !$user->is_active;
        $user->save();

        $statusText = $user->is_active ? 'diaktifkan' : 'dinonaktifkan (diblokir)';
        return redirect()->back()->with('success', "Akun dokter berhasil {$statusText}.");
    }
}
