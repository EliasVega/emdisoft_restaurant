<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'origin' => 'string|max:50',
            'destination' => 'nullable|string|max:20',
            'pay' => 'required',
            'balance' => '',
            'note' => 'nullable|string|max:255',
            'status' => 'in:pendiente,parcial,aplicado',
            'user_id' => '',
            'branch_id' => '',
            'supplier_id' => 'required|integer'
        ];
    }
}
