<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
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
            'number'          => 'required|string|unique:suppliers,number,'.$this->supplier->id,'|max:12',
            'email'           => 'required|string|unique:suppliers,email,'.$this->supplier->id,'|max:45',
            'document_id'     => 'required',
        ];
    }
}
