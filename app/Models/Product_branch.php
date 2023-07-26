<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_branch extends Model
{

        protected $fillable = ['quantity', 'user_id', 'product_id', 'branch_id', 'origin_branch_id'];

        public function products(){
            return $this->belongsToMany(Product::class);
        }

        public function branch(){
            return $this->hasOne(Branch::class);
        }

        public function originBranch(){
            return $this->hasOne(Branch::class);
        }

        public function transfer(){
            return $this->belongsTo(Transfer::class);
        }
}
