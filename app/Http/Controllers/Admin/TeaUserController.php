<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Teauser;
use App\Http\Requests\Admin\TeaUserRequest;
use App\Model\Role;
use DB;
use Hash;
use CatTree;

class TeaUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $rs = session('user');
        $res = Teauser::where(function($query) use($req){
                //检测关键字
                $username = $req->input('username');
                $cate = $req->input('cate');
                //如果用户名不为空
                if(!empty($username)) {
                    $query->where('username','like','%'.$username.'%');
                }
                if($cate != 0) {
                    $query->where('cate',$cate);
                }
            })->orderBy('id', 'desc')->paginate(5);
        $class_cate = new CatTree('class_cate');
        $cate = $class_cate->getTree();
        $role = Role::get();
        return view('admin.teauser.index',compact(['res','rs','cate','req','role']));
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
        $class_cate = new CatTree('class_cate');
        $cate = $class_cate->getTree();
        return view('admin.teauser.add',compact(['rs','cate','role']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeaUserRequest $request)
    {
        $res = $request->except('_token');
        $same_user = DB::table('tea_users')->where('username',$request->username)->get();

        if(!empty($same_user[0]->username)){
            return back()->with('errors','用户名重复');
        }
        // 默认密码
        $pass = '123456';
        $res['password'] = Hash::make($pass);
        $res['addtime'] = time();
        try{
            $rs = DB::table('tea_users')->insert($res);
            return redirect('/admin/teauser')->with('success','添加成功');
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
        $res = Teauser::find($id);
        $rs = session('user');
        $role = Role::get();
        $class_cate = new CatTree('class_cate');
        $cate = $class_cate->getTree();
        // dd($res);
        return view('admin.teauser.edit',compact(['res','rs','cate','role']));
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
    public function update(TeaUserRequest $request, $id)
    {
        // dd($id);
        //验证用户名唯一

        $same_user = DB::table('tea_users')->where('username',$request->username)->get();

        if(!empty($same_user[0]->username) && $same_user[0]->id != $id){
            return back()->with('errors','用户名重复');
        }
        
        $res = $request->except('_token','_method');
        // dd($res);
        try{
            $rs = Teauser::where('id',$id)->update($res);
            if($rs){
                return redirect('/admin/teauser')->with('success','修改成功');
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
        $old_img = Teauser::find($id)->img;
        try{
            $rs = Teauser::destroy($id);
            if ($old_img != '/uploads/teacher/123.jpg') {
                unlink('.'.$old_img);
            }
            return redirect('/admin/teauser')->with('success','删除成功');
        }catch(\Exception $e){

            return back()->with('errors','删除失败');

        }
    }
}
