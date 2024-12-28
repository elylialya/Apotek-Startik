

@extends('layouts.app')

@section('content')
<div class="card border-info mb-3" style="width: 50rem; margin-left: 120px; margin-top: 50px">
<div class="card-footer bg-info" style="text-align:center;">Detail Transaksi</div>
  <div class="card-body text-info">
    <h5 class="card-title">Info card title</h5>
    <p class="card-text">Nama Pelanggan : {{ $transaction->customer_name }} </p>
    <p class="card-text">Nomor Telepon : {{ $transaction->customer_phone }} </p>
    <p class="card-text">Alamat : {{ $transaction->customer_address }} </p>
    <p class="card-text">Total Harga: : Rp.{{ $transaction->total_amount }} </p>
    <p class="card-text">Jumlah Bayar : Rp. {{ $transaction->amount_paid }} </p>
    <p class="card-text">Metode Pembayaran : {{ ucfirst($transaction->payment_method) }} </p>
    <p class="card-text">Tanggal Transaksi : {{ $transaction->created_at->format('d-m-Y H:i:s') }} </p>
    <h2>Detail Produk</h2>
    <ul>
        @foreach ($transaction->transactionDetails as $detail)
            <li>
                <img src="{{ asset('storage/' . $detail->product->image) }}" alt="{{ $detail->product->name }}" width="50">
                {{ $detail->product->name }} - {{ $detail->quantity }} x {{ $detail->price }} = {{ $detail->subtotal }}
            </li>
        @endforeach
    </ul>
  </div>
  <div class="card-footer bg-info"></div>
</div>

@endsection
