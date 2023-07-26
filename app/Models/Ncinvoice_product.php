<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ncinvoice_product extends Model
{

    protected $fillable = [
        'cantidad',
        'precio',
        'ncinvoice_id',
        'product_id'
    ];
    /*
    public function ncinvoice(){
        return $this->hasOne(Ncinvoice::class);
    }

    public function product(){
        return $this->hasMany(Product::class);
    }*/
}
