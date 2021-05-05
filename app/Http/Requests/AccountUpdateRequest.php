<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountUpdateRequest extends ApiRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ext_rules = [];
        $validate = [
            'name' => 'required|between:3,16',
            //'email' => 'required|email|unique:users',
            'birthday' => 'required|date|date_format:Y-m-d|before:now',
            'sex' => [
                'required',
                Rule::in(['male', 'female'])
            ]
        ];

        $isChangePw = $this->request->get('is_change_password');

        if ($isChangePw) {
            $ext_rules = [
                'old_password' => 'required|between:6,32',
                'new_password' => 'required|confirmed|between:6,32', //password_confirmation
            ];
        }


        return array_merge($validate, $ext_rules);
    }
}
