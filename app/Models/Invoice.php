<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    protected $fillable = [

        'document',
        'type_document',
        'type_operation',
        'due_date',
        'total',
        'total_iva',
        'total_pay',
        'pay',
        'balance',
        'retention',
        'status',
        'note',
        'user_id',
        'branch_id',
        'customer_id',
        'payment_form_id',
        'payment_method_id',
        'percentage_id',
        'voucher_type_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function paymentForm(){
        return $this->belongsTo(Payment_form::class);
    }

    public function paymentMethod(){
        return $this->belongsTo(Payment_method::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function ndinvoice()
    {
        return $this->hasOne(Ndinvoice::class);
    }

    public function ncinvoice()
    {
        return $this->belongsTo(Ncinvoice::class);
    }

    public function pay_invoices()
    {
        return $this->hasMany(Pay_invoice::class);

    }
    public function retention(){
        return $this->hasOne(Retention::class);
    }

    public function voucherTipe()
    {
        return $this->belongsTo(Voucher_type::class);
    }
}
