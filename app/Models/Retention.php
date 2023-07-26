<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Retention extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'porsentage',
        'base',
    ];

    public function orders(){
        return $this->hasMany(Order::class);
    }
}
