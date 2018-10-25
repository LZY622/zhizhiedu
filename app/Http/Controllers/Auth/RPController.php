<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Role;
use App\Model\Premission;
use App\Model\RP;
use App\Model\UR;

class RPController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin_hasrole')->only('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rs = session('user');
        $res = Role::get();
        $res_p = Premission::get();
        return view('rp',compact('rs','res','res_p'));
    }

    /**
     * 修改权限名和url
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try{
            $data = [];
            $res = Premission::where('id',$request->id)->first();
            if ($request->p_title) {
                $res->p_title = $request->p_title;
            }elseif ($request->p_url) {
                $res->p_url = $request->p_url;
            }
            
            $res->save();
            $data['status'] = 1;
            $data['con'] = '修改成功';
            return response()->json($data);
        }catch(\Exception $e){
            $data['status'] = 0;
            $data['con'] = '修改失败';
            return response()->json($data);
        }
    }

    /**
     * 添加角色
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $res = $request->except('_token');
            Role::insert($res);
            return back()->with('success','添加成功');
        }catch(\Exception $e){
            return back()->with('errors','添加失败');
        }
    }

    /**
     * 修改角色名
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
            // dd($id.$request->name);\
        try{
            $data = [];
            $res = Role::where('id',$id)->first();
            $res->name = $request->name;
            $res->save();
            $data['status'] = 1;
            $data['con'] = '修改成功';
            return response()->json($data);
        }catch(\Exception $e){
            $data['status'] = 0;
            $data['con'] = '修改失败';
            return response()->json($data);
        }
    }

    /**
     * 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        // dump($request->pid);
        // dump($id);
        $data = [];
        try{
            if ($request->pid) {
                foreach ($request->pid as $key => $value) {
                    RP::where('r_id',$id)->where('p_id',$value)->delete();
                    RP::insert(['r_id'=>$id,'p_id'=>$value]);
                }
            }else{
                RP::where('r_id',$id)->delete();
            }
            
            $data['status'] = 1;
            $data['con'] = 1;
            return response()->json($data);
        }catch(\Exception $e){
            $data['status'] = 0;
            $data['con'] = 0;
            return response()->json($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            Role::where('id',$id)->delete();
            return back()->with('success','删除成功');
        }catch(\Exception $e){
            return back()->with('errors','删除失败');
        }
    }
    /**
     *  删除权限
     *     @param 
     *  @return \Illuminate\Http\Response
     */
    public function deletep($id)
    {
        // dd($id);
        try{
            Premission::where('id',$id)->delete();
            return back()->with('success','删除权限成功');
        }catch(\Exception $e){
            return back()->with('errors','删除权限失败');
        }
    }
    /**
     *  添加权限
     *     @param 
     *  @return \Illuminate\Http\Response
     */
    public function addp(Request $request)
    {
        try{
            $data = [];
            $res = $request->except('_token');
            $pid = Premission::insertGetId($res);
            $tr = Premission::where('id',$pid)->first();
            $data['status'] = 1;
            $data['con'] = $tr;
            return response()->json($data);
        }catch(\Exception $e){
            $data['status'] = 0;
            $data['con'] = 0;
            return response()->json($data);
        }
    }
    /**
     *  展示角色允许的权限
     *     @param 
     *  @return \Illuminate\Http\Response
     */
     public function showp($id)
    {
        try{

            $data = [];
            $tr = RP::where('r_id',$id)->pluck('p_id');
            if ($tr) {
                $data['status'] = 1;
                $data['con'] = $tr;
            }else{
                $data['status'] = 1;
                $data['con'] = [];
            }
            return response()->json($data);
        }catch(\Exception $e){
            $data['status'] = 0;
            return response()->json($data);
        }
    }
}
