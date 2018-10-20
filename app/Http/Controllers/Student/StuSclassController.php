<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Stuuser_classnum;
use App\Model\Teauser;
use App\Model\TeaSclass;
use App\Model\StuSclass;
use DB;

class StuSclassController extends Controller
{
    /**
     *  构造函数 插入中间件
     *     @param 
     *  @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('student_hasrole')->only('create');
    }
    /**
     * 展示学生预约口语课的页面(并且ajax切换老师)
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request->success);
        // 判断是否从create函数来 并且设置了没有errors或者success
        if ($request->from == 'create' && $request->errors) {
            $var = 'errors';
            $errors = $request->errors;
        }elseif ($request->from == 'create' && $request->success) {
            $var = 'success';
            $success = $request->success;
        }else{
            $var = '';
        }
        $username = session('user_stu')->phone;
        $tea = Teauser::where('cate',2)->where('status',1)->pluck('username','id');
        if ($request->id) {
            $id = $request->id;
            $view = 'student.stu_sclass.ajax_teaclass';
        }else{
            $id = Teauser::where('cate',2)->where('status',1)->first()->id;
            $modal_con = DB::table('notice_con')->where('type','speak')->value('content');
            $view = 'student.stu_sclass.index';
        }
        // dd($id);
        $today = strtotime(date('Y-m-d',time()));
        $tea_sclass = [];
        $tea_sclass_booked = [];
        //得到口语老师开放课程表中该老师在本日之后的所有课程
        $tea_sclass_row = TeaSclass::where('tid',$id)->where('classdate','>=',$today)->get();
        // dd(count($tea_sclass_row));
        // dd($tea_sclass_row);
        if(count($tea_sclass_row)){
            //得到口语老师开放课程表中该老师在本日之后的所有已预约课程
            $tea_sclass_row_booked = TeaSclass::where('tid',$id)->where('classdate','>=',$today)->where('status','1')->get();
            foreach ($tea_sclass_row as $key => $value) {
                $tea_sclass[] = $value->classdate.'|'. $value->classtime;
            }
            foreach ($tea_sclass_row_booked as $key => $value) {
                $tea_sclass_booked[] = $value->classdate.'|'. $value->classtime;
            }
        }
        $s_num = Stuuser_classnum::where('uid',session('user_stu')->id)->value('s_num');
        $m_num = Stuuser_classnum::where('uid',session('user_stu')->id)->value('m_num');
        return view($view,compact('tea','tea_sclass','tea_sclass_booked','id','today','s_num','m_num',$var,'modal_con'));
    }

    /**
     * ajax 预约课程
     *   1 判断时间是否超时
         2 判断是否填入手机或者淘宝id
         3 判断是否有该用户
         4 判断该课程是否是空课
         5 判断该学生是否有课时
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // $res = $request->only('cateid','id');
        $request->from = 'create';
        $classtime_arr = explode(',', rtrim($request->classtime,','));
        $res = [];
        $t = [];
        foreach ($classtime_arr as $key => $value) {
            $a_arr = explode('|', $value);
            $res_classtime = $a_arr[0]+8*3600+$a_arr[1];
            $res[] = ['cateid'=>$request->cateid,'tid'=>$request->id,'classtime'=>$res_classtime];
        }
        foreach ($res as $key => $value) {
            $classdate = strtotime(date('Y-m-d',$value['classtime']));
            $classtime = $value['classtime']-$classdate-8*3600;
            if ($value['classtime']-time()<=2*3600) {
                $request->errors = '预约时间不足,需要提前2小时';
                return Self::index($request);
            }
            $res[$key]['uid'] = session('user_stu')->id;
            $t[$key] = TeaSclass::where('classdate',$classdate)->where('classtime',$classtime)->where('tid',$value['tid'])->first();
            if($t[$key]->status){
                $request->errors = '该课程刚刚已经被预约';
                return Self::index($request);
            }
            $t[$key]->status = 1; 
        }
         // dd($res);
        $n = Stuuser_classnum::where('uid',$res[0]['uid'])->first();
        if ($res[0]['cateid'] == 0 && $n->st_sta == 1) {
            // return back()->with('errors','您已经没有试听机会了亲');
            $request->errors = '您已经没有试听机会了亲';
            return Self::index($request);
        }elseif ($res[0]['cateid'] == 0 && count($res)>1) {
            // return back()->with('errors','只能选择一个试听时间进行预约');
            $request->errors = '只能选择一个试听时间进行预约';
            return Self::index($request);
        } elseif ($res[0]['cateid'] == 4 && $n->s_num < 0.5*count($res)) {
            // return back()->with('errors','您正式课课时数不足');
            $request->errors = '您正式课课时数不足';
            return Self::index($request);
        }elseif ($res[0]['cateid'] == 5 && $n->m_num < count($res)) {
           // return back()->with('errors','您口语模考课时数不足');
            $request->errors = '您口语模考课时数不足';
            return Self::index($request);
        }
        try{
            switch ($res[0]['cateid']) {
                case '0':
                    $n->st_sta = 1;
                    $n->save();
                    break;
                case '4':
                    $n->s_num -= 0.5*count($res);
                    $n->save();
                    break;
                case '5':
                    $n->m_num -= count($res);
                    $n->save();
                    break;
            }
            foreach ($t as $key => $value) {
                $value->save();
            }
            DB::table('stu_sclass')->insert($res);
            $request->success = '预约成功';
            return Self::index($request);
            // return back()->with('success','预约成功');
        }catch(\Exception $e){
            $request->errors = '预约失败';
            return Self::index($request);
        }
    }

    /**
     * 展示学生的课表
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->status);
        $data = [];
        $status = [$request->status];
        if ($status == [3]) {
            $status = [3,4,5,6,7];
        }
        $tea = Teauser::where('cate',2)->pluck('username','id');
        $tea_qq = Teauser::where('cate',2)->pluck('qq','id');
        $res = StuSclass::where('uid',session('user_stu')->id)->whereIn('status',$status)->orderBy('classtime','ASC')->get();
        $data['status'] = $request->status;
        $data['con'] = $res;
        $data['tea'] = $tea;
        $data['tea_qq'] = $tea_qq;
        $data['cateid'] = [0=>'口语试听',4=>'口语正式课',5=>'口语模考'];
        $data['sta'] = [1=>'待完成',2=>'已完成',3=>'正常取消',4=>'老师缺席',5=>'学生缺席',6=>'老师紧急取消',7=>'学生紧急取消'];
        return response()->json($data);
    }

    /**
     * 取消课程
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = [];
        $class = StuSclass::where('cid',$id)->where('status',1)->first();
        if(($class->classtime - time()) <= 2*3600){
            $data['status'] = 0;
            $data['con'] = '必须提前2小时取消，谢谢您的配合';
            return response()->json($data);
        }
        try{
            // dd($request->cb_type);
            if ($class->cateid == 0) {
                $catename = 'st_sta';
                $num = -1;
            }elseif ($class->cateid == 4) {
                $catename = 's_num';
                $num = 0.5;
                       
            }elseif ($class->cateid == 5) {
                $catename = 'm_num';
                $num = 1;
            }
            $class->status = 3;
            $date = strtotime(date('Y-m-d',$class->classtime));
            $time = $class->classtime-$date-8*3600;
            // dd($time);

            $tea_class = TeaSclass::where('classtime',$time)->where('classdate',$date)->where('tid',$class->tid)->where('status',1)->first();
            $tea_class->status = 0;

            $stu_num = Stuuser_classnum::where('uid',$class->uid)->first();
            $stu_num->$catename = $stu_num->$catename += $num;
            // dd($stu_num->$catename);

            if (!$class || !$tea_class || !$stu_num) {
                $data['status'] = 0;
                $data['con'] = '取消失败';
                return response()->json($data);
            }

            $class->save();
            $tea_class->save();
            $stu_num->save();
            $data['status'] = 1;
            $data['cid'] = $id;
            return response()->json($data);
        }catch(\Exception $e){
            dd($e);
            $data['status'] = 0;
            $data['con'] = '取消失败1';
            return response()->json($data);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $files = StuSclass::where('cid',$id)->value('files');
        
        return response()->download('.'.$files);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
