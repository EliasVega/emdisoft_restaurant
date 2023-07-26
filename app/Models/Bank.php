<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];

    public function payInvoicePaymenMethod(){
        return $this->BelongsToMany(PayinvoicePaymentmethod::class);
    }

    public function paymenmethodPayorder(){
        return $this->BelongsToMany(PayinvoicePaymentmethod::class);
    }
}
