<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bantuan</title>
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
            margin-top: 30px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 50px;
            background-color: #089DA1;
        }

        .dropdown {
            margin: 10px 0;
        }

        .dropdown button {
            background-color: white;
            color:#089DA1;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 15px;
            height: 50px;
        }

        .dropdown-content {
            display: none;
            background-color: #f9f9f9;
            padding: 10px;
            border: 1px solid #ddd;
            margin-top: 5px;
        }

        .dropdown-content p {
            margin: 0;
            font-size: 14px;
        }

        .dropdown.active .dropdown-content {
            display: block;
        }

        .dropdown i {
            margin-left: 10px;
        }
    </style>
</head>

<body>
    <header>
        <div class="header-content">
            <a href="{{ route('welcome') }}" class="back-button"><i class="fas fa-arrow-left"></i></a>
            <h1>Bantuan</h1>
        </div>
    </header>

    <div class="shipping-address">
        <!-- Dropdown 1 -->
        <div class="dropdown">
            <button id="button1">
                Cara mencari produk di platform kami
                <i class="fas fa-chevron-down"></i>
            </button>
            <div id="dropdown1" class="dropdown-content">
                <p>Anda dapat menggunakan fitur pencarian yang terletak di bagian atas
                    <br> halaman untuk menemukan produk yang Anda inginkan.</p>
            </div>
        </div>

        <!-- Dropdown 2 -->
        <div class="dropdown">
            <button id="button2">
                Cara melakukan pembelian
                <i class="fas fa-chevron-down"></i>
            </button>
            <div id="dropdown2" class="dropdown-content">
                <p>Untuk melakukan pembelian, pilih produk yang ingin dibeli, tambahkan ke keranjang <br>
                atau beli langsung, lalu ikuti instruksi pembayaran di halaman checkout.</p>
            </div>
        </div>

        <!-- Dropdown 3 - Pertanyaan yang sering diajukan (FAQ) -->
        <div class="dropdown">
            <button id="button3">
                Pertanyaan yang sering diajukan (FAQ)
                <i class="fas fa-chevron-down"></i>
            </button>
            <div id="dropdown3" class="dropdown-content">
                <p>Di sini Anda dapat menemukan jawaban atas pertanyaan umum:</p>
                <strong>Metode Pembayaran:</strong>
                <p>Kami menerima metode pembayaran melalui transfer bank, kartu kredit, dan e-wallet.</p>
                <strong>Pengiriman:</strong>
                <p>Pengiriman dilakukan dalam 2-3 hari kerja setelah pembayaran dikonfirmasi.</p>
                <strong>Kebijakan Pengembalian:</strong>
                <p>Anda dapat mengembalikan produk dalam waktu 14 hari jika tidak sesuai atau rusak.</p>
            </div>
        </div>
             <!-- Dropdown 4 - Cara melihat transaksi -->
             <div class="dropdown">
                <button id="button4">
                    Cara melihat riwayat transaksi
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div id="dropdown4" class="dropdown-content">
                    <p>Jika anda ingin melihat riwayat transaksi, klik menu Transaksi</p>
                </div>
            </div>
             <!-- Dropdown 5 -  -->
             <div class="dropdown">
                <button id="button5">
                    Menu keranjang
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div id="dropdown5" class="dropdown-content">
                    <p>Ada menu keranjang disamping menu search, dimenu keranjang</p>
                    <p>anda dapat menambahkan beberapa produk yang ingin dibeli</p>
                </div>
            </div>
        </div>                 
                
    
    <script>
        // Fungsionalitas toggle dropdown sederhana
        document.getElementById('button1').addEventListener('click', function () {
            toggleDropdown('dropdown1');
        });

        document.getElementById('button2').addEventListener('click', function () {
            toggleDropdown('dropdown2');
        });

        document.getElementById('button3').addEventListener('click', function () {
            toggleDropdown('dropdown3');
        });
        document.getElementById('button4').addEventListener('click', function () {
            toggleDropdown('dropdown4');
        });
        document.getElementById('button5').addEventListener('click', function () {
            toggleDropdown('dropdown5');
        });

        function toggleDropdown(dropdownId) {
            var dropdown = document.getElementById(dropdownId);
            if (dropdown.style.display === "none" || dropdown.style.display === "") {
                dropdown.style.display = "block";
            } else {
                dropdown.style.display = "none";
            }
        }

        // Pastikan dropdown tertutup saat pertama kali di-load
        document.getElementById('dropdown1').style.display = 'none';
        document.getElementById('dropdown2').style.display = 'none';
        document.getElementById('dropdown3').style.display = 'none';
        document.getElementById('dropdown4').style.display = 'none';
        document.getElementById('dropdown5').style.display = 'none';
    </script>
</body>
</html>
