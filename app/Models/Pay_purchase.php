<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pay_purchase extends Model
{
    protected $fillable = [
        'pay',
        'balance_purchase',
        'status',
        'user_id',
        'branch_id',
        'purchase_id',
    ];

    public function purchase(){
        return $this->belongsTo(Purchase::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function paymentMethod(){
        return $this->hasMany(Payment_method::class);
    }

    public function dischargeReceipt()
    {
        return $this->morphMany(Discharge_receipt::class, 'paymentable');
    }
}
