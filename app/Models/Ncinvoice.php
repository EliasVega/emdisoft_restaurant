<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ncinvoice extends Model
{

    protected $fillable = [
        'total',
        'total_iva',
        'total_pay',
        'pay',
        'balance',
        'status',
        'user_id',
        'branch_id',
        'invoice_id',
        'customer_id',
        'nc_discrepancy_id',
        'payment_method_id',
        'payment_form_id',
        'voucher_type_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function nc_discrepancy(){
        return $this->belongsTo(Nc_discrepancy::class);
    }

    public function Nd_discrepancy(){
        return $this->HasMany(Nd_discrepancy::class);
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }
}
