<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cash_in extends Model
{
    public $table = 'cash_ins';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'payment',
        'reason',
        'sale_box_id',
        'user_id',
        'branch_id',
        'admin_id'
    ];

    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function admin(){
        return $this->belongsTo(User::class);
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function saleBox(){
        return $this->belongsTo(Sale_box::class);
    }
}
