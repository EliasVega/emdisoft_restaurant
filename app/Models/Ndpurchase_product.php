<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ndpurchase_product extends Model
{

    protected $fillable = [

        'cantidad',
        'precio',
        'ntdcompra_id',
        'producto_id'
    ];

    public function Ndpurchase(){
        return $this->belongsTo(Ndpurchase::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
