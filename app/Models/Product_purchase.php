<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_purchase extends Model
{
    protected $fillable = [

        'quantity',
        'price',
        'iva',
        'subtotal',
        'ivasubt',
        'item',
        'purchase_id',
        'product_id',
    ];

    public function purchase(){
        return $this->belongsTo(Purchase::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
