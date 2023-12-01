<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NcinvoiceProduct extends Model
{
    use HasFactory;

    public $table = 'ncinvoice_products';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'quantity',
        'price',
        'tax_rate',
        'subtotal',
        'tax_subtotal',
        'ncpurchase_id',
        'product_id'
    ];

    protected $guarded = [
        'id'
    ];



    public function ncinvoice(){
        return $this->hasOne(Ncinvoice::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
