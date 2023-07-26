<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pay_ndpurchase extends Model
{
    protected $fillable = [
        'pay',
        'balance_ndpurchase',
        'user_id',
        'branch_id',
        'invoice_id',
    ];

    public function ndpurchase(){
        return $this->belongsTo(Ndpurchase::class);
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
