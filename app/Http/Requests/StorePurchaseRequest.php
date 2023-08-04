<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorepurchaseRequest extends FormRequest
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
            'total_inc'         => 'required|numeric',
            'total_pay'         => 'required|numeric',
            'pay'               => 'numeric',
            'balance'           => 'numeric',
            'branch_id'         => 'integer',
            'supplier_id'       => 'required|integer',
            'payment_form_id'   => 'required|integer',
            'payment_method_id' => 'integer',
        ];
    }
}
