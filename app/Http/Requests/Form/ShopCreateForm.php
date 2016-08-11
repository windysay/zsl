<?php

namespace App\Http\Requests\Form;

use App\Http\Requests\Request;

class ShopCreateForm extends Request
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
            'shop_name'            => 'required',
            'shop_email'                 => 'required|email',
//            'password'              => 'required|confirmed',
//            'password_confirmation' => 'required',
//            'cat_id'               => 'required',
//            'store_id'             => 'required',
        ];
    }

    public function messages()
    {
        return [
            'shop_name.required'                  => '商户名称不能为空',
            'shop_email.required'                 => '商户邮箱不能为空',
            'shop_email.email'                   => '商户邮箱格式不正确',
//            'password.required'              => '用户密码不能为空',
//            'password.confirmed'             => '确认密码不一致',
//            'password_confirmation.required' => '确认密码不能为空',
//            'role_id.required'               => '用户角色不能为空',
        ];
    }
}
