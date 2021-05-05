<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Họ tên',
            'password' => 'Mật khẩu',
            'sex' => 'Giới tính',
            'birthday' => 'Ngày sinh',
            'email' => 'Email',
            'old_password' => 'Mật khẩu cũ',
            'new_password' => 'Mật khẩu mới',
        ];
    }


    public function messages()
    {
        return [
            'required' => ':attribute là bắt buộc.',
            'between' => ':attribute phải dài khoảng :min - :max kí tự.',
            'confirmed' => ':attribute nhập lại không chính xác.',
            'date' => 'Ngày không hợp lệ.',
            'date_format' => 'Không đúng định dạng.',
            'before' => 'Ngày không hợp lệ.',
            'unique' => ':attribute đã tồn tại trên hệ thống.',
            'in' => ':attribute không hợp lệ.'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $message = "The given data was invalid.";
        throw new HttpResponseException($this->respondedError($message, $validator->errors()));
    }

    public function respondedError($message, $errors): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => "error",
            'status_code' => 400,
            'data' => $errors,
            'message' => $message
        ]);
    }
}
