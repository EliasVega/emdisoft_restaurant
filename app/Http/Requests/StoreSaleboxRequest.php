<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleboxRequest extends FormRequest
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
            'cash_box'        => '',
            'in_order_cash'   => '',
            'in_order'        => '',
            'order'           => '',
            'in_invoice_cash' => '',
            'in_invoice'      => '',
            'sale'            => '',
            'in_pay_cash'     => '',
            'in_pay'          => '',
            'in_advance'      => '',
            'out_purchase_cash' => '',
            'out_purchase'    => '',
            'purchase'        => '',
            'out_expense_cash' => '',
            'out_expense'    => '',
            'expense'        => '',
            'out_payment'     => '',
            'out_cash'        => '',
            'cash'            => '',
            'departure'       => '',
            'total'           => '',
            'verification_code_open'  => '',
            'verification_code_close' => '',
            'status'          => '',
            'user_id'         => '',
            'branch_id'       => '',
            'user_open_id'    => '',
            'user_close_id'   => ''
        ];
    }
}
