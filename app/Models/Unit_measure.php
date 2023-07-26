<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit_measure extends Model
{
    public $table = 'unit_measures';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'code',
        'status'
    ];

    protected $guarded = ['id'];

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function rawMaterials(){
        return $this->hasMany(RawMaterial::class);
    }
}
