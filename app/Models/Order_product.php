<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_product extends Model
{

    protected $fillable = [
        'quantity',
        'price',
        'iva',
        'subtotal',
        'ivasubt',
        'item',
        'order_id',
        'product_id'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
