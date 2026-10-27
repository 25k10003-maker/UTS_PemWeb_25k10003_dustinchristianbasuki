<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Pemakaian di route: ->middleware('role:admin') atau 'role:operator'
 */
class EnsureRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user || ! in_array($user->role, $roles, true)) {
            return response()->json([
                'success' => false,
                'error' => 'forbidden',
                'message' => 'Akses ditolak. Fitur ini hanya untuk role: '.implode(', ', $roles).'.',
            ], 403);
        }

        return $next($request);
    }
}
