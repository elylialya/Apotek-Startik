
                   

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Kategori</title>
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

.products-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* 4 produk per baris */
    gap: 15px; /* Jarak antar produk */
    margin-top: 20px;
    margin-left: 50px;
}

.product-item {
    background-color: #ffffff;
    width: 230px;
    padding: 15px;
    margin: 0 5px;
    border: 1px solid #ccc;
    border-radius: 10px;
    text-align: center;
}

.product-image {
    width: 100px;
    height: 100px;
    border-radius: 5px;
    margin-bottom: 15px;
}

.product-name {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
}

.product-description {
    font-size: 14px;
    color: #555;
    margin-bottom: 15px;
}

.product-price {
    font-size: 16px;
    font-weight: bold;
    color: #089DA1;
    margin-bottom: 15px;
}

.product-quantity {
    margin-bottom: 5px;
}

.product-quantity label {
    margin-right: 10px;
}

.product-quantity input {
    width: 50px;
    padding: 5px;
    text-align: center;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.show-produk{
    margin-bottom: 20px;
    color: black;
}

.show-produk a{
    color: black;
}

.add-to-cart-btn  {
    width: 100px;
    background-color: #089DA1;
    color: white;
    padding: 9px 18px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    margin-top: 5px; /* Beri jarak antara tombol */
}
.buy-now-btn{
    width: 60px;
    background-color: #089DA1;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    margin-top: 5px;
}

.add-to-cart-btn:hover, .buy-now-btn:hover {
    background-color: #077f8a;
}

.all-products-title {
    font-size: 30px;
    font-weight: bold;
    text-align: center;
    color: #ffffff;
    margin-top: 20px;
    margin-bottom: 20px;
}
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <a href="{{ route('welcome') }}" class="back-button"><i class="fas fa-arrow-left"></i></a>
            <h1>Produk dalam Kategori: {{ $category->name }}</h1>
        </div>
    </header>
    <div class="products-grid">
        <!-- Product 1 -->
        @if($products->count())
        @foreach ($products as $product)
        <div class="product-item">
        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/default-product.jpg') }}" alt="{{ $product->name }}" class="product-image">
                    <div class="product-name">{{ $product->name }}</div>
                    <div class="product-price">Rp {{ number_format($product->price, 3, '.', ',') }}</div>
                    <div class="show-produk"><a href="{{ route('kategori.welcome', $product->id) }}">Lihat Produk</a></div>
                    <form method="POST" action="{{ route('cart.store') }}" style="display: inline;">
                    @csrf
                    <div class="product-quantity">
                    <input type="number" name="quantity" min="1" max="{{ $product->stock }}" required>
                    </div>
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="add-to-cart-btn">Keranjang</button>
                    </form>
                    <form method="GET" action="{{ route('user.transactions.create') }}" style="display: inline;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="buy-now-btn">Beli</button>
                    </form>
                </div>
            @endforeach
        </div>
       
    @else
        <p>Tidak ada produk dalam kategori ini.</p>
    @endif
</div>
      
</body>
</html>