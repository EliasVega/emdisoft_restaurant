<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pay_expense extends Model
{
    protected $fillable = [
        'pay',
        'balance_expense',
        'user_id',
        'branch_id',
        'expense_id',
    ];

    public function expense(){
        return $this->belongsTo(Expense::class);
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

    public function dischargeReceipt()
    {
        return $this->morphMany(Discharge_receipt::class, 'paymentable');
    }
}
