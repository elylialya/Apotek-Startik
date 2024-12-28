@extends('layouts.app')

@section('content')

@push('style-alt')
  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
  <style>
    /* Mengurangi ukuran font dan padding untuk tabel */
    #data-table {
        font-size: 15px; /* Ukuran font lebih kecil */
    }

    #data-table th, #data-table td {
        padding: 8px; /* Mengurangi padding */
        text-align: center; /* Menyelaraskan teks ke tengah */
    }

    /* Mengatur lebar kolom */
    #data-table th:nth-child(1),
    #data-table td:nth-child(1) { width: 30px; } /* No */

    #data-table th:nth-child(3),
    #data-table td:nth-child(3) { width: 70px; } /* Kode */

    #data-table th:nth-child(4),
    #data-table td:nth-child(4) { width: 100px; } /* Harga */

    #data-table th:nth-child(5),
    #data-table td:nth-child(5) { width: 50px; } /* Stok */

    #data-table th:nth-child(8),
    #data-table td:nth-child(8) { width: 150px; } /* Deskripsi */

    #data-table th:nth-child(9),
    #data-table td:nth-child(9) { width: 100px; } /* Dosis */
  </style>
@endpush


    <!-- Main content -->
    <section class="content pt-4">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Produk Obat</h3>
                <a href="{{ route('products.create') }}" class="btn btn-success bg-info shadow-sm float-right"> <i class="fa fa-plus"></i> Tambah Produk </a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                    <table id="data-table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kode</th>
                        <th>Kode Batch</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Kategori</th>
                        <th>Unit</th>
                        <th>Kadaluarsa</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)

                            <tr>    
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->code }}</td>
                            <td>{{ $product->batch_code }}</td>
                            <td>Rp{{ number_format($product->price, 2, '.', ',') }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->category ? $product->category->name : 'Tidak ada kategori' }}</td>
                            <td>{{ $product->unit }}</td>
                            
                            @php
                              // Hitung sisa waktu menuju tanggal kedaluwarsa
                              $expiration_date = \Carbon\Carbon::parse($product->expiration_date);
                              $now = \Carbon\Carbon::now();
                              $diffInMonths = $now->diffInMonths($expiration_date, false);
                            @endphp
                          <td
                          @if($diffInMonths <= 3)
                              style="color: red;"
                          @elseif($diffInMonths <= 5)
                              style="color: #E1E100;"
                          @endif
                      >
                              {{ $expiration_date->format('d-m-Y') }}
                          </td>
    
                            <td>
                                @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="50">
                               @endif
                                </td>
                      

                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form onclick="return confirm('are you sure !')" action="{{ route('products.destroy', $product->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                                    
                            </tr>
                        
                    @endforeach
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
