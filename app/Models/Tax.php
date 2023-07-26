<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'code',
        'name',
        'description',
    ];

    public function suppliers(){
        return $this->hasMany(Supplier::class);
    }

    public function companies(){
        return $this->hasMany(Company::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
