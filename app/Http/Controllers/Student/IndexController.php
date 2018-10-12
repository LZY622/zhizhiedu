<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\SignupRequest;
use \DB;
use Hash;


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
        // session(['user_stu'=>'']);
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
        //表单验证
        //验证用户名唯一
        $user = DB::table('stu_users')->where('phone',$request->phone)->get();

        if(!empty($user[0]->phone)){
            return back()->with('errors','用户名重复');
        }
        //插入数据
        $res = $request->except(['_token','repass','code']);
        $res['password'] = Hash::make($res['password']);
        $res['addtime'] = time();
        // dd($res);
        //处理结果
        try{
            $rs = DB::table('stu_users')->insert($res);

            if($rs){
                return redirect('/login')->with('success','注册成功请登录');
            }
        }catch(\Exception $e){
            return back()->with('errors','注册失败');
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
            // dd(1);
            session(['user_stu'=>$rs[0]]);
            // dd($rs[0]->phone);
            return view('student.zhu.index',compact('rs[0]'))->with('success','登陆成功');
        }else{
            return back()->with('errors','登录失败，密码错误');
        }

    }
}
