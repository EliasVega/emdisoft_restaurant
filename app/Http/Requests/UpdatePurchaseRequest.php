<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatepurchaseRequest extends FormRequest
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
            'document'          => 'required|max:20',
            'due_date'          => 'required',
            'items'             => 'numeric',
            'total'             => 'required|numeric',
            'total_iva'         => 'required|numeric',
            'total_pay'         => 'required|numeric',
            'pay'               => 'numeric',
            'balance'           => 'numeric',
            'retention'         => 'numeric',
            'status'            => '',
            'document_type' => '',
            'branch_id'         => 'integer',
            'supplier_id'       => 'required|integer',
            'payment_form_id'   => 'required|integer',
            'payment_method_id' => 'required|integer',
            'percentage_id'     => '',
            'type_generation_id' => 'integer',
            'voucher_type_id' => 'integer'
        ];
    }
}
