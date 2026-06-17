<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AkunKasirController extends Controller
{
    public function index()
    {
        $staffs = User::where('role', 'kasir')->get();
        $roleLabel = 'Kasir';
        $roleSlug = 'kasir';

        return view('superadmin.data_pengguna.akun_staff.index', compact('staffs', 'roleLabel', 'roleSlug'));
    }

    public function create()
    {
        $roleLabel = 'Kasir';
        $roleSlug = 'kasir';
        return view('superadmin.data_pengguna.akun_staff.create', compact('roleLabel', 'roleSlug'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_wa' => 'required|string|max:20',
            'cabang' => 'required|in:slawi,tegal,brebes',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'nama' => $validated['nama'],
            'no_wa' => $validated['no_wa'],
            'cabang' => $validated['cabang'],
            'email' => $validated['email'],
            'role' => 'kasir',
            'password' => Hash::make($validated['password']),
            'is_active' => true,
        ]);

        return redirect()->route('superadmin.kasir.index')->with('success', 'Akun kasir berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $staff = User::findOrFail($id);
        $roleLabel = 'Kasir';
        $roleSlug = 'kasir';
        return view('superadmin.data_pengguna.akun_staff.edit', compact('staff', 'roleLabel', 'roleSlug'));
    }

    public function update(Request $request, $id)
    {
        $staff = User::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'no_wa' => 'required|string|max:20',
            'cabang' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id . ',id_user',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'nama' => $request->nama,
            'no_wa' => $request->no_wa,
            'cabang' => $request->cabang,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $staff->update($data);

        return redirect()->route('superadmin.kasir.index')->with('success', 'Data kasir berhasil diperbarui.');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('superadmin.kasir.index')->with('success', 'Akun kasir berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        if ($user->role !== 'kasir') {
            abort(403);
        }
        $user->is_active = !$user->is_active;
        $user->save();

        $statusText = $user->is_active ? 'diaktifkan' : 'dinonaktifkan (diblokir)';
        return redirect()->back()->with('success', "Akun kasir berhasil {$statusText}.");
    }
}
