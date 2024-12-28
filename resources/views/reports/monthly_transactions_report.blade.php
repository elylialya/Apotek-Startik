@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Laporan Transaksi Bulanan - {{ \Carbon\Carbon::parse($month)->format('F Y') }}</h1>
    
    <form method="GET" action="{{ route('reports.monthly-transactions') }}">
        <div class="form-group">
            <label for="month">Pilih Bulan:</label>
            <input type="month" name="month" id="month" class="form-control" value="{{ $month }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Tampilkan</button>
    </form>

    <p><strong>Total Hasil Transaksi:</strong> Rp{{ number_format($totalTransactions, 0, ',', '.') }}</p>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Pelanggan</th>
                <th>Total Pembayaran</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->id }}</td>
                <td>{{ $transaction->customer_name }}</td>
                <td>Rp{{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                <td>{{ $transaction->status }}</td>
                <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d-m-Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
