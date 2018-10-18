<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StuUserRequest extends FormRequest
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
           'phone' => 'required|regex:/^\w{3,12}$/',
           'qq' => 'required',
           'taobaoID' => 'required',
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
            'qq.required'=>'qq号不能为空',
            'taobaoID.required'=>'淘宝ID不能为空',
            
            'phone.regex'=>'用户名格式不正确',

        ];
    }
}
