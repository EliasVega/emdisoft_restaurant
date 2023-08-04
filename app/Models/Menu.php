<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'price',
        'sale_price',
        'stock',
        'status',
        'image',
        'category_id',
        'unit_measure_id'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function unitMeasure(){
        return $this->belongsTo(Unit_measure::class);
    }
    /*
    public function Productoventas(){
        return $this->hasMany(ProductoVenta::class);
    }*/

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class);
    }

    public function kardex(){
        return $this->hasOne(Kardex::class);
    }

    public function menuProducts(){
        return $this->belongsToMany(Order_product::class);
    }
}
