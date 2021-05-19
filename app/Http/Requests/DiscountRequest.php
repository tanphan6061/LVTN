<?php

namespace App\Http\Requests;

class DiscountRequest extends WebRequest
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
            'amount'=>'numeric|min:1',
            'start_date'=>'required',
            'end_date'=>'required|date|after:start_date',
            'percent'=>'required|numeric|min:0',
            'from_price'=>'required|numeric|min:1000',
            'max_price'=>'required|numeric|min:1000',
            'category_id'=>'nullable|exists:categories,id'
        ];
    }
}
