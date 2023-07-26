<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice_product extends Model
{

    protected $fillable = [
        'quantity',
        'price',
        'iva',
        'subtotal',
        'ivasubt',
        'item',
        'invoice_id',
        'product_id',
    ];

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
