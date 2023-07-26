<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ndpurchase extends Model
{

    protected $fillable = [

        'purchase',
        'total',
        'total_iva',
        'total_pay',
        'user_id',
        'branch_id',
        'purchase_id',
        'supplier_id',
        'nc_discrepancy_id',
        'voucher_type_id'
    ];

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function purchase(){
        return $this->belongsTo(Purchase::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function nc_discrepancy(){
        return $this->belongsTo(Nc_discrepancy::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
