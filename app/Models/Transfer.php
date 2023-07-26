<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{

    protected $fillable = [
        'user_id',
        'branch_id',
        'origin_branch_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function branch(){
        return $this->hasOne(Branch::class);
    }

    public function originBranch(){
        return $this->hasOne(Branch::class);
    }

    public function productBranch(){
        return $this->hasOne(Branch::class);
    }
}
