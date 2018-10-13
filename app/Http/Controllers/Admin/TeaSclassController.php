<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Teauser;
use App\Model\Stuuser;
use App\Model\TeaSclass;
use App\Model\StuSclass;
use DB;
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
        // dd($request->time);
        $rs = session('user');
        $today = strtotime(date('Y-m-d',time()));
        //设置区间默认范围查询(过滤掉秒)
        $range = $request->input('range')?$request->input('range'):date('Y-m-d',$today).' - '.date('Y-m-d',$today+7*86400);
        $range_arr = explode(' - ', $range);
        $start = strtotime($range_arr[0]);
        $end = strtotime($range_arr[1]);
        // 设置默认查询时间
        // $timemoren = strtotime('1970-01-01'.date('H:i',time()));
        // dd($timemoren);
        // 设置查询老师
        $tid = $request->input('tid')?$request->input('tid'):0;
        // 找到老师信息
        $tea = Teauser::where('cate',2)->pluck('username','id');
        $tea_qq = Teauser::where('cate',2)->pluck('qq','id');
        // dd($tea);
        $res = TeaSclass::where(function($query) use($request,$tid){
            $time = $request->input('time');
            if($tid != 0){
                $query->where('tid',$tid);
            }
            if($time != 0){
                $time_range = strtotime('1970-01-01 '.$time);
                $query->whereBetween('classtime',[$time_range-3600,$time_range+3600]);
            }

        })
        ->where('status',0)
        ->where('classdate','>=',$start)
        ->where('classdate','<=',$end)
        // ->where('classtime','>',$timemoren)
        ->orderBy('classdate','ASC')
        ->orderBy('classtime','ASC')
        ->paginate(10);
        
        // dd($tea_qq);
        return view('admin.tea_sclass.index_all',compact(['rs','request','range','tea_qq','tea','res','tid']));
    }

    /**
     * 老师课时数统计
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $res = [];
        $rs = session('user');
        $price = ['0'=>'STPRICE','4'=>'SPEAKPRICE','5'=>'MOCKPRICE'];
        $today = date('Y-m-d',time());
        $month = date('Y-m-d',time()-24*3600*14);
        //设置区间默认范围查询
        $range = $request->input('range')?$request->input('range'):$month.' - '.$today;
        $range_arr = explode(' - ', $range);
        $start = strtotime($range_arr[0]);
        $end = strtotime($range_arr[1]);
        // dd($end);
        // 设置默认的下拉框信息
        $tid = $request->input('tid')?$request->input('tid'):0;
        $status = [2,4,5,6,7];
        $cateid = ['0'=>'st','4'=>'cla','5'=>'mt'];
        // 找到老师信息
        $tea = Teauser::where('cate',2)->pluck('username','id');
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
        // dd($tea_id);
        return view('admin.tea_sclass.keshishu',compact('rs','request','res','tea','tea_id','range','tid','price'));
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
        
        return view('admin.tea_sclass.index',compact(['tea','rs','tea_sclass','tea_sclass_booked','empty','id','username','today']));
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
