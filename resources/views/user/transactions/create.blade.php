@php
    $totalWeight = $carts->reduce(function ($total, $cart) {
        return $total + $cart->product->weight * $cart->quantity;
    }, 0);
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Transaksi</title>
    <link rel="stylesheet" href="style4.css">
    <!-- Tambahkan Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Tambahkan Midtrans Snap.js -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <style>
        /* Style sebelumnya */
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

        .transaction-nav {
            background-color: #ffffff;
            color: rgb(181, 180, 180);
            padding: 10px 20px;
            display: flex;
            font-weight: lighter;
            margin-bottom: -10px;
        }

        .nav-item {
            text-align: left;
            padding: 5px;
        }

        .nav-item.product {
            flex: 3;
        }

        .nav-item+.nav-item {
            margin-left: 50px;
        }

        .nav-item:not(.product) {
            flex: 1;
            text-align: center;
        }

        main {
            padding: 20px;
        }

        .transaction-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            margin-bottom: -10px;
            border-bottom: 1px solid #ddd;
        }

        .transaction-item .item {
            text-align: center;
        }

        .transaction-item .product {
            display: flex;
            align-items: center;
            text-align: left;
            flex: 3;
        }

        .transaction-item .product img {
            width: 80px;
            height: auto;
            margin-right: 10px;
        }

        .transaction-item .product-name {
            font-weight: bold;
            margin: 0;
        }

        .transaction-item .price,
        .transaction-item .quantity,
        .transaction-item .subtotal {
            flex: 1;
            margin-left: 50px;
        }

        .main-content {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        .buyer-info {
            width: 60%;
        }

        .input-group {
            margin: 0 40px;
            width: 400px;
        }

        .payment-method,
        .summary,
        .button-container {
            width: 400px;
            margin-right: 50px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #777;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            height: 80px;
            /* Sesuaikan tinggi textarea jika perlu */
        }

        .summary {
            margin-bottom: 20px;
        }

        .summary label {
            display: block;
            margin-bottom: 5px;
            color: #777;
        }

        .summary input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            background-color: #f5f5f5;
            /* Warna latar belakang agar berbeda dengan input yang dapat diedit */
        }

        .button-container {
            display: flex;
            justify-content: flex-end;
            /* Menempatkan tombol di ujung kanan */
        }

        .checkout-button {
            padding: 15px;
            background-color: #089DA1;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
        }

        .checkout-button:hover {
            background-color: #007e87;
        }
    </style>
</head>

<body>
    <header>
        <div class="header-content">
            <a href="{{ route('cart.index') }}" class="back-button"><i class="fas fa-arrow-left"></i></a>
            <h1>Transaksi</h1>
        </div>
    </header>
    <nav class="transaction-nav">
        <div class="nav-item product">Produk yang Dipesan</div>
        <div class="nav-item">Harga Satuan</div>
        <div class="nav-item">Kuantitas</div>
        <div class="nav-item">Subtotal</div>
    </nav>

    <!-- Form untuk transaksi -->
    <form id="payment-form" method="POST" action="{{ route('user.transactions.process') }}">
    @csrf
    <main>
        <!-- Loop untuk produk yang dipesan -->
        @foreach ($carts as $cart)
            <!-- Menggunakan $cart->product->id karena $cart tidak memiliki properti product_id secara langsung -->
            <input type="hidden" name="product_id[]" value="{{ $cart->product->id }}">
            <input type="hidden" name="quantity[]" value="{{ $cart->quantity }}">
            <input type="hidden" name="price" value="{{ $cart->product->price * $cart->quantity }}">
            
            <div class="transaction-item">
                <div class="item product">
                    <img src="{{ asset('storage/' . $cart->product->image) }}" alt="{{ $cart->product->name }}">
                    <p class="product-name">{{ $cart->product->name }}</p>
                </div>
                <div class="item price">
                    <p>Rp {{ number_format($cart->product->price, 2, ',', '.') }}</p>
                </div>
                <div class="item quantity">
                    <p>{{ $cart->quantity }}</p>
                </div>
                <div class="item subtotal">
                    <p>Rp {{ number_format($cart->product->price * $cart->quantity, 2, ',', '.') }}</p>
                </div>
            </div>
        @endforeach
    </main>

       <!-- Bagian input informasi pembeli -->
