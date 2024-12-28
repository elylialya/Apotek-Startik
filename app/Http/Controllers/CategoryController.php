<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);
    
        // Mengupload gambar jika ada
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/categories'), $imageName);
        }
    
        // Menyimpan kategori dengan gambar
        Category::create([
            'name' => $request->name,
            'image' => isset($imageName) ? $imageName : null, // Simpan nama file gambar
        ]);
    
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan');
    }
    
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);
    
        // Mengupload gambar baru jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($category->image) {
                unlink(public_path('images/categories/' . $category->image));
            }
            
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/categories'), $imageName);
            $category->image = $imageName; // Update nama file gambar
        }
    
        $category->name = $request->name; // Update nama kategori
        $category->save(); // Simpan perubahan
    
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui');
    }
    
    public function edit($id)
{
    // Temukan kategori berdasarkan ID
    $category = Category::findOrFail($id);

    // Kembalikan view untuk mengedit kategori, dengan data kategori yang ditemukan
    return view('categories.edit', compact('category'));
}


    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus');
    }
}
