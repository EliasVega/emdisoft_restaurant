<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment_method_pay_order extends Model
{

    protected $fillable = [
        'payment',
        'transaction',
        'pay_order_id',
        'payment_method_id',
        'bank_id',
        'card_id',
        'pay_event_id',
    ];

    public function banks()
    {
        return $this->belongsToMany(Bank::class);
    }

    public function cards()
    {
        return $this->belongsToMany(Card::class);
    }

    public function payevent()
    {
        return $this->hasOne(Payevent::class);
    }
}
