<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceMenu extends Model
{
    use HasFactory;

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

    public function menu(){
        return $this->belongsTo(Menu::class);
    }
}
