<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $fillable = [

        'name',
        'number',
        'dv',
        'address',
        'phone',
        'email',
        'credit_lmit',
        'used',
        'available',
        'department_id',
        'municipality_id',
        'document_id',
        'liability_id',
        'organization_id',
        'regime_id',
    ];



    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }

    public function document(){
        return $this->belongsTo(Document::class);
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

    public function invoice(){
        return $this->hasMany(Invoice::class);
    }

    public function ndinvoice()
    {
        return $this->hasMany(Ndinvoice::class);
    }

    public function ncinvoices()
    {
        return $this->hasMany(Ncinvoice::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function advances(){
        return $this->hasMany(Customer::class);
    }
}
