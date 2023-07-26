<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discharge_receipt extends Model
{
    public $table = 'discharge_receipts';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'type'
    ];

    protected $guarded = [
        'id'
    ];

    public function paymentable()
    {
        return $this->morphTo();
    }
}
