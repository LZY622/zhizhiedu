<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class SetuserRequest extends FormRequest
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
           'username' => 'required|regex:/^\w{6,12}$/',
            // 'password' => 'regex:/^\S{6,12}$/',
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
            'username.required'=>'Username is required',
            'username.regex'=>'用户名格式不正确',
            // 'password.regex'=>'密码格式不正确',
            'repass.same'=>'两次密码不一致',
        ];
    }
}
