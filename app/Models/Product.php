<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function deleteImage()
    {
        if ($this->image) {
            Storage::disk('public')->delete($this->image);
        }
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {
            $product->deleteImage();
        });
    }

    public function orderDetails()
{
    return $this->hasMany(OrderDetail::class);
}


public function stockMovements()
{
    return $this->hasMany(StockMovement::class);
}

public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'product_transaction')
            ->withPivot('quantity')
            ->withTimestamps();
    }

// Relasi ke TransactionDetail (Stok keluar)
public function transactionDetails()
{
    return $this->hasMany(TransactionDetail::class);
}

// Relasi ke PurchaseOrderItem (Stok masuk)
public function purchaseOrderItems()
{
    return $this->hasMany(PurchaseOrderItem::class, 'product_id');
}

// Fungsi untuk menghitung stok keluar (transaksi)
public function getStockOut($month, $year)
{
    return $this->transactionDetails()
        ->whereHas('transaction', function ($query) use ($month, $year) {
            $query->whereMonth('created_at', $month)
                  ->whereYear('created_at', $year);
        })
        ->sum('quantity');
}

// Fungsi untuk menghitung stok masuk (purchase order)
public function getStockIn($month, $year)
{
    return $this->purchaseOrderItems()
        ->whereMonth('created_at', $month)
        ->whereYear('created_at', $year)
        ->sum('quantity');
}

}

