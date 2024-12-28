<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('css/home.css')}}">
</head>
<body>
<section>
<nav class="navbar">
    <div class="navbar-container">
        <!-- Logo dan Nama -->
        <div class="navbar-brand">
            <img src="asset/logo1.jpg" alt="Logo" class="navbar-logo">
            <h1 class="navbar-name">Cinta Sehat</h1>
        </div>

        <!-- Tombol Hamburger untuk Tampilan Seluler -->
<div class="menu-toggle" onclick="toggleMenu()">
    <i class="fa fa-bars" id="menu-icon"></i>
</div>

        <!-- Menu Navigasi -->
        <ul class="navbar-menu">
             <!-- Tombol Close -->
    <li class="close-menu">
        <i class="fa fa-times" onclick="toggleMenu()"></i>
    </li>

            <li><a href="{{ route('home') }}">Beranda</a></li>
            <li><a href="{{ route('hubungi-home') }}">Hubungi Kami</a></li>
            <li><a href="{{ route('user.transactions.history') }}">Transaksi</a></li>
            <li><a href="{{ route('products.userIndex') }}">Produk</a></li>
            <li><a href="{{ route('bantuan-home') }}">Bantuan</a></li>
        </ul>

        <!-- Pencarian dan User Menu -->
        <div class="user-menu">
            <a href="{{ route('products.userIndex') }}" class="icon"><i class="fa fa-search"></i></a>
            <a href="{{ route('user.profile') }}" class="icon"><i class="fa-solid fa-user"></i></a>
            <a href="{{ route('cart.index') }}" class="icon"><i class="fa-solid fa-cart-shopping"></i></a>
        </div>

        <!-- Login/Logout -->
        <div class="auth">
            <a href="{{ route('login') }}" class="btn">Login</a>
            <a href="{{ route('logout') }}" class="btn">Logout</a>
        </div>
    </div>
</nav>




    <!--content-->
    <div class="main">
        <div class="main_tag">
            <h1>SELAMAT DATANG DI<br><span>APOTEK CINTA SEHAT</span></h1>
            <p>
                Aplikasi apotek kami menawarkan penawaran yang terbaik dengan obat terlengkap terjamin dan asli
                , yang bisa memenuhi semua kebutuhan kesehatanmu. produk yang dijual di Startik hadir dengan
                berbagai macam kategori obat pilihan untuk memenuhi seluruh kebutuhan kesehatan, mulai dari obat
                generik, obat untuk ibu dan anak, suplemen kesehatan,dan perawatan tubuh
            </p>
            <a href="#" class="main_btn">Miliki Sekarang</a>
        </div>

        <div class="main_img">
            <img src="asset/obat.jpg">
        </div>
    </div>

</section>

<!--category-->

<div class='category coll-3 icon-p-2'>
    <h2>Kategori</h2>
    <ul>
        @foreach($categories as $category)
            <li>
                <a href="{{ route('products.byCategory', $category->id) }}">
                    <img src="{{ asset('images/categories/' . $category->image) }}" alt="{{ $category->name }}" class="category-image">
                    {{ $category->name }}
                </a>
            </li>
        @endforeach
    </ul>
</div>

<!--end -->

<!--Service/Layanan-->

<div class="services">
    <h2>Layanan</h2>

    <div class="services_box">
        <!-- Pengiriman cepat -->
        <div class="services_card">
            <a href="{{ route('pengiriman-home') }}">
                <i class="fa-solid fa-truck-fast"></i>
                <h3>Pengiriman cepat</h3>
            </a>
        </div>

        <!-- Layanan 24x7 -->
        <div class="services_card">
            <a href="{{ route('layanan-home') }}">
                <i class="fa-solid fa-headset"></i>
                <h3>Layanan 24x7</h3>
            </a>
        </div>

        <!-- Penawaran terbaik -->
        <div class="services_card">
            <a href="{{ route('penawaran-home') }}">
                <i class="fa-solid fa-tag"></i>
                <h3>Penawaran terbaik</h3>
            </a>
        </div>
    </div>
</div>

<!--end service-->


<!--Penawaran Obat -->

