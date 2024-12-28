@extends('layouts.app')

@section('content')

    <!-- Main content -->
    <section class="content pt-4">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Edit Kategori</h3>
                <a href="{{ route('categories.index') }}" class="btn btn-success shadow-sm float-right">
                  <i class="fa fa-arrow-left"></i> Kembali
                </a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form method="post" action="{{ route('categories.update', $category->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Input untuk Nama Kategori -->
                    <div class="form-group row border-bottom pb-4">
                        <label for="name" class="col-sm-2 col-form-label">Nama Kategori</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $category->name) }}" required>
                        </div>
                    </div>
                    
                    <!-- Input untuk Upload Gambar -->
                    <div class="form-group row border-bottom pb-4">
                        <label for="image" class="col-sm-2 col-form-label">Foto Kategori</label>
                        <div class="col-sm-10">
                          <input type="file" class="form-control-file" name="image" id="image" accept="image/*">
                          @if($category->image)
                              <img src="{{ asset('storage/categories/' . $category->image) }}" alt="Category Image" width="100" class="mt-3">
                          @endif
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-success bg-info">Save</button>
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