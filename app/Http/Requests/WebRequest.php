<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class WebRequest extends FormRequest
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
            // discount code
            'code' => 'Mã giảm giá',
            'amount' => 'Số lượng',
            'start_date' => 'Ngày bắt đầu',
            'end_date' => 'Ngày kết thúc',
            'percent' => 'Phần trăm giảm',
            'from_price' => 'Giá giảm từ (vnđ)',
            'max_price' => 'Giá giảm tối đa (vnđ)',
            'category_id' => 'Loại sản phẩm',

            // supplier
            'name' => 'Tên',
            'email' => 'Địa chỉ email',
            'avatar' => 'Ảnh đại diện',
            'phone' => 'Số điện thoại',
            'password' => 'Mật khẩu',
            'nameOfShop' => 'Tên của cửa hàng',
            'address' => 'Địa chỉ',
            'password' => 'Mật khẩu',
            'new_password' => 'Mật khẩu mới',
            'password_confirmation' => 'Nhập lại mật khẩu',

            // product
            'price' => 'Giá',
            'amount' => 'Số lượng',
            'description' => 'Mô tả',
            'discount' => 'Giảm giá',
            'brand_id' => 'Thương hiệu',
            'max_buy'=> 'Số lượng mua tối đa',
            'status'=>'Trạng thasiF'
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
            'in' => ':attribute không hợp lệ.',
            'numeric' => ':attribute phải là một số.',
            'after' => ':attribute phải sau ngày bắt đầu.',
            'regex' => ':attribute định dạng không hợp lệ.',
            'min' => ':attribute tối thiểu :min kí tự.',
            'max' => ':attribute tối đa :max kí tự.',
        ];
    }
}
