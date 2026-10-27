@extends('layouts.app')

@section('title', 'Data Barang')

@php
    $role = session('api_user.role');
    $rp = fn ($v) => 'Rp '.number_format((float) $v, 0, ',', '.');
@endphp

@section('content')
<div class="card">
    <h1>Data Barang</h1>

    @if ($apiError)
        <div class="alert alert-error">{{ $apiError }}</div>
    @endif

    <div class="toolbar">
        <form method="GET" action="{{ route('barang.index') }}">
            <input name="search" value="{{ $search }}" placeholder="Cari nama barang…">
            <button class="btn btn-sm btn-gray">Cari</button>
        </form>
        <span style="margin-left:auto"></span>
        @if ($role === 'admin')
            <a href="{{ route('barang.create') }}" class="btn">+ Tambah Barang</a>
        @else
            <span class="muted">Mode kasir: masukkan jumlah lalu klik <b>Jual</b> untuk mengurangi stok.</span>
        @endif
    </div>

    <div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th class="num">QTY</th>
                <th class="num">Price</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($barang as $b)
            <tr>
                <td>{{ $b['id'] }}</td>
                <td>{{ $b['nama'] }}</td>
                <td class="num {{ $b['qty'] <= 5 ? 'stock-low' : '' }}">{{ $b['qty'] }}</td>
                <td class="num">{{ $rp($b['price']) }}</td>
                <td>
                    @if ($role === 'admin')
                        <a href="{{ route('barang.edit', $b['id']) }}" class="btn btn-sm">Edit</a>
                        <form method="POST" action="{{ route('barang.destroy', $b['id']) }}" class="inline"
                              onsubmit="return confirm('Hapus {{ addslashes($b['nama']) }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('barang.jual', $b['id']) }}" class="inline">
                            @csrf @method('PATCH')
                            <input type="number" name="jumlah" value="1" min="1" max="{{ $b['qty'] }}" {{ $b['qty'] < 1 ? 'disabled' : '' }}>
                            <button class="btn btn-sm btn-success" {{ $b['qty'] < 1 ? 'disabled' : '' }}>Jual</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="muted" style="text-align:center">Belum ada data barang.</td></tr>
        @endforelse
        </tbody>
    </table>
    </div>
</div>
@endsection
