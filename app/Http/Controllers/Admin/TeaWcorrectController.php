<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Teauser;
use App\Model\TeaWcorrect;
use App\Model\StuWcorrect;
use DB;

class TeaWcorrectController extends Controller
{
    /**
     * 查看未预约作文批改篇数列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request->time);
        $username = $request->input('username')?$request->input('username'):'';
        $rs = session('user');
        $today = date('Y-m-d',time());
        //设置区间默认范围查询
        $range = $request->input('range')?$request->input('range'):$today;
        $start = strtotime($range);
        $end = $start+6*24*3600;
        $cateid = $request->input('cateid')?$request->input('cateid'):0;
        // 设置查询老师
        $tid = $request->input('tid')?$request->input('tid'):0;
        // 找到老师信息
        
        $tea = Teauser::where('cate',13)->orWhere('cate',15)->pluck('username','id');
        $teacateid = Teauser::where('cate',13)->orWhere('cate',15)->pluck('cate','id');
        $teacate = [];
        $teacate['13'] = Teauser::where('cate',13)->pluck('id');
        $teacate['15'] = Teauser::where('cate',15)->pluck('id');
        // dd($tea);
        $res = TeaWcorrect::where(function($query) use($request,$tid,$teacate,$cateid){ 
            
            if($tid != 0){
                $query->where('tid',$tid);
            }
            if($cateid != 0){
                $query->whereIn('tid',$teacate[$cateid]);
            }
        })
        ->where('classtime','>=',$start)
        ->where('classtime','<=',$end)
        // ->where('classtime','>',$timemoren)
        ->orderBy('classtime','ASC');
        // $res_get = $res->get();
        // $res_classtime = $res->pluck('classtime');
        $res_tid = $res->pluck('tid');
        // dd(array_unique($res_classtime->);
        // $res_classtimes = [];
        $res_tids = [];
        // foreach ($res_classtime as $key => $value) {
        //     $res_classtimes[] = $value;
        //     $res_classtimes = array_unique($res_classtimes);
        // }
        foreach ($res_tid as $key => $value) {
            $res_tids[] = $value;
            $res_tids = array_unique($res_tids);
        }
        // dd($res_get);
        // dd($res_classtimes);
        return view('admin.tea_wcorrect.index_all',compact(['rs','request','range','res_tids','res','tid','start','cateid','tea','teacateid','username']));
    }

    /**
     * 查看老师篇数统计
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $rs = session('user');
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
        $cateid = $request->input('cateid')?$request->input('cateid'):13;
        $tid = $request->input('tid')?$request->input('tid'):0;
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
        // dd($res);
        return view('admin.tea_wcorrect.pianshu',compact('rs','request','res','tea','tea_cate','range','tid','cateid','price'));
    }

    /**
     * 开放篇数
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{    
            $res = $request->except('_token','tid');
            foreach ($res as $key => $value) {
                $r = TeaWcorrect::where('classtime',$key)->where('tid',$request->tid)->first();
                if (!is_object($r)) {
                    TeaWcorrect::insert(['tid'=>$request->tid,'classtime'=>$key]);
                }
                $r = TeaWcorrect::where('classtime',$key)->where('tid',$request->tid)->first();
                $r->num += $value;
                $r->total_num += $value;
                if ($r->num > 1) {
                    $r->status = 1;
                }elseif ($r->num == 1) {
                    $r->status = 2;
                }elseif ($r->num == 0 && $r->total_num == 0) {
                    $r->status = 4;
                }elseif ($r->num == 0 && $r->total_num != 0) {
                    $r->status = 3;
                }else{
                    return back()->with('errors','操作失败'); 
                }
                $r->save();
            }
            return back()->with('success','操作成功'); 
        }catch(\Exception $e){
            dd($e);
            return back()->with('errors','操作失败1');
        }

    }

    /**
     * 指定老师添加篇数页面
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rs = session('user');
        $date = strtotime(date('Y-m-d',time()));
        $tea = Teauser::where('cate',13)->orWhere('cate',15)->pluck('username','id');
        $cateid = Teauser::where('id',$id)->value('cate');
        $res = TeaWcorrect::where('tid',$id)->whereBetween('classtime',[$date,$date+6*24*3600])->orderBy('classtime','ASC')->pluck('num');
        $res_total = TeaWcorrect::where('tid',$id)->whereBetween('classtime',[$date,$date+7*24*3600])->orderBy('classtime','ASC')->pluck('total_num');
        

        // 如果$res元素不足7个，补足7个元素
        // 如果大于7个元素，那就是有错误的
        $res_num = count($res);
        if ($res_num <= 7) {
            for ($i=0; $i < 7-$res_num; $i++) { 
                $res[] = 0;
                $res_total[] = 0;
            }
            // dd($res);
        }else{
            return redirect('/admin');
        }
        // dd($res);
        return view('admin.tea_wcorrect.index',compact('id','date','rs','tea','res','res_total','cateid'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
