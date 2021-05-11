<?php

namespace App\Http\Requests\Api;

class FavouriteCreateRequest extends ApiRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => 'required|numeric'
        ];
    }
}
