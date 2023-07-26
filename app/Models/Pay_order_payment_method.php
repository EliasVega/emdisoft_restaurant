<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pay_order_payment_method extends Model
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

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(Payment_method::class);
    }
}
