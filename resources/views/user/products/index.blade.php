<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Pencarian Produk</title>
    <style>
          body {
    font-family: Arial, sans-serif;
    background-color: #089DA1;
    margin: 0;
    padding: 20px;
  }

.product-list-title {
    font-size: 30px;
    font-weight: bold;
    margin-top: 0;
    margin-bottom: 50px;
    text-align: center;
    color: #ffffff;
}

.search-bar {
    display: flex;
    align-items: center;
    margin-bottom: 50px;
}

.back-icon {
    color: #ffffff;
    font-size: 24px;
    margin: 0 10px;
    margin-left: 370px;
    cursor: pointer;
}

.search-input {
    width: 400px;  
    height: 25px; 
    padding: 5px;
    border: 1px solid #089DA1;
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
}

.search-icon-container {
    background-color: #ffffff; 
    width: 30px;  
    height: 25px; 
    padding: 5px;
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.search-icon {
    font-size: 16px;
    color: #089DA1; /* Warna ikon */
    cursor: pointer;
}

.product-container {
    margin-left: 420px;
    background-color: #ffffff;
    width: 230px;
    padding: 15px;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    margin-top: 20px;
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

.products-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* 4 produk per baris */
    gap: 15px; /* Jarak antar produk */
    margin-top: 20px;
    margin: 0 20px; 
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

.show-produk{
    margin-bottom: 20px;
    color: black;
}

.show-produk a{
    color: black;
}
.cart {
    margin-left: 15px;
  
   
}

.cart a {
   color: white;
   width: 200px;
   
}

.cart .fa-solid{
   width: 200px;
}


    </style>
</head>
<body>
    

    <div class="product-list">
        <h2 class="product-list-title">Daftar Produk</h2>
    </div>

    <div class="search-bar">
        <a href="{{ route('home') }}"><i class="fas fa-arrow-left back-icon"></i></a>
        <form method="GET" action="{{ route('products.userIndex') }}" style="display: flex; align-items: center;">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari produk..." class="search-input">
            <div class="search-icon-container">
                <button><i class="fas fa-search search-icon"></i></button>
            </div>
            <div class="cart">
                    <a href="{{ route('cart.index') }}"><i class="fa-solid fa-cart-shopping"></i></a>
               </div>
        </form>
    </div>

    @if ($products->isEmpty())
        <p>Produk tidak ditemukan.</p>
    @else

        <div class="products-grid">
            @foreach ($products as $product)
                <div class="product-item">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/default-product.jpg') }}" alt="{{ $product->name }}" class="product-image">
                    <div class="product-name">{{ $product->name }}</div>
                    <div class="product-price">Rp {{ number_format($product->price, 2, '.', ',') }}</div>
                    <div class="show-produk"><a href="{{ route('user.products.show', $product->id) }}">Lihat Produk</a></div>
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

       
    @endif

    <!-- Menampilkan semua produk di bawah daftar hasil pencarian -->
    <div class="all-products-title">Semua Produk</div>
    <div class="products-grid">
        @foreach ($allProducts as $product)
            <div class="product-item">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/default-product.jpg') }}" alt="{{ $product->name }}" class="product-image">
                <div class="product-name">{{ $product->name }}</div>
                <div class="product-price">Rp {{ number_format($product->price, 2, '.', ',') }}</div>
                <div class="show-produk"><a href="{{ route('products.show', $product->id) }}">Lihat Produk</a></div>
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
   
</body>
</html>
