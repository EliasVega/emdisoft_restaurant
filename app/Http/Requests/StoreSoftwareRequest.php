<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSoftwareRequest extends FormRequest
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
            'identifier'         => 'nullable|string|max:50',
            'pin'                => 'nullable|string|max:5',
            'set'                => 'nullable|string|max:64',
            'payroll_identifier' => 'nullable|string|max:50',
            'payroll_pin'        => 'nullable|string|max:5',
            'payroll_set'        => 'nullable|string|max:64'
        ];
    }
}
