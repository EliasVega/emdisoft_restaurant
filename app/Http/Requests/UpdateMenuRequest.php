<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuRequest extends FormRequest
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
            'code'            => 'required|string|unique:menus,code,'.$this->menu->id,'|max:20',
            'name'            => 'required|max:100',
            'price'           => '',
            'sale_price'      => '',
            'stock'           => '',
            'status'          => '',
            'image'           => '',
            'category_id'     => 'required',
            'unit_measure_id' => 'required'
        ];
    }
}
