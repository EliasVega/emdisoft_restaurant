<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $table = 'payments';

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
        'supplier_id'
    ];

    protected $guarded = [
        'id'
    ];

    public function purchase(){
        return $this->belongsTo(Purchase::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function payment_payment_method(){
        return $this->hasMany(Advance_payment_method::class);
    }
}
