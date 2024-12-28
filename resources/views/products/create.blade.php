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
                <a href="{{ route('products.index') }}" class="btn btn-success shadow-sm float-right"> <i class="fa fa-arrow-left"></i> Kembali</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form method="post" action="{{ route('products.store') }}" enctype="multipart/form-data">
                    @csrf 
                    <div class="form-group row border-bottom pb-2">
                        <label for="name" class="col-sm-2 col-form-label">Nama Produk</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required>
                        </div>
                    </div>
                    <div class="form-group row border-bottom pb-2">
                        <label for="code" class="col-sm-2 col-form-label">Kode</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" name="code" id="code" value="{{ old('code') }}" required>
                        </div>
                    </div>

                    <!-- Input Batch Code -->
                    <div class="form-group row border-bottom pb-2">
                        <label for="batch_code" class="col-sm-2 col-form-label">Kode Batch</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" name="batch_code" id="batch_code" value="{{ old('batch_code') }}">
                        </div>
                    </div>

                    <div class="form-group row border-bottom pb-2">
                        <label for="price" class="col-sm-2 col-form-label">Harga</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" name="price" id="price" value="{{ old('price') }}" required>
                        </div>
                    </div>

                    <div class="form-group row border-bottom pb-2">
                        <label for="stock" class="col-sm-2 col-form-label">STOK</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" name="stock" id="stock" value="{{ old('stock') }}" required>
                        </div>
                    </div>

                    <div class="form-group row border-bottom pb-2">
                        <label for="category_id" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                        <select class="form-control" name="category_id" id="category_id" required>
                          <option value="">Pilih Kategori</option>
                          @foreach ($categories as $category)
                              <option value="{{ $category->id }}">{{ $category->name }}</option>
                          @endforeach
                        </select>
                        </div>
                    </div>

                    <div class="form-group row border-bottom pb-2">
                        <label for="unit" class="col-sm-2 col-form-label">SATUAN</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" name="unit" id="unit" value="{{ old('unit') }}" required>
                        </div>
                    </div>

                    <div class="form-group row border-bottom pb-2">
                        <label for="expiration_date" class="col-sm-2 col-form-label">Tanggal Kadaluarsa</label>
                        <div class="col-sm-10">
                        <input type="date" class="form-control" name="expiration_date" id="expiration_date" value="{{ old('expiration_date') }}" required>
                        </div>
                    </div>

                    <div class="form-group row border-bottom pb-2">
                        <label for="weight" class="col-sm-2 col-form-label">Berat Obat</label>
                        <div class="col-sm-10">
                        <input type="number" class="form-control" name="weight" id="weight" required>
                        </div>
                    </div>

                    <div class="form-group row border-bottom pb-2">
                        <label for="image" class="col-sm-2 col-form-label">Gambar</label>
                        <div class="col-sm-10">
                        <input type="file" class="form-control" name="image" id="image">
                        </div>
                    </div>

                    <!-- Input Deskripsi -->
                    <div class="form-group row border-bottom pb-2">
                        <label for="description" class="col-sm-2 col-form-label">Deskripsi Produk</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="description" id="description" rows="3">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <!-- Input Dosis -->
                    <div class="form-group row border-bottom pb-2">
                        <label for="dosage" class="col-sm-2 col-form-label">Dosis Produk</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="dosage" id="dosage" value="{{ old('dosage') }}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success bg-info">Simpan</button>
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
