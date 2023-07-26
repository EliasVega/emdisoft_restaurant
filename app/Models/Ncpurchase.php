<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ncpurchase extends Model
{

    protected $fillable = [

        'purchase',
        'total',
        'total_iva',
        'total_pay',
        'pay',
        'balance',
        'status',
        'user_id',
        'branch_id',
        'purchase_id',
        'supplier_id',
        'nd_discrepancy_id',
        'voucher_type_id'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function purchase(){
        return $this->belongsTo(Purchase::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class);
    }

    public function nd_discrepancy(){
        return $this->belongsTo(Nd_discrepancy::class);
    }
}
