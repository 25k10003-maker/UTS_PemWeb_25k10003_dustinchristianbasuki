<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApiToken;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    /** POST /api/register (khusus admin) */
    public function register(Request $request): JsonResponse
    {
        // PERBAIKAN: Menggunakan $user->getTable() agar dinamis mengikuti custom table (t003_users)
        $userModel = new User();
        
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:' . $userModel->getTable() . ',email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role' => ['required', Rule::in(['admin', 'dosen', 'mahasiswa', 'operator'])],
        ]);

        $user = User::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Registrasi user berhasil.',
            'data' => $this->userPayload($user),
        ], 201);
    }

    /** POST /api/login */
    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $identifier = trim($data['email']);
        $normalized = strtoupper(str_replace(['.', ' ', '-'], '', $identifier));

        // Cari user berdasarkan email, username, atau NIM (termasuk format tanpa titik)
        $user = User::where('email', $identifier)
            ->orWhere('username', $identifier)
            ->orWhere('nim', $identifier)
            ->orWhereRaw("REPLACE(REPLACE(nim, '.', ''), '-', '') = ?", [$normalized])
            ->orWhereRaw("REPLACE(REPLACE(username, '.', ''), '-', '') = ?", [$normalized])
            ->first();

        // Fallback untuk akun Admin jika login menggunakan NIM 25.K1.0003 / 25K10003 / email student
        if (! $user && in_array(strtolower($identifier), ['25.k1.0003', '25k10003', 'admin', 'admin@pos.test', '25k10003@student.unika.ac.id'])) {
            $user = User::where('role', 'admin')->first();
        }

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'error' => 'invalid_credentials',
                'message' => 'Username/NIM/Email atau password salah.',
            ], 401);
        }

        // bersihkan token lama milik user yang sudah kedaluwarsa
        $user->apiTokens()->where('expires_at', '<', now())->delete();

        [$plain, $token] = ApiToken::issueFor($user);

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'data' => [
                'access_token' => $plain,
                'token_type' => 'Bearer',
                'expires_in' => (int) config('api.token_ttl', 1) * 60, // detik
                'expires_at' => $token->expires_at->toIso8601String(),
                'user' => $this->userPayload($user),
            ],
        ]);
    }

    /** GET /api/me */
    public function me(Request $request): JsonResponse
    {
        $token = $request->attributes->get('api_token');

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $this->userPayload($request->user()),
                'expires_at' => $token?->expires_at?->toIso8601String(),
            ],
        ]);
    }

    /** POST /api/logout */
    public function logout(Request $request): JsonResponse
    {
        $request->attributes->get('api_token')?->delete();

        return response()->json(['success' => true, 'message' => 'Logout berhasil.']);
    }

    private function userPayload(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'username' => $user->username ?? $user->nim ?? '25.K1.0003',
            'nim' => $user->nim ?? '25.K1.0003',
            'email' => $user->email,
            'role' => $user->role,
            'avatar' => $user->avatar ?? 'uploads/profile_dustin.png',
        ];
    }
}