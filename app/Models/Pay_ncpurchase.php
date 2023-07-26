<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pay_ncpurchase extends Model
{
    protected $fillable = [
        'pay',
        'balance_ncpurchase',
        'user_id',
        'branch_id',
        'invoice_id',
    ];

    public function ncpurchase(){
        return $this->belongsTo(Ncpurchase::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function PpaymentMethods(){
        return $this->hasMany(Payment_method::class);
    }
}
