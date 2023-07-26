<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRawMaterial extends Model
{
    use HasFactory;

    public $table = 'product_raw_materials';

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
