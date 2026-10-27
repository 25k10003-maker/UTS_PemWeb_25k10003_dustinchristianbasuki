@extends('layouts.app')

@php $edit = $barang !== null; @endphp

@section('title', $edit ? 'Edit Barang' : 'Tambah Barang')

@section('content')
<div class="card" style="max-width:560px">
    <h1>{{ $edit ? 'Edit Barang #'.$barang['id'] : 'Tambah Barang' }}</h1>

    <form method="POST" action="{{ $edit ? route('barang.update', $barang['id']) : route('barang.store') }}">
        @csrf
        @if ($edit) @method('PUT') @endif

        <label for="nama">Nama</label>
        <input id="nama" name="nama" value="{{ old('nama', $barang['nama'] ?? '') }}" required maxlength="150">
        @error('nama') <div class="field-error">{{ $message }}</div> @enderror

        <label for="qty">QTY</label>
        <input id="qty" type="number" name="qty" min="0" value="{{ old('qty', $barang['qty'] ?? 0) }}" required>
        @error('qty') <div class="field-error">{{ $message }}</div> @enderror

        <label for="price">Price (Rp)</label>
        <input id="price" type="number" name="price" min="0" step="0.01" value="{{ old('price', $barang['price'] ?? '') }}" required>
        @error('price') <div class="field-error">{{ $message }}</div> @enderror

        <div style="margin-top:22px; display:flex; gap:10px">
            <button class="btn">{{ $edit ? 'Simpan Perubahan' : 'Simpan' }}</button>
            <a href="{{ route('barang.index') }}" class="btn btn-gray">Batal</a>
        </div>
    </form>
</div>
@endsection
