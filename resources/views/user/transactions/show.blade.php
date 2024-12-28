<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi</title>
    <link rel="stylesheet" href="style5.css">
    <!-- Tambahkan Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #089DA1;
            color: white;
            padding: 20px 20px;
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .header-content {
            display: flex;
            align-items: center;
        }

        .back-button {
            color: white;
            text-decoration: none;
            font-size: 20px;
            margin-right: 10px;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
            margin-left: 30px;
        }

        .shipping-address {
            margin-top: 10px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .shipping-address h3 {
            margin-bottom: 10px;
            font-size: 20px;
            font-weight: bold;
        }

        .address-info p {
            margin: 5px 0;
            font-size: 16px;
        }

        .address-info p strong {
            font-weight: bold;
        }

        .product-detail {
            display: flex;
            align-items: center;
            margin-top: 10px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            justify-content: space-between;
        }

        .product-image img {
            width: 100px;
            height: auto;
            margin-right: 20px;
        }

        .product-info {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .product-name {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
        }

        .quantity-price {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .quantity,
        .price {
            font-size: 16px;
            margin: 0;
            margin-top: 10px;
        }

        .order-total {
            margin-top: 10px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .total-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .subtotal-label,
        .service-fee-label,
        .total-label,
        .subtotal-amount,
        .service-fee-amount,
        .total-amount {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
        }

        .subtotal-amount,
        .service-fee-amount,
        .total-amount {
            text-align: right;
        }

        .payment-method {
            margin-top: 10px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .payment-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .payment-label,
        .payment-value {
            font-size: 16px;
            margin: 0;
        }

        .payment-label {
            font-weight: bold;
        }

        .payment-value {
            text-align: right;
        }
    </style>
</head>

<body>
    <header>
        <div class="header-content">
            <a href="{{ route('user.transactions.history') }}" class="back-button"><i class="fas fa-arrow-left"></i></a>
            <h1>Detail Transaksi</h1>
        </div>
    </header>
    <div class="shipping-address">
        <h3>Alamat Pengiriman</h3>
        <div class="address-info">
            <p><strong>Nama:</strong> {{ $transaction->customer_name }}</p> <!-- Pastikan menggunakan customer_name -->
            <p><strong>No. Telepon:</strong> {{ $transaction->customer_phone }}</p>
            <p><strong>Alamat:</strong> {{ $transaction->customer_address }}</p>
        </div>
    </div>

    @foreach ($transactionProduct as $detail)
        <div class="product-detail">
            <div class="product-image">
                <img src="{{ asset('/storage/' . $detail->product->image) }}" alt="{{ $detail->product->name }}" width="50">
            </div>
            <div class="product-info">
                <p class="product-name">{{ $detail->product->name }}</p>
                <div class="quantity-price">
                    <p class="quantity">{{ $detail->quantity }}x</p>
                    <p class="price">{{ number_format($detail->price, 2, '.', ',') }}</p>
                </div>
            </div>
        </div>
    @endforeach

    <div class="order-total">
        <div class="total-item">
            <p class="subtotal-label">Subtotal Produk:</p>
            <p class="subtotal-amount">Rp{{ number_format($transaction->amount_paid, 2, '.', ',') }}</p>
        </div>
        <div class="total-item">
            <p class="service-fee-label">Biaya Layanan:</p>
            <p class="service-fee-amount">Rp.0</p>
        </div>
        <div class="total-item total">
            <p class="total-label">Total Pesanan:</p>
            <p class="total-amount">Rp{{ number_format($transaction->total_amount, 2, '.', ',') }}</p>
        </div>
    </div>

    <div class="payment-method">
        <div class="payment-info">
            <p class="payment-label">Metode Pembayaran:</p>
            <p class="payment-value">{{ $transaction->payment_method }}</p>
        </div>
    </div>

    <div class="payment-method">
        <div class="payment-info">
            <p class="payment-label">Opsi Pengiriman:</p>
            <p class="payment-value">{{ $transaction->shipping_option }}</p>
        </div>
    </div>

    <div class="payment-method">
        <div class="payment-info">
            <p class="payment-label">Status Pengiriman:</p>
            <p class="payment-value">{{ ucfirst($transaction->status) }}</p>
        </div>
    </div>
</body>

</html>
