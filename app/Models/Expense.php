<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    public $table = 'expenses';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'document',
        'due_date',
        'items',
        'total',
        'total_iva',
        'total_pay',
        'note',
        'user_id',
        'branch_id',
        'supplier_id',
        'payment_form_id',
        'payment_method_id'
    ];

    protected $guarded = [
        'id'
    ];

    public function user(){
        return $this->belongsTo(Customer::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function services(){
        return $this->hasMany(Service::class);
    }

    public function expenseServices(){
        return $this->hasMany(Expense_service::class);
    }

    public function paymentForm(){
        return $this->belongsTo(Payment_form::class);
    }

    public function paymentMethod(){
        return $this->belongsTo(Payment_method::class);
    }

    public function payExpenses(){
        return $this->hasMany(Pay_expense::class);
    }
}
