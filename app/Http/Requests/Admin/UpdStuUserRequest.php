<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdStuUserRequest extends FormRequest
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
           'mname' => 'required',
           'exam_date' => 'required',
           'sgoal' => 'required|regex:/[3456789]{1}\.?[05]?/',
           'wgoal' => 'required|regex:/[3456789]{1}\.?[05]?/',
           'sex' => 'required',
           'status' => 'required',
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
            'username.required'=>'用户名不能为空',
            'qq.required'=>'qq号不能为空',
            'taobaoID.required'=>'淘宝ID不能为空',
            'mname.required'=>'英文名不能为空',
            'exam_date.required'=>'考试日期不能为空',
            'sgoal.required'=>'口语目标分不能为空',
            'wgoal.required'=>'写作目标分不能为空',
            'sex.required'=>'性别不能为空',
            'status.required'=>'状态不能为空',
            'username.regex'=>'用户名格式不正确',
            'sgoal.regex'=>'口语目标分不正确',
            'wgoal.regex'=>'写作目标分不正确',

        ];
    }
}
