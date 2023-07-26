<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
        'due_date',
        'items',
        'total',
        'total_iva',
        'total_pay',
        'pay',
        'balance',
        'retention',
        'status',
        'user_id',
        'branch_id',
        'customer_id',
        'payment_form_id',
        'payment_method_id',
        'percentage_id',
        'voucher_type_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function paymentForm(){
        return $this->belongsTo(Payment_form::class);
    }

    public function paymentMethod(){
        return $this->belongsTo(Payment_method::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function payOrders(){
        return $this->hasMany(Pay_order::class);
    }

    public function retention(){
        return $this->hasOne(Retention::class);
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function voucherTipe()
    {
        return $this->belongsTo(Voucher_type::class);
    }
}
