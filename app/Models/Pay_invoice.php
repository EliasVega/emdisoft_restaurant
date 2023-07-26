<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pay_invoice extends Model
{

    protected $fillable = [
        'pay',
        'balance_invoice',
        'status',
        'user_id',
        'branch_id',
        'invoice_id',
    ];

    public function invoice(){
        return $this->belongsTo(Invoice::class);
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

    public function cashReceipt()
    {
        return $this->morphMany(Cash_receipt::class, 'payable');
    }
}
