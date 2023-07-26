<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateType_documentRequest extends FormRequest
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
            'code' => 'nullable|string|max:4',
            'name' => 'required|string|max:50',
            'prefix' => 'required|string|max:4',
            'cufe_algorithm' => 'nullable|string|max:20'
        ];
    }
}
