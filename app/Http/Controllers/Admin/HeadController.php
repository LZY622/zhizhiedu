<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Model\SEO;
use App\Model\Lunbo;
use App\Model\Notice_con;
use Input;

class HeadController extends Controller
{
    /**
     *  SEO 修改展示
     * 	@param 
     *  @return \Illuminate\Http\Response
     */
    public function seo(Request $request)
    {
    	try{
    		$data = [];
	    	$res = SEO::where('status',1)->first();
	    	$con = $request->con;
	    	$value = $request->value;
	    	if ($con && $value) {
	       		$res->$con = $value;
	    		$res->save();
	    		$data['status'] = 1;
	    		return response()->json($data);
	    	}else{
		    	$rs = session('user');
		    	return view('admin.guanwang.seo',compact('rs','res'));	
	    	}
    	}catch(\Exception $e){
            $data['status'] = 0;
	    	return response()->json($data);
        }

    }
    /**
     *  banner展示
     * 	@param 
     *  @return \Illuminate\Http\Response
     */
    public function banner()
    {
    	$rs = session('user');
    	return view('admin.guanwang.banner',compact('rs'));	
    }
    /**
     *  banner上传
     * 	@param 
     *  @return \Illuminate\Http\Response
     */
    public function up_banner(Request $request)
    {
        //获取上传的文件对象
        $file = $request->file('file_upload');
        //判断文件是否有效
        if($file->isValid()){
            $entension = $file->getClientOriginalExtension();//上传文件的后缀名
            $entension_arr = ['jpg','png','jpeg'];
            if (!in_array($entension, $entension_arr)) {
            	return response()->json(['status'=>0]);
            }
            $newName = 'bann.jpg';
            $path = $file->move('student/images/',$newName);
            $filepath = '/student/images/'.$newName;
            //返回文件的路径
            return response()->json(['status'=>1,'filepath'=>$filepath]);
        }else{
        	return response()->json(['status'=>0]);
        }
    }
    /**
     *  学生主页轮播图模块
     * 	@param 
     *  @return \Illuminate\Http\Response
     */
    public function lunbo(Request $request)
    {
    	$rs = session('user');
    	$res = DB::table('lunbo')->get();
    	$count = count($res);
    	return view('admin.guanwang.lunbo',compact('rs','res','count'));	
    }
    /**
     *  删除某一轮播图
     * 	@param 
     *  @return \Illuminate\Http\Response
     */
    public function lunbo_shan($id)
    {
     	try{
     		Lunbo::where('id',$id)->delete();
     		return back()->with('success','删除成功');
     	}catch(\Exception $e){
	     	return back()->with('errors','删除失败');
        } 
    	
    }
     /**
      *  更改轮播图
      * 	@param 
      *  @return \Illuminate\Http\Response
      */
    public function up_lunbo(Request $request)
    {
    	try{
	     	$rs = Lunbo::where('id',$request->id)->first();
	     	// dd($rs);
	     	//获取上传的文件对象
	     	if ($file = $request->file('file_upload_'.$request->id)) {
	     		//判断文件是否有效
	     		if($file->isValid()){
		            $entension = $file->getClientOriginalExtension();//上传文件的后缀名
		            $entension_arr = ['jpg','png','jpeg'];
		            if (!in_array($entension, $entension_arr)) {
		            	return response()->json(['status'=>0]);
		            }
		            $newName = date('YmdHis').mt_rand(1000,9999).'.'.$entension;
		            $path = $file->move('uploads/banner/',$newName);
		            $filepath = '/uploads/banner/'.$newName;
                    // 删除旧照片
                    if (file_exists('.'.$rs->url)) {
                        unlink('.'.$rs->url);
                    }
		            $rs->url = $filepath;
		            $rs->save();
		            //返回文件的路径
		            return response()->json(['status'=>1,'filepath'=>$filepath]);
		        }else{
		        	return response()->json(['status'=>0]);
		        }
	     	}
	     	$name = $request->name;
	     	$value = $request->value;
	     	$rs->$name = $value;
	     	$rs->save();
	     	return response()->json(['status'=>1]);
	     }catch(\Exception $e){
	     	dd($e);
	    	return response()->json(['status'=>0]);
        } 
    }
    /**
     *  增加一个轮播
     * 	@param 
     *  @return \Illuminate\Http\Response
     */
    public function add_lunbo()
    {
    	try{
     		Lunbo::create([]);
     		return back()->with('success','添加成功');
     	}catch(\Exception $e){
	     	return back()->with('errors','添加失败');
        }     	
    }
    /**
     *  展示口语 作文预约页面中的注意事项
     *     @param 
     *  @return \Illuminate\Http\Response
     */
    public function notice()
    {
        $res = DB::table('notice_con')->get();
        $rs = session('user');
        return view('admin.guanwang.notice',compact('rs','res'));
    }
    /**
     *  更改内容
     *     @param 
     *  @return \Illuminate\Http\Response
     */
    public function notice_upd(Request $request)
    {
        try{
            $req = $request->except('_token','write','speak');
            foreach ($req as $key => $value) {
                $arr = explode('_', $key);
                $res = Notice_con::where('type',$arr[0])->first();
                $res->content = $value;
                $res->save();
            }
            
            return back()->with('success','修改成功');
        }catch(\Exception $e){
            return back()->with('errors','修改失败');
        } 
    }
}
