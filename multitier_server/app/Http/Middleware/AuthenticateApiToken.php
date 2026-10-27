<?php

namespace App\Http\Middleware;

use App\Models\ApiToken;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Validasi header "Authorization: Bearer <token>".
 * Token hanya berlaku 1 menit (config/api.php -> token_ttl).
 */
class AuthenticateApiToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $plain = $request->bearerToken();

        if (! $plain) {
            return response()->json([
                'success' => false,
                'error' => 'token_missing',
                'message' => 'Access token tidak ditemukan. Silakan login.',
            ], 401);
        }

        $token = ApiToken::findByPlain($plain);

        if (! $token || ! $token->user) {
            return response()->json([
                'success' => false,
                'error' => 'token_invalid',
                'message' => 'Access token tidak valid. Silakan login.',
            ], 401);
        }

        if ($token->isExpired()) {
            $token->delete();

            return response()->json([
                'success' => false,
                'error' => 'token_expired',
                'message' => 'Access token sudah kedaluwarsa (berlaku 1 menit). Silakan login ulang.',
            ], 401);
        }

        Auth::setUser($token->user);
        $request->setUserResolver(fn () => $token->user);
        $request->attributes->set('api_token', $token);

        return $next($request);
    }
}
