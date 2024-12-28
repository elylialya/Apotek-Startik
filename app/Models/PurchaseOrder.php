<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $fillable = ['supplier_name','supplier_id', 'total_amount', 'status', 'order_date'];

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }
}
