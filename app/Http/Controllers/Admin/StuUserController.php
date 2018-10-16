<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Stuuser;
use App\Model\Teauser;
use App\Model\Stuuser_classnum;
use App\Model\Stuuser_message;
use App\Model\ClassnumAdd;
use App\Http\Requests\Admin\StuUserRequest;
use App\Http\Requests\Admin\UpdStuUserRequest;
use DB;
use Hash;
use CatTree;

class StuUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $rs = session('user');
        $chushi_id = Teauser::where('cate',2)->where('status',1)->first()->id;
        if ($req->input('status') === '0') {
            $status = 0;
        }else{
            $status = 1;
        }
        // dd($status);
        $res = Stuuser::where('status',$status)->whereHas('user_message',function($query) use($req)
            {
                //检测关键字
                $username = $req->input('username');
                //如果用户名不为空
                if(!empty($username)) {
                    $query->where('qq',$username)->orWhere('taobaoID',$username)->orWhere('mname',$username);
                }    
            })
        ->whereHas('user_classnum',function($query) use($req)
            {
                // $query->where('st_sta',0);
            })
        ->orWhere(function($query) use($req){
                //检测关键字
                $username = $req->input('username');
                
                //如果用户名不为空
                if(!empty($username)) {
                    $query->where('phone',$username);
                }    
            })
        ->with([])->orderBy('id', 'desc')->paginate(10);
            // dd($res[0]['user_classnum']);
        return view('admin.stuuser.index',compact(['res','rs','req','status','chushi_id']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //展示添加页面
        $rs = session('user');
        
        return view('admin.stuuser.add',compact(['rs']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StuUserRequest $request)
    {
        $res_user = [];
        $res_message = $request->except('_token','phone');
        $res_num = [];
        $same_user = DB::table('stu_users')->where('phone',$request->phone)->get();

        if(count($same_user)){
            return back()->with('errors','用户名重复');
        }
        // 默认密码
        $pass = '123456';
        $res_user['phone'] = $request->phone;
        $res_user['password'] = Hash::make($pass);
        $res_user['addtime'] = time();
        try{
            $id = DB::table('stu_users')->insertGetId($res_user);
            $res_message['uid'] = $id;
            $res_num['uid'] = $id;
            $rs = DB::table('users_message')->insert($res_message);
            $rs = DB::table('class_num')->insert($res_num);
            return redirect('/admin/stuuser')->with('success','添加成功');
        }catch(\Exception $e){
            return back()->with('errors','添加失败');
        }
        // dd($res);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //获取单条数据
        $res = Stuuser::with('user_message')->find($id);
        // dd($res);
        $rs = session('user');
        
        // dd($res);
        return view('admin.stuuser.edit',compact(['res','rs']));
    }

    /**
     * 添加课时
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        try{
            $res = Stuuser_classnum::where('uid',$id)->first();
            $res->s_num += $request->s_num;
            $res->m_num += $request->m_num;
            $res->w_num += $request->w_num;
            $res->bw_num += $request->bw_num;
            $res->sw_num += $request->sw_num;
            if($res->st_sta != $request->st_sta){
                $res->st_sta = $request->st_sta;
                // 作为试听课课时变动的是否进入记录表的标准
                $st_addjilu_cateid = 1;
            }else{
                $st_addjilu_cateid = 0;
            }
            
            // 获取需要添加到添加课时记录表中的数据
            $data = [];
            $addtime = time();
            $type = $request->input('type',1);
            $jname = session('user')->username;
            $req = $request->except('type');
            // dd($request->input());
            foreach ($req as $key => $value) {
                if(($value && $key != 'st_sta') || ($st_addjilu_cateid && $key=='st_sta')){
                    switch ($key) {
                        case 's_num':
                            $cateid = 4;
                            break;
                        case 'm_num':
                            $cateid = 5;
                            break;
                        case 'w_num':
                            $cateid = 7;
                            break;
                        case 'bw_num':
                            $cateid = 13;
                            break;
                        case 'sw_num':
                            $cateid = 15;
                            break;
                        case 'st_sta':
                            $cateid = 0;
                            if($value){
                                $value = -1;
                            }else{
                                $value = 1;
                            }
                            break;
                    }
                    $data[] = ['cateid'=>$cateid,'jname'=>$jname,'uid'=>$id,'num'=>$value,'addtime'=>$addtime,'type'=>$type];
                }
            }
            // dd($data);
            if(!$data){
                return redirect('/admin/stuuser')->with('errors','修改内容为空');
            }
            $res->save();
            ClassnumAdd::insert($data);
            return redirect('/admin/stuuser')->with('success','添加成功');
        }catch(\Exception $e){
            // dd($e);
            return redirect('/admin/stuuser')->with('errors','修改失败');

        } 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdStuUserRequest $request, $id)
    {
        // dd($request->except('_token','_method','phone','status'));
        //验证用户名唯一

        $same_user = DB::table('stu_users')->where('phone',$request->phone)->get();

        if((count($same_user)) && $same_user[0]->id != $id){
            return back()->with('errors','用户名(手机号)重复');
        }
        
        $res_user = $request->only(['phone','status']);
        $res_user_message = $request->except('_token','_method','phone','status');
        // dd($res);
        try{
            Stuuser::where('id',$id)->update($res_user);
            Stuuser_message::where('uid',$id)->update($res_user_message);
            return redirect('/admin/stuuser')->with('success','修改成功');
        }catch(\Exception $e){

            return back()->with('errors','修改失败');

        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
        $res_user = [];
        $pass = '123456';
        $res_user['password'] = Hash::make($pass);
        try{
            Stuuser::where('id',$id)->update($res_user);
           
            return redirect('/admin/stuuser')->with('success','重置成功');
        }catch(\Exception $e){

            return back()->with('errors','重置失败');

        }
    }
    /**
     *  ajax查询calss_num中的数据 
     *     @param 
     *  @return json
     */
     public function select_num($id)
    {
        try{
            $data = [];
            $res = DB::table('class_num')->where('uid',$id)->get();
            $taobaoID = DB::table('users_message')->where('uid',$id)->value('taobaoID');
            $phone = DB::table('stu_users')->where('id',$id)->value('phone');
            // 建立一个数组 表示查询添加记录得到总课时的变量名以及不同的类型的状态的名字（正常还是转让等等）
            $add_cateid = ['0'=>'add_st','4'=>'add_s','5'=>'add_m','7'=>'add_w','13'=>'add_bw','15'=>'add_sw'];
            $add_type = ['1'=>'total_yimai','2'=>'total_zhuanrang','4'=>'total_tuikuan','5'=>'total_buchang'];
            foreach ($add_type as $k => $v) {
                $data[$v] = [];
                foreach ($add_cateid as $key => $value) {
                    if ($k==1) {
                       $add = DB::table('classnum_add')->where('uid',$id)->where('cateid',$key)->whereIn('type',[1,3])->sum('num');
                       // dump(0);
                    }else{
                        $add = DB::table('classnum_add')->where('uid',$id)->where('cateid',$key)->where('type',$k)->sum('num');
                        // dump(1);
                    }
                    if ($key == 0 && $k == 1) {
                        $add += 1;
                    }
                    $data[$v][$value] = $add;
                }
            }
                
            
            // dd($add);

            
            $data['con'] = $res;
            $data['status'] = 1;
            $data['taobaoID'] = $taobaoID;
            $data['phone'] = $phone;
            return response()->json($data);
        }catch(\Exception $e){
            $data = [];
            $data['status'] = 0;
            return response()->json($data);
        }
    }
    /**
     *  展示添加记录所有内容
     *     @param 
     *  @return \Illuminate\Http\Response
     */
     public function select_all(Request $request)
    {
        $rs = session('user');
        $today = strtotime(date('Y-m-d',time()));
        //设置区间默认范围查询(过滤掉秒)
        $range = $request->input('range')?$request->input('range'):date('Y-m-d',time()).' - '.date('Y-m-d',time());
        $range_arr = explode(' - ', $range);
        $start_time = strtotime($range_arr[0]);
        $end_time = strtotime($range_arr[1].' 23:59:59');
        // 设置默认的下拉框信息
        if ($request->input('cateid') || $request->input('cateid') === '0') {
            $cateid = $request->input('cateid');
        }else{
            $cateid = 'a';
        }
        // dd($cateid);
        // 找到老师信息
        $admin = DB::table('admin_users')->pluck('username');
        $res = ClassnumAdd::where(function($query) use($request,$cateid){
            $username = $request->input('username');
            $type = $request->input('type');
            $jname = $request->input('jname');
            if(!empty($username)){
                $uid = Stuuser_message::where('qq',$username)->orWhere('mname',$username)->orWhere('taobaoID',$username)->pluck('uid');
                // dd($uid);
                $id = Stuuser::where('phone',$username)->value('id');
                if ($id) {
                    $uid[] = $id;
                }
                $query->whereIn('uid',$uid);
            }
            if($type != 0){
                $query->where('type',$type);
            }
            if ($cateid != 'a') {
                $query->where('cateid',$cateid);
            }
            if ($jname != 0) {
                $query->where('jname',$jname);
            }

        })->where('addtime','>=',$start_time)
            ->where('addtime','<=',$end_time)
            ->orderBy('addtime','DESC')
            ->paginate(10);
        //根据记录表筛选出来的结果找到对应的学生信息
        $users = [];
        foreach ($res as $key => $value) {
            $users[$value->uid]['phone'] = Stuuser::where('id',$value->uid)->value('phone');
            $users_message = Stuuser_message::where('uid',$value->uid)->select('taobaoID')->get();
            $users[$value->uid][] = $users_message[0];
        }
        return view('admin.stuuser.jilu_index',compact(['rs','res','request','users','admin','range','cateid']));

    }
}
