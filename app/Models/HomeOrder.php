<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'domiciliary',
        'time_receipt',
        'time_sent',
        'order_id'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
