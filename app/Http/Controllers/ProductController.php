<?php

namespace App\Http\Controllers;
use App\Models\StockMovement;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
   
    public function welcome()
    {
       // Mengambil semua kategori untuk ditampilkan di halaman home
    $categories = Category::all();

    // Mengambil kategori dengan nama "Vitamin"
    $category = Category::where('name', 'Vitamin')->first();

    // Jika kategori ditemukan, ambil produk dalam kategori tersebut
    if ($category) {
        $products = Product::where('category_id', $category->id)->paginate(10);
    } else {
        // Jika kategori "Vitamin" tidak ditemukan, tampilkan koleksi produk kosong
        $products = collect(); // Mengembalikan collection kosong jika tidak ada kategori
    }

    // Mengirimkan data kategori dan produk ke view
    return view('welcome', compact('categories', 'products'));
    }


    public function Category($id)
    {
         // Ambil kategori berdasarkan ID
         $category = Category::findOrFail($id);
    
         // Mengambil 20 produk berdasarkan kategori dengan paginasi
         $products = Product::where('category_id', $id)->paginate(28);
    
        return view('category-produk', compact('products', 'category'));
    }

    public function WelcomeIndex(Request $request)
    {
        $search = $request->input('search');
        
        // Query produk dengan pencarian
        if ($search) {
            $products = Product::where('name', 'like', "%{$search}%")
                ->orderBy('created_at', 'desc') // Urutkan produk berdasarkan yang paling terakhir
                ->paginate(4); // Paginate jika ada banyak produk
  } else {
            $products = Product::paginate(4); // Jika tidak ada pencarian, tampilkan semua produk
        }
    
        // Semua produk, tanpa filter pencarian, urutkan berdasarkan yang paling terakhir
        $allProducts = Product::orderBy('created_at', 'desc')->paginate(8);
    
        return view('welcome_index', compact('products', 'search', 'allProducts'));
    }

    public function Welcomeshow($id)
    {
        // Ambil produk berdasarkan ID
        $product = Product::findOrFail($id);
    
        return view('welcome_show', compact('product'));
    }

    public function kategoriwelcome($id)
    {
        // Ambil produk berdasarkan ID
        $product = Product::findOrFail($id);
    
        return view('kategori_welcome', compact('product'));
    }

    //home
    
    public function HomeIndex()
    {
        // Mengambil semua kategori untuk ditampilkan di halaman home
        $categories = Category::all();
    
        // Mengambil kategori dengan nama "Vitamin"
        $category = Category::where('name', 'Vitamin')->first();
    
        // Jika kategori ditemukan, ambil produk dalam kategori tersebut
        if ($category) {
            $products = Product::where('category_id', $category->id)->paginate(10);
        } else {
            // Jika kategori "Vitamin" tidak ditemukan, tampilkan koleksi produk kosong
            $products = collect(); // Mengembalikan collection kosong jika tidak ada kategori
        }
    
        // Mengirimkan data kategori dan produk ke view
        return view('home', compact('categories', 'products'));
    }
    

    
    public function showProductsByCategory($id)
    {
        // Ambil kategori berdasarkan ID
        $category = Category::findOrFail($id);
    
        // Mengambil 20 produk berdasarkan kategori dengan paginasi
        $products = Product::where('category_id', $id)->paginate(28);
    
        return view('products-by-category', compact('products', 'category'));
    }
    
    

    
    public function userIndex(Request $request)
    {
        $search = $request->input('search');
        
        // Query produk dengan pencarian
        if ($search) {
            $products = Product::where('name', 'like', "%{$search}%")
                ->orderBy('created_at', 'desc') // Urutkan produk berdasarkan yang paling terakhir
                ->paginate(4); // Paginate jika ada banyak produk
  } else {
            $products = Product::paginate(4); // Jika tidak ada pencarian, tampilkan semua produk
        }
    
        // Semua produk, tanpa filter pencarian, urutkan berdasarkan yang paling terakhir
        $allProducts = Product::orderBy('created_at', 'desc')->paginate(8);
    
        return view('user.products.index', compact('products', 'search', 'allProducts'));
    }
    

    public function Usershow($id)
    {
        // Ambil produk berdasarkan ID
        $product = Product::findOrFail($id);
    
        return view('user.products.show', compact('product'));
    }
    
    public function kategorihome($id)
    {
        // Ambil produk berdasarkan ID
        $product = Product::findOrFail($id);
    
        return view('kategori_home', compact('product'));
    }

    

    //admin
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:products',
            'batch_code' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'unit' => 'required',
            'expiration_date' => 'required|date',
            'weight' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string', 
            'dosage' => 'nullable|string',
        ]);
    
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
        }
    
        Product::create([
            'name' => $request->name,
            'code' => $request->code,
            'batch_code' => $request->batch_code, 
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'unit' => $request->unit,
            'expiration_date' => $request->expiration_date,
            'weight' => $request->weight,
            'image' => $imagePath,
            'description' => $request->description,
            'dosage' => $request->dosage,
           
        ]);
    
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');
    }
    


       public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
        
    }

       public function update(Request $request, Product $product)
{
    $request->validate([
        'name' => 'required',
        'code' => 'required|unique:products,code,'.$product->id,
        'batch_code' => 'required|string',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'category_id' => 'required|exists:categories,id',
        'unit' => 'required',
        'expiration_date' => 'required|date',
        'weight' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'description' => 'nullable|string',
        'dosage' => 'nullable|string',
         // Tambahkan validasi untuk batch_code
    ]);

    $imagePath = $product->image;
    if ($request->hasFile('image')) {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $imagePath = $request->file('image')->store('product_images', 'public');
    }

    $product->update([
        'name' => $request->name,
        'code' => $request->code,
        'batch_code' => $request->batch_code,
        'price' => $request->price,
        'stock' => $request->stock,
        'category_id' => $request->category_id,
        'unit' => $request->unit,
        'expiration_date' => $request->expiration_date,
        'weight' => $request->weight,
        'image' => $imagePath,
        'description' => $request->description,
        'dosage' => $request->dosage,
         // Perbarui batch_code
    ]);

    return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui');
}


    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus');
    }
}
