<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type_generation extends Model
{
    public $timestamps = false;

    protected $fillable = ['description'];

    public function purchase(){
        return $this->belongsTo(Purchase::class);
    }
}
