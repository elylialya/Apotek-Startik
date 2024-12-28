

@extends('layouts.app')

@section('content')

    <!-- Main content -->
    <section class="content pt-4">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Tambah Produk</h3>
                <a href="{{ route('purchase_orders.index') }}" class="btn btn-success shadow-sm float-right"> <i class="fa fa-arrow-left"></i> Kembali</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <form action="{{ route('purchase_orders.store') }}" method="POST">
                 @csrf

                    <div class="form-group row border-bottom pb-2">
                        <label for="nama_produk" class="col-sm-2 col-form-label">Nama Pemasok:</label>
                        <div class="col-sm-10">
                        <input type="text"  class="form-control" name="supplier_name" id="supplier_name" required>
                        </div>
                    </div>
                    <div class="form-group row border-bottom pb-2">
                    <label for="supplier_id" class="col-sm-2 col-form-label">ID Pemasok:</label>
                        <div class="col-sm-10">
                        <input type="number" class="form-control" name="supplier_id" id="supplier_id" required>
                        </div>
                    </div>
                    <div class="form-group row border-bottom pb-2">
                    <label for="total_amount" class="col-sm-2 col-form-label">Total Pembayaran:</label>
                        <div class="col-sm-10">
                        <input type="number"class="form-control" step="0.01" name="total_amount" id="total_amount" required>
                        </div>
                    </div>

                    <div class="form-group row border-bottom pb-2">
                    <label for="status" class="col-sm-2 col-form-label">Status:</label>
                        <div class="col-sm-10">
                        <select class="form-control" name="status" id="status" required>
                        <option value="pending">Menunggu</option>
                        <option value="completed">Selesai</option>
                        <option value="canceled">Dibatalkan</option>
                    </select>
                        </div>
                    </div>



                    <div class="form-group row border-bottom pb-2">
                        <label for="body" class="col-sm-2 col-form-label">Tanggal Pesanan:</label>
                        <div class="col-sm-10">
                        <input type="date" class="form-control" name="order_date" id="order_date" required>
                        </div>
                    </div>


                  <div id="products">
            <div class="product">
                <select class="form-control" name="products[0][product_id]" required>
                    <option value="">Pilih Produk</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                <input class="form-control" type="number" name="products[0][quantity]" placeholder="Jumlah" required>
                <input class="form-control"type="number" step="0.01" name="products[0][price]" placeholder="Harga" required>
            </div>
        </div>
                   
                    <button  type="submit" class="btn btn-success bg-info">Save</button>
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
