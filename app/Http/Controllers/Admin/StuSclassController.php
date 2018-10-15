<?php
//在老师开关课表页面添加
//删除
//查看
namespace App\Http\Controllers\Admin;

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
    /**
     * 在老师开关课表页面添加预约
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /**
         1 判断时间是否超时
         2 判断是否填入手机或者淘宝id
         3 判断是否有该用户
         4 判断该课程是否是空课
         5 判断该学生是否有课时
         */
         
        $res = $request->only('cateid','tid','classtime');
        $classdate = strtotime(date('Y-m-d',$request->classtime));
        $classtime = $request->classtime-$classdate-8*3600;
        // dd($classdate);
        // dd($classtime);
        try{
            if ($request->classtime-time()<=2*3600) {
                 return back()->with('errors','预约时间不足');
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

            $t = TeaSclass::where('classdate',$classdate)->where('classtime',$classtime)->where('tid',$request->tid)->first();
            
            if($t->status){
                return back()->with('errors','该课程已经被预约');
            }
            $t->status = 1;
            $n = Stuuser_classnum::where('uid',$res['uid'])->first();
            // $t->save();
            if ($request->cateid == 0 && $n->st_sta == 1) {
                return back()->with('errors','该学生已经试听');
            }elseif ($request->cateid == 4 && $n->s_num < 0.5) {
                return back()->with('errors','该学生课时数不足');
            }elseif ($request->cateid == 5 && $n->m_num < 1) {
               return back()->with('errors','该学生课时数不足');
            }
            switch ($request->cateid) {
                case '0':
                    $t->save();
                    $n->st_sta = 1;
                    $n->save();
                    DB::table('stu_sclass')->insert($res);
                    break;
                case '4':
                    $t->save();
                    $n->s_num -= 0.5;
                    $n->save();
                    DB::table('stu_sclass')->insert($res);
                    break;
                case '5':
                    $t->save();
                    $n->m_num -= 1;
                    $n->save();
                    DB::table('stu_sclass')->insert($res);
                    break;
            }
            return back()->with('success','预约成功');
        }catch(\Exception $e){
            return back()->with('errors','预约失败');
        }
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
        $tid = $request->input('tid')?$request->input('tid'):0;
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
        return view('admin.stu_sclass.index',compact('rs','request','res','tea','users','today','range','status','tid','cateid'));
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
                $data['download'] = '/admin/stu_sclass/'.$id.'/edit';
                $data['con'] = '下载课件';
            }else{
                $data['status'] = 1;
                $data['download'] = 'javascript:;';
                $data['con'] = '还没有文件上传，请您耐心等待';
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
        // dd($id);
        /**
         *  判断：
         1 判断时间是否超时（学生需要）
         2 判断该学生课程中是否是status为1
         2 判断该老师课程中是否是status为1
            改变：
            1 老师开放表中状态变为0
            2 学生课时增加
            3 预约课时表中状态改变
         */
        try{
            // dd($request->cb_type);
            if ($request->cateid == 0) {
                $catename = 'st_sta';
                switch ($request->cb_type) {
                    case '1':
                        $num = -1;
                        break;
                    case '2':
                        $num = -1;
                        break;
                    case '3':
                        $num = -1;
                        break;
                    case '4':
                        $num = -1;
                        break;
                    case '5':
                        $num = -1;
                        break;
                }
            }elseif ($request->cateid == 4) {
                $catename = 's_num';
                switch ($request->cb_type) {
                    case '1':
                        $num = 0.5;
                        break;
                    case '2':
                        $num = 1;
                        break;
                    case '3':
                        $num = 0;
                        break;
                    case '4':
                        $num = 0.75;
                        break;
                    case '5':
                        $num = 0.25;
                        break;
                }
            }elseif ($request->cateid == 5) {
                $catename = 'm_num';
                switch ($request->cb_type) {
                    case '1':
                        $num = 1;
                        break;
                    case '2':
                        $num = 2;
                        break;
                    case '3':
                        $num = 0;
                        break;
                    case '4':
                        $num = 1.5;
                        break;
                    case '5':
                        $num = 0.5;
                        break;
                }
            }
            switch ($request->cb_type) {
                case '1':
                    $status = 3;
                    break;
                case '2':
                    $status = 4;
                    break;
                case '3':
                    $status = 5;
                    break;
                case '4':
                    $status = 6;
                    break;
                case '5':
                    $status = 7;
                    break;
            }
            $class = StuSclass::where('cid',$id)->where('status',1)->first();
            $class->status = $status;
            $date = strtotime(date('Y-m-d',$class->classtime));
            $time = $class->classtime-$date-8*3600;
            // dd($time);

            $tea_class = TeaSclass::where('classtime',$time)->where('classdate',$date)->where('tid',$class->tid)->where('status',1)->first();
            $tea_class->status = 0;

            $stu_num = Stuuser_classnum::where('uid',$class->uid)->first();
            $stu_num->$catename = $stu_num->$catename += $num;
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
}
