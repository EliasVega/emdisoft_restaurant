<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public $table = 'services';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'code',
        'name',
        'price',
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

    public function expenses(){
        return $this->hasMany(Expense::class);
    }

    public function unit_measure(){
        return $this->hasOne(Unit_measure::class);
    }

    public function expenseServices(){
        return $this->hasMany(Expense_service::class);
    }
}
