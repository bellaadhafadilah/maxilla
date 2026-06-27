<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request)
    {
        $loginInput = $request->input('email');
        
        // Tentukan apakah input adalah email atau nomor HP (no_wa)
        $loginField = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'no_wa';
        
        // Gabungkan field login yang sesuai ke dalam request untuk divalidasi
        $request->merge([$loginField => $loginInput]);

        $credentials = $request->validate([
            $loginField => ['required', 'string'],
            'password' => ['required'],
        ]);

        $authCredentials = [
            $loginField => $credentials[$loginField],
            'password' => $credentials['password'],
        ];

        if (Auth::attempt($authCredentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            if (!$user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors([
                    $loginField => 'Akun Anda telah dinonaktifkan. Silakan hubungi admin.',
                ])->onlyInput($loginField);
            }

            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
            ]);

            if ($user->role === 'superadmin') {
                return redirect()->intended('/superadmin/dashboard');
            } elseif ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->role === 'dokter') {
                return redirect()->intended('/dokter/dashboard');
            } elseif ($user->role === 'apoteker') {
                return redirect()->intended('/apoteker/dashboard');
            } elseif ($user->role === 'kasir') {
                return redirect()->intended('/kasir/dashboard');
            } elseif ($user->role === 'pasien') {
                if (empty($user->nik) || empty($user->no_wa)) {
                    return redirect()->intended('/pasien/profil/lengkapi')->with('warning', 'Silakan lengkapi profil Anda (NIK dan No. HP) sebelum melakukan reservasi.');
                }
                return redirect()->intended('/pasien/dashboard');
            }

            // Default redirect for normal patients
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email/Nomor HP atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Handle registration request for new patients.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.unique' => 'Alamat email ini sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal harus 8 karakter.',
        ]);

        $user = \App\Models\User::create([
            'nama' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'pasien',
            'is_active' => true,
        ]);

        event(new \Illuminate\Auth\Events\Registered($user));

        // Redirect back to register page with the user's email in session to show the verification notice
        return redirect()->route('register')->with('registered_email', $user->email);
    }

    /**
     * Verify email from the link without requiring login.
     */
    public function verifyEmail($id, $hash)
    {
        $user = \App\Models\User::find($id);

        if (!$user) {
            return view('auth.verify-status', [
                'status' => 'error',
                'message' => 'Pengguna tidak ditemukan atau akun sudah dihapus.',
                'redirect_url' => '/register',
                'button_text' => 'Kembali ke Pendaftaran'
            ]);
        }

        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return view('auth.verify-status', [
                'status' => 'error',
                'message' => 'Link verifikasi tidak valid atau sudah kadaluarsa.',
                'redirect_url' => '/register',
                'button_text' => 'Kembali ke Pendaftaran'
            ]);
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new \Illuminate\Auth\Events\Verified($user));
        }

        return view('auth.verify-status', [
            'status' => 'success',
            'message' => 'Email berhasil diverifikasi! Silakan login untuk melanjutkan.',
            'redirect_url' => '/login',
            'button_text' => 'Lanjutkan ke Login'
        ]);
    }

    /**
     * Resend verification email for unregistered/unverified users.
     */
    public function resendVerification(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user && !$user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }

        return redirect()->route('register')->with('registered_email', $request->email)->with('resent', true);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Redirect to Google OAuth.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth Callback.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')
                ->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))
                ->user();
            
            $user = \App\Models\User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Update google_id if empty
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->getId()]);
                }
                
                // Jika belum diverifikasi, arahkan ke halaman tunggu verifikasi
                if (!$user->hasVerifiedEmail()) {
                    return redirect()->route('register')->with('registered_email', $user->email);
                }
                
                if (!$user->is_active) {
                    return redirect('/login')->withErrors(['email' => 'Akun Anda telah dinonaktifkan. Silakan hubungi admin.']);
                }

                // Jika sudah verifikasi, login
                Auth::login($user);
                
                $user->update([
                    'last_login_at' => now(),
                    'last_login_ip' => request()->ip(),
                ]);
                
                if ($user->role === 'superadmin') return redirect()->intended('/superadmin/dashboard');
                elseif ($user->role === 'admin') return redirect()->intended('/admin/dashboard');
                elseif ($user->role === 'dokter') return redirect()->intended('/dokter/dashboard');
                elseif ($user->role === 'apoteker') return redirect()->intended('/apoteker/dashboard');
                elseif ($user->role === 'kasir') return redirect()->intended('/kasir/dashboard');
                elseif ($user->role === 'pasien') {
                    if (empty($user->nik) || empty($user->no_wa)) {
                        return redirect()->intended('/pasien/profil/lengkapi')->with('warning', 'Silakan lengkapi profil Anda (NIK dan No. HP) sebelum melakukan reservasi.');
                    }
                    return redirect()->intended('/pasien/dashboard');
                }
                
                return redirect()->intended('/');
                
            } else {
                // Create new user (Daftar via Google)
                $user = \App\Models\User::create([
                    'nama' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(\Illuminate\Support\Str::random(16)), // Random password
                    'role' => 'pasien',
                    'is_active' => true,
                    // email_verified_at tetap NULL agar harus diverifikasi
                ]);

                // Kirim email verifikasi
                event(new \Illuminate\Auth\Events\Registered($user));

                // Arahkan ke halaman tunggu verifikasi (tidak langsung login)
                return redirect()->route('register')->with('registered_email', $user->email);
            }

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Google OAuth Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            // If local environment, let's show the actual error to debug easily
            if (app()->environment('local')) {
                return redirect('/login')->withErrors(['email' => 'Gagal login dengan Google: ' . $e->getMessage()]);
            }
            return redirect('/login')->withErrors(['email' => 'Gagal login dengan Google. Silakan coba lagi.']);
        }
    }

    public function checkVerification(\Illuminate\Http\Request $request)
    {
        $email = $request->query('email');
        if (!$email) {
            return response()->json(['verified' => false]);
        }
        $user = \App\Models\User::where('email', $email)->first();
        if ($user && $user->hasVerifiedEmail()) {
            return response()->json(['verified' => true]);
        }
        return response()->json(['verified' => false]);
    }
}
