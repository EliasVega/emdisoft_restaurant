<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
        'total',
        'total_inc',
        'total_pay',
        'status',
        'user_id',
        'restaurant_table_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function restaurantTable()
    {
        return $this->belongsTo(RestaurantTable::class);
    }

    public function homeOrder()
    {
        return $this->hasOne(HomeOrder::class);
    }
}
