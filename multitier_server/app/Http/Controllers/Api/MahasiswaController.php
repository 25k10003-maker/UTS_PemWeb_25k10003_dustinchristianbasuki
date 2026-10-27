<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;

class MahasiswaController extends Controller
{
    public function index()
    {
        $data = Mahasiswa::with(['user', 'nilai.matakuliah'])->get();
        return response()->json([
            'status' => 'success',
            'nim_owner' => '25.K1.0003',
            'data' => $data
        ], 200);
    }
}
