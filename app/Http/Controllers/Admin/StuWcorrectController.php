<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\TeaWcorrect;
use App\Model\StuWcorrect;
use App\Model\Teauser;
use App\Model\Stuuser;
use App\Model\Stufiles;
use App\Model\Stuuser_message;
use App\Model\Stuuser_classnum;
use DB;

class StuWcorrectController extends Controller
{
    /**
     *  审核通过
     *     @param 
     *  @return \Illuminate\Http\Response
     */
     public function shenhe($id)
    {
        $res = StuWcorrect::where('cid',$id)->first();
        if($res->status==4){
            $res->status = 5;
            $res->save();
            return back()->with('seccess','审核通过');
        }else{
            return back()->with('errors','审核失败');
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /**
         1 判断时间是否超时
         2 判断是否填入手机或者淘宝id
         3 判断是否有该用户
         4 判断该老师的该时间手否有篇数
         5 判断该学生是否有课时
         改变 课时数减掉  老师课表中状态调整和篇数调整 学生课表中添加
         */

        $res = $request->only(['tid','classtime']);
        $classtime = $request->classtime;
        // dd($classdate);
        // dd($classtime);
        try{
            if (time()-$classtime>22*3600) {
                 return back()->with('errors','超过当日22点不可预约当日批改');
            }

            if ($request->phone) {
                $res['uid'] = DB::table('stu_users')->where('phone',$request->phone)->value('id');
                // dd();
                if(!is_numeric($res['uid'])){
                    return back()->with('errors','手机号填写错误无此用户');
                }
            }elseif ($request->taobaoID) {
                $res['uid'] = DB::table('users_message')->where('taobaoID',$request->taobaoID)->value('uid');
                if(!is_numeric($res['uid'])){
                return back()->with('errors','淘宝ID填写错误无此用户');
                }
            }else{
                return back()->with('errors','未填写学生');
            }

            $t = TeaWcorrect::where('classtime',$classtime)->where('tid',$request->tid)->first();
            
            if(!is_object($t) || $t->status==3 || $t->status==4){
                return back()->with('errors','该老师已经没有篇数');
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
                return back()->with('errors','操作失败'); 
            }
            $n = Stuuser_classnum::where('uid',$res['uid'])->first();
            // $t->save();
            if ($request->cateid == 13 && $n->bw_num < 1) {
                return back()->with('errors','该学生课时数不足');
            }elseif ($request->cateid == 15 && $n->sw_num < 1) {
               return back()->with('errors','该学生课时数不足');
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
            return back()->with('success','预约成功');
        }catch(\Exception $e){
            dd($e);
            return back()->with('errors','预约失败');
        }
    }

    /**
     * 查看批改作文预约列表
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
        $rs = session('user');
        $today = date('Y-m-d',time()-24*3600);
        //设置区间默认范围查询
        $range = $request->input('range')?$request->input('range'):$today.' - '.$today;
        $range_arr = explode(' - ', $range);
        $start = strtotime($range_arr[0]);
        $end = strtotime($range_arr[1]);

        // 设置默认的下拉框信息
        $status = ($request->input('status') || $request->input('status')==='0')?$request->input('status'):2;
        $cateid = $request->input('cateid')?$request->input('cateid'):13;
        $tid = $request->input('tid')?$request->input('tid'):0;
        // dd($cateid);
        // 找到老师信息
        $tea = Teauser::where('cate',13)->orWhere('cate',15)->pluck('username','id');
        $tea_cate = Teauser::where('cate',13)->orWhere('cate',15)->pluck('cate','id');
        $tea_id = Teauser::where('cate',$cateid)->pluck('id');
        // 筛选课表中的信息
        $res = StuWcorrect::where(function($query) use($request,$tid,$status){
            $username = $request->input('username');
            if(!empty($username)){
                $uid = Stuuser_message::where('qq',$username)->orWhere('mname',$username)->orWhere('taobaoID',$username)->pluck('uid');
                // dd($uid);
                $id = Stuuser::where('phone',$username)->value('id');
                if ($id) {
                    $uid[] = $id;
                }
                $query->whereIn('uid',$uid);
            }
            if($tid != 0){
                $query->where('tid',$tid);
            }
            if ($status != 0) {
                $query->where('status',$status);
            }
        })->where('classtime','>=',$start)
        ->where('classtime','<=',$end)
        ->whereIn('tid',$tea_id)
        ->orderBy('classtime','ASC')
        ->orderBy('cid','ASC')
        ->paginate(10);
        //根据课表筛选出来的结果找到对应的学生信息
        $users = [];
        foreach ($res as $key => $value) {
            $users[$value->uid]['phone'] = Stuuser::where('id',$value->uid)->value('phone');
            $users_message = Stuuser_message::where('uid',$value->uid)->select('taobaoID','qq','mname')->get();
            $users[$value->uid][] = $users_message[0];
        }
        return view('admin.stu_wcorrect.index',compact('rs','request','res','tea','tea_cate','users','range','status','tid','cateid'));
    //     $rs = session('user');
    //     //还要传入表单用户名老师以及课程id方便老师对应并且上传
    //     return view('admin.stu_wcorrect.index',compact('rs'));
    }

    /**
     * 文件上传ajax
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        // dd($request->input());
        $data = [];
        switch ($request->cateid_u) {
            case '13':
                $cateid = 'task2';
                break;
            
            case '15':
                $cateid = 'task1';
                break;
        }
        if ($request->name == 'pdf_files') {
            $exts = ['pdf'];
            $con_con = 'pdf';
        }else{
            $exts = ['doc','docx'];
            $con_con = 'doc/docx';
        }
        if($request->isMethod('POST')){ //判断是否是POST传值
            $file = $request->file($request->name);    //接文件
            //文件是否上传成功
            if($file->isValid()){   //判断文件是否上传成功
                $originalName = $file->getClientOriginalName(); //源文件名
                $ext = $file->getClientOriginalExtension();    //文件拓展名
                if(in_array($ext, $exts)){
                    $fileName = $request->phone_u.'-'.$request->classtime_u.'-'.$request->tea_u.'-'.$cateid.'.'.$ext;  //新文件名
                    //将文件从临时目录移动到制定目录
                    $path = $file->move('uploads/class_files/correct/',$fileName);
                    $data['status'] = 1;
                    $data['con'] = '/uploads/class_files/correct/'.$fileName;
                }else{
                    $data['status'] = 0;
                    $data['con'] = '文件类型不正确，请选择'.$con_con.'文件';
                }
            }else{
                $data['status'] = 0;
                $data['con'] = '文件未能上传成功';
            }
        }else{
            $data['status'] = 0;
            $data['con'] = '未选中文件';
        }
        
        return response()->json($data);
    }

    /**
     * ajax判断并获取学生文章内容
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
     * 下载判断
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $data = [];
            // $sclass = StuSclass::where('cid',$id)->get();
            // dd($sclass);
            $files_word = StuWcorrect::where('cid',$id)->value('files_word');
            $files_pdf = StuWcorrect::where('cid',$id)->value('files_pdf');
            if ($files_pdf && $files_word) {
                $data['status'] = 1;
                $data['download_word'] = '/admin/stu_wcorrect/download_file/word/'.$id;
                $data['download_pdf'] = '/admin/stu_wcorrect/download_file/pdf/'.$id;
                $data['con_word'] = '下载word回稿';
                $data['con_pdf'] = '下载pdf回稿';
            }else{
                $data['status'] = 1;
                $data['download_word'] = 'javascript:;';
                $data['download_pdf'] = 'javascript:;';
                $data['con_word'] = '无word文件上传，请您耐心等待';
                $data['con_pdf'] = '无pdf文件上传，请您耐心等待';
            }
            return response()->json($data);
        }catch(\Exception $e){
            $data = [];
            $data['status'] = 0;
            return response()->json($data);
        }
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
        // dd($request->input());
        try{
            if($request->content && $request->title){
                $res = StuWcorrect::where('cid',$id)->first();
                if ($res->fid) {
                    $rs = Stufiles::where('fid',$res->fid)->first();
                    $rs->title = $request->title;
                    $rs->content = $request->content;
                    $rs->save();
                    return back()->with('success','修改成功');
                }else{
                    $req = $request->except('_token','_method');
                    $fid = DB::table('stu_files')->insertGetId($req);
                    $res->fid = $fid;
                    if($res->status == 1){
                        $res->status = 2;
                        $res->save();
                        return back()->with('success','上传成功');
                    }else{
                        return back()->with('errors','未知错误');
                    }
                }
            }else{
                return back()->with('errors','上传失败');
            }
        }catch(\Exception $e){
            return back()->with('errors','上传失败1');
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
        try{
            // dd($request->cb_type);
            if ($request->cateid == 13) {
                $catename = 'bw_num';
            }else{
                $catename = 'sw_num';
            }
            $class = StuWcorrect::where('cid',$id)->where('status',1)->orWhere('status',2)->first();
            $class->status = 3;
            if ($class->fid) {
                DB::table('stu_files')->where('fid',$class->fid)->delete();
            }

            $date = strtotime(date('Y-m-d',$class->classtime));
            // dd($time);

            $tea_class = TeaWcorrect::where('classtime',$date)->where('tid',$class->tid)->where('status','!=',4)->first();
            $tea_class->num += 1;
            if ($tea_class->num > 1) {
                $tea_class->status = 1;
            }elseif ($tea_class->num == 1) {
                $tea_class->status = 2;
            }else{
                return back()->with('errors','操作失败'); 
            }

            $stu_num = Stuuser_classnum::where('uid',$class->uid)->first();
            $stu_num->$catename += 1;
            // dd($stu_num->$catename);

            if (!$class || !$tea_class || !$stu_num) {
                return back()->with('errors','取消失败');
            }

            $class->save();
            $tea_class->save();
            $stu_num->save();
            return back()->with('success','取消成功');
        }catch(\Exception $e){
            return back()->with('errors','取消失败1');
        }
    }
    /**
     *  上传文件修改数据库
     *     @param 
     *  @return \Illuminate\Http\Response
     */
     public function upload_update(Request $request)
    {
        // dd($request->input());
        if($request->upload_wordname && $request->upload_pdfname && file_exists('.'.$request->upload_wordname) && file_exists('.'.$request->upload_pdfname)){
            $files = StuWcorrect::where('cid',$request->cid_u)->first();
            $files->files_word = $request->upload_wordname;
            $files->files_pdf = $request->upload_pdfname;
            if ($files->status == 2) {
                $files->status = 4;
                $files->save();
                return back()->with('success','上传成功');  
            }elseif ($files->status == 5) {
                $files->save();
                return back()->with('success','修改成功');
            }else{
                return back()->with('errors','未知错误');
            }
            
        }else{
            return back()->with('errors','未上传文件');
        }
    }
    /**
     *  下载老师回稿
     *     @param 
     *  @return \Illuminate\Http\Response
     */
     public function download_file($type,$id)
    {
        // dump($id);
        // dump($type);
        // dd(1);
        $files = StuWcorrect::where('cid',$id)->value('files_'.$type);
        
        return response()->download('.'.$files);
    }
}
