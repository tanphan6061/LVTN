<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class OrderCreateRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'address_id' => 'numeric|nullable',
            'payment_type' => 'required',
            'coupon_global_use' => 'nullable',
            'coupon_suppliers_use' => 'nullable|array'
        ];
    }
}
