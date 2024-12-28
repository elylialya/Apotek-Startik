<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    
   public function index()
   {
       // Mengambil semua item keranjang milik pengguna yang sedang login
       $carts = Cart::where('user_id', auth()->id())->with('product')->get();
       return view('user.cart.index', compact('carts'));
   }

   /**
    * Menambahkan produk ke keranjang.
    */
   public function store(Request $request)
   {
       $validated = $request->validate([
           'product_id' => 'required|exists:products,id',
           'quantity' => 'required|integer|min:1',
       ]);

       // Memperbarui atau membuat item keranjang baru
       $cart = Cart::updateOrCreate(
           ['user_id' => auth()->id(), 'product_id' => $validated['product_id']],
           ['quantity' => $validated['quantity']]
       );

       return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang');
   }


   
   public function processSelectedItems(Request $request)
   {
       // Validasi input, memastikan ada ID keranjang yang dipilih
   $validatedData = $request->validate([
       'cart_ids' => 'required|array', // Mengharapkan array ID keranjang yang dipilih
       'cart_ids.*' => 'exists:carts,id', // Validasi bahwa setiap ID keranjang ada di tabel carts
   ]);

   // Ambil produk keranjang yang dipilih berdasarkan ID
   $selectedCarts = Cart::whereIn('id', $validatedData['cart_ids'])->get();

   // Hitung total harga berdasarkan produk yang dicentang
   $totalPrice = $selectedCarts->sum(function ($cart) {
       return $cart->product->price * $cart->quantity;
   });

   // Simpan ID keranjang yang dipilih dan total harga ke dalam sesi untuk checkout
   session([
       'selected_cart_ids' => $validatedData['cart_ids'],
       'total_price' => $totalPrice,
   ]);


   // Redirect ke halaman transaksi
   return redirect()->route('user.transactions.create');
   }
   /**
    * 
    * Menghapus produk dari keranjang.
    */
   public function destroy($id)
   {
       // Menghapus item keranjang berdasarkan ID dan user yang sedang login
       $cart = Cart::where('user_id', auth()->id())->where('id', $id)->firstOrFail();
       $cart->delete();
       return redirect()->back()->with('success', 'Produk dihapus dari keranjang');
   }

   public function incrementQuantity($id)
    {
        $cart = Cart::where('user_id', auth()->id())->where('id', $id)->firstOrFail();
        $product = $cart->product;

        if ($cart->quantity < $product->stock) {
            $cart->quantity++;
            $cart->save();
        }

        return redirect()->route('cart.index')->with('success', 'Kuantitas produk berhasil ditambah');
    }

    /**
     * Mengurangi kuantitas produk dalam keranjang.
     */
    public function decrementQuantity($id)
    {
        $cart = Cart::where('user_id', auth()->id())->where('id', $id)->firstOrFail();

        if ($cart->quantity > 1) {
            $cart->quantity--;
            $cart->save();
        } else {
            return redirect()->route('cart.destroy', $cart->id);
        }

        return redirect()->route('cart.index')->with('success', 'Kuantitas produk berhasil dikurangi');
    }
}