<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cash_out extends Model
{
    public $table = 'cash_outs';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'payment',
        'reason',
        'admin',
        'sale_box_id',
        'user_id',
        'branch_id',
        'admin_id',
    ];

    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function adminCash(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function salelBox(){
        return $this->belongsTo(Sale_box::class);
    }
}
