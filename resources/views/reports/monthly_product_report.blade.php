@extends('layouts.app')

@section('content')

    <!-- Konten utama -->
    <section class="content pt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Laporan Total Penjualan Bulanan</h3>
                            <a href="{{ url()->previous() }}" class="btn btn-success shadow-sm float-right">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            
                            <!-- Form Pemilihan Bulan -->
                            <form method="GET" action="{{ route('reports.monthlyProduct') }}">
                                <div class="form-group">
                                    <label for="month">Pilih Bulan:</label>
                                    <input type="month" id="month" name="month" value="{{ request('month') ?? now()->format('Y-m') }}" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-primary">Tampilkan Laporan</button>
                            </form>

                            <hr>

                            <!-- Menampilkan bulan laporan -->
                            <p class="mt-4">Bulan: {{ \Carbon\Carbon::parse($month)->translatedFormat('F Y') }}</p>

                            <!-- Daftar Produk Terjual -->
                            <h4>Produk Terjual</h4>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Harga Satuan</th>
                                        <th>Total Terjual</th>
                                        <th>Harga Total Terjual</th> <!-- Kolom baru untuk harga total terjual -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ number_format($product->price, 2) }}</td>
                                            <td>{{ $product->total_sold }}</td>
                                            <td>{{ number_format($product->total_earned, 2) }}</td> <!-- Tampilkan harga total terjual -->
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection
