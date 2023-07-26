<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advance extends Model
{
    public $table = 'advances';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'origin',
        'destination',
        'pay',
        'balance',
        'note',
        'status',
        'user_id',
        'branch_id',
        'customer_id'
    ];

    protected $guarded = [
        'id'
    ];

    public function invoice(){
        return $this->belongsToMany(Invoice::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function advance_payment_method(){
        return $this->hasMany(Advance_payment_method::class);
    }
}
