<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{

    protected $fillable = [

        'document',
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
        'supplier_id',
        'payment_form_id',
        'payment_method_id',
        'percentage_id',
        'type_generation_id',
        'voucher_type_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function productPurchases(){
        return $this->hasMany(ProductPurchase::class);
    }

    public function ncpurchase(){
        return $this->hasOne(Ncpurchase::class);
    }

    public function Products(){
        return $this->hasMany(Product::class);
    }

    public function ndpurchase(){
        return $this->hasOne(Ndpurchase::class);
    }

    public function type_generation(){
        return $this->hasOne(Generation::class);
    }

    public function paymentForm(){
        return $this->belongsTo(Payment_form::class);
    }

    public function paymentMethod(){
        return $this->belongsTo(Payment_method::class);
    }

    public function pay_purchases()
    {
        return $this->hasMany(Pay_purchase::class);

    }
    public function retention(){
        return $this->hasOne(Retention::class);
    }

    public function voucherTipe()
    {
        return $this->belongsTo(Voucher_type::class);
    }
}
