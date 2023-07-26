<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment_method extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'code',
        'name',
    ];

    public function invoice(){
        return $this->hasMany(Invoice::class);
    }

    public function payorders(){
        return $this->belongsToMany(Payorder::class);
    }

    public function payevents(){
        return $this->hasMany(Payevent::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function payOrder(){
        return $this->hasMany(Payorder::class);
    }

    public function payInvoice(){
        return $this->hasMany(Payinvoice::class);
    }

    public function Pay_ndinvoices(){
        return $this->hasMany(Pay_ndinvoice::class);
    }

    public function advance_payment_method(){
        return $this->hasMany(Advance_payment_method::class);
    }
}
