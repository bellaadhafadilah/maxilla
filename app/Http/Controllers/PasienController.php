<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PasienController extends Controller
{
    /**
     * Show the patient dashboard.
     */
    public function dashboard()
    {
        $reservasiAktif = \App\Models\Reservasi::where('id_user', Auth::id())
            ->where('tanggal', '>=', \Carbon\Carbon::today())
            ->whereIn('status', ['Menunggu', 'Dikonfirmasi'])
            ->orderBy('tanggal', 'asc')
            ->orderBy('id_reservasi', 'asc')
            ->get();

        foreach ($reservasiAktif as $reservasi) {
            $reservasi->antrian = \App\Models\Reservasi::where('tanggal', $reservasi->tanggal)
                ->where('jam', $reservasi->jam)
                ->where('cabang', $reservasi->cabang)
                ->where('dokter_nama', $reservasi->dokter_nama)
                ->whereIn('status', ['Menunggu', 'Dikonfirmasi', 'Hadir', 'Menunggu Antrian', 'Diperiksa', 'Menunggu Obat', 'Menunggu Pembayaran', 'Selesai']) // Include ALL statuses to keep queue number fixed
                ->where('id_reservasi', '<=', $reservasi->id_reservasi)
                ->count();

            // Calculate how many people have not been served yet before this patient
            $reservasi->menunggu = \App\Models\Reservasi::where('tanggal', $reservasi->tanggal)
                ->where('jam', $reservasi->jam)
                ->where('cabang', $reservasi->cabang)
                ->where('dokter_nama', $reservasi->dokter_nama)
                ->whereIn('status', ['Menunggu', 'Dikonfirmasi', 'Hadir']) // Not yet finished or cancelled
                ->where('id_reservasi', '<', $reservasi->id_reservasi)
                ->count();

            // 30 to 60 minutes per patient
            $reservasi->estimasiWaktuMin = $reservasi->menunggu * 30;
            $reservasi->estimasiWaktuMax = $reservasi->menunggu * 60;

            $now = \Carbon\Carbon::now();
            $reservasi->estimasiJamDiperiksaMin = $now->copy()->addMinutes($reservasi->estimasiWaktuMin)->format('H:i');
            $reservasi->estimasiJamDiperiksaMax = $now->copy()->addMinutes($reservasi->estimasiWaktuMax)->format('H:i');
        }

        // Ambil riwayat perawatan yang sudah selesai
        $riwayats = \App\Models\Reservasi::where('id_user', Auth::id())
            ->where('status', 'Selesai')
            ->orderBy('tanggal', 'desc')
            ->orderBy('id_reservasi', 'desc')
            ->take(2)
            ->get();

        // Hitung total kunjungan selesai
        $totalKunjungan = \App\Models\Reservasi::where('id_user', Auth::id())
            ->where('status', 'Selesai')
            ->count();

        return view('pasien.dashboard', compact('reservasiAktif', 'riwayats', 'totalKunjungan'));
    }

    /**
     * Show the patient treatment history.
     */
    public function riwayat()
    {
        $riwayats = \App\Models\Reservasi::where('id_user', Auth::id())
            ->orderBy('tanggal', 'desc')
            ->orderBy('id_reservasi', 'desc')
            ->get();

        $setting = \App\Models\Setting::first();

        return view('pasien.riwayat', compact('riwayats', 'setting'));
    }

    /**
     * Update the patient's profile information.
     */
    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'size:16'],
            'no_wa' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string', 'max:500'],
            'gender' => ['required', 'in:L,P'],
            'tanggal_lahir' => ['required', 'date', 'before_or_equal:' . now()->subYears(4)->format('Y-m-d')],
            'riwayat_penyakit' => ['nullable', 'string', 'max:1000'],
            'alergi_obat' => ['nullable', 'string', 'max:1000'],
            'file-upload' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        // Handle foto upload jika ada
        if ($request->hasFile('file-upload')) {
            // Hapus foto lama jika ada dan bukan null
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            // Simpan foto baru
            $fotoPath = $request->file('file-upload')->store('avatars', 'public');
            $user->foto = $fotoPath;
        }

        // Update data user dasar
        $user->nama = $validated['nama'];
        $user->nik = $validated['nik'];
        $user->no_wa = $validated['no_wa'];
        $user->save();

        // Menyimpan data medis/profil tambahan ke tabel pasiens
        \App\Models\Pasien::updateOrCreate(
            ['id_user' => $user->id_user],
            [
                'alamat' => $validated['alamat'],
                'jenis_kelamin' => $validated['gender'] === 'L' ? 'Laki-laki' : 'Perempuan',
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'riwayat_penyakit' => $validated['riwayat_penyakit'] ?? null,
                'alergi_obat' => $validated['alergi_obat'] ?? null,
            ]
        );

        return redirect('/pasien/dashboard')->with('success', 'Profil medis Anda berhasil diperbarui!');
    }

    /**
     * Show the booking form.
     */
    public function buatJanji(Request $request)
    {
        $oldReservasi = null;
        if ($request->has('reschedule')) {
            $oldReservasi = \App\Models\Reservasi::where('id_reservasi', $request->reschedule)
                ->where('id_user', Auth::id())
                ->first();
        } elseif ($request->has('copy_from')) {
            $oldReservasi = \App\Models\Reservasi::where('id_reservasi', $request->copy_from)
                ->where('id_user', Auth::id())
                ->first();
            // Clear ID so it creates a new one
            if ($oldReservasi) {
                $oldReservasi = clone $oldReservasi;
                $oldReservasi->id_reservasi = null;
            }
        }

        $riwayatPasienLain = \App\Models\Reservasi::where('id_user', Auth::id())
            ->where('hubungan', '!=', 'Diri Sendiri')
            ->whereNotNull('nama_pasien')
            ->select('nama_pasien', 'jenis_kelamin_pasien', 'tanggal_lahir_pasien', 'hubungan')
            ->groupBy('nama_pasien', 'jenis_kelamin_pasien', 'tanggal_lahir_pasien', 'hubungan')
            ->get();

        return view('pasien.buat-janji', compact('oldReservasi', 'riwayatPasienLain'));
    }

    /**
     * Get available doctors based on cabang, tanggal, and sesi.
     */
    public function getAvailableDoctors(Request $request)
    {
        $cabang = $request->query('cabang');
        $tanggal = $request->query('tanggal'); // YYYY-MM-DD
        $sesi = $request->query('jam'); // Pagi, Siang, Sore

        if (!$cabang || !$tanggal || !$sesi) {
            return response()->json([]);
        }

        // Cek jika reservasi hari ini, tolak jika sudah mendekati jam selesai sesi (batas 30 menit sebelum selesai)
        if (\Carbon\Carbon::parse($tanggal)->isToday()) {
            $now = \Carbon\Carbon::now();
            $batasWaktu = null;

            if ($sesi === 'Pagi') {
                $batasWaktu = \Carbon\Carbon::today()->setTime(12, 30); // Sesi berakhir 13:00
            } elseif ($sesi === 'Siang') {
                $batasWaktu = \Carbon\Carbon::today()->setTime(16, 30); // Sesi berakhir 17:00
            } elseif ($sesi === 'Sore') {
                $batasWaktu = \Carbon\Carbon::today()->setTime(20, 30); // Sesi berakhir 21:00
            }

            if ($batasWaktu && $now->greaterThan($batasWaktu)) {
                // Waktu sudah melewati batas untuk sesi ini pada hari ini
                return response()->json([]);
            }
        }

        // Parse tanggal to get day name in Indonesian
        $carbonDate = \Carbon\Carbon::parse($tanggal)->locale('id');
        $hari = $carbonDate->translatedFormat('l'); // 'Senin', 'Selasa', dll

        // Fetch from JadwalDokter
        $jadwal = \App\Models\JadwalDokter::where('cabang', $cabang)
            ->where('hari', $hari)
            ->where('sesi', $sesi)
            ->get();

        return response()->json($jadwal);
    }


    /**
     * Cancel a booking.
     */
    public function batalJanji($id)
    {
        $reservasi = \App\Models\Reservasi::where('id_reservasi', $id)
            ->where('id_user', Auth::id())
            ->firstOrFail();

        if (!in_array($reservasi->status, ['Menunggu', 'Dikonfirmasi'])) {
            return back()->with('error', 'Reservasi ini tidak dapat dibatalkan.');
        }

        $reservasi->update(['status' => 'Dibatalkan']);

        return back()->with('success', 'Reservasi Anda telah berhasil dibatalkan.');
    }

    /**
     * Check-in pasien berbasis lokasi
     */
    public function checkin(Request $request, $id)
    {
        $reservasi = \App\Models\Reservasi::where('id_reservasi', $id)
            ->where('id_user', Auth::id())
            ->firstOrFail();

        if ($reservasi->status !== 'Menunggu') {
            return response()->json(['success' => false, 'message' => 'Status antrean tidak valid untuk check-in.']);
        }

        // Pastikan hanya bisa check in di hari yang sama
        if (!\Carbon\Carbon::parse($reservasi->tanggal)->isToday()) {
            return response()->json(['success' => false, 'message' => 'Check-in hanya dapat dilakukan pada jadwal hari ini.']);
        }

        $reservasi->update(['status' => 'Hadir']);

        // Kirim Notifikasi ke staf terkait (Admin)
        $cabang = $reservasi->cabang;
        $staff = \App\Models\User::whereIn('role', ['admin'])
            ->where('cabang', $cabang)
            ->get();

        if (!empty($reservasi->dokter_nama)) {
            $dokterClean = preg_replace('/^(drg\.|dr\.|drg|dr)\s+/i', '', $reservasi->dokter_nama);
            $dokterUser = \App\Models\User::where('role', 'dokter')
                ->where('nama', 'LIKE', '%' . $dokterClean . '%')
                ->first();
            if ($dokterUser) {
                $staff->push($dokterUser);
            }
        }

        foreach ($staff as $userStaff) {
            $url = '#';
            if ($userStaff->role === 'admin') $url = '/admin/booking';
            elseif ($userStaff->role === 'dokter') $url = '/dokter/antrian';
            elseif ($userStaff->role === 'apoteker') $url = '/apoteker/antrian';
            elseif ($userStaff->role === 'kasir') $url = '/kasir/dashboard';

            $userStaff->notify(new \App\Notifications\SystemNotification(
                'Pasien Hadir (Check-In)',
                'Pasien ' . ($reservasi->nama_pasien ?? ($reservasi->user->nama ?? 'Pasien')) . ' telah check-in di cabang ' . $cabang . '.',
                $url
            ));
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Check-in berhasil! Anda telah dikonfirmasi hadir di klinik.']);
        }

        return back()->with('success', 'Check-in berhasil! Anda telah dikonfirmasi hadir di klinik.');
    }

    /**
     * Store or Update a booking (reservasi)
     */
    public function storeJanji(Request $request)
    {
        $validated = $request->validate([
            'id_reservasi' => 'nullable|exists:reservasis,id_reservasi',
            'untuk_siapa' => 'required|in:diri_sendiri,orang_lain',
            'nama_pasien' => 'required_if:untuk_siapa,orang_lain|nullable|string|max:255',
            'jenis_kelamin_pasien' => 'required_if:untuk_siapa,orang_lain|nullable|in:Laki-laki,Perempuan',
            'tanggal_lahir_pasien' => 'required_if:untuk_siapa,orang_lain|nullable|date',
            'hubungan' => 'required_if:untuk_siapa,orang_lain|nullable|string|max:100',
            'cabang' => 'required|string',
            'tanggal' => 'required|date',
            'jam' => 'required|string',
            'dokter' => 'required|string',
            'keluhan' => 'nullable|string|max:1000'
        ]);

        $user = Auth::user();

        // Validasi tambahan: tolak jika reservasi untuk hari ini dan waktu sudah mendekati akhir sesi (30 menit)
        if (\Carbon\Carbon::parse($validated['tanggal'])->isToday()) {
            $now = \Carbon\Carbon::now();
            $batasWaktu = null;

            if ($validated['jam'] === 'Pagi') {
                $batasWaktu = \Carbon\Carbon::today()->setTime(12, 30);
            } elseif ($validated['jam'] === 'Siang') {
                $batasWaktu = \Carbon\Carbon::today()->setTime(16, 30);
            } elseif ($validated['jam'] === 'Sore') {
                $batasWaktu = \Carbon\Carbon::today()->setTime(20, 30);
            }

            if ($batasWaktu && $now->greaterThan($batasWaktu)) {
                return back()->with('error', 'Mohon maaf, pemesanan gagal karena waktu sesi ' . $validated['jam'] . ' hari ini sudah akan berakhir atau ditutup.');
            }
        }

        $data = [
            'id_user' => $user->id_user,
            'nama_pasien' => $validated['untuk_siapa'] === 'diri_sendiri' ? $user->nama : $validated['nama_pasien'],
            'jenis_kelamin_pasien' => $validated['untuk_siapa'] === 'diri_sendiri' ? ($user->pasien->jenis_kelamin ?? null) : $validated['jenis_kelamin_pasien'],
            'tanggal_lahir_pasien' => $validated['untuk_siapa'] === 'diri_sendiri' ? ($user->pasien->tanggal_lahir ?? null) : $validated['tanggal_lahir_pasien'],
            'hubungan' => $validated['untuk_siapa'] === 'diri_sendiri' ? 'Diri Sendiri' : $validated['hubungan'],
            'cabang' => $validated['cabang'],
            'tanggal' => $validated['tanggal'],
            'jam' => $validated['jam'],
            'dokter_nama' => $validated['dokter'],
            'keluhan' => $validated['keluhan'] ?? '',
            'status' => 'Menunggu' // Reset status jika reschedule
        ];

        if (!empty($validated['id_reservasi'])) {
            \App\Models\Reservasi::where('id_reservasi', $validated['id_reservasi'])
                ->where('id_user', $user->id_user)
                ->update($data);
            $message = 'Reservasi berhasil dijadwalkan ulang!';
        } else {
            \App\Models\Reservasi::create($data);
            $message = 'Reservasi berhasil diajukan!';
            
            // Notify all relevant staff roles (Admin)
            $cabang = $validated['cabang'];
            $staff = \App\Models\User::whereIn('role', ['admin'])
                ->where('cabang', $cabang)
                ->get();

            // Find selected doctor
            if (!empty($validated['dokter'])) {
                $dokterClean = preg_replace('/^(drg\.|dr\.|drg|dr)\s+/i', '', $validated['dokter']);
                $dokterUser = \App\Models\User::where('role', 'dokter')
                    ->where('nama', 'LIKE', '%' . $dokterClean . '%')
                    ->first();
                if ($dokterUser) {
                    $staff->push($dokterUser);
                }
            }

            foreach ($staff as $userStaff) {
                $url = '#';
                if ($userStaff->role === 'admin') $url = '/admin/booking';
                elseif ($userStaff->role === 'dokter') $url = '/dokter/antrian';
                elseif ($userStaff->role === 'apoteker') $url = '/apoteker/antrian';
                elseif ($userStaff->role === 'kasir') $url = '/kasir/dashboard';

                $userStaff->notify(new \App\Notifications\SystemNotification(
                    'Reservasi Baru',
                    'Ada reservasi baru atas nama ' . $data['nama_pasien'] . ' untuk sesi ' . $data['jam'] . ' di cabang ' . $cabang . '.',
                    $url
                ));
            }
        }

        return redirect('/pasien/dashboard')->with('success', $message);
    }
}
