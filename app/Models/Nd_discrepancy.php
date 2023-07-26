<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nd_discrepancy extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'description'
    ];

    public function ndinvoices(){
        return $this->HasMany(Ndinvoice::class);
    }

    public function ncpurchase(){
        return $this->HasMany(Ncpurchase::class);
    }
}
