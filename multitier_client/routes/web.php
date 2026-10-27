<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - SiAkad-003 (multitier_client)
|--------------------------------------------------------------------------
*/

// Redirect Halaman Utama
Route::get('/', function () {
    if (session()->has('token')) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Halaman Form Login
Route::get('/login', function () {
    if (session()->has('token')) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
})->name('login');

// Proses Submit Login
Route::post('/login', function (Request $request) {
    $email = $request->input('email') ?? $request->input('username') ?? $request->input('nim');

    if (!$email) {
        return back()->with('error', 'Silakan masukkan Email / NIM / Username Anda.');
    }

    $apiUrl = config('services.api.base_url', env('API_BASE_URL', 'http://127.0.0.1:8000/api')) . '/login';

    try {
        $response = Http::acceptJson()->timeout(5)->post($apiUrl, [
            'email'    => trim($email),
            'password' => $request->input('password'),
        ]);

        if ($response->successful()) {
            $token = $response->json('data.access_token') ?? $response->json('token');
            $user  = $response->json('data.user') ?? $response->json('user');

            session([
                'token'     => $token,
                'api_token' => $token,
                'user'      => $user,
            ]);

            return redirect()->route('dashboard')->with('success', 'Berhasil login ke SiAkad-003!');
        }

        return back()->withInput($request->only('email'))
            ->with('error', $response->json('message') ?? 'Login gagal! Periksa email dan password.');

    } catch (\Throwable $e) {
        return back()->withInput($request->only('email'))
            ->with('error', 'Gagal terhubung ke API Server. Pastikan backend berjalan di 127.0.0.1:8000.');
    }
});

// Halaman Dashboard
Route::get('/dashboard', function () {
    if (!session()->has('token')) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    $token   = session('token') ?? session('api_token');
    $user    = session('user');
    $apiBase = config('services.api.base_url', env('API_BASE_URL', 'http://127.0.0.1:8000/api'));

    $userRole = is_array($user) ? ($user['role'] ?? 'mahasiswa') : 'mahasiswa';

    $mahasiswa       = [];
    $totalMatakuliah = 0;
    $totalNilai      = 0;

    try {
        $response = Http::acceptJson()
            ->withToken($token)
            ->timeout(5)
            ->get($apiBase . '/mahasiswa');

        if ($response->successful()) {
            $allMahasiswa = $response->json('data') ?? [];

            // Jika role mahasiswa, filter hanya data milik sendiri berdasarkan NIM
            if ($userRole === 'mahasiswa') {
                $userNim = is_array($user) ? ($user['nim'] ?? '') : '';
                $mahasiswa = array_values(array_filter($allMahasiswa, function ($m) use ($userNim) {
                    return ($m['nim'] ?? '') === $userNim;
                }));
            } else {
                // Admin & Dosen bisa lihat semua data mahasiswa
                $mahasiswa = $allMahasiswa;
            }

            $uniqueMk = [];
            foreach ($mahasiswa as $m) {
                if (!empty($m['nilai'])) {
                    $totalNilai += count($m['nilai']);
                    foreach ($m['nilai'] as $n) {
                        if (!empty($n['matakuliah_id'])) {
                            $uniqueMk[$n['matakuliah_id']] = true;
                        }
                    }
                }
            }
            $totalMatakuliah = count($uniqueMk);
        }
    } catch (\Throwable $e) {
        // Fallback jika API bermasalah
    }

    return view('dashboard', [
        'mahasiswa'       => $mahasiswa,
        'totalMatakuliah' => $totalMatakuliah,
        'totalNilai'      => $totalNilai,
    ]);
})->name('dashboard');

// Proses Logout (Mendukung GET & POST agar tidak MethodNotAllowedException)
Route::match(['get', 'post'], '/logout', function () {
    $token   = session('token') ?? session('api_token');
    $apiBase = config('services.api.base_url', env('API_BASE_URL', 'http://127.0.0.1:8000/api'));

    if ($token) {
        try {
            Http::withToken($token)
                ->acceptJson()
                ->timeout(3)
                ->post($apiBase . '/logout');
        } catch (\Throwable $e) {
            // Biarkan lewat jika API server tidak merespons
        }
    }

    session()->flush();
    return redirect()->route('login')->with('success', 'Anda telah berhasil keluar (logout).');
})->name('logout');