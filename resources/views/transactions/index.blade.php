@extends('layouts.app')

@section('content')

    <!-- Main content -->
    <section class="content pt-4">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Order</h3>
                <a href="{{ route('transactions.create') }}" class="btn btn-success bg-info shadow-sm float-right" style="margin-left:20px"> <i class="fa fa-plus"></i> Tambah </a>
                <a href="{{ route('transactions.return.history') }}" class="btn btn-danger shadow-sm float-right"> <i class="fa fa-trash"></i> Trash </a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                    <table id="data-table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal Transaksi</th>
                        <th>Nama Pelanggan</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $transaction->created_at->format('d-m-Y H:i:s') }}</td>
                                <td>{{ $transaction->customer_name }}</td>
                                <td>{{ $transaction->total_amount }}</td>
                                <td>
                                <div class="btn-group btn-group-sm">
                                <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> </a>
                               
                                  <!-- Tombol Return -->
                                  @if (!$transaction->is_returned)
                                      <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#returnModal" data-id="{{ $transaction->id }}">
                                          <i class="fa fa-undo"></i> Return
                                      </button>
                                  @else
                                      <button class="btn btn-secondary" disabled>Returned</button>
                                  @endif

                              
                                    <!-- untuk menghapus data -->
                                    <form onclick="return confirm('are you sure !')" action="{{ route('transactions.destroy', $transaction->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                    </form>
                                </div>
                                </td>
                            </tr>
                            @endforeach
                      
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

    <!-- Modal Return -->
    <div class="modal fade" id="returnModal" tabindex="-1" role="dialog" aria-labelledby="returnModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="returnModalLabel">Alasan Pengembalian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="returnForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="return_reason">Alasan Return</label>
                            <textarea name="return_reason" id="return_reason" class="form-control" rows="4" required></textarea>
                            @if ($errors->has('return_reason'))
                                <div class="text-danger">{{ $errors->first('return_reason') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-warning">Kirim Return</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('style-alt')
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
@endpush

@push('script-alt') 
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#data-table").DataTable();

            $('#returnModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var transactionId = button.data('id'); // Extract info from data-* attributes
                
                var form = $('#returnForm');
                form.attr('action', '/transactions/' + transactionId + '/return');
            });
        });
    </script>
@endpush
