<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advance_payment_method extends Model
{
    protected $fillable = [
        'payment',
        'transaction',
        'payment_id',
        'payment_method_id',
        'bank_id',
        'card_id'
    ];

    public function bank(){
        return $this->belongsTo(Bank::class);
    }

    public function card(){
        return $this->belongsTo(Card::class);
    }

    public function payment(){
        return $this->belongsTo(Advance::class);
    }

    public function payment_method(){
        return $this->belongsTo(Payment_method::class);
    }
}
