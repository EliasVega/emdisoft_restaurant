<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
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
            'number'          => 'required|max:20',
            'dv'              => '',
            'address'         => 'required|max:45',
            'phone'           => 'required|max:20',
            'email'           => 'required|max:45',
            'contact'         => 'required|max:50',
            'phone_contact'   => 'required|max:20',
            'department_id'   => 'required',
            'municipality_id' => 'required',
            'document_id'     => 'required',
            'liability_id'    => 'required',
            'organization_id' => 'required',
            'regime_id'       => 'required',
        ];
    }
}
