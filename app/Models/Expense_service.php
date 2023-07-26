<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense_service extends Model
{
    public $table = 'expense_services';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [

        'quantity',
        'price',
        'iva',
        'subtotal',
        'ivasubt',
        'expense_id',
        'service_id',
        'item'
    ];

    public function expense(){
        return $this->belongsTo(Expense::class);
    }

    public function service(){
        return $this->belongsTo(Service::class);
    }
}
