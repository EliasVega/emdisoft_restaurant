<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuProduct extends Model
{
    use HasFactory;

    public $table = 'menu_products';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'quantity',
        'consumer_price',
        'subtotal',
        'reaw_material_id',
        'product_id'
    ];

    protected $guarded = [
        'id'
    ];

}
