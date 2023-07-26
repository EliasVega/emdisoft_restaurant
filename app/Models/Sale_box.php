<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale_box extends Model
{

    protected $fillable = [
        'cash_box',
        'in_order_cash',
        'in_order',
        'order',
        'in_invoice_cash',
        'in_invoice',
        'sale',
        'in_pay_cash',
        'in_pay',
        'in_advance',
        'out_purchase_cash',
        'out_purchase',
        'purchase',
        'out_expense_cash',
        'out_expense',
        'expense',
        'out_payment',
        'out_cash',
        'cash',
        'departure',
        'total',
        'verification_code_open',
        'verification_code_close',
        'status',
        'user_id',
        'user_open',
        'user_close',
        'branch_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function cashIns(){
        return $this->belongsTo(Cash_in::class);
    }

    public function cashOuts(){
        return $this->hasMany(Cash_out::class);
    }

}
