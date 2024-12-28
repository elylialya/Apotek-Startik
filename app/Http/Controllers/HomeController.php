<?php
 
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
 
class HomeController extends Controller
{
  public function index()
{
    // Mendapatkan kategori dengan nama "Vitamin"
    $category = Category::where('name', 'Vitamin')->first();

    // Jika kategori ditemukan, ambil semua produk dalam kategori tersebut
    if ($category) {
        $products = Product::where('category_id', $category->id)->paginate(10);
    } else {
        // Jika kategori tidak ditemukan, tampilkan koleksi produk kosong
        $products = collect();
    }

    // Mengirimkan data produk ke view
    return view('home', compact('products'));
}
  
    

}