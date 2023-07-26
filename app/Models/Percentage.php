<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Percentage extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'percentage',
        'base',
    ];
}
