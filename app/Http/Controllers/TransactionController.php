<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Cart;
use App\Models\TransactionDetail;
use App\Models\Product;
use App\Models\TransactionProducts;
use Midtrans\Midtrans;
use Midtrans\Config;
use Midtrans\Snap;
// use RajaOngkir\RajaOngkir;
use Nekoding\Rajaongkir\Rajaongkir;
// use Nekoding\Rajaongkir\Facades\RajaOngkir;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // Menampilkan semua transaksi untuk user biasa


    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    // Menampilkan semua transaksi untuk user biasa
    public function userIndex()
    {
        $transactions = Transaction::where('user_id', auth()->id())->with('transactionDetails.product')->get();
        return view('user.transactions.index', compact('transactions'));
    }


    public function process(Request $request)
    {
        // dd($request->all());
        $data = $request->all();

        $transaction = Transaction::create([
            'user_id' => auth()->user()->id,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'total_amount' => $request->totalPrice,
            'amount_paid' => $request->totalPrice,
            'payment_method' => 'gopay',
            'shipping_option' => $request->service
        ]);

        foreach ($request->product_id as $index => $product_id) {
            $transactionProduct = TransactionProducts::create([
                'transaction_id' => $transaction->id,
                'product_id' => $product_id,
                'quantity' => $request->quantity[$index], // Get corresponding quantity for the product
                'price' => $request->price
            ]);
        }

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $transaction->amount_paid,
            ),
            'customer_details' => array(
                'first_name' => Auth::user()->username,
                'email' => Auth::user()->email
            )
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        $transaction->snap_token = $snapToken;
        $transaction->save();

        return redirect()->route('user.transactions.checkout', $transaction->id);
    }

    public function checkout(Transaction $transaction)
    {
        $products = config('products');
        $product = collect($products)->firstWhere('id', $transaction->product_id);

        return view('user.transactions.checkout',  compact('transaction', 'product'));
    }

    public function success(Transaction $transaction)
    {
        // Ubah status transaksi menjadi 'success'
        $transaction->status = 'success';
        $transaction->save();
    
        // Ambil semua produk yang terlibat dalam transaksi
        $transactionProducts = TransactionProducts::where('transaction_id', $transaction->id)->get();
    
        foreach ($transactionProducts as $transactionProduct) {
            // Ambil data produk berdasarkan ID
            $product = Product::where('id', $transactionProduct->product_id)->first();
    
            if ($product) {
                // Kurangi stok produk sesuai dengan jumlah dalam transaksi
                $product->stock -= $transactionProduct->quantity;
    
                // Simpan pembaruan stok
                $product->save();
            }
    
            // Cek apakah transaksi ini berasal dari keranjang atau pembelian langsung
            if (!session()->has('direct_purchase_product') || session('direct_purchase_product.product_id') != $transactionProduct->product_id) {
                // Hapus produk dari keranjang hanya jika bukan dari pembelian langsung
                Cart::where('user_id', auth()->id())
                    ->where('product_id', $transactionProduct->product_id)
                    ->delete();
            }
        }
    
        // Redirect ke halaman riwayat transaksi
        return redirect('/user/transactions/history')->with('success', 'Transaksi berhasil dan produk telah dihapus dari keranjang.');
    }
    
    public function userCreate(Request $request, Transaction $transaction)
    {
        $carts = collect(); // Koleksi item keranjang sementara
    $totalPrice = 0; // Total harga awal
    
    // Penanganan untuk tombol "Beli Langsung"
    if ($request->has('product_id')) {
        // Validasi input dari pembelian langsung
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Ambil detail produk berdasarkan product_id
        $product = Product::find($validated['product_id']);
        $totalPrice = $product->price * $validated['quantity']; // Hitung total harga

        // Tambahkan produk ke dalam koleksi sementara untuk pembelian langsung
        $carts->push((object)[
            'id' => null, // Tidak ada ID keranjang karena ini pembelian langsung
            'product' => $product,
            'quantity' => $validated['quantity'],
        ]);

        // Simpan detail produk yang akan dibeli secara langsung ke dalam session
        session([
            'direct_purchase_product' => [
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'price' => $product->price,
            ],
            'total_price' => $totalPrice,
        ]);
    
       // Penanganan pembelian langsung tidak akan menghapus sesi keranjang yang ada
    } else {
        // Penanganan untuk pembelian melalui keranjang
        $cartIds = session('selected_cart_ids', $request->input('selected_carts', []));

        // Ambil semua produk yang ada di keranjang berdasarkan ID
        $carts = Cart::whereIn('id', $cartIds)
                    ->where('user_id', auth()->id())
                    ->with('product')
                    ->get();

        // Jika tidak ada produk di keranjang, arahkan kembali ke halaman keranjang
        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada item yang dipilih untuk transaksi.');
        }

        // Hitung total harga untuk semua produk di keranjang
        $totalPrice = $carts->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
    }

    
        // Ambil data provinsi dan kota dari API RajaOngkir
        \Nekoding\Rajaongkir\Utils\Config::setApiKey(env('RAJAONGKIR_API_KEY'));
        \Nekoding\Rajaongkir\Utils\Config::setApiMode(env('RAJAONGKIR_API_MODE'));
    
        $city = Rajaongkir::city()->get();
        $province = RajaOngkir::province()->get();
    
        // Ambil biaya pengiriman dari session (jika sudah ada)
        $shippingCost = session('cost');
    
        // Kirim data ke view halaman transaksi
        return view('user.transactions.create', [
            'carts' => $carts, // Produk yang akan ditransaksikan
            'totalPrice' => $totalPrice, // Total harga keseluruhan
            'transaction' => $transaction, // Model transaksi
            'city' => $city['results'], // Data kota dari RajaOngkir
            'provinces' => $province['results'], // Data provinsi dari RajaOngkir
            'shippingCost' => $shippingCost, // Biaya pengiriman
        ]);
    }
    

    public function getOngkir(Request $request)
    {
        \Nekoding\Rajaongkir\Utils\Config::setApiKey(env('RAJAONGKIR_API_KEY'));
        \Nekoding\Rajaongkir\Utils\Config::setApiMode(env('RAJAONGKIR_API_MODE'));

        $origin = $request->input('origin'); // Your store's city ID
        $destination = $request->input('destination'); // User's selected city ID
        $weight = $request->input('weight'); // Total weight of the products in grams
        $courier = $request->input('courier'); // e.g., 'jne', 'tiki', 'pos'

        $cost = Rajaongkir::cost()
            ->setOrigin($origin)
            ->setDestination($destination)
            ->setWeight($weight)
            ->setCourier($courier)
            ->get();

        session(['cost' => $cost]);

        return response()->json($cost);
    }

    // Menyimpan transaksi baru untuk user biasa
    public function userStore(Request $request)
    {
        $validatedData = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:15',
            'customer_address' => 'required|string|max:255',
            'payment_method' => 'required|in:cod,credit_card,bank_transfer,gopay,dana',
            'amount_paid' => 'required|numeric|min:0',
            'shipping_option' => 'required|in:ambil di tempat,gojek,grab,jne',
        ]);

        $directPurchase = session('direct_purchase_product');
        $totalPrice = $directPurchase ? $directPurchase['price'] * $directPurchase['quantity'] : Cart::whereIn('id', session('selected_cart_ids', []))->where('user_id', auth()->id())->with('product')->get()->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Ensure totalPrice is at least 0.01
        $totalPrice = max($totalPrice, 0.01);

        // Round totalPrice to an integer for IDR currency
        $totalPrice = round($totalPrice);

        // Debugging: Check the totalPrice before sending to Midtrans
        \Log::info('Total Price for Midtrans: ' . $totalPrice);

        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'customer_name' => $validatedData['customer_name'],
            'customer_phone' => $validatedData['customer_phone'],
            'customer_address' => $validatedData['customer_address'],
            'total_amount' => $totalPrice + $request->service,
            'amount_paid' => $validatedData['amount_paid'],
            'payment_method' => $validatedData['payment_method'],
            'shipping_option' => $validatedData['shipping_option'],
            'shipping_status' => 'menunggu',
        ]);

        if ($directPurchase) {
            $product = Product::find($directPurchase['product_id']);
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $product->id,
                'quantity' => $directPurchase['quantity'],
                'price' => $product->price,
                'subtotal' => $product->price * $directPurchase['quantity'],
            ]);
            $product->decrement('stock', $directPurchase['quantity']);
            session()->forget('direct_purchase_product');
        } else {
            $carts = Cart::whereIn('id', session('selected_cart_ids', []))->where('user_id', auth()->id())->with('product')->get();
            foreach ($carts as $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'subtotal' => $item->product->price * $item->quantity,
                ]);
                $item->product->decrement('stock', $item->quantity);
            }
            Cart::whereIn('id', session('selected_cart_ids', []))->where('user_id', auth()->id())->delete();
            session()->forget('selected_cart_ids');
        }

        $paymentData = [
            'transaction_details' => [
                'order_id' => $transaction->id,
                'gross_amount' => $totalPrice,
            ],
        ];

        if ($validatedData['payment_method'] == 'credit_card') {
            $paymentData['credit_card'] = ['secure' => true];
        } elseif ($validatedData['payment_method'] == 'gopay') {
            $paymentData['gopay'] = [];
        } elseif ($validatedData['payment_method'] == 'dana') {
            $paymentData['dana'] = [];
        }

        $midtrans = new \Midtrans\Snap();
        try {
            $snapToken = $midtrans->createTransaction($paymentData);

            // Debugging: Check the response from Midtrans
            \Log::info('SnapToken Response: ' . print_r($snapToken, true));

            // Redirect to Midtrans payment page
            return redirect()->to($snapToken->redirect_url);
        } catch (\Exception $e) {
            return redirect()->route('user.transactions.show', $transaction->id)
                ->with('success', 'Transaksi berhasil diselesaikan.');
        }
    }


    // Mendapatkan biaya pengiriman menggunakan RajaOngkir
    // public function getShippingCost(Request $request)
    // {
    //     $request->validate([
    //         'origin' => 'required',
    //         'destination' => 'required',
    //         'weight' => 'required|numeric',
    //         'courier' => 'required',
    //     ]);

    //     $rajaOngkir = new RajaOngkir();
    //     $rajaOngkir->setApiKey(config('services.rajaongkir.api_key'));
    //     $response = $rajaOngkir->getCost([
    //         'origin' => $request->origin,
    //         'destination' => $request->destination,
    //         'weight' => $request->weight,
    //         'courier' => $request->courier,
    //     ]);

    //     return response()->json($response);
    // }

    // Menampilkan detail transaksi untuk user biasa
    public function userHistory()
    {
        // Mengambil ID user yang sedang login
        $userId = auth()->id();
    
        // Mengambil semua transaksi milik user yang sedang login beserta relasi user dan detail produk
        $transactions = Transaction::where('user_id', $userId)
            ->with(['user', 'transactionDetails.product']) // Relasi ke model User dan transactionDetails
            ->latest()
            ->get();
    
        // Mengirim data transaksi ke view
        return view('user.transactions.history', compact('transactions'));
    }
    
    // Menampilkan detail transaksi untuk user biasa
    public function userShow($id)
    {
        $transaction = Transaction::where('id', $id)
            ->where('user_id', auth()->user()->id)
            ->firstOrFail();

        $transactionProduct = TransactionProducts::where('transaction_id', $transaction->id)->get();

        return view('user.transactions.show', compact('transaction', 'transactionProduct'));
    }



    // Menampilkan semua transaksi untuk admin
    public function index()
    {
        $transactions = Transaction::with('transactionDetails.product')->latest()->get();
        return view('transactions.index', compact('transactions'));
    }

    public function create(Request $request)
    {
        // Ambil query search dari input
        $search = $request->input('search');
        
        // Lakukan pencarian produk jika ada query
        $products = Product::query()
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->get();
        
        // Kembalikan view beserta data produk dan query search untuk request normal
        return view('transactions.create', compact('products', 'search'));
    }
    

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'customer_name' => 'required|string|max:255', // Add validation for customer_name
        'product_ids' => 'required|array',
        'product_ids.*' => 'exists:products,id',
        'quantities' => 'required|array',
        'quantities.*' => 'required|integer|min:1',
        'total_amount' => 'required|numeric|min:0',
        'payment_method' => 'required|in:cash,credit_card,bank_transfer',
    ]);

    // Create a new transaction
    $transaction = Transaction::create([
        'user_id' => auth()->id(),
        'customer_name' => $validatedData['customer_name'], // Save the customer name
        'total_amount' => $validatedData['total_amount'],
        'amount_paid' => $validatedData['total_amount'],
        'payment_method' => $validatedData['payment_method'],
        'shipping_option' => null,
        'shipping_status' => 'completed',
    ]);

    foreach ($validatedData['product_ids'] as $index => $productId) {
        $product = Product::find($productId);
        $quantity = $validatedData['quantities'][$index];

        // Add to transaction products
        TransactionProducts::create([
            'transaction_id' => $transaction->id,
            'product_id' => $productId,
            'quantity' => $quantity,
            'price' => $product->price,
            'subtotal' => $product->price * $quantity,
        ]);

        // Decrease product stock
        $product->decrement('stock', $quantity);
    }

    return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diselesaikan.');
}





    public function status()
    {
        // Mengambil data transaksi dengan detail produk
        $transactions = Transaction::with('transactionDetails.product')->latest()->get();

        // Mengirim data transaksi ke view 'transactions.status'
        return view('transactions.status', compact('transactions'));
    }

    // TransactionController.php
    public function updateShippingStatus(Request $request, $id)
    {
        $request->validate([
            'shipping_status' => 'required|in:menunggu,dikirim,sampai,dibatalkan',
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->shipping_status = $request->input('shipping_status');
        $transaction->save();

        // Log untuk debugging
        \Log::info("Transaction ID $id updated with status: " . $transaction->shipping_status);

        return redirect()->route('transactions.status')
            ->with('success', 'Status pengiriman berhasil diperbarui.');
    }


    public function show($id)
    {
        $transaction = Transaction::with('transactionDetails.product')->findOrFail($id);
        return view('transactions.show', compact('transaction'));
    }


    public function destroy($id)
{
    // Temukan transaksi berdasarkan ID
    $transaction = Transaction::findOrFail($id);

    // Hapus detail transaksi yang berelasi dengan transaksi
    foreach ($transaction->transactionDetails as $detail) {
        $detail->delete(); // Hapus detail satu per satu
    }

    // Hapus transaksi
    $transaction->delete();

    // Redirect kembali ke halaman index transaksi dengan pesan sukses
    return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
}

    // Menampilkan halaman formulir return
    public function returnForm($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->is_returned) {
            return redirect()->route('transactions.index')
                ->with('error', 'Transaksi ini sudah pernah dikembalikan.');
        }

        return view('transactions.return_form', compact('transaction'));
    }

    // Memproses return transaksi
    public function returnTransaction(Request $request, $id)
    {
        $request->validate([
            'return_reason' => 'required|string|max:255',
        ]);

        $transaction = Transaction::findOrFail($id);

        if ($transaction->is_returned) {
            return redirect()->route('transactions.index')
                ->with('error', 'Transaksi ini sudah pernah dikembalikan.');
        }

        // Mengembalikan stok produk
        $transactionProducts = TransactionProducts::where('transaction_id', $transaction->id)->get();

        foreach ($transactionProducts as $detail) {
            $product = Product::find($detail->product_id);
            if ($product) {
                $product->increment('stock', $detail->quantity);
            }
        }

        $transaction->update([
            'is_returned' => true,
            'return_reason' => $request->return_reason,
            'return_date' => now(),
        ]);

        return redirect()->route('transactions.return.history')
            ->with('success', 'Transaksi berhasil dikembalikan.');
    }

    public function returnHistory()
    {
        // Ambil semua transaksi yang telah dikembalikan (is_returned = true)
        $transactions = Transaction::where('is_returned', true)
            ->with('transactionDetails.product')
            ->get();

        // Konversi return_date menjadi objek Carbon untuk setiap transaksi
        foreach ($transactions as $transaction) {
            $transaction->return_date = Carbon::parse($transaction->return_date);
        }

        // Tampilkan view dengan data transaksi yang telah dikembalikan
        return view('transactions.return_history', compact('transactions'));
    }
}
