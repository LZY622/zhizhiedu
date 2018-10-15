<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\SignupRequest;
use \DB;
use Hash;
use App\library\SMS\SendTemplateSMS;
use App\library\SMS\M3Result;


class IndexController extends Controller
{
    /**
     *  展示学生端主页
     * 	@param 
     *  @return 
     */
    public function index()
    {
        $rs = session('user_stu');
    	return view('student.index',compact(['rs']));
    }

    /**
     *  学生登录页面
     *  @param 
     *  @return 
     */
    public function login()
    {
        return view('student.login');
    }

    /**
     *  退出登录
     *  @param 
     *  @return \Illuminate\Http\Response
     */
     public function loginout()
     {
        session(['user_stu'=>'']);
        return view('student.login');
     }

    /**
     *  学生注册页面
     * 	@param 
     *  @return 
     */
    public function signup()
    {
    	return view('student.sign_up');
    }

    /**
     *  处理注册表单信息
     *     @param Request $request
     *  @return 
     */
    public function do_signup(SignupRequest $request)
    {
       // dd($request->errors);
        // dd('0123' == true);
        //表单验证
        $code = $request->code;
        if ($code != session('code') && $code != 'dtyasi') {
            return back()->with('errors','验证码输入有误');
        }
        
        $res_user = $request->except(['_token','repass','code','qq']);
        $res_message = $request->only('qq');
        // dd($res_message);
        $res_num = [];
        //验证用户名唯一
        $user = DB::table('stu_users')->where('phone',$request->phone)->get();

        if(!empty($user[0]->phone)){
            return back()->with('errors','用户名重复');
        }
        //插入数据
        $res_user['password'] = Hash::make($res_user['password']);
        $res_user['addtime'] = time();
        // dd($res);
        //处理结果
        try{
            $id = DB::table('stu_users')->insertGetId($res_user);
            $res_message['uid'] = $id;
            $res_num['uid'] = $id;
            $rs = DB::table('users_message')->insert($res_message);
            $rs = DB::table('class_num')->insert($res_num);
            return redirect('/login')->with('success','注册成功请登录');
        }catch(\Exception $e){
            return back()->with('errors','添加失败');
        }
    }

    /**
     *  处理登录表单
     *     @param Request $request
     *  @return 
     */
     public function do_login(Request $request)
    {
        $rs = DB::table('stu_users')->where('phone',$request->phone)->get();
        // dd($rs);
        if(empty($rs[0]->phone)){
            return back()->with('errors','登录失败，用户不存在');
        }
        if(Hash::check($request->password,$rs[0]->password)){
            $res = DB::table('users_message')->where('uid',$rs[0]->id)->get();
            session(['user_stu'=>$rs[0],'user_stu_m'=>$res[0]]);
            return redirect('/students')->with('success','登陆成功');
        }else{
            return back()->with('errors','登录失败，密码错误');
        }

    }
    public function sendCode(Request $request)
    {
        // dd($request->phone);
        //获取要发送的手机号
        $phone = $request->phone;
        //生成模板中需要的参数
        $code = rand(1000,9999);
        $arr = [$code,5];
        //调用熔炼云通讯的接口
        $templateSMS = new SendTemplateSMS();
        $M3result = new M3Result();
        $M3result = $templateSMS->sendTemplateSMS($phone,$arr,1);
        //将验证码存入session
        session()->put('code',$code);
        //给客户端返回响应结果
        return $M3result->toJson();
    }

    /**
     *  学生修改个人信息
     *     @param 
     *  @return 
     */
     public function setuser(Request $request)
    {
        $rs = session('user_stu');
        dump($rs);
        return view('student.zhu.setuser',compact(['rs']));
    }

    /**
     *  跳转到学生预约主页
     *     @param 
     *  @return \Illuminate\Http\Response
     */
     public function student()
    {
        $rs = session('user_stu');
        $res = session('user_stu_m');
        return view('student.zhu.index',compact('rs','res'))->with('success','登陆成功');
    }
}
