<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SignupRequest;
use App\Http\Requests\Admin\SetuserRequest;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use \DB;
use Hash;


class IndexController extends Controller
{
    /**
     *  展示消息页面
     *     @param 
     *  @return \Illuminate\Http\Response
     */
    public function message(Request $request)
    {
        $status = $request->status?$request->status:0;
        $rs = session('user');
        // DB::table('msm')->where('status',0)->update(['status',1]);
        $res = DB::table('msm')->where('status',$status)->get();
        $user = DB::table('stu_users')->pluck('phone','id');
        $tea = DB::table('tea_users')->where('cate',13)->orWhere('cate',15)->pluck('username','id');
        $class = [];
        foreach ($res as $key => $value) {
            if ($value->others) {
                $arr = explode('|', $value->others);
                $class[$value->id] = DB::table('stu_'.$arr[0])->where('cid',$arr[1])->first();
            }
        }
        // dd($class);
        return view('admin.message',compact(['rs','res','user','class','tea','status']));
    }
    /**
     *  标记已读
     *     @param 
     *  @return \Illuminate\Http\Response
     */
     public function messageid($id)
    {
        try{
            $msm = DB::table('msm')->where('id',$id)->first();
            if ($msm->status) {
                DB::table('msm')->where('id',$id)->update(['status'=>0]);
            }else{
                DB::table('msm')->where('id',$id)->update(['status'=>1]);
            }
            return back()->with('success','标记成功');
        }catch(\Exception $e){
            return back()->with('errors','标记失败');
        }
    }
    /**
     *  展示后台主页
     * 	@param 
     *  @return 
     */
    public function index()
    {
        $rs = session('user');
    	return view('admin.index',compact(['rs']));
    }
    /**
     *  ajax得到折现数据
     *     @param 
     *  @return \Illuminate\Http\Response
     */
    public function zhexian()
    {
        $data = [];
        try{
            $data['kouyu'] = [];
            $data['mokao'] = [];
            $data['task1'] = [];
            $data['task2'] = [];
            $data['Xzhou'] = [];
            $yesterday = strtotime('yesterday');
            for ($i=14; $i >= 0; $i--) { 
                $a = $yesterday-$i*24*3600;
                $b = $a+24*3600;
                $data['Xzhou'][] = date('Y-m-d',$a);
                $data['kouyu'][] = DB::table('classnum_add')->where('cateid','4')->where('addtime','>=',$a)->where('addtime','<',$b)->sum('num');
                $data['mokao'][] = DB::table('classnum_add')->where('cateid','5')->where('addtime','>=',$a)->where('addtime','<',$b)->sum('num');
                $data['task1'][] = DB::table('classnum_add')->where('cateid','13')->where('addtime','>=',$a)->where('addtime','<',$b)->sum('num');
                $data['task2'][] = DB::table('classnum_add')->where('cateid','15')->where('addtime','>=',$a)->where('addtime','<',$b)->sum('num');
            }
            $data['status'] = 1;
        }catch(\Exception $e){
            $data['status'] = 0;
        }
        return response()->json($data);
        
    }

    /**
     *  退出登录
     *     @param 
     *  @return \Illuminate\Http\Response
     */
     public function loginout()
     {
        session(['user'=>'']);
        return view('admin.login');
     }

    /**
     *  展示登录页面
     * 	@param 
     *  @return 
     */
    public function login()
    {
    	return view('admin.login');
    }

     /**
      *  展示注册页面
      *  @param 
      *  @return 
      */
    public function signup()
    {
    	return view('admin.sign_up');
    }

    /**
     *  展示后台设置账号页面
     *     @param 
     *  @return 
     */
     public function setuser(Request $request)
    {
        $rs = session('user');
        return view('admin.setuser',compact(['rs']));
    }

