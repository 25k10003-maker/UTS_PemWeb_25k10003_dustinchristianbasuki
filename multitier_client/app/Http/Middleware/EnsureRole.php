<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/** Menyembunyikan halaman sesuai role (server tetap melakukan validasi role). */
class EnsureRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $role = session('api_user.role');

        if (! in_array($role, $roles, true)) {
            return redirect()->route('barang.index')
                ->with('error', 'Akses ditolak. Halaman ini hanya untuk role: '.implode(', ', $roles).'.');
        }

        return $next($request);
    }
}
