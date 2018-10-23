<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Adminuser;
use App\Model\Role;
use App\Http\Requests\Admin\AdminUserRequest;
use DB;
use Hash;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rs = session('user');
        $res = Adminuser::orderBy('id', 'desc')->paginate(100);
        $role = Role::get();
        return view('admin.adminuser.index',compact(['res','rs','role']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //展示添加页面
        $rs = session('user');
        $role = Role::get();
        return view('admin.adminuser.add',compact(['rs','role']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminUserRequest $request)
    {
        $res = $request->except('_token');
        $same_user = DB::table('admin_users')->where('username',$request->username)->get();

        if(!empty($same_user[0]->username)){
            return back()->with('errors','用户名重复');
        }
        // 默认密码
        $pass = '123456';
        $res['password'] = Hash::make($pass);
        $res['addtime'] = time();
        try{
            $rs = DB::table('admin_users')->insert($res);
            return redirect('/admin/adminuser')->with('success','添加成功');
        }catch(\Exception $e){
            return back()->with('errors','添加失败');
        }
        // dd($res);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //获取单条数据
        $res = Adminuser::find($id);
        $rs = session('user');
        $role = Role::get();
        // dd($res);
        return view('admin.adminuser.edit',compact(['res','rs','role']));
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
    public function update(AdminUserRequest $request, $id)
    {
        // dd($id);
        //验证用户名唯一

        $same_user = DB::table('admin_users')->where('username',$request->username)->get();

        if(!empty($same_user[0]->username) && $same_user[0]->id != $id){
            return back()->with('errors','用户名重复');
        }
        
        $res = $request->except('_token','_method');
        // dd($res);
        try{
            $rs = Adminuser::where('id',$id)->update($res);
            if($rs){
                return redirect('/admin/adminuser')->with('success','修改成功');
            }
        }catch(\Exception $e){

            return back()->with('errors','修改失败');

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
        $old_img = Adminuser::find($id)->img;
        try{
            $rs = Adminuser::destroy($id);
            if ($old_img != '/uploads/admin/123.jpg') {
                unlink('.'.$old_img);
            }
            return redirect('/admin/adminuser')->with('success','删除成功');
        }catch(\Exception $e){

            return back()->with('errors','删除失败');

        }
    }
}
