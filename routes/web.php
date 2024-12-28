
<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
 
Route::get('/', [ProductController::class, 'welcome'])->name('welcome');
Route::get('/category/{id}/produk', [ProductController::class, 'Category'])->name('category.produk');
Route::get('/search', [ProductController::class, 'WelcomeIndex'])->name('welcome.search');
Route::get('/kategori/welcome/{id}', [ProductController::class, 'kategoriwelcome'])->name('kategori.welcome');
Route::get('/product/{id}', [ProductController::class, 'Welcomeshow'])->name('welcome.show');
Route::get('/hubungi-kami', function () {return view('hubungi-kami');})->name('hubungi-kami');
Route::get('/bantuan', function () {return view('bantuan');})->name('bantuan');
Route::get('/pengiriman', function () {return view('pengiriman');})->name('pengiriman-cepat');
Route::get('/layanan', function () { return view('layanan');})->name('layanan-24x7');
Route::get('/penawaran', function () {return view('penawaran');})->name('penawaran-terbaik');


 
Route::get('/about', [UserController::class, 'about'])->name('about');
 
Route::controller(AuthController::class)->group(function () {
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');
 
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');
 
    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});



//Normal Users Routes List
Route::middleware(['auth', 'user-access:user'])->group(function () {
    Route::get('/home', [ProductController::class, 'HomeIndex'])->name('home');
    Route::get('/hubungi-kami-home', function () {return view('hubungi-home');})->name('hubungi-home');
    Route::get('/bantuan-home', function () {return view('bantuan-home');})->name('bantuan-home');
    Route::get('/pengiriman-home', function () {return view('pengiriman-home');})->name('pengiriman-home');
    Route::get('/layanan-home', function () { return view('layanan-home');})->name('layanan-home');
    Route::get('/penawaran-home', function () {return view('penawaran-home');})->name('penawaran-home');
    Route::get('/products/category/{id}', [ProductController::class, 'showProductsByCategory'])->name('products.byCategory');
    Route::get('/kategori/home/{id}', [ProductController::class, 'kategorihome'])->name('kategori.home');
    


    Route::get('/userprofile', [UserController::class, 'index'])->name('user.profile');
    Route::post('/profile', [UserController::class, 'store'])->name('user.profile.store');
    
    // Route untuk melihat produk
    Route::get('/products/user', [ProductController::class, 'userIndex'])->name('products.userIndex');
    Route::get('/user/products/{id}', [ProductController::class, 'Usershow'])->name('user.products.show');
   

    // Route untuk transaksi yang dilakukan oleh user biasa

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/process-selected', [CartController::class, 'processSelectedItems'])->name('cart.processSelected');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::patch('/cart/increment/{id}', [CartController::class, 'incrementQuantity'])->name('cart.increment');
    Route::patch('/cart/decrement/{id}', [CartController::class, 'decrementQuantity'])->name('cart.decrement');
    

    Route::get('/transactions', [TransactionController::class, 'userIndex'])->name('user.transactions.index');
    Route::post('/transactions/user/process', [TransactionController::class, 'process'])->name('user.transactions.process');
    Route::get('/transactions/user/checkout/{transaction}', [TransactionController::class, 'checkout'])->name('user.transactions.checkout');
    Route::get('/transactions/user/checkout-success/{transaction}', [TransactionController::class, 'success'])->name('user.transactions.success');
    Route::get('/transactions/user/create', [TransactionController::class, 'userCreate'])->name('user.transactions.create');
    Route::post('/user/transactions/store', [TransactionController::class, 'userStore'])->name('user.transactions.store');
    
    // Rute untuk menampilkan riwayat transaksi
    Route::get('/user/transactions/history', [TransactionController::class, 'userHistory'])->name('user.transactions.history');
    // Rute untuk menampilkan detail transaksi
    Route::get('/user/transactions/{id}', [TransactionController::class, 'userShow'])->name('user.transactions.show');

});

 
//Admin Routes List
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('/Dashboard-Admin', [DashboardController::class, 'index'])->name('dashboardadmin')->middleware('auth');
    Route::get('/admin/profile', [AdminController::class, 'profilepage'])->name('admin/profile');

    Route::get('users', [UserAdminController::class, 'index'])->name('users.index');

    Route::resource('products', ProductController::class); 
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::resource('purchase_orders', PurchaseOrderController::class);
    Route::get('purchase_orders/create', [PurchaseOrderController::class, 'create'])->name('purchase_orders.create');
    Route::post('/purchase_orders', [PurchaseOrderController::class, 'store'])->name('purchase_orders.store');
    Route::get('/purchase_orders', [PurchaseOrderController::class, 'index'])->name('purchase_orders.index');

    Route::get('/purchase_orders/search', [PurchaseOrderController::class, 'search'])->name('purchase_orders.search'); // Route baru untuk pencarian
    Route::resource('categories', CategoryController::class);
    Route::get('categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');


    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');


    Route::get('/transactions/status', [TransactionController::class, 'status'])->name('transactions.status');
    Route::get('/transactions/{id}/return-form', [TransactionController::class, 'returnForm'])->name('transactions.return.form');
    Route::post('/transactions/{id}/return', [TransactionController::class, 'returnTransaction'])->name('transactions.return.process');
    Route::get('/transactions/return-history', [TransactionController::class, 'returnHistory'])->name('transactions.return.history');
    Route::post('/transactions/{id}/update-shipping-status', [TransactionController::class, 'updateShippingStatus'])->name('transactions.updateShippingStatus');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');

   
    // Route untuk pencarian produk
    Route::get('transactions/search-products', [TransactionController::class, 'searchProducts'])->name('transactions.search-products');    
   
    Route::get('/reports/monthly-sales', [ReportController::class, 'monthlySalesReport'])->name('reports.monthlySales');
    Route::get('/reports/monthly-stock', [ReportController::class, 'monthlyStockReport'])->name('reports.monthly_stock_report');
    Route::get('/reports/monthly-product', [ReportController::class, 'monthlyProductReport'])->name('reports.monthlyProduct');
    Route::get('/reports/daily-sales', [ReportController::class, 'dailySalesReport'])->name('reports.daily_sales');
    Route::get('/reports/monthly-transactions', [ReportController::class, 'monthlyTransactionsReport'])->name('reports.monthly-transactions');
    Route::get('/reports/stock', [ReportController::class, 'monthlyStockReport'])->name('reports.monthly_stock');


});