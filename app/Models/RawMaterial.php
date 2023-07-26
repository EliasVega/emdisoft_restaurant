<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMaterial extends Model
{
    use HasFactory;

    public $table = 'raw_materials';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'code',
        'name',
        'price',
        'stock',
        'status',
        'category_id',
        'unit_measure_id'
    ];

    protected $guarded = [
        'id'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function unitMeasure(){
        return $this->belongsTo(Unit_measure::class);
    }

}
