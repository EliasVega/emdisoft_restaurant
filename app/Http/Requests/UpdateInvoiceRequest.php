<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
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
            'total'             => 'required|numeric',
            'total_iva'          => 'numeric',
            'total_pay'          => 'numeric',
            'pay'               => 'nullable|numeric',
            'balance'           => '',
            'branch_id'         => 'integer',
            'customer_id'       => 'required|integer',
            'payment_form_id'   => 'required|integer',
            'payment_method_id' => 'required|integer',
            'restaurant_table_id' => 'required|integer'
        ];
    }
}
