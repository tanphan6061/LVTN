<?php

namespace App\Http\Requests\Api;


class AddressCreateRequest extends ApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'active' => 'boolean|nullable',
        ];
    }
}
