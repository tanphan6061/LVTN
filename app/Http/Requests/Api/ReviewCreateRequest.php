<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ReviewCreateRequest extends ApiRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'comment' => 'required|between:8,200',
            'star' => 'required|numeric|between:1,5',
            'product_id' => 'required'
        ];
    }
}
