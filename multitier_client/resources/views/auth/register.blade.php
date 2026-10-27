@extends('layouts.app')

@section('title', 'Register - SiAkad-003')

@section('content')
<div class="container py-4">
    <div class="card shadow-lg border-0 rounded-4 mx-auto" style="max-width: 500px; overflow: hidden;">
        <!-- Header Card -->
        <div class="card-header bg-primary text-white text-center py-3 fs-4 fw-bold">
            Register User Baru
        </div>

        <div class="card-body p-4">
            <form method="POST" action="{{ route('register.submit') }}">
                @csrf

                <!-- Nama -->
                <div class="mb-3">
                    <label for="name" class="form-label text-muted fw-semibold">Nama Lengkap</label>
                    <input id="name" name="name" class="form-control form-control-lg fs-6 @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Masukkan nama pengguna" required autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email / Username -->
                <div class="mb-3">
                    <label for="email" class="form-label text-muted fw-semibold">Email / Username</label>
                    <input id="email" type="email" name="email" class="form-control form-control-lg fs-6 @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="contoh@domain.com" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Role -->
                <div class="mb-3">
                    <label for="role" class="form-label text-muted fw-semibold">Role User</label>
                    <select id="role" name="role" class="form-select form-select-lg fs-6 @error('role') is-invalid @enderror" required>
                        <option value="operator" @selected(old('role') === 'operator')>Operator (Kasir) — hanya penjualan / update QTY</option>
                        <option value="admin" @selected(old('role') === 'admin')>Admin — tambah, ubah, hapus barang</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label text-muted fw-semibold">Password</label>
                    <input id="password" type="password" name="password" class="form-control form-control-lg fs-6 @error('password') is-invalid @enderror" placeholder="Minimal 6 karakter" required minlength="6">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label text-muted fw-semibold">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control form-control-lg fs-6" placeholder="Ulangi password" required>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold mb-3">Daftarkan User</button>
            </form>

            <!-- Navigasi Kembali -->
            <div class="text-center pt-2 border-top">
                <a href="{{ route('barang.index') }}" class="text-decoration-none text-muted small">
                    &larr; Kembali ke Data Barang
                </a>
            </div>
        </div>
    </div>
</div>
@endsection