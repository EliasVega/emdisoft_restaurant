<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher_type extends Model
{
    use HasFactory;

    public $table = 'voucher_types';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'code',
        'name',
        'consecutive',
        'state'
    ];

    protected $guarded = [
        'id'
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
