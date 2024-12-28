<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $lowStockProducts = Product::where('stock', '<=', 10)->get();
        $expiredProducts = Product::where('expiration_date', '<', now())->get();
        $nearExpirationProducts = Product::whereBetween('expiration_date', [now(), now()->copy()->addMonths(3)])->get();
        $nearExpirationProducts2 = Product::whereBetween('expiration_date', [now(), now()->copy()->addMonths(5)])->get();
        
        // Menambahkan total transaksi
        $totalTransactions = Transaction::count();
        
        // Menambahkan total user
        $totalUsers = User::count();
    
        return view('dashboardadmin.index', compact(
            'totalProducts', 
            'totalCategories', 
            'lowStockProducts', 
            'expiredProducts', 
            'nearExpirationProducts', 
            'nearExpirationProducts2', 
            'totalTransactions', 
            'totalUsers' // Sertakan total user
        ));
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
