
@extends('layouts.app')

@section('content')

    <!-- Main content -->
    <section class="content pt-4">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Daftar Pesanan Pembelian</h3>
                <a href="{{ route('purchase_orders.create') }}" class="btn btn-success bg-info shadow-sm float-right"> <i class="fa fa-plus"></i> Tambah </a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                    <table id="data-table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Pemasok</th>
                        <th>ID Pemasok</th>
                        <th>Total Pembayaran</th>
                        <th>Status</th>
                        <th>Tanggal Pesanan</th>
                        <th>Produk</th>
                        <th>keterangan</th>
                        
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($purchaseOrders as $order)
                            <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->supplier_name }}</td>
                            <td>{{ $order->supplier_id }}</td>
                            <td>Rp {{ number_format($order->total_amount, 2, '.', ',') }}</td>
                            <td>{{ $order->status }}</td>
                            <td>{{ $order->order_date }}</td>
                    <td>
                        <ul>
                            @foreach($order->items as $item)
                                <li>{{ $item->product->name }} ({{ $item->quantity }})</li>
                            @endforeach
                        </ul>
                    </td>
                               
                    <td>
                      <div class="btn-group btn-group-sm">
                          <a href="{{ route('purchase_orders.edit', $order->id) }}" class="btn btn-sm btn-primary">
                              <i class="fa fa-edit"></i>
                          </a>
                          
                          <!-- untuk menghapus data -->
                          <form onclick="return confirm('Apakah Anda yakin?')" action="{{ route('purchase_orders.destroy', $order->id) }}" method="POST">
                              @csrf
                              @method('DELETE')
                              <button class="btn btn-sm btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                          </form>
                      </div>
                  </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Data Kosong !</td>
                            </tr>
                        @endforelse
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