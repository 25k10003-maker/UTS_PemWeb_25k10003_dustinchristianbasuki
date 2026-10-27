<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\MahasiswaController;
use App\Http\Middleware\AuthenticateApiToken; // Import middleware kustom

/*
|--------------------------------------------------------------------------
| Public Routes (Tanpa Token)
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Protected Routes (Perlu Bearer Token)
|--------------------------------------------------------------------------
*/
Route::middleware(AuthenticateApiToken::class)->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/register', [AuthController::class, 'register']);
    
    // Resource routes untuk CRUD Data Barang & Mahasiswa
    Route::apiResource('barang', BarangController::class);
    Route::apiResource('mahasiswa', MahasiswaController::class);
});