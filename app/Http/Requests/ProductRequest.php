<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class ProductRequest extends WebRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'amount' => 'required|numeric|min:0',
            'description' => 'required',
            'discount' => 'required|numeric|min:0|max:100',
            // 'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'max_buy' => 'required|numeric|min:0',
            'status' => [
                'required',
                Rule::in(['available', 'hidden'])
            ]
        ];
    }
}
