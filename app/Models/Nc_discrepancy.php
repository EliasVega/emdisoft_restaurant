<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nc_discrepancy extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'description'
    ];

    public function ncinvoices(){
        return $this->HasMany(Ncinvoice::class);
    }

    public function Ndpurchase(){
        return $this->HasMany(Ndpurchase::class);
    }
}
