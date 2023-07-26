<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pay_expense_payment_method extends Model
{
    protected $fillable = [
        'valor',
        'transaction',
        'pay_expense_id',
        'payment_method_id',
        'bank_id',
        'card_id',
        'payment_id'
    ];

    public function bank(){
        return $this->belongsTo(Bank::class);
    }

    public function card(){
        return $this->belongsTo(Card::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(Payment_method::class);
    }
}
