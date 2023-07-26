<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNcpurchaseRequest extends FormRequest
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

            'purchase'    => '',
            'total'       => 'required',
            'total_iva'   => 'required',
            'total_pay'   => 'required',
            'pay'         => '',
            'balance'     => '',
            'status'      => '',
            'branch_id'   => '',
            'purchase_id' => '',
            'product_id'  => '',
            'nd_discrepancy_id' => 'required',
            'voucher_type_id' => 'integer'
        ];
    }
}