    /**
     *  处理设置账号页面传入的数据
     *     @param 
     *  @return 
     */
     public function do_setuser(SetuserRequest $request)
    {
        //表单验证
        //如果获取的用户名与session中的不同 验证用户名唯一
        if($request->username != session('user')->username){
            $same_user = DB::table('admin_users')->where('username',$request->username)->get();

            if(!empty($same_user[0]->username)){
                return back()->with('errors','用户名重复');
            }
        }
        //获取数据
        $res = $request->except('_token','repass','img','password','oldpassword');
        //如果新密码为空 获取的数据是老密码 否则 获取新密码并且加密
        if (empty($request->password)) {
            $res['password'] = session('user')->password;
        }else{
            $pattern = "/^\S{6,12}$/";
            if (!preg_match($pattern,$request->password)) {
                return back()->with('errors','新密码格式不对');
            }
            $pass = session('user')->password;
            // 获取输入的老密码与密码是否一致
            if(! Hash::check($request->oldpassword,$pass)){
                return back()->with('errors','原密码输入错误，修改失败');
            }
            $res['password'] = Hash::make($request->password);
        }
        // 如果有文件上传处理文件 并且做为获取的图片数据 
        if($request->hasFile('img')){
            //自定义名字
            $name = time().rand(1111,9999);

            //获取后缀
            $suffix = $request->file('img')->getClientOriginalExtension(); 

            //移动
            $request->file('img')->move('uploads/admin',$name.'.'.$suffix);
            $res['img'] = '/uploads/admin/'.$name.'.'.$suffix;
        }
        
        // $res['pass'] = Hash::make($request->input('pass'));
        
        try{
            $rs = DB::table('admin_users')->where('id',session('user')->id)->update($res);
            // 查得老图片
            $old_img = session('user')->img;
            // // 获取新的这条数据并改变session
            // $new_user = DB::table('admin_users')->where('id',session('user')->id)->get();
            // session(['user'=>$new_user[0]]);
            // 如果此时这条数据的img不是默认值并且获取数据的img值不为空 删除老图片
            if ((session('user')->img != '/uploads/admin/123.jpg') && (!empty($res['img']))) {
                unlink('.'.$old_img);
            }
            return redirect('/admin/loginout');
        }catch(\Exception $e){
            return back()->with('errors','修改失败');
        }
    }

    /**
     *  处理注册表单信息
     *     @param SignupRequest $request
     *  @return 
     */
    public function do_signup(SignupRequest $request)
    {
       // dd($request->errors);
        //表单验证
        //验证用户名唯一
        $same_user = DB::table('admin_users')->where('username',$request->username)->get();

        if(!empty($same_user[0]->username)){
            return back()->with('errors','用户名重复');
        }
        //验证验证码
        if($request->code != session('code')){
            return back()->with('errors','验证码书写错误');
        }
        //插入数据
        $res = $request->except(['_token','repass','code']);
        $res['password'] = Hash::make($res['password']);
        $res['addtime'] = time();
        // dd($res);
        //处理结果
        try{
            $rs = DB::table('admin_users')->insert($res);

            if($rs){
                return redirect('/admin/login')->with('success','注册成功请登录');
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

        $rs = DB::table('admin_users')->where('username',$request->username)->get();
        if(empty($rs[0]->username)){
            return back()->with('errors','登录失败，用户不存在');
        }
        if(Hash::check($request->password,$rs[0]->password)){
            // dd(1);
            session(['user'=>$rs[0]]);
            return redirect('/admin/')->with('success','登陆成功');
        }else{
            return back()->with('errors','登录失败，密码错误');
        }
    }

    /**
     *  生成验证码
     *     @param 
     *  @return 
     */
     public function pic_code()
    {

        $phrase = new PhraseBuilder;
        // 设置验证码位数
        $code = $phrase->build(4);
        // 生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder($code, $phrase);
        // 设置背景颜色
        $builder->setBackgroundColor(123, 203, 230);
        $builder->setMaxAngle(25);
        $builder->setMaxBehindLines(0);
        $builder->setMaxFrontLines(0);
        // 可以设置图片宽高及字体
        $builder->build($width = 120, $height = 40, $font = null);
        // 获取验证码的内容
        $phrase = $builder->getPhrase();
        // 把内容存入session
      
        session(['code'=>$phrase]);

        // 生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type:image/jpeg");
        $builder->output();
    }
}
