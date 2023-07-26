<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pay_order extends Model
{

    protected $fillable = [
        'pay',
        'balance_order',
        'user_id',
        'branch_id',
        'order_id',
    ];

    public function order(){
        return $this->belongsTo(Order::class);
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
}
