<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
            'number'          => 'required|string|unique:customers,number,'.$this->customer->id,'|max:12',
            'email'           => 'required|string|unique:customers,email,'.$this->customer->id,'|max:45',
            'document_id'     => 'required',
        ];
    }
}