<div class="main-content">
    <div class="buyer-info">
        <div class="input-group">
            <label for="buyerName">Nama Pembeli:</label>
            <input type="text" id="buyerName" name="customer_name" placeholder="Masukkan nama pembeli"
                value="{{ auth()->user()->name ?? '' }}" required>

            <label for="phone">No. Telepon:</label>
            <input type="text" id="phone" name="customer_phone" placeholder="Masukkan nomor telepon"
                value="{{ auth()->user()->phone ?? '' }}" required>

            <label for="destination_province">Ke Provinsi:</label>
            <select id="destination_province" name="destination_province" required>
                <option value="">Pilih Provinsi</option>
                @foreach ($provinces as $province)
                    <option value="{{ $province['province_id'] }}">{{ $province['province'] }}</option>
                @endforeach
            </select>

            <label for="destination_city">ke Kota:</label>
            <select id="destination_city" name="destination_city" required>
                <option value="">Pilih Kota</option>
            </select>

            <label for="ekspedisi">Ekspedisi:</label>
            <select id="ekspedisi" name="ekspedisi" required>
                <option value="">Pilih Opsi</option>
                <option value="jne">JNE</option>
                <option value="tiki">Tiki</option>
                <option value="pos">POS</option>
            </select>
        </div>
    </div>

    <div class="order-summary">
        <label for="service">Layanan:</label>
        <select id="service" name="service" required>
            <option value="">Pilih Layanan Pengiriman</option>
            @if (isset($shippingCost))
                <!-- Tambahkan opsi layanan pengiriman sesuai kebutuhan -->
            @else
                <option value="" disabled>Belum ada layanan pengiriman tersedia</option>
            @endif
        </select>

        <label for="address">Alamat:</label>
        <textarea id="address" name="customer_address" placeholder="Masukkan alamat pengiriman" required>{{ auth()->user()->address ?? '' }}</textarea>

        <div class="summary">
            <label for="totalPrice">Total Harga:</label>
            <input type="hidden" id="totalPriceHidden" name="totalPrice" value="{{ $totalPrice }}" readonly>
            <input type="text" id="totalPriceInput" name="totalPriceDisplay"
                value="Rp {{ number_format($totalPrice, 2, ',', '.') }}" readonly>
        </div>

        <div class="button-container">
            <button type="submit" class="checkout-button">Selesaikan Pembayaran</button>
        </div>
    </div>
</div>



    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
    </script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const totalWeight = @json($totalWeight); // Use the PHP calculated value
            console.log('Total Weight:', totalWeight);

            const destinationProvinceSelect = document.getElementById('destination_province');
            const destinationCitySelect = document.getElementById('destination_city');
            const serviceSelect = document.getElementById(
                'service'); // Add this to reference the service select element

            // Check if these elements exist
            if (!destinationProvinceSelect || !destinationCitySelect || !serviceSelect) {
                console.error('Required form elements are not found.');
                return;
            }

            const cities = @json($city); // Mengambil data kota dari PHP ke JavaScript
            const provinces = @json($province); // Mengambil data provinsi dari PHP ke JavaScript

            // Function to populate cities based on province ID
            function populateCities(provinceId, selectElement) {
                selectElement.innerHTML = '<option value="">Pilih Kota</option>';
                const filteredCities = cities.filter(city => city.province_id == provinceId);
                filteredCities.forEach(city => {
                    selectElement.innerHTML += `<option value="${city.city_id}">${city.city_name}</option>`;
                });
            }

            // Populate cities when the province is selected
            destinationProvinceSelect.addEventListener('change', function() {
                populateCities(this.value, destinationCitySelect);
            });

            async function fetchOngkir() {
                const origin = "36"; // Replace with your actual element ID
                const destination = document.getElementById('destination_city').value;
                const courier = document.getElementById('ekspedisi').value;

                console.log("Destination:", destination, "Courier:", courier); // For debugging

                try {
                    const response = await fetch('http://127.0.0.1:8000/api/ongkir', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            origin: origin,
                            destination: destination,
                            weight: totalWeight,
                            courier: courier
                        })
                    });

                    const data = await response.json();
                    console.log('Shipping Data:', data); // Log the response to see if it's correct

                    if (data.results && data.results[0] && data.results[0].costs) {
                        populateShippingOptions(data.results[0].costs);
                    } else {
                        console.error("No shipping options found.");
                    }

                } catch (error) {
                    console.error('Error fetching ongkir:', error);
                }
            }

            function populateShippingOptions(costs) {
                const serviceSelect = document.getElementById('service');
                serviceSelect.innerHTML =
                '<option value="" data-cost="0">Pilih Layanan Pengiriman</option>'; // Reset options

                costs.forEach(cost => {
                    const service = cost.service;   
                    const description = cost.description;
                    const price = cost.cost[0].value;
                    const etd = cost.cost[0].etd;

                    // Create a new option for each shipping service
                    const option = document.createElement('option');
                    option.value = service; // Use the service code as the value
                    option.setAttribute('data-cost', price); // Set data-cost attribute for price
                    option.text = `${service} - ${description} (${price} IDR, Estimasi: ${etd} hari)`;

                    serviceSelect.appendChild(option);
                });
            }



            // Fetch ongkir when destination city or courier is selected
            destinationCitySelect.addEventListener('change', fetchOngkir);
            document.getElementById('ekspedisi').addEventListener('change', fetchOngkir);

            // Update total price when the service is selected
            serviceSelect.addEventListener('change', function() {
                let shippingCost = parseFloat(this.options[this.selectedIndex].getAttribute('data-cost')) ||
                    0;
                let totalPrice = parseFloat({{ $totalPrice }}); // Get the total price from the server

                // Calculate the new total (product price + shipping cost)
                let finalTotal = totalPrice + shippingCost;

                // Update the total price input field
                document.getElementById('totalPriceInput').value = 'Rp ' + finalTotal.toLocaleString(
                    'id-ID', {
                        minimumFractionDigits: 2
                    });
                document.getElementById('totalPriceHidden').value = finalTotal;
            });
        });
    </script>
</body>

</html>
