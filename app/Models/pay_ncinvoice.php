<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pay_ncinvoice extends Model
{
    protected $fillable = [
        'pay',
        'balance_ncinvoice',
        'user_id',
        'branch_id',
        'invoice_id',
    ];

    public function ncinvoice(){
        return $this->belongsTo(Ncinvoice::class);
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
