<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'branch_id',
    ];

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function invoices(){
        return $this->hasMany(Invoices::class);
    }
}
