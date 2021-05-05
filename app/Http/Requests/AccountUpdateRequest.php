<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $validate = [
            'name' => 'required|between:3,16',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|between:6,32', //password_confirmation
            'birthday' => 'required|date|date_format:Y-m-d|before:now',
            'sex' => [
                'required',
                Rule::in(['male', 'female'])
            ]
        ];

        return [
            //
        ];
    }
}
