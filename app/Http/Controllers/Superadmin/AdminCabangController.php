<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminCabangController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'admin');

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('cabang') && $request->cabang !== 'Semua Cabang') {
            $query->where('cabang', $request->cabang);
        }

        $admins = $query->get();
        
        $stats = [
            'total_active' => User::where('role', 'admin')->where('is_active', true)->count(),
            'online_now' => User::where('role', 'admin')
                ->where('last_login_at', '>=', now()->subMinutes(15))
                ->count(),
            'needs_rotation' => 0 // Placeholder
        ];

        return view('superadmin.data_pengguna.akun_admin.index', compact('admins', 'stats'));
    }

    public function create()
    {
        return view('superadmin.data_pengguna.akun_admin.create');
    }

    public function store(Request $request)
    {
        if (!$request->has('no_wa') && $request->has('no_hp')) {
            $request->merge(['no_wa' => $request->no_hp]);
        }

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
            'role' => 'admin',
            'password' => Hash::make($validated['password']),
            'is_active' => true,
        ]);

        return redirect('/superadmin/pengguna/admin')->with('success', 'Akun admin cabang berhasil ditambahkan.');
    }

    public function show($id)
    {
        $admin = User::findOrFail($id);
        return view('superadmin.data_pengguna.akun_admin.show', compact('admin'));
    }

    public function edit($id)
    {
        $admin = User::findOrFail($id);
        return view('superadmin.data_pengguna.akun_admin.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        if (!$request->has('no_wa') && $request->has('no_hp')) {
            $request->merge(['no_wa' => $request->no_hp]);
        }

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

        $admin->update($data);

        return redirect('/superadmin/pengguna/admin')->with('success', 'Data admin berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();

        return redirect('/superadmin/pengguna/admin')->with('success', 'Akun admin berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        if ($user->role !== 'admin') {
            abort(403);
        }
        $user->is_active = !$user->is_active;
        $user->save();

        $statusText = $user->is_active ? 'diaktifkan' : 'dinonaktifkan (diblokir)';
        return redirect()->back()->with('success', "Akun admin cabang berhasil {$statusText}.");
    }
}
