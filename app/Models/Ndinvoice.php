<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ndinvoice extends Model
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
        'nd_discrepancy_id',
        'payment_method_id',
        'payment_form_id',
        'voucher_type_id',
        'voucher_type_id'
    ];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
    public function Payment_Method(){
        return $this->hasMany(Payment_method::class);
    }
    public function Payment_form(){
        return $this->hasMany(Payment_form::class);
    }
}
