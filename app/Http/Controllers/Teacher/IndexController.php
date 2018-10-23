<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\SignupRequest;
use App\Http\Requests\Teacher\SetuserRequest;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use App\Model\Teauser;
use App\Model\StuSclass;
use App\Model\StuWcorrect;
use \DB;
use Hash;


class IndexController extends Controller
{
    public function __construct()
    {
        $this->middleware('teacher_hasrole')->only('index');
    }
    /**
     *  展示主页
     * 	@param 
     *  @return 
     */
    public function index(Request $request)
    {
        $rs = session('user');
        // dd($rs->id);
        // dd();
        if ($rs->cate == 2) {
            $a = DB::table('tea_sclass')->where('classdate','>',strtotime(date('Y-m-d',time())))->where('status',0)->where('tid',$rs->id)->count();
            $b = DB::table('stu_sclass')->where('tid',$rs->id)->where('classtime','>=',time())->where('classtime','<',strtotime('tomorrow'))->where('status',1)->count();
            $c = DB::table('stu_sclass')->where('tid',$rs->id)->where('classtime','<',time())->where('status',1)->count();
            $d = 0;
            $e = 70.00;
        }else{
            // dd(strtotime('today'));
            $a = DB::table('tea_wcorrect')->where('tid',$rs->id)->where('classtime','>',strtotime('today'))->sum('num');
            $b = DB::table('stu_wcorrect')->where('tid',$rs->id)->where('classtime','<',strtotime('today'))->where('status',2)->count();
            $c = DB::table('stu_wcorrect')->where('tid',$rs->id)->where('classtime',strtotime('today'))->where('status',1)->count();
            $d = 0;
        }
        // 老师工资表
        if ($rs->cate == 2) {
            $res = [];
            $price = ['0'=>'STPRICE','4'=>'SPEAKPRICE','5'=>'MOCKPRICE'];
            $today = date('Y-m-d',time());
            $month = date('Y-m-d',time()-24*3600*14);
            $range = $request->input('range')?$request->input('range'):$month.' - '.$today;
            $range_arr = explode(' - ', $range);
            $start = strtotime($range_arr[0]);
            $end = strtotime($range_arr[1]);
            $tid = $rs->id;
            $status = [2,4,5,6,7];
            $cateid = ['0'=>'st','4'=>'cla','5'=>'mt'];
            $tea = Teauser::where('cate',2)->where('status',1)->pluck('username','id');
            // 筛选课表中的信息
            foreach ($cateid as $key => $value) {
                foreach ($status as $k => $v) {
                    $res[$value][$v] = StuSclass::where(function($query) use($request,$tid){
                        if($tid != 0){
                            $query->where('tid',$tid);
                        }
                    })
                    ->where('classtime','>=',$start)
                    ->where('classtime','<=',$end+(24*3600-1))
                    ->where('cateid',$key)
                    ->where('status',$v)->groupBy('tid')->select('tid',DB::raw('count(*) as total'))
                    ->get();
                }
            }
            $tea_id = StuSclass::where(function($query) use($request,$tid){
                    if($tid != 0){
                        $query->where('tid',$tid);
                    }
                })
                ->where('classtime','>=',$start)
                ->where('classtime','<=',$end+(24*3600-1))
                ->where('status','!=','1')
                ->where('status','!=','3')
                ->groupBy('tid')->select('tid',DB::raw('count(*) as total'))
                ->get();
        }else{
            $price = ['13'=>'TASK2PRICE','15'=>'TASK1PRICE'];
            $today = date('Y-m-d',time());
            $month = date('Y-m-d',time()-24*3600*14);
            //设置区间默认范围查询
            $range = $request->input('range')?$request->input('range'):$month.' - '.$today;
            $range_arr = explode(' - ', $range);
            $start = strtotime($range_arr[0]);
            $end = strtotime($range_arr[1]);
            // dd($end);
            // 设置默认的下拉框信息
            $cateid = $rs->cate;
            $tid = $rs->id;
            // dd($cateid);
            // 找到老师信息
            $tea = Teauser::where('cate',13)->orWhere('cate',15)->pluck('username','id');
            $tea_cate = Teauser::where('cate',13)->orWhere('cate',15)->pluck('cate','id');
            $tea_id = Teauser::where('cate',$cateid)->pluck('id');
            // 筛选课表中的信息
            $res = StuWcorrect::where(function($query) use($request,$tid){
                if($tid != 0){
                    $query->where('tid',$tid);
                }
            })
            ->where('classtime','>=',$start)
            ->where('classtime','<=',$end)
            ->whereIn('tid',$tea_id)
            ->where('status',5)->groupBy('tid')->select('tid',DB::raw('count(*) as total'))
            ->get();
        }
        // dd($tea_id);
    	return view('teacher.index',compact(['rs','a','b','c','d','e','request','res','tea','tea_id','range','tid','price','tea_cate','cateid']));
    }

    /**
     *  退出登录
     *     @param 
     *  @return \Illuminate\Http\Response
     */
     public function loginout()
     {
        session(['user'=>'']);
        return view('teacher.login');
     }

    /**
     *  展示登录页面
     * 	@param 
     *  @return 
     */
    public function login()
    {
    	return view('teacher.login');
    }

     /**
      *  展示注册页面
      *  @param 
      *  @return 
      */
    public function signup()
    {
    	return view('teacher.sign_up');
    }

    /**
     *  展示后台设置账号页面
     *     @param 
     *  @return 
     */
     public function setuser(Request $request)
    {
        $rs = session('user');
        return view('teacher.setuser',compact(['rs']));
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
            $same_user = DB::table('tea_users')->where('username',$request->username)->get();

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
            $request->file('img')->move('uploads/teacher',$name.'.'.$suffix);
            $res['img'] = '/uploads/teacher/'.$name.'.'.$suffix;
        }
        
        // $res['pass'] = Hash::make($request->input('pass'));
        
        try{
            $rs = DB::table('tea_users')->where('id',session('user')->id)->update($res);
            // 查得老图片
            $old_img = session('user')->img;
            // // 获取新的这条数据并改变session
            // $new_user = DB::table('tea_users')->where('id',session('user')->id)->get();
            // session(['user'=>$new_user[0]]);
            // dd(session('user')->img);
            // 如果此时这条数据的img不是默认值并且获取数据的img值不为空 删除老图片
            if ((session('user')->img != '/uploads/teacher/123.jpg') && (!empty($res['img']))) {
                unlink('.'.$old_img);
            }
            return redirect('/teacher/loginout');
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
        $same_user = DB::table('tea_users')->where('username',$request->username)->get();

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
            $rs = DB::table('tea_users')->insert($res);

            if($rs){
                return redirect('/teacher/login')->with('success','注册成功请登录');
            }
        }catch(\Exception $e){
            // dd($e);
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

        $rs = DB::table('tea_users')->where('username',$request->username)->get();
        if(empty($rs[0]->username)){
            return back()->with('errors','登录失败，用户不存在');
        }
        if(Hash::check($request->password,$rs[0]->password)){
            // dd(1);
            session(['user'=>$rs[0]]);
            return redirect('/teacher/')->with('success','登陆成功');
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
    /**
     *  展示无权限访问页面
     *     @param 
     *  @return \Illuminate\Http\Response
     */
    public function nopermission()
    {
        $rs = session('user');
        $errors = '请您点击左侧菜单切换至其他页面';
        return view('teacher.nopermission',compact(['rs','errors']));
    }
}
