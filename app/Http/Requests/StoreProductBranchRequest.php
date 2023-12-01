<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductBranchRequest extends FormRequest
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
            'quantity'         => 'required|numeric',
            'product_id'       => 'required|integer',
            'branch_id'        => 'required|integer',
            'origin_branch_id' => 'integer',
            'transfer_id'      => 'integer'
        ];
    }
}
