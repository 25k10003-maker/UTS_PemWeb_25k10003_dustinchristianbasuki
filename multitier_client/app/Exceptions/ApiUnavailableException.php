<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\RedirectResponse;

/** Dilempar ketika multitier_server tidak bisa dihubungi. */
class ApiUnavailableException extends Exception
{
    public function render(): RedirectResponse
    {
        return back()->withInput()->with(
            'error',
            'Tidak dapat terhubung ke API server ('.config('pos_api.base_url').'). Pastikan multitier_server sedang berjalan.'
        );
    }
}
