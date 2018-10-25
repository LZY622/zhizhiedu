<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
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
           'phone' => 'required|regex:/^\w{6,12}$/',
            'password' => 'required|regex:/^\S{6,12}$/',
            'repass' =>'same:password',
        ];
    }
    /**
     * 获取已定义验证规则的错误消息。
     *
     * @return array
     */
    public function messages()
    {
        return [
            'phone.required'=>'用户名不能为空',
            'password.required'=>'密码不能为空',
            'phone.regex'=>'用户名格式不正确，必须为6-12位数字字母下划线',
            'password.regex'=>'密码格式不正确，长度必须为6-12位',
            'repass.same'=>'两次密码不一致',
        ];
    }
    
}
