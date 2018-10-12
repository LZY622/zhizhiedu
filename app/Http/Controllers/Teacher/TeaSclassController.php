<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Teauser;
use App\Model\Stuuser;
use App\Model\TeaSclass;
// use CatTree;

class TeaSclassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datetime = explode('|', $request->input('classtime'));
        $date = $datetime[0];
        $time = $datetime[1]; 
        //查重
        $res = TeaSclass::where('tid',$request->input('tid'))->where('classdate',$date)->where('classtime',$time)->get();
        // 时间是否为此时之前的时间
        $ret = time() - ($date + 8*60*60 + $time);
        if (count($res) || $ret >= 0) {
            $data=['status'=>'0'];
            // return;
            return response()->json($data);
        }
        try{
            $rs = TeaSclass::create(['tid'=>$request->input('tid'),'classdate'=>$date,'classtime'=>$time]);
            $data=['status'=>'1'];
            // return;
            return response()->json($data);
        }catch(\Exception $e){
            $data=['status'=>'0'];
            // return;
            return response()->json($data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 展示老师课程表（控制开关）
     * 得到表中的开课记录如果是空的，在视图中，就是全部都是close 如果过不是空，其中如果是已预约就是booked 如果是非预约就是opened
     * @param  int  $id
     * @return 保存为固定格式的开放课程时间的数组以及已预约课程数组
     */
    public function edit($id,Request $request)
    {
        $username = '';
        if ($request->id) {
            $username = Stuuser::where('id',$request->id)->value('phone');
            // dd($username);
        }
        $rs = session('user');
        $tea = Teauser::where('cate',2)->pluck('username','id');
        // dd('tea');
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
        //空课率
        if(count($tea_sclass)){
            $empty = round(1-(count($tea_sclass_booked)/count($tea_sclass)),2)*100;
        }else{
            $empty = 100;
        }
        
        return view('teacher.tea_sclass.index',compact(['tea','rs','tea_sclass','tea_sclass_booked','empty','id','username','today']));
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
    public function destroy($id,Request $request)
    {
        // dd($id);
        $datetime = explode('|', $id);
        $date = $datetime[0];
        $time = $datetime[1];
        // 时间是否为此时之前的时间
        $ret = time() - ($date + 8*60*60 + $time);
        if ($ret >= 0) {
            $data=['status'=>'0'];
            // return;
            return response()->json($data);
        }
        try{
            $rs = TeaSclass::where('classdate',$date)->where('classtime',$time)->where('tid',$request->tid)->where('status',0)->delete();
            $data=['status'=>'1'];
            return response()->json($data);
        }catch(\Exception $e){
            $data=['status'=>'0'];
            return response()->json($data);
        }
    }
}
