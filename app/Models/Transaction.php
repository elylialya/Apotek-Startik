<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_transaction')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function user()
{
    return $this->belongsTo(User::class);
}
    
}

