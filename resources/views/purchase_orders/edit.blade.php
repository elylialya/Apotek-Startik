@extends('layouts.app')

@section('content')

<!-- Main content -->
<section class="content pt-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Pesanan Pembelian</h3>
                        <a href="{{ route('purchase_orders.index') }}" class="btn btn-success shadow-sm float-right">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{ route('purchase_orders.update', $purchaseOrder->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group row border-bottom pb-2">
                                <label for="supplier_name" class="col-sm-2 col-form-label">Nama Pemasok:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="supplier_name" id="supplier_name" value="{{ $purchaseOrder->supplier_name }}" required>
                                </div>
                            </div>
                            <div class="form-group row border-bottom pb-2">
                                <label for="supplier_id" class="col-sm-2 col-form-label">ID Pemasok:</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="supplier_id" id="supplier_id" value="{{ $purchaseOrder->supplier_id }}" required>
                                </div>
                            </div>
                            <div class="form-group row border-bottom pb-2">
                                <label for="total_amount" class="col-sm-2 col-form-label">Total Pembayaran:</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" step="0.01" name="total_amount" id="total_amount" value="{{ $purchaseOrder->total_amount }}" required>
                                </div>
                            </div>

                            <div class="form-group row border-bottom pb-2">
                                <label for="status" class="col-sm-2 col-form-label">Status:</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="status" id="status" required>
                                        <option value="pending" {{ $purchaseOrder->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="completed" {{ $purchaseOrder->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                        <option value="canceled" {{ $purchaseOrder->status == 'canceled' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row border-bottom pb-2">
                                <label for="order_date" class="col-sm-2 col-form-label">Tanggal Pesanan:</label>
                                <div class="col-sm-10">
                                <input type="date" class="form-control" name="order_date" id="order_date" value="{{ \Carbon\Carbon::parse($purchaseOrder->order_date)->format('Y-m-d') }}" required>
                                </div>
                            </div>

                            <div id="products">
                                @foreach($purchaseOrder->items as $index => $item)
                                    <div class="product mb-2">
                                        <select class="form-control" name="products[{{ $index }}][product_id]" required>
                                            <option value="">Pilih Produk</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}" {{ $product->id == $item->product_id ? 'selected' : '' }}>{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                        <input class="form-control" type="number" name="products[{{ $index }}][quantity]" value="{{ $item->quantity }}" placeholder="Jumlah" required>
                                        <input class="form-control" type="number" step="0.01" name="products[{{ $index }}][price]" value="{{ $item->price }}" placeholder="Harga" required>
                                    </div>
                                @endforeach
                            </div>

                            <button type="submit" class="btn btn-success bg-info">Update</button>
                        </form>
                    </div>
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
