<?php

namespace App\Http\Requests\Api;


use Illuminate\Validation\Rule;

class AuthorizationRegisterRequest extends ApiRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|between:3,16',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|between:6,32', //password_confirmation
            'sex' => [
                'required',
                Rule::in(['male', 'female'])
            ],
            'birthday' => 'required|date|date_format:Y-m-d|before:now'
        ];
    }


}
