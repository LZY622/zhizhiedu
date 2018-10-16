<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Stuuser_classnum;
use App\Model\Teauser;
use App\Model\TeaSclass;

class StuSclassController extends Controller
{
    /**
     * 展示学生预约口语课的页面(ajax切换老师)
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $username = session('user_stu')->phone;
        $tea = Teauser::where('cate',2)->where('status',1)->pluck('username','id');
        if ($request->id) {
            $id = $request->id;
            $view = 'student.stu_sclass.ajax_teaclass';
        }else{
            $id = Teauser::where('cate',2)->where('status',1)->first()->id;
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

        return view($view,compact('tea','tea_sclass','tea_sclass_booked','id','username','today','s_num','m_num'));
    }

    /**
     * 
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = $request->id;
        try{

        }catch(\Exception $e){

            return response()->json(['status'=>2,'id'=>$id]);
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
        //
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
