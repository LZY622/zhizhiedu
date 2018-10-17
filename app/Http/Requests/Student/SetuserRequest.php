<?php

namespace App\Http\Requests\Student;

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
            'mname' => 'required',
            'password' => 'required|regex:/^\S{6,12}$/',
            'repass' =>'same:password',
            'sex' => 'required',
            'phone' => 'required|regex:/^\w{3,12}$/',
            'qq' => 'required',
            'taobaoID' => 'required',
            'exam_date' => 'required',
            'sgoal' => 'required|regex:/[3456789]{1}\.?[05]?/',
            'wgoal' => 'required|regex:/[3456789]{1}\.?[05]?/',
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
            'mname.required'=>'英文名不能为空',
            'password.required'=>'密码不能为空',
            'password.regex'=>'密码格式不正确',
            'repass.same'=>'两次密码不一致',
            'sex.required'=>'性别不能为空',
            'phone.required'=>'手机号不能为空',
            'phone.regex'=>'手机号格式不正确',
            'qq.required'=>'qq号不能为空',
            'taobaoID.required'=>'淘宝ID不能为空',
            'exam_date.required'=>'考试日期不能为空',
            'sgoal.required'=>'口语目标分不能为空',
            'wgoal.required'=>'写作目标分不能为空',
            'sgoal.regex'=>'口语目标分格式不正确',
            'wgoal.regex'=>'写作目标分格式不正确',
        ];
    }
}
