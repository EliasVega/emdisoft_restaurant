<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVoucher_typeRequest extends FormRequest
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
            'code' => 'required|unique:voucher_types,code,'.$this->voucher_type->id,'|string|max:4',
            'name' => 'required|unique:voucher_types,name,'.$this->voucher_type->id,'|string|max:50',
            'consecutive' => 'required|integer',
            'state' => 'required|in:active,inactive'
        ];
    }
}
