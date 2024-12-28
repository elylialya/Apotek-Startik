<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('shipping/cost', [TransactionController::class, 'calculateShippingCost']);
Route::post('transaction/{transactionId}/payment', [TransactionController::class, 'processPayment']);

Route::post('/ongkir', [TransactionController::class, 'getOngkir']);


