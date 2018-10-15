<?php
//在老师开关课表页面添加
//删除
//查看
namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Model\TeaSclass;
use App\Model\StuSclass;
use App\Model\Stuuser_classnum;
use App\Model\Stuuser;
use App\Model\Teauser;
use App\Model\Stuuser_message;
use CatTree;

class StuSclassController extends Controller
{
    public function __construct()
    {
        $this->middleware('teacher_hasrole')->only('create');
    }
    /**
     * 在老师开关课表页面添加预约
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $res = StuSclass::where('uid',$request->uid)->get();
        $tea = Teauser::where('cate',2)->where('status',1)->pluck('username','id');
        $cateid = [0=>'试听',4=>'口语课',5=>'口语模考'];
        $status = [1=>'已预约',2=>'已完成',3=>'已取消',4=>'老师缺席',5=>'学生缺席',6=>'老师紧急取消',7=>'学生紧急取消'];
        foreach ($res as $key => $value) {
            $value->tid = $tea[$value->tid];
            $value->classtime = date('Y-m-d H:i:s',$value->classtime);
            $value->cateid = $cateid[$value->cateid];
            $value->status = $status[$value->status];
        }
        if ($res) {
            $data['status'] = 1;
            $data['con'] = $res;
        }else{
            $data['status'] = 0;
        }
        return response()->json($data);
    }
    /**
     *  老师开关课表页面中的预约信息查询
     *     @param 
     *  @return \Illuminate\Http\Response
     */
     public function book_info(Request $request)
    {
        $data = [];
        // dd($cate_arr);
        $bookinfo = DB::table('stu_sclass')->where('classtime',$request->classtime)->where('tid',$request->tid)->where('status','<=',2)->first();
        $data['phone'] = Stuuser::where('id',$bookinfo->uid)->value('phone');
        $data['taobaoID'] = Stuuser_message::where('uid',$bookinfo->uid)->value('taobaoID');
        switch ($bookinfo->cateid) {
            case '0':
                $data['catename'] = '(试听)';
                break;
            case '4':
                $data['catename'] = '(正课)';
                break;
            case '5':
                $data['catename'] = '(模考)';
                break;
        }
        $data['status'] = 1;
        $data['bookedtime'] = $request->bookedtime;
        return response()->json($data);
    } 
    /**
     * 展示已预约但未完成的课程
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // dd($request->range);
        
        // dd($id);
        $rs = session('user');
        $today = strtotime(date('Y-m-d',time()));
        //设置区间默认范围查询(过滤掉秒)
        $range = $request->input('range')?$request->input('range'):date('Y-m-d H:i:s',$today).' - '.date('Y-m-d H:i:s',$today+7*86400);
        $range_arr = explode(' - ', $range);
        $start_time = strtotime($range_arr[0]);
        $end_time = strtotime($range_arr[1]);
        $start = strtotime(date('Y-m-d H:i',$start_time));
        $end = strtotime(date('Y-m-d H:i',$end_time));
        // 设置默认的下拉框信息
        $status = ($request->input('status') || $request->input('status')==='0')?$request->input('status'):1;
        if ($request->input('cateid') || $request->input('cateid') === '0') {
            $cateid = $request->input('cateid');
        }else{
            $cateid = 'a';
        }
        $tid = $request->input('tid')?$request->input('tid'):session('user')->id;
        // dd($cateid);
        // 找到老师信息
        $tea = Teauser::where('cate',2)->where('status',1)->pluck('username','id');
        // 筛选课表中的信息
        $res = StuSclass::where(function($query) use($request,$tid,$cateid,$status){
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
            if ($cateid != 'a') {
                $query->where('cateid',$cateid);
            }
            if ($status != 0) {
                $query->where('status',$status);
            }

        })->where('classtime','>=',$start)
        ->where('classtime','<=',$end)
        ->orderBy('classtime','ASC')
        ->paginate(10);
        //根据课表筛选出来的结果找到对应的学生信息
        $users = [];
        foreach ($res as $key => $value) {
            $users[$value->uid]['phone'] = Stuuser::where('id',$value->uid)->value('phone');
            $users_message = Stuuser_message::where('uid',$value->uid)->select('taobaoID','qq','mname')->get();
            $users[$value->uid][] = $users_message[0];
        }
        return view('teacher.stu_sclass.index',compact('rs','request','res','tea','users','today','range','status','tid','cateid'));
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
            case '0':
                $cateid = 'st';
                break;
            case '4':
                $cateid = 'class';
                break;
            case '5':
                $cateid = 'mock';
                break;
        }
        if($request->isMethod('POST')){ //判断是否是POST传值
            $file = $request->file('files');    //接文件
            //文件是否上传成功
            if($file->isValid()){   //判断文件是否上传成功
                $originalName = $file->getClientOriginalName(); //源文件名
                $ext = $file->getClientOriginalExtension();    //文件拓展名
                if(in_array($ext, ['doc','pdf','docx'])){
                    $fileName = $request->phone_u.'-'.$request->classtime_u.'-'.$request->tea_u.'-'.$cateid.'.'.$ext;  //新文件名
                    //将文件从临时目录移动到制定目录
                    $path = $file->move('uploads/class_files/speak/',$fileName);
                    $data['status'] = 1;
                    $data['con'] = '/uploads/class_files/speak/'.$fileName;
                }else{
                    $data['status'] = 0;
                    $data['con'] = '文件类型不正确，请选择doc docx 或者pdf文件';
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
     * 下载 判断 ajax
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $data = [];
            // $sclass = StuSclass::where('cid',$id)->get();
            // dd($sclass);
            $files = StuSclass::where('cid',$id)->value('files');
            if ($files) {
                $data['status'] = 1;
                $data['download'] = '/teacher/stu_sclass/'.$id.'/edit';
                $data['con'] = '下载课件';
            }else{
                $data['status'] = 1;
                $data['download'] = 'javascript:;';
                $data['con'] = '还没有文件上传，请您抓紧时间上传';
            }
            return response()->json($data);
        }catch(\Exception $e){
            $data = [];
            $data['status'] = 0;
            return response()->json($data);
        }
    }

    /**
     * 下载操作
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
     *  修改上传文件数据库里面的信息
     *     @param 
     *  @return \Illuminate\Http\Response
     */
     public function upload_update(Request $request)
    {
        // dd($request->input());
        if($request->upload_filename && file_exists('.'.$request->upload_filename)){
            $files = StuSclass::where('cid',$request->cid_u)->first();
            $files->files = $request->upload_filename;
            $files->status = 2;
            $files->save();
            return back()->with('success','上传成功');
        }else{
            return back()->with('errors','未上传文件');
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
}
