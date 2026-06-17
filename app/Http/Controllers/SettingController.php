<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Tampilkan halaman CMS Pengaturan Web Superadmin
     */
    public function index()
    {
        // Ambil data pengaturan pertama (karena hanya butuh 1 baris CMS)
        $setting = Setting::first() ?? new Setting();

        return view('superadmin.pengaturan-web', compact('setting'));
    }

    /**
     * Memperbarui data Pengaturan Web
     */
    public function update(Request $request)
    {
        $setting = Setting::first();
        if (!$setting) {
            $setting = new Setting();
        }

        // Tangani upload file Logo Navbar
        if ($request->hasFile('logo_navbar')) {
            // Hapus logo lama jika ada
            if ($setting->logo_navbar && Storage::disk('public')->exists($setting->logo_navbar)) {
                Storage::disk('public')->delete($setting->logo_navbar);
            }

            $file = $request->file('logo_navbar');
            $filename = time() . '_logo.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('settings', $filename, 'public');
            $setting->logo_navbar = 'settings/' . $filename;
        }

        // Teks & Kontak
        if ($request->has('hero_headline'))
            $setting->hero_headline = $request->hero_headline;
        if ($request->has('hero_badge'))
            $setting->hero_badge = $request->hero_badge;
        if ($request->has('hero_subheadline'))
            $setting->hero_subheadline = $request->hero_subheadline;

        if ($request->has('hero_button1_text'))
            $setting->hero_button1_text = $request->hero_button1_text;
        if ($request->has('hero_button2_text'))
            $setting->hero_button2_text = $request->hero_button2_text;

        if ($request->has('hero_checkmarks') && is_array($request->hero_checkmarks)) {
            $checks = [];
            foreach ($request->hero_checkmarks as $check) {
                if (!empty($check)) {
                    $checks[] = $check;
                }
            }
            $setting->hero_checkmarks = $checks;
        }

        if ($request->has('solusi_badge'))
            $setting->solusi_badge = $request->solusi_badge;
        if ($request->has('solusi_judul'))
            $setting->solusi_judul = $request->solusi_judul;
        if ($request->has('solusi_deskripsi'))
            $setting->solusi_deskripsi = $request->solusi_deskripsi;

        if ($request->has('estimasi_badge'))
            $setting->estimasi_badge = $request->estimasi_badge;
        if ($request->has('estimasi_judul'))
            $setting->estimasi_judul = $request->estimasi_judul;
        if ($request->has('estimasi_deskripsi'))
            $setting->estimasi_deskripsi = $request->estimasi_deskripsi;

        if ($request->has('alur_judul'))
            $setting->alur_judul = $request->alur_judul;
        if ($request->has('alur_deskripsi'))
            $setting->alur_deskripsi = $request->alur_deskripsi;

        if ($request->has('cabang_judul'))
            $setting->cabang_judul = $request->cabang_judul;
        if ($request->has('cabang_subjudul'))
            $setting->cabang_subjudul = $request->cabang_subjudul;

        if ($request->has('footer_deskripsi'))
            $setting->footer_deskripsi = $request->footer_deskripsi;
        if ($request->has('kontak_telepon'))
            $setting->kontak_telepon = $request->kontak_telepon;
        if ($request->has('kontak_email'))
            $setting->kontak_email = $request->kontak_email;
        if ($request->has('teks_copyright'))
            $setting->teks_copyright = $request->teks_copyright;

        // Bantuan WA Cabang
        if ($request->has('wa_tegal'))
            $setting->wa_tegal = $request->wa_tegal;
        if ($request->has('wa_slawi'))
            $setting->wa_slawi = $request->wa_slawi;
        if ($request->has('wa_brebes'))
            $setting->wa_brebes = $request->wa_brebes;
        if ($request->has('wa_template_tegal'))
            $setting->wa_template_tegal = $request->wa_template_tegal;
        if ($request->has('wa_template_slawi'))
            $setting->wa_template_slawi = $request->wa_template_slawi;
        if ($request->has('wa_template_brebes'))
            $setting->wa_template_brebes = $request->wa_template_brebes;

        // Data Multi-Dimensi Arrays (JSON) dapat ditangkap sebagai array manual dari Frontend, 
        // atau jika saat ini form-nya belum mendukung array input, kita biarkan form yg ada menyimpan sementara 
        // Array Solusi (Layanan)
        if ($request->has('layanan_titles') && is_array($request->layanan_titles)) {
            $layanans = [];
            foreach ($request->layanan_titles as $index => $title) {
                if (!empty($title)) {
                    $layanans[] = [
                        'title' => $title,
                        'desc' => $request->layanan_descs[$index] ?? ''
                    ];
                }
            }
            $setting->layanan_medis = $layanans;
        }

        // Array Estimasi Harga
        if ($request->has('estimasi_names') && is_array($request->estimasi_names)) {
            $estimasis = [];
            foreach ($request->estimasi_names as $index => $name) {
                if (!empty($name)) {
                    $estimasis[] = [
                        'name' => $name,
                        'price' => $request->estimasi_prices[$index] ?? ''
                    ];
                }
            }
            $setting->estimasi_harga = $estimasis;
        }

        // Array Waktu Tunggu / Estimasi Steps
        if ($request->has('estimasi_step_titles') && is_array($request->estimasi_step_titles)) {
            $est_steps = [];
            foreach ($request->estimasi_step_titles as $index => $title) {
                if (!empty($title)) {
                    $est_steps[] = [
                        'title' => $title,
                        'desc' => $request->estimasi_step_descs[$index] ?? ''
                    ];
                }
            }
            $setting->estimasi_steps = $est_steps;
        }

        // Array Alur Pasien
        if ($request->has('alur_titles') && is_array($request->alur_titles)) {
            $alurs = [];
            foreach ($request->alur_titles as $index => $title) {
                if (!empty($title)) {
                    $alurs[] = [
                        'title' => $title,
                        'desc' => $request->alur_descs[$index] ?? ''
                    ];
                }
            }
            $setting->alur_pasien = $alurs;
        }

        // Array Cabang
        if ($request->has('cabang_names') && is_array($request->cabang_names)) {
            $cabangs = [];
            foreach ($request->cabang_names as $index => $name) {
                if (!empty($name)) {
                    $cabangs[] = [
                        'name' => $name,
                        'address' => $request->cabang_addresses[$index] ?? '',
                        'lat' => $request->cabang_lats[$index] ?? '',
                        'lng' => $request->cabang_lngs[$index] ?? '',
                        'radius' => $request->cabang_radius[$index] ?? 0.1
                    ];
                }
            }
            $setting->cabang_list = $cabangs;
        }

        $setting->save();

        return redirect()->back()->with('success', 'Pengaturan Web berhasil diperbarui!');
    }
}
