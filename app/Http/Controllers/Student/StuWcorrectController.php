<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Stuuser_classnum;
use DB;
use App\Model\Teauser;
use App\Model\Stufiles;
use App\Model\StuWcorrect;
use App\Model\TeaWcorrect;

class StuWcorrectController extends Controller
{
    /**
     * 展示空课页面
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
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
        // dd($request->time);
        $username = session('user_stu')->phone;
        $today = date('Y-m-d',time());
        //设置区间默认范围查询
        $range = $today;
        $start = strtotime($range);
        $end = $start+4*24*3600;
        if ($request->cateid) {
            $cateid = $request->cateid;
            $view = 'student.stu_wcorrect.ajax_teacorrect';
        }else{
            $cateid = 13;
            $view = 'student.stu_wcorrect.index';
        }

        // 找到老师信息
        
        $tea = Teauser::where('cate',13)->orWhere('cate',15)->pluck('username','id');
        $teacateid = Teauser::where('cate',13)->orWhere('cate',15)->pluck('cate','id');
        $teacate = [];
        $teacate['13'] = Teauser::where('cate',13)->pluck('id');
        $teacate['15'] = Teauser::where('cate',15)->pluck('id');
        // dd($tea);
        $res = TeaWcorrect::where(function($query) use($request,$teacate,$cateid){
            if($cateid != 0){
                $query->whereIn('tid',$teacate[$cateid]);
            }
        })
        ->where('classtime','>=',$start)
        ->where('classtime','<=',$end)
        // ->where('classtime','>',$timemoren)
        ->orderBy('classtime','ASC');
        $res_tid = $res->pluck('tid');
        $res_tids = [];
        foreach ($res_tid as $key => $value) {
            $res_tids[] = $value;
            $res_tids = array_unique($res_tids);
        }
        $sw_num = Stuuser_classnum::where('uid',session('user_stu')->id)->value('sw_num');
        $bw_num = Stuuser_classnum::where('uid',session('user_stu')->id)->value('bw_num');
        return view($view,compact($var,'res_tids','res','tid','start','cateid','tea','teacateid','sw_num','bw_num'));
    }

    /**
     * 添加预约
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
        /**
         1 判断时间是否超时
         2 判断是否填入手机或者淘宝id
         3 判断是否有该用户
         4 判断该老师的该时间手否有篇数
         5 判断该学生是否有课时
         改变 课时数减掉  老师课表中状态调整和篇数调整 学生课表中添加
         */
        $request->from = 'create';
        $res = $request->only(['tid','classtime']);
        $classtime = $request->classtime;
        // dd($classdate);
        // dd($classtime);
        try{
            if (time()-$classtime>22*3600) {
                $request->errors = '超过当日22点不可预约当日批改';
                return Self::index($request);
            }
            $res['uid'] = session('user_stu')->id;
            

            $t = TeaWcorrect::where('classtime',$classtime)->where('tid',$request->tid)->first();
            
            if(!is_object($t) || $t->status==3 || $t->status==4){
                $request->errors = '该老师已经没有篇数';
                return Self::index($request);
            }
            // $t->status = 1;
            $t->num -= 1;
            if ($t->num > 1) {
                $t->status = 1;
            }elseif ($t->num == 1) {
                $t->status = 2;
            }elseif ($t->num == 0 && $t->total_num == 0) {
                $t->status = 4;
            }elseif ($t->num == 0 && $t->total_num != 0) {
                $t->status = 3;
            }else{
                $request->errors = '操作失败';
                return Self::index($request);
            }
            $n = Stuuser_classnum::where('uid',$res['uid'])->first();
            // $t->save();
            if ($request->cateid == 13 && $n->bw_num < 1) {
                $request->errors = '您的篇数不足';
                return Self::index($request);
            }elseif ($request->cateid == 15 && $n->sw_num < 1) {
               $request->errors = '您的篇数不足';
                return Self::index($request);
            }
            switch ($request->cateid) {
                case '13':
                    $t->save();
                    $n->bw_num -= 1;
                    $n->save();
                    DB::table('stu_wcorrect')->insert($res);
                    break;
                case '15':
                    $t->save();
                    $n->sw_num -= 1;
                    $n->save();
                    DB::table('stu_wcorrect')->insert($res);
                    break;
            }
            $request->success = '预约成功';
            return Self::index($request);
        }catch(\Exception $e){
            $request->errors = '预约失败';
            return Self::index($request);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->status);
        $data = [];
        switch ($request->status) {
            case '1':
                $status = [1];
                break;
            case '2':
                $status = [2,4];
                break;
            case '3':
                $status = [5];
                break;
            case '4':
                $status = [3];
                break;
        }
        $tea = Teauser::where('cate',13)->orWhere('cate',15)->pluck('username','id');
        $tea_cate = Teauser::where('cate',13)->orWhere('cate',15)->pluck('cate','id');
        $res = StuWcorrect::where('uid',session('user_stu')->id)->whereIn('status',$status)->orderBy('classtime','ASC')->get();
        $data['status'] = $request->status;
        $data['con'] = $res;
        $data['tea'] = $tea;
        $data['tea_cate'] = $tea_cate;
        $data['cateid'] = [13=>'大作文',15=>'小作文'];
        $data['sta'] = [1=>'待上传',2=>'批改中...',3=>'已取消',4=>'老师正在审核，请稍等',5=>'已回稿'];
        return response()->json($data);
    }

    /**
     * 检查学生作文的状态是否可以修改并获取内容
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
        $data = [];
        $time_class = strtotime($request->classtime);
        $time_cha = time()-$time_class;
        if ($time_cha > 22*3600) {
            $data['submited'] = 0;
        }else{
            $data['submited'] = 1;
        }
        $res = StuWcorrect::where('cid',$id)->first();
        // dd($res);
        if($res->fid){
            $rs = DB::table('stu_files')->where('fid',$res->fid)->first();
            $data['status'] = 1;
            $data['title'] = $rs->title;
            $data['content'] = $rs->content;
        }else{
            $data['status'] = 0;
            $data['title'] = '';
            $data['content'] = '';
        }
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        $type = $request->type;
        $files = StuWcorrect::where('cid',$id)->value('files_'.$type);
        
        return response()->download('.'.$files);
    }

    /**
     * 上传学生作文
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = [];
        // dd($request->input());
        try{
            if($request->content && $request->title){
                $res = StuWcorrect::where('cid',$id)->first();
                if ($res->fid) {
                    $rs = Stufiles::where('fid',$res->fid)->first();
                    $rs->title = $request->title;
                    $rs->content = $request->content;
                    $rs->save();
                    $data['status'] = 1;
                    $data['con'] = '修改成功';
                    return response()->json($data);
                }else{
                    $req = $request->except('_token','_method');
                    $fid = DB::table('stu_files')->insertGetId($req);
                    $res->fid = $fid;
                    if($res->status == 1){
                        $res->status = 2;
                        $res->save();
                        $data['status'] = 1;
                        $data['con'] = '上传成功';
                        return response()->json($data);
                    }else{
                        $data['status'] = 0;
                        $data['con'] = '未知错误';
                        return response()->json($data);
                    }
                }
            }else{
                $data['status'] = 0;
                $data['con'] = '上传失败，题目或者内容为空';
                return response()->json($data);
            }
        }catch(\Exception $e){
            $data['status'] = 0;
            $data['con'] = '上传失败';
            return response()->json($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        
        /**
         *  判断：
         1 判断时间是否超时（学生需要）
         2 判断该学生课程中是否是status为1或者2
         2 判断该老师课程中是否是status不为4
            改变：
            1 老师开放表中状态变为？
            2 学生课时增加
            3 预约课时表中状态改变以及删除学生作文对应的id
         */
        $data = [];
        try{
            // dd($request->cateid);
            if ($request->cateid == 13) {
                $catename = 'bw_num';
            }else{
                $catename = 'sw_num';
            }
            $class = StuWcorrect::where('cid',$id)->where('status',1)->first();
            // 判断时间(18点钱可以取消)
            $date = strtotime(date('Y-m-d',$class->classtime));
            if((time() - $date + 18*3600) >=0){
                $data['status'] = 0;
                $data['con'] = '最迟当日晚18点前取消，谢谢您的配合';
                return response()->json($data);
            }
            $class->status = 3;
            if ($class->fid) {
                DB::table('stu_files')->where('fid',$class->fid)->delete();
            }

            
            // dd($time);
            
            
            $tea_class = TeaWcorrect::where('classtime',$date)->where('tid',$class->tid)->where('status','!=',4)->first();
            $tea_class->num += 1;
            if ($tea_class->num > 1) {
                $tea_class->status = 1;
            }elseif ($tea_class->num == 1) {
                $tea_class->status = 2;
            }else{
                $data['status'] = 0;
                $data['con'] = '操作失败';
                return response()->json($data);
            }

            $stu_num = Stuuser_classnum::where('uid',$class->uid)->first();
            $stu_num->$catename += 1;
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
            return response()->json($data);
        }catch(\Exception $e){
            $data['status'] = 0;
            $data['con'] = '取消失败,请联系助教（淘宝客服）';
            return response()->json($data);
        }
    }
}
