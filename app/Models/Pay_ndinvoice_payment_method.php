<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pay_ndinvoice_payment_method extends Model
{
    protected $fillable = [
        'valor',
        'transaction',
        'pay_ndinvoice_id',
        'payment_method_id',
        'bank_id',
        'card_id',
        'advance_id'
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
<<<<<<< HEAD
=======
    public function payNcinvoice()
    {
        return $this->belongsTo(pay_ncinvoice::class);
    }
>>>>>>> 6276eea0077679ed6e2380e1b91400604e21b707
    public function advance()
    {
        return $this->belongsTo(Advance::class);
    }
<<<<<<< HEAD
=======

>>>>>>> 6276eea0077679ed6e2380e1b91400604e21b707
}
