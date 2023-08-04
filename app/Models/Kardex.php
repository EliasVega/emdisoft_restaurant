<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{

    protected $fillable = [
        'product_id',
        'branch_id',
        'operation',
        'number',
        'quantity',
        'stock',
        'observation'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }
}
