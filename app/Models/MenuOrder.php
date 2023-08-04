<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'price',
        'iva',
        'subtotal',
        'ivasubt',
        'edition',
        'order_id',
        'product_id'
    ];

    public function menu(){
        return $this->belongsTo(Menu::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }
}
