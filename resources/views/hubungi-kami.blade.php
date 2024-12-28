<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hubungi-kami</title>
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
            width: 1165px;
            padding: 30px;
            border: 6px solid #089DA1;
            border-radius: 100px;
            background-color: #ffffff;
            margin-left: 20px;
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

        .shipping-partners {
            margin-top: 20px;
        }
        .shipping-partners img {
            width: 100px; /* Atur lebar gambar sesuai kebutuhan */
            margin: 0 400px; /* Jarak antar gambar */

        }

        .shipping-partners img{
            width: 30%;
            margin-left: 35%;
        }
    </style>
</head>

<body>
    <header>
        <div class="header-content">
            <a href="{{ route('welcome') }}" class="back-button"><i class="fas fa-arrow-left"></i></a>
            <h1>Hubungi Kami</h1>
        </div>
    </header>
    <div class="shipping-address">
    <h1>Hubungi Kami</h1>
    <p>Jika Anda memiliki pertanyaan atau membutuhkan bantuan, silakan hubungi kami melalui informasi berikut:</p>
    <ul>
        <li>Email: cintasehat@gmail.com</li><br>
        <li>Telepon: +62 853-4720-3752 (Chandra Wijaya)</li><br>
        <li>Alamat: Jalan No.2 RT. 11, Antasan Kecil Timur, Kec. Banjarmasin Utara, Kota Banjarmasin, Kalimantan Selatan 70123</li><br>
        <li>Jam Operasional 08.00 - 22.00</li>
    </ul>
    </div>
    <div class="shipping-partners">
    <img src="asset/apotek cinta sehat.jpg">

    </div>
</body>

</html>
