<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
            'name'            => 'required|max:45',
            'dv'              => 'required',
            'number'          => 'required|max:20',
            'address'         => 'max:45',
            'phone'           => 'max:20',
            'email'           => 'max:45',
            'credit_limit'    => 'required',
            'used'            => '',
            'available'       => '',
            'department_id'   => '',
            'municipality_id' => '',
            'document_id'     => 'required',
            'liability_id'    => 'required',
            'organization_id' => 'required',
            'regime_id'       => 'required',
        ];
    }
}
