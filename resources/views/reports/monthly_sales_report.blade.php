@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">Laporan Hasil Keuntungan Penjualan Bulanan</h1>

        <!-- Form untuk memilih bulan -->
        <form method="GET" action="{{ route('reports.monthlySales') }}">
            <div class="form-group">
                <label for="month">Pilih Bulan:</label>
                <input type="month" id="month" name="month" value="{{ request('month') ?? now()->format('Y-m') }}" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Tampilkan Laporan</button>
        </form>

        <!-- Tampilkan bulan yang dipilih -->
        <p class="mt-4">Bulan: {{ \Carbon\Carbon::parse($month)->translatedFormat('F Y') }}</p>

        <!-- Tabel Laporan Penjualan -->
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Total Penjualan</th>
                    <th>Total Pembayaran</th>
                    <th>Total Pembelian (FBF)</th> <!-- Tambahkan header untuk total pembelian -->
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Rp. {{ number_format($sales->total_sales, 2, ',', '.') }}</td>
                    <td>Rp. {{ number_format($sales->total_paid, 2, ',', '.') }}</td>
                    <td>Rp. {{ number_format($totalPurchases, 2, ',', '.') }}</td> <!-- Tambahkan total pembelian -->
                </tr>
            </tbody>
        </table>
    </div>
@endsection
