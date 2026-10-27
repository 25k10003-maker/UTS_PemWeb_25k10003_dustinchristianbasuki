<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ClientMahasiswaController extends Controller
{
    public function index()
    {
        // Mengambil data dari backend API
        $response = Http::get('http://127.0.0.1:8000/api/mahasiswa');
        $result = $response->json();

        $mahasiswa = $result['data'] ?? [];

        return view('welcome', compact('mahasiswa'));
    }
}
