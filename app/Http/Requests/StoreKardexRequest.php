<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKardexRequest extends FormRequest
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
            'product_id' => 'required',
            'branch_id'  => 'required',
            'operation'  => 'required',
            'number'     => 'required',
            'quantity'   => 'required',
            'stock'      => 'required',
            'observation' => 'nullable|string|max:255'
        ];
    }
}
