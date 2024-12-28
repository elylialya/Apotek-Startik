<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('riwayat.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Riwayat Transaksi</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color:  #089DA1;
            overflow: hidden;
            display: flex;
            justify-content: left;
            align-items: left;
            padding: 20px 20px;
        }

        .back-icon {
            color: #ffffff; 
            font-size: 24px;
            margin: 0 10px;
            cursor: pointer;
        }

        .navbar .title {
            margin-left: 10px;
            color:  #ffffff;
            font-size: 20px;
            font-weight: bold;
            text-align: left;
        }

        .container {
            width: 1320px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            margin-top: 20px;
        }

        .user-info {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
        }

        table {
            width: 1240px;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        a {
            color: #089DA1;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .user-info{
           margin-bottom: -20px;
            margin-left: 25px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{ route('home') }}"><i class="fas fa-arrow-left back-icon"></i></a>
        <div class="title">Riwayat Aktivitas</div>
    </div>

    <!-- Menampilkan nama user -->
    <div class="user-info">
        Nama Pengguna : <strong>{{ auth()->user()->name }}</strong>
    </div>

    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Tanggal</th>
                    <th>Total Pembelian</th>
                    <th>Metode Pembayaran</th>
                    <th>Status Pengiriman</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @if($transactions->isEmpty())
                    <tr>
                        <td colspan="7">Anda belum memiliki riwayat transaksi.</td>
                    </tr>
                @else
                    @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
                        <td>Rp {{ number_format($transaction->total_amount, 2, ',', '.') }}</td>
                        <td>{{ $transaction->payment_method }}</td>
                        <td>{{ ucfirst($transaction->status) }}</td>
                        <td><a href="{{ route('user.transactions.show', $transaction->id) }}">Lihat Detail</a></td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</body>
</html>
