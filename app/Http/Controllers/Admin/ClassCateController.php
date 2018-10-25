<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use CatTree;
use DB;

class ClassCateController extends Controller
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
        $class_cate = new CatTree('class_cate');
        $res = $class_cate->getTree();
        // dd($res);
        $rs = session('user');
        return view('admin.classcate.index',compact(['res','rs']));
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
        $res = $request->except('_token');
        try{
            $rs = DB::table('class_cate')->insert($res);
            return redirect('/admin/classcate')->with('success','添加成功');
        }catch(\Exception $e){
            return back()->with('errors','添加失败');
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
        $res = $request->except('_token','_method');
        // dd($res);
        foreach ($res['catename'] as $key => $value) {
            $catename = explode('--|', $value);
            $rs = DB::table('class_cate')->where('cateid',$res['cateid'][$key])->update(['ord'=>$res['ord'][$key],'catename'=>$catename[1]]);
        }

        return redirect('/admin/classcate')->with('success','修改成功');
           
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
            $rs = DB::table('class_cate')->where('cateid',$id)->delete();
            
            return redirect('/admin/classcate')->with('success','删除成功');
        }catch(\Exception $e){

            return back()->with('errors','删除失败');

        }
    }
}
