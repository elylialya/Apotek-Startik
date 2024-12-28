<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="style3.css">
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

        .cart-nav {
            display: flex;
            background-color: #f1f1f1;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .nav-item {
            flex: 1;
            text-align: center;
        }

        .nav-item p {
            margin: 0;
            font-weight: bold;
        }

        .checkbox {
            flex: 0.5;
            text-align: center;
        }

        .product {
            flex: 2;
        }

        main {
            padding: 20px;
        }

        .cart-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        .cart-item .item {
            flex: 1;
            text-align: center;
        }

        .cart-item .checkbox {
            flex: 0.5;
            margin-left: -10px;
        }

        .cart-item .product {
            flex: 2;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cart-item .product img {
            width: 80px;
            height: auto;
            margin-right: 10px;
        }

        .cart-item .product-details p {
            margin: 0;
            text-align: left;
        }

        .cart-item .quantity input {
            width: 50px;
            margin-left: 10px;
        }

        .delete-button {
            background-color: transparent;
            border: none;
            color: #089DA1;
            cursor: pointer;
            font-size: 18px;
            margin-left: 15px;
        }

        .cart-footer {
    padding: 20px;
    background-color: #f9f9f9;
    border-top: 1px solid #ddd;
    display: flex;
    justify-content: flex-end; /* Memindahkan semua elemen ke kanan */
    align-items: center;
}

.total-payment {
    font-size: 18px;
    font-weight: bold;
    margin-right: 20px; /* Tambahkan jarak antara total pembayaran dan tombol */
}

.button-group {
    display: flex; /* Mengatur tombol dalam baris */
    gap: 10px; /* Jarak antar tombol */
}

.checkout-button {
    background-color: #089DA1; /* Warna latar belakang tombol */
    color: white; /* Warna teks tombol */
    border: none; /* Menghilangkan border default */
    padding: 10px 20px; /* Padding dalam tombol */
    font-size: 18px; /* Ukuran font */
    cursor: pointer; /* Pointer saat hover */
    transition: background-color 0.3s; /* Efek transisi saat hover */
    border-radius: 5px; /* Sudut melingkar tombol */
}

/* Efek hover untuk tombol */
.checkout-button:hover {
    background-color: #067C7C; /* Warna latar belakang saat hover */
}

/* Tambahkan media query untuk responsivitas jika diperlukan */
@media (max-width: 600px) {
    .cart-footer {
        flex-direction: column; /* Mengubah layout menjadi kolom pada layar kecil */
        align-items: flex-start; /* Mengatur alignment pada posisi awal */
    }

    .total-payment {
        margin-bottom: 10px; /* Menambahkan margin bawah */
        margin-right: 0; /* Menghapus margin kanan pada layar kecil */
    }
}

    </style>
</head>

<body>
    <header>
        <div class="header-content">
            <a href="{{ route('products.userIndex') }}" class="back-button"><i class="fas fa-arrow-left"></i></a>
            <h1>Keranjang Saya</h1>
        </div>
    </header>
    <nav class="cart-nav">
        <div class="nav-item checkbox">
            <input type="checkbox">
        </div>
        <div class="nav-item product">
            <p>Produk</p>
        </div>
        <div class="nav-item price">
            <p>Harga Satuan</p>
        </div>
        <div class="nav-item quantity">
            <p>Kuantitas</p>
        </div>
        <div class="nav-item action">
            <p>Aksi</p>
        </div>
    </nav>
    <main>
        <!-- Form utama untuk memproses pembayaran -->
        <form action="{{ route('cart.processSelected') }}" method="POST">
            @csrf
            @foreach ($carts as $cart)
                <div class="cart-item">
                    <div class="item checkbox">
                        <!-- Checkbox untuk memilih item -->
                        <input type="checkbox" name="cart_ids[]" value="{{ $cart->id }}"
                            {{ session('selected_cart_ids') && in_array($cart->id, session('selected_cart_ids')) ? 'checked' : '' }}>
                    </div>
                    <div class="item product">
                        <img src="{{ asset('storage/' . $cart->product->image) }}" alt="{{ $cart->product->name }}">
                        <div class="product-details">
                            <p>{{ $cart->product->name }}</p>
                        </div>
                    </div>
                    <div class="item price">
                        <p>Rp. {{ number_format($cart->product->price, 2, ',', '.') }}</p>
                    </div>
                    <div class="item quantity">
                        <!-- Tombol untuk mengurangi kuantitas (menggunakan form terpisah) -->
                        <button type="button" class="quantity-button"
                            onclick="document.getElementById('decrement-{{ $cart->id }}').submit();">-</button>

                        <span>{{ $cart->quantity }}</span>

                        <!-- Tombol untuk menambah kuantitas (menggunakan form terpisah) -->
                        <button type="button" class="quantity-button"
                            onclick="document.getElementById('increment-{{ $cart->id }}').submit();">+</button>
                    </div>
                    <div class="item action">
                        <!-- Tombol hapus produk (menggunakan form terpisah) -->
                        <button class="delete-button" type="button"
                            onclick="document.getElementById('delete-{{ $cart->id }}').submit();">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            @endforeach

            <footer class="cart-footer">
    <div class="total-payment">
        <p>Total ({{ session('selected_cart_ids') ? count(session('selected_cart_ids')) : 0 }} produk):
            <span>Rp. {{ number_format(session('total_price', 0), 2, ',', '.') }}</span>
        </p>
        <div style="display: flex; gap: 10px;">
            <button type="button" class="checkout-button" onclick="window.location.href='{{ route('products.userIndex') }}'">Lanjut Berbelanja</button>
            <button type="submit" class="checkout-button">Proses Pembayaran</button>
        </div>
    </div>
</footer>

        </form>

        <!-- Forms untuk setiap aksi terpisah -->
        @foreach ($carts as $cart)
            <form id="decrement-{{ $cart->id }}" action="{{ route('cart.decrement', $cart->id) }}" method="POST"
                style="display:none;">
                @csrf
                @method('PATCH')
            </form>

            <form id="increment-{{ $cart->id }}" action="{{ route('cart.increment', $cart->id) }}" method="POST"
                style="display:none;">
                @csrf
                @method('PATCH')
            </form>

            <form id="delete-{{ $cart->id }}" action="{{ route('cart.destroy', $cart->id) }}" method="POST"
                style="display:none;">
                @csrf
                @method('DELETE')
            </form>
        @endforeach

        </div>
        </footer>
</body>

</html>
