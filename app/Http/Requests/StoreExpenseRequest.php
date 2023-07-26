<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'document'          => 'required|max:20',
            'due_date'          => 'required',
            'items'             => 'numeric',
            'total'             => 'required|numeric',
            'total_iva'         => 'required|numeric',
            'total_pay'         => 'required|numeric',
            'note'              => 'nullable|string|max:255',
            'user_id'           => '',
            'branch_id'         => 'integer',
            'supplier_id'       => 'required|integer',
            'payment_form_id'   => 'required|integer',
            'payment_method_id' => 'required|integer'
        ];
    }
}
