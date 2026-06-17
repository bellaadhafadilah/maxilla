<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Cek jika user login adalah pasien dan datanya belum lengkap
        if ($user && $user->role === 'pasien') {
            if (empty($user->nik) || empty($user->no_wa)) {
                // Biarkan mereka mengakses halaman lengkapi profil tanpa redirect berulang
                if (!$request->is('pasien/profil/lengkapi') && !$request->is('logout')) {
                    return redirect('/pasien/profil/lengkapi')->with('warning', 'Silakan lengkapi profil Anda (NIK dan No. HP) sebelum melanjutkan.');
                }
            }
        }

        return $next($request);
    }
}
