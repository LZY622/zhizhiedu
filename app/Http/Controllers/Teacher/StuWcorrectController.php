<?php

namespace App\Http\Controllers\Teacher;

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
    public function __construct()
    {
        $this->middleware('teacher_hasrole')->only('create','shenhe');
    }
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
        // 
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
        $cateid = $request->input('cateid')?$request->input('cateid'):session('user')->cate;
        $tid = $request->input('tid')?$request->input('tid'):session('user')->id;
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
        return view('teacher.stu_wcorrect.index',compact('rs','request','res','tea','tea_cate','users','range','status','tid','cateid'));
    //     $rs = session('user');
    //     //还要传入表单用户名老师以及课程id方便老师对应并且上传
    //     return view('teacher.stu_wcorrect.index',compact('rs'));
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
                $data['download_word'] = '/teacher/stu_wcorrect/download_file/word/'.$id;
                $data['download_pdf'] = '/teacher/stu_wcorrect/download_file/pdf/'.$id;
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
        // 
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