<div class="featured_boks">

    <h1>Penawaran Obat</h1>

    <div class="featured_obat_box">

    @foreach ($products as $product)       
        <div class="featured_obat_card">

            <div class="featurde_obat_img">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            </div>

            <div class="featurde_obat_tag">
                <h4>{{ $product->name }}</h4>
                <p class="obat_price">
                    Rp {{ $product->price }}</p>
                    <form method="GET" action="{{ route('user.transactions.create') }}" style="display: inline;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit"  class="f_btn">Beli</button>
                    </form>
            </div>

        </div>
        @endforeach

    </div>
    <!--end Penawaran Obat-->

    <!--Produk Obat Terlaris-->

    <div class="featured_boks">

    <h1>Produk Obat Terlaris</h1>

    <div class="featured_obat_box">
        @php
            // Mendapatkan kategori berdasarkan nama "Vitamin"
            $vitaminCategory = \App\Models\Category::where('name', 'Vitamin')->first();

            // Jika kategori ditemukan, ambil produk terakhir dalam kategori Vitamin berdasarkan created_at
            $products = $vitaminCategory ? $vitaminCategory->products()->orderBy('created_at', 'desc')->take(7)->get() : collect();
        @endphp

        @if($vitaminCategory && $products->count() > 0)
            @foreach ($products as $product)
                <div class="featured_obat_card">

                    <div class="featurde_obat_img">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    </div>

                    <div class="featurde_obat_tag">
                        <h4>{{ $product->name }}</h4>
                        <p class="obat_price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <form method="GET" action="{{ route('user.transactions.create') }}" style="display: inline;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="f_btn">Beli</button>
                        </form>
                    </div>

                </div>
            @endforeach
        @else
            <p>Kategori Vitamin atau produk tidak tersedia.</p>
        @endif
    </div>
</div>


        <!-- footer -->
        <footer class="footer-distributed">
            <div class="footer-left">
                <img src="asset/logo1.jpg" width="50%">
                <h3>Cinta Sehat</h3>
            </div>
            <div class="footer-right">
                <p class="footer-company-about">
                    <span>Informasi</span>
                    Apotek Cinta Sehat adalah apotek yang berkomitmen untuk menyediakan layanan kesehatan terbaik bagi masyarakat.
                    Dengan prinsip Cepat, Interaktif, Terjangkau, dan Aman, Apotek Cinta Sehat menawarkan layanan yang fokus pada
                      kecepatan dalam melayani pelanggan, interaksi yang ramah dan mudah, harga yang terjangkau,
                     serta keamanan dalam setiap produk dan layanan yang disediakan.
                </p>
                <p class="footer-links">
                    <a href="#">Tentang kami</a>
                    |
                    <a href="#">FAQ</a>
                    |
                    <a href="#">Bantuan</a>
                </p>
                <div class="footer-icons">
                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>
            <div class="footer-center">
                <div>
                <i class="fa fa-map-marker"></i>
                    <p><span>Jalan No.2 RT. 11, Antasan Kecil Timur,</span>
                    <span>Kec. Banjarmasin Utara, Kota Banjarmasin,</span>
                    Kalimantan Selatan 70123</p>
                </div>
                <div>
                    <i class="fa fa-phone"></i>
                    <p>+62 853-4720-3752 (Chandra Wijaya)</p>
                </div>
                <div>
                    <i class="fa fa-envelope"></i>
                    <p><a href="#">Email: cintasehat@gmail.com</a></p>
                </div>
            </div>
        </footer>

        <!-- end footer-->

        </body>

        <script>
          
          function toggleMenu() {
    const menu = document.querySelector('.navbar-menu');
    const menuIcon = document.querySelector('#menu-icon');

    // Toggle kelas 'active' pada menu
    menu.classList.toggle('active');
    
    // Ubah ikon dari fa-bars ke fa-times
    if (menu.classList.contains('active')) {
        menuIcon.classList.remove('fa-bars');
        menuIcon.classList.add('fa-times');
    } else {
        menuIcon.classList.remove('fa-times');
        menuIcon.classList.add('fa-bars');
    }
}

        </script>
</html>