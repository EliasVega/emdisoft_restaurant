<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'items'             => 'integer',
            'due_date'          => 'required|date',
            'total'             => 'required|numeric',
            'totalIva'          => 'numeric',
            'totalPay'          => 'numeric',
            'pay'               => 'nullable|numeric',
            'balance'           => '',
            'retention'         => '',
            'status'            => 'in_array:pendiente,facturado,anulado',
            'branch_id'         => 'integer',
            'customer_id'       => 'required|integer',
            'payment_form_id'   => 'required|integer',
            'payment_method_id' => 'required|integer',
            'percentage_id'      => 'nullable',
            'voucher_type_id' => 'integer'
        ];
    }
}
