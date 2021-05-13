<?php

namespace App\Http\Requests\Api;

use Facade\FlareClient\Api;
use Illuminate\Foundation\Http\FormRequest;

class ReviewEditRequest extends ApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'comment' => 'required|between:8,500',
            'star' => 'required|numeric|between:1,5',
        ];
    }
}
