<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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

            'name'          => 'required|max:45',
            'nit'             => 'required|max:20',
            'dv'              => 'required|max:1',
            'email'           => 'required',
            'emailfe'         => 'required',
            'estado'          => '',
            'logo'            => '',
            'department_id'   => 'required',
            'municipality_id' => 'required',
            'liability_id'    => 'required',
            'organization_id' => 'required',
            'regime_id'       => 'required',
        ];
    }
}
