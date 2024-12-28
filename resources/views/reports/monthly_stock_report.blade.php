@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Laporan Stok Produk Bulanan</h1>

    <!-- Formulir untuk memilih bulan laporan -->
    <form method="GET" action="{{ route('reports.monthly_stock_report') }}">
        <div class="form-group">
            <label for="month">Pilih Bulan:</label>
            <input type="month" id="month" name="month" value="{{ request('month') ?? now()->format('Y-m') }}" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Tampilkan Laporan</button>
    </form>

    <p class="mt-4">Bulan: {{ \Carbon\Carbon::parse($month)->translatedFormat('F Y') }}</p>

    <!-- Menambahkan CSS custom untuk memperkecil ukuran tabel -->
    <table class="table table-bordered mt-4" style="width: 100%; font-size: 15px; margin: auto;">
        <thead>
            <tr>
                <th style="width: 15%;">Nama Produk</th>
                <th style="width: 10%;">Kode Produk</th>
                <th style="width: 10%;">Kategori</th>
                <th style="width: 10%;">Satuan</th>
                <th style="width: 10%;">Harga Beli</th>
                <th style="width: 10%;">Harga Jual</th>
                <th style="width: 8%;">Stok Awal</th>
                <th style="width: 8%;">Stok Masuk</th>
                <th style="width: 8%;">Stok Keluar</th>
                <th style="width: 8%;">Stok Akhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $product['code'] }}</td>
                    <td>{{ $product['category'] }}</td>
                    <td>{{ $product['unit'] }}</td>
                    <td>Rp. {{ number_format($product['purchase_price'], 2) }}</td>
                    <td>Rp. {{ number_format($product['sale_price'], 2) }}</td>
                    <td>{{ $product['initial_stock'] }}</td>
                    <td>{{ $product['stock_in'] }}</td>
                    <td>{{ $product['stock_out'] }}</td>
                    <td>{{ $product['ending_stock'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">Tidak ada data untuk bulan ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
