<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\PurchaseOrder;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function monthlyProductReport(Request $request)
{
    // Ambil bulan yang dipilih dari request, atau gunakan bulan saat ini sebagai default
    $month = $request->input('month', Carbon::now()->format('Y-m'));

    // Ambil transaksi yang terjadi pada bulan yang dipilih
    $transactions = Transaction::whereYear('created_at', Carbon::parse($month)->year)
        ->whereMonth('created_at', Carbon::parse($month)->month)
        ->get();

    // Ambil produk yang terkait dengan transaksi pada bulan tersebut
    $products = Product::select('products.name', 'products.price', 
            DB::raw('SUM(transaction_products.quantity) as total_sold'), 
            DB::raw('SUM(transaction_products.quantity * products.price) as total_earned'))
        ->join('transaction_products', 'products.id', '=', 'transaction_products.product_id')
        ->join('transactions', 'transaction_products.transaction_id', '=', 'transactions.id')
        ->whereYear('transactions.created_at', Carbon::parse($month)->year)
        ->whereMonth('transactions.created_at', Carbon::parse($month)->month)
        ->groupBy('products.id', 'products.name', 'products.price')
        ->havingRaw('SUM(transaction_products.quantity) > 0') // Hanya produk yang terjual
        ->get();

    return view('reports.monthly_product_report', compact('products', 'transactions', 'month'));
}


    public function monthlyStockReport(Request $request)
{
    // Ambil bulan yang dipilih dari request, atau gunakan bulan saat ini sebagai default
    $month = $request->input('month', Carbon::now()->format('Y-m'));

    // Tentukan tanggal awal dan akhir bulan
    $startDate = Carbon::parse($month)->startOfMonth();
    $endDate = Carbon::parse($month)->endOfMonth();

    // Query untuk menghitung stok masuk (dari pembelian PBF)
    $stockInSubquery = DB::table('purchase_order_items')
        ->select('product_id', DB::raw('COALESCE(SUM(quantity), 0) as stock_in'), DB::raw('COALESCE(SUM(price * quantity), 0) as total_purchase_price'))
        ->join('purchase_orders', 'purchase_order_items.purchase_order_id', '=', 'purchase_orders.id')
        ->whereBetween('purchase_orders.created_at', [$startDate, $endDate])
        ->groupBy('product_id');

    // Query untuk menghitung stok keluar (dari penjualan)
    $stockOutSubquery = DB::table('transaction_products')
        ->select('product_id', DB::raw('COALESCE(SUM(quantity), 0) as stock_out'))
        ->join('transactions', 'transaction_products.transaction_id', '=', 'transactions.id')
        ->whereBetween('transactions.created_at', [$startDate, $endDate])
        ->groupBy('product_id');

    // Query utama untuk mendapatkan data produk
    $products = Product::select(
        'products.name',
        'products.code',
        'categories.name as category',
        'products.unit',
        'products.price as sale_price',
        'products.stock as initial_stock',
        DB::raw('COALESCE(stock_in_table.stock_in, 0) as stock_in'), // Stok masuk
        DB::raw('COALESCE(stock_out_table.stock_out, 0) as stock_out'), // Stok keluar
        DB::raw('products.stock + COALESCE(stock_in_table.stock_in, 0) - COALESCE(stock_out_table.stock_out, 0) as ending_stock'), // Stok akhir
        DB::raw('COALESCE(stock_in_table.total_purchase_price / NULLIF(stock_in_table.stock_in, 0), 0) as purchase_price') // Harga beli
    )
    // Join dengan tabel kategori
    ->leftJoin('categories', 'products.category_id', '=', 'categories.id')

    // Left join dengan subquery stok masuk
    ->leftJoinSub($stockInSubquery, 'stock_in_table', function ($join) {
        $join->on('products.id', '=', 'stock_in_table.product_id');
    })

    // Left join dengan subquery stok keluar
    ->leftJoinSub($stockOutSubquery, 'stock_out_table', function ($join) {
        $join->on('products.id', '=', 'stock_out_table.product_id');
    })

    ->get();

    // Kembalikan hasil ke view laporan stok bulanan
    return view('reports.monthly_stock_report', compact('products', 'month'));
}



public function monthlySalesReport(Request $request)
{
    // Ambil bulan yang dipilih dari request, atau gunakan bulan saat ini sebagai default
    $month = $request->input('month', Carbon::now()->format('Y-m'));

    // Ambil total penjualan dan total pembayaran berdasarkan bulan yang dipilih
    $sales = Transaction::selectRaw('SUM(total_amount) as total_sales, SUM(amount_paid) as total_paid')
        ->whereYear('created_at', Carbon::parse($month)->year)
        ->whereMonth('created_at', Carbon::parse($month)->month)
        ->first();

    // Ambil total amount dari purchase_orders
    $totalPurchases = PurchaseOrder::whereYear('order_date', Carbon::parse($month)->year)
        ->whereMonth('order_date', Carbon::parse($month)->month)
        ->sum('total_amount');

    // Kirim data ke view
    return view('reports.monthly_sales_report', compact('sales', 'totalPurchases', 'month'));
}


    public function monthlyTransactionsReport(Request $request)
{
    // Ambil bulan yang dipilih dari request, atau gunakan bulan saat ini sebagai default
    $month = $request->input('month', Carbon::now()->format('Y-m'));

    // Query untuk mengambil semua transaksi pada bulan tersebut
    $transactions = Transaction::whereYear('created_at', Carbon::parse($month)->year)
        ->whereMonth('created_at', Carbon::parse($month)->month)
        ->with('products') // Pastikan relasi produk dimuat
        ->get();

    // Hitung total hasil transaksi untuk bulan yang dipilih
    $totalTransactions = $transactions->sum('total_amount');
    
    return view('reports.monthly_transactions_report', compact('transactions', 'totalTransactions', 'month'));
}

}


