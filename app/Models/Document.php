<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'code',
        'name',
        'initial',
    ];

    public function suppliers(){
        return $this->hasMany(Proveedore::class);
    }

    public function customers(){
        return $this->hasMany(Customer::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
