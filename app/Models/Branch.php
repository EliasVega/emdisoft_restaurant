<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{

    protected $fillable = [

        'name',
        'address',
        'phone',
        'mobile',
        'email',
        'manager',
        'department_id',
        'municipality_id',
        'company_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function invoices(){
        return $this->hasMany(Invoice::class);
    }

    public function purchases(){
        return $this->hasMany(Invoice::class);
    }

    public function ncpurchases(){
        return $this->hasMany(Ncpurchase::class);
    }

    public function ncinvoices(){
        return $this->hasMany(Ncinvoice::class);
    }

    public function ndpurchases(){
        return $this->hasMany(Ndpurchase::class);
    }

    public function ndinvoices(){
        return $this->hasMany(Ndinvoice::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function payorders(){
        return $this->hasMany(Payorder::class);
    }

    public function cashIns(){
        return $this->belongsTo(Cash_in::class);
    }

    public function cashOuts(){
        return $this->hasMany(Cash_out::class);
    }

    public function prePurchase(){
        return $this->hasMany(PrePurchase::class);
    }

    public function kardexes(){
        return $this->hasMany(Kardex::class);
    }
}
