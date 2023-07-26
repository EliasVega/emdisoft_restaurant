<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{

    public $table = 'municipalities';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [

        'code',
        'name',
        'department_id'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
