<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{


    public function create()
    {
        $products = Product::all();
        return view('purchase_orders.create', compact('products'));
    }

    // app/Http/Controllers/PurchaseOrderController.php

// app/Http/Controllers/PurchaseOrderController.php

public function store(Request $request)
{
    $request->validate([
        'supplier_name' => 'required|string',
        'supplier_id' => 'required|numeric',
        'total_amount' => 'required|numeric',
        'status' => 'required',
        'order_date' => 'required|date',
        'products' => 'required|array',
        'products.*.product_id' => 'required|exists:products,id',
        'products.*.quantity' => 'required|integer|min:1',
        'products.*.price' => 'required|numeric|min:0',
    ]);

    $purchaseOrder = PurchaseOrder::create([
        'supplier_id' => $request->supplier_id,
        'supplier_name' => $request->supplier_name, // Pastikan nilai ini selalu diisi
        'total_amount' => $request->total_amount,
        'status' => $request->status,
        'order_date' => $request->order_date
    ]);

    foreach ($request->products as $product) {
        PurchaseOrderItem::create([
            'purchase_order_id' => $purchaseOrder->id,
            'product_id' => $product['product_id'],
            'quantity' => $product['quantity'],
            'price' => $product['price'],
        ]);

        // Update stock produk
        $productModel = Product::find($product['product_id']);
        $productModel->stock += $product['quantity'];
        $productModel->save();
    }

    return redirect()->route('purchase_orders.index')->with('success', 'Pesanan pembelian berhasil dibuat!');
}


    public function index()
    {
        $purchaseOrders = PurchaseOrder::with('items.product')->get();
        return view('purchase_orders.index', compact('purchaseOrders'));
    }

    public function search(Request $request)
{
    // Mengambil input pencarian produk
    $productSearch = $request->input('product_search');

    // Filter produk berdasarkan pencarian jika ada input; jika tidak, ambil semua produk
    $products = Product::when($productSearch, function ($query, $productSearch) {
        return $query->where('name', 'LIKE', '%' . $productSearch . '%');
    })->get();

    return view('purchase_orders.create', compact('products', 'productSearch'));
}

public function edit($id)
{
    $purchaseOrder = PurchaseOrder::with('items.product')->findOrFail($id);
    $products = Product::all();
    
    return view('purchase_orders.edit', compact('purchaseOrder', 'products'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'supplier_name' => 'required|string',
        'supplier_id' => 'required|numeric',
        'total_amount' => 'required|numeric',
        'status' => 'required',
        'order_date' => 'required|date',
        'products' => 'required|array',
        'products.*.product_id' => 'required|exists:products,id',
        'products.*.quantity' => 'required|integer|min:1',
        'products.*.price' => 'required|numeric|min:0',
    ]);

    $purchaseOrder = PurchaseOrder::findOrFail($id);
    $purchaseOrder->update([
        'supplier_id' => $request->supplier_id,
        'supplier_name' => $request->supplier_name,
        'total_amount' => $request->total_amount,
        'status' => $request->status,
        'order_date' => $request->order_date
    ]);

    // Hapus item lama
    $purchaseOrder->items()->delete();

    // Tambahkan item baru
    foreach ($request->products as $product) {
        PurchaseOrderItem::create([
            'purchase_order_id' => $purchaseOrder->id,
            'product_id' => $product['product_id'],
            'quantity' => $product['quantity'],
            'price' => $product['price'],
        ]);

        // Update stock produk
        $productModel = Product::find($product['product_id']);
        $productModel->stock += $product['quantity'];
        $productModel->save();
    }

    return redirect()->route('purchase_orders.index')->with('success', 'Pesanan pembelian berhasil diperbarui!');
}

public function destroy($id)
{
    $purchaseOrder = PurchaseOrder::findOrFail($id);

    // Hapus item terkait
    $purchaseOrder->items()->delete();

    // Hapus pesanan pembelian
    $purchaseOrder->delete();

    return redirect()->route('purchase_orders.index')->with('success', 'Pesanan pembelian berhasil dihapus!');
}

}


