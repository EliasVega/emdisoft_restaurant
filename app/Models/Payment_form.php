<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment_form extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function invoices(){
        return $this->hasMany(Invoice::class);
    }

    public function payOrders(){
        return $this->belongsToMany(Pay_order::class);
    }

    public function payEvents(){
        return $this->belongsToMany(Pay_event::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function purchases(){
        return $this->hasMany(Purchase::class);
    }
}
