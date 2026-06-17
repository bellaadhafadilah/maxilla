<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasirDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $cabang = $user->cabang;

        // Antrian Pembayaran (Selalu tampilkan yang Menunggu Pembayaran, dan tampilkan yang Selesai HANYA hari ini)
        $antrianKasir = Reservasi::with(['user', 'rekamMedis.resepObats.obat', 'transaksi'])
            ->where('cabang', $cabang)
            ->where(function($query) {
                $query->where('status', 'Menunggu Pembayaran')
                      ->orWhere(function($q) {
                          $q->where('status', 'Selesai')
                            ->whereDate('updated_at', today());
                      });
            })
            ->orderByRaw("FIELD(status, 'Menunggu Pembayaran', 'Selesai') ASC")
            ->orderBy('id_reservasi', 'asc')
            ->get();

        return view('kasir.pos', compact('antrianKasir'));
    }

    public function processesBayar(Request $request, $id_reservasi)
    {
        return $this->prosesBayar($request, $id_reservasi);
    }

    public function prosesBayar(Request $request, $id_reservasi)
    {
        $reservasi = Reservasi::with(['rekamMedis.resepObats.obat'])->findOrFail($id_reservasi);
        
        // Hitung total obat
        $total_obat = 0;
        foreach ($reservasi->rekamMedis->resepObats as $resep) {
            if ($resep->obat) {
                $total_obat += ($resep->obat->harga * $resep->jumlah);
            }
        }

        $total_tindakan = $request->total_tindakan ?? 0;
        $grand_total = $total_obat + $total_tindakan;

        // Simpan Transaksi
        $transaksi = Transaksi::create([
            'id_reservasi' => $id_reservasi,
            'total_obat' => $total_obat,
            'total_tindakan' => $total_tindakan,
            'total_bayar' => $grand_total,
            'jumlah_bayar' => $request->jumlah_bayar ?? $grand_total,
            'kembalian' => $request->kembalian ?? 0,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_pembayaran' => 'Lunas',
            'kasir_id' => auth()->id(),
        ]);

        // Update Reservasi ke Selesai
        $reservasi->update(['status' => 'Selesai']);

        // Kirim Notifikasi ke Pasien terkait
        if ($reservasi->user) {
            $reservasi->user->notify(new \App\Notifications\SystemNotification(
                'Transaksi Selesai',
                'Pembayaran Anda telah diterima. Terima kasih telah melakukan perawatan gigi di Maxilla Dental Care.',
                url('/pasien/riwayat')
            ));
        }

        // Kirim Notifikasi ke semua staf terkait (Admin, Dokter, Apoteker, Kasir)
        $cabang = $reservasi->cabang;
        $staff = \App\Models\User::whereIn('role', ['admin', 'kasir'])
            ->where('cabang', $cabang)
            ->get();

        // if (!empty($reservasi->dokter_nama)) {
        //     $dokterClean = preg_replace('/^(drg\.|dr\.|drg|dr)\s+/i', '', $reservasi->dokter_nama);
        //     $dokterUser = \App\Models\User::where('role', 'dokter')
        //         ->where('nama', 'LIKE', '%' . $dokterClean . '%')
        //         ->first();
        //     if ($dokterUser) {
        //         $staff->push($dokterUser);
        //     }
        // }

        foreach ($staff as $userStaff) {
            $url = '#';
            if ($userStaff->role === 'admin') $url = '/admin/booking';
            elseif ($userStaff->role === 'dokter') $url = '/dokter/antrian';
            elseif ($userStaff->role === 'apoteker') $url = '/apoteker/dashboard';
            elseif ($userStaff->role === 'kasir') $url = '/kasir/dashboard';

            $userStaff->notify(new \App\Notifications\SystemNotification(
                'Transaksi Selesai',
                'Pembayaran untuk pasien ' . ($reservasi->nama_pasien ?? ($reservasi->user->nama ?? 'Pasien')) . ' sebesar Rp ' . number_format($grand_total, 0, ',', '.') . ' telah lunas.',
                $url
            ));
        }

        return redirect()->back()->with([
            'success' => 'Pembayaran berhasil diproses!',
            'cetak_struk_id' => $transaksi->id_transaksi
        ]);
    }

    public function serahkanObat($id_reservasi)
    {
        $reservasi = Reservasi::findOrFail($id_reservasi);
        $reservasi->update(['status' => 'Menunggu Pembayaran']);

        // Kirim Notifikasi ke Pasien terkait
        if ($reservasi->user) {
            $reservasi->user->notify(new \App\Notifications\SystemNotification(
                'Antrean Pembayaran',
                'Obat Anda telah siap diserahkan. Silakan menuju kasir untuk melakukan pembayaran.',
                url('/pasien/dashboard')
            ));
        }

        // Kirim Notifikasi ke semua staf terkait (Admin, Dokter, Kasir)
        $cabang = $reservasi->cabang;
        $staff = \App\Models\User::whereIn('role', ['admin', 'kasir'])
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
            elseif ($userStaff->role === 'kasir') $url = '/kasir/dashboard';

            $userStaff->notify(new \App\Notifications\SystemNotification(
                'Antrean Pembayaran',
                'Obat untuk pasien ' . ($reservasi->nama_pasien ?? ($reservasi->user->nama ?? 'Pasien')) . ' telah diserahkan. Pasien dialihkan ke Kasir untuk pembayaran.',
                $url
            ));
        }

        return redirect()->back()->with('success', 'Obat berhasil diserahkan.');
    }

    public function cetakStruk($id_transaksi)
    {
        $transaksi = Transaksi::with(['reservasi.user', 'reservasi.rekamMedis.resepObats.obat'])->findOrFail($id_transaksi);
        return view('kasir.struk', compact('transaksi'));
    }

    public function kirimStrukEmail($id_transaksi)
    {
        $transaksi = Transaksi::with(['reservasi.user', 'reservasi.rekamMedis.resepObats.obat'])->findOrFail($id_transaksi);
        
        $email = $transaksi->reservasi->user->email ?? null;

        if (!$email) {
            return response()->json(['success' => false, 'message' => 'Email pasien tidak ditemukan.']);
        }

        try {
            \Illuminate\Support\Facades\Mail::to($email)->send(new \App\Mail\StrukPembayaranMail($transaksi));
            return response()->json(['success' => true, 'message' => 'Struk berhasil dikirim ke ' . $email]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal mengirim email: ' . $e->getMessage()]);
        }
    }
}
