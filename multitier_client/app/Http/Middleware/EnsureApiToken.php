<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/** Halaman hanya bisa dibuka jika user sudah login & token belum kedaluwarsa. */
class EnsureApiToken
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! session()->has('api_token')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $expiresAt = session('api_expires_at');

        if ($expiresAt && Carbon::parse($expiresAt)->isPast()) {
            session()->forget(['api_token', 'api_user', 'api_expires_at']);

            return redirect()->route('login')
                ->with('error', 'Access token sudah kedaluwarsa (berlaku 1 menit). Silakan login ulang.');
        }

        return $next($request);
    }
}
