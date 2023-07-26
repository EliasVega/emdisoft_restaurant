<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResolutionRequest extends FormRequest
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
            'consecutive'      => 'required|numeric',
            'prefix'           => 'required|string|max:4',
            'resolution'       => 'string|max:20',
            'resolution_date'  => 'nullable|date',
            'technical_key'    => 'nullable|string|max:64',
            'start_number'     => 'required|numeric',
            'end_number'       => 'required|numeric',
            'start_date'       => 'nullable|date',
            'end_date'         => 'nullable|date',
            'company_id'       => '',
            'type_document_id' => 'required|numeric'
        ];
    }
}
