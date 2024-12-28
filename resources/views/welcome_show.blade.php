

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>detail produk</title>
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
    padding: 20px;
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

.product-image {
    display: flex;
    align-items: center;
}

.product-image img {
    width: 150px; /* Adjust size for smaller screens */
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

/* Responsive adjustments */
@media (max-width: 768px) {
    header h1 {
        font-size: 20px;
    }

    .shipping-address h3 {
        font-size: 18px;
    }

    .address-info p {
        font-size: 14px;
    }

    .product-image img {
        width: 100px; /* Smaller image for mobile */
    }
}
    </style>
</head>

<body>
    <header>
        <div class="header-content">
                   <a href="{{ route('welcome.search') }}" class="back-button"><i class="fas fa-arrow-left"></i></a>
            <h1>Detail Produk</h1>
        </div>
    </header>
    <div class="shipping-address">
        <h3>Produk :</h3>
        <div class="address-info">
            <p><strong>Nama Produk :</strong> {{ $product->name }}</p>
            <p><strong>Kategori :</strong> {{ $product->category->name }}</p>
        </div>
    </div>

    <div class="shipping-address">
    <div class="product-image">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/default-product.jpg') }}" alt="{{ $product->name }}">
                <p>Harga: Rp {{ number_format($product->price, 2, '.', ',') }}</p>
        </div>
    </div>

    <div class="shipping-address">
        <h3>Deskripsi Produk :</h3><br>
        <div class="address-info">
            <p><strong>Deskripsi :</strong></p>
            <p>{{ $product->description }}</p><br>
            <p><strong>Dosis :</strong> {{ $product->dosage }}</p>
        </div>
    </div>
</body>

</html>

