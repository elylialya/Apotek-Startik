@extends('layouts.app')

@section('content')

    <!-- Main content -->
    <section class="content pt-4">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Kategori</h3>
                <a href="{{ route('categories.create') }}" class="btn btn-success bg-info shadow-sm float-right">
                  <i class="fa fa-plus"></i> Tambah
                </a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                    <table id="data-table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Foto</th> <!-- Kolom baru untuk Foto -->
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->name }}</td>
                                
                                <!-- Menampilkan foto jika tersedia -->
                                <td>
                                  @if($category->image)
                                    <img src="{{ asset('images/categories/' . $category->image) }}" alt="Foto Kategori" width="80">
                                  @else
                                    <span class="text-muted">Tidak ada foto</span>
                                  @endif
                                </td>
                               
                                <td>
                                  <div class="btn-group btn-group-sm">
                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    
                                    <!-- untuk menghapus data -->
                                    <form onclick="return confirm('Are you sure?')" action="{{ route('categories.destroy', $category->id) }}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                    </form>
                                  </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Data Kosong!</td>
                            </tr>
                        @endforelse
                    </tbody>
                    </table>
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

@push('style-alt')
  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
@endpush

@push('script-alt') 
    <script
        src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
        crossorigin="anonymous"
    >
    </script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script>
    $("#data-table").DataTable();
    </script>
@endpush
