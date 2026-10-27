<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiUnauthorizedException;
use App\Services\ApiClient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct(private ApiClient $api) {}

    public function showLogin(): View|RedirectResponse
    {
        if (session()->has('api_token')) {
            return redirect()->route('barang.index');
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $res = $this->api->send('post', 'login', $data, authenticated: false);
        #dd("Response server nya ini lho : ", $res->body());
        if ($res->failed()) {
            return back()->withInput($request->only('email'))
                ->withErrors($res->json('errors') ?? [])
                ->with('error', $res->json('message') ?? 'Login gagal.');
        }

        $request->session()->regenerate();
        session([
            'api_token' => $res->json('data.access_token'),
            'api_user' => $res->json('data.user'),
            'api_expires_at' => $res->json('data.expires_at'),
        ]);

        return redirect()->route('barang.index')->with('success', $res->json('message'));
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6', 'confirmed'],
            'role' => ['required', 'in:admin,operator'],
        ]);
        $data['password_confirmation'] = $request->input('password_confirmation');

        $res = $this->api->post('register', $data);

        if ($res->failed()) {
            return back()->withInput($request->except('password', 'password_confirmation'))
                ->withErrors($res->json('errors') ?? [])
                ->with('error', $res->json('message') ?? 'Registrasi gagal.');
        }

        return redirect()->route('register')
            ->with('success', "User {$res->json('data.name')} ({$res->json('data.role')}) berhasil didaftarkan.");
    }

    public function logout(Request $request): RedirectResponse
    {
        try {
            $this->api->post('logout');
        } catch (ApiUnauthorizedException) {
            // token sudah kedaluwarsa, tidak masalah
        }

        session()->forget(['api_token', 'api_user', 'api_expires_at']);
        $request->session()->regenerate();

        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}
