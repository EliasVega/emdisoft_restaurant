<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    protected $fillable = [

        'name',
        'nit',
        'dv',
        'email',
        'emailfe',
        'logo',
        'department_id',
        'municipaliy_id',
        'liability_id',
        'organization_id',
        'regime_id'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function liability()
    {
        return $this->belongsTo(Liability::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function regime()
    {
        return $this->belongsTo(Regime::class);
    }

    public function resolutions(){
        return $this->hasMany(Resolution::class);
    }

    public function software(){
        return $this->hasOne(Software::class);
    }
}
