@extends('layouts.app')

@section('content')

    <!-- Main content -->
    <section class="content pt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Buat Transaksi</h3>
                            <a href="{{ route('transactions.index') }}" class="btn btn-success shadow-sm float-right">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form method="GET" action="{{ route('transactions.create') }}" class="mb-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" placeholder="Cari produk..." value="{{ old('search', $search) }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">Cari</button>
                                    </div>
                                </div>
                            </form>

                            <form method="post" action="{{ route('transactions.store') }}">
                                @csrf 

                                <!-- Nama Pelanggan (Required) -->
                                <div class="form-group row border-bottom pb-2">
                                    <label for="customer_name" class="col-sm-2 col-form-label">Nama Pelanggan</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="customer_name" id="customer_name" value="{{ old('customer_name', Auth::user()->name) }}" required>
                                        @error('customer_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Pilih Produk dan Kuantitas -->
                                <div class="form-group row border-bottom pb-2">
                                    <label for="product_ids" class="col-sm-2 col-form-label">Pilih Produk</label>
                                    <div class="col-sm-10">
                                        <select name="product_ids[]" id="product_ids" class="form-control" multiple required>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }} - Stok: {{ $product->stock }} - Harga: Rp{{ number_format($product->price, 0, ',', '.') }}</option>
                                            @endforeach
                                        </select>
                                        @error('product_ids')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Kuantitas Produk -->
                                <div class="form-group row border-bottom pb-2">
                                    <label for="quantities" class="col-sm-2 col-form-label">Jumlah Produk</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" name="quantities[]" min="1" placeholder="Masukkan kuantitas produk" required>
                                        @error('quantities')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Total Amount (otomatis terhitung dari controller atau dapat diinput manual) -->
                                <div class="form-group row border-bottom pb-2">
                                    <label for="total_amount" class="col-sm-2 col-form-label">Total Harga</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" name="total_amount" id="total_amount" placeholder="Total harga" required>
                                        @error('total_amount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Metode Pembayaran -->
                                <div class="form-group row border-bottom pb-2">
                                    <label for="payment_method" class="col-sm-2 col-form-label">Metode Pembayaran</label>
                                    <div class="col-sm-10">
                                        <select name="payment_method" id="payment_method" class="form-control" required>
                                            <option value="cash">Cash</option>
                                            <option value="credit_card">Credit Card</option>
                                            <option value="bank_transfer">Bank Transfer</option>
                                        </select>
                                        @error('payment_method')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success bg-info">Simpan Transaksi</button>
                            </form>
                        </div>
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
