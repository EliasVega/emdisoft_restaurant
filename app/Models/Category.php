<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = [
        'name',
        'description',
        'iva',
        'utility',
        'status'
    ];

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function services(){
        return $this->hasMany(Service::class);
    }

    public function rawMaterials(){
        return $this->hasMany(RawMaterial::class);
    }
}
