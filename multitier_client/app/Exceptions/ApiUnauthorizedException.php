<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\RedirectResponse;

/**
 * Dilempar ketika API menjawab 401 (token hilang / tidak valid / kedaluwarsa).
 * Laravel otomatis memanggil render() -> sesi dibersihkan, user diarahkan ke login.
 */
class ApiUnauthorizedException extends Exception
{
    public function render(): RedirectResponse
    {
        session()->forget(['api_token', 'api_user', 'api_expires_at']);

        return redirect()->route('login')->with('error', $this->getMessage());
    }
}
