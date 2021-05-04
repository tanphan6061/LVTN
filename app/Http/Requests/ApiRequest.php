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
