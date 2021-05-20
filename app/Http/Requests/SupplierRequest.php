<?php

namespace App\Http\Requests;

class SupplierRequest extends WebRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'name'=>'required',
            // 'email'=>'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'phone'=>['required','regex:/^((84|0[3|5|7|8|9])+[0-9]{8})$/i'],
            'nameOfShop' =>'required',
            'address'=>'required'
        ];
    }
}
