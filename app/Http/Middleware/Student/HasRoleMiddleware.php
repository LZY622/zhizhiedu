<?php

namespace App\Http\Middleware\Student;

use Closure;
use \DB;
use App\Model\Teauser;
use App\Model\Premission;
use App\Model\RP;

class HasRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // dd($request);
        //知道我有哪些角色 1 2 3 4
        $role = session('user_stu')->roles;

        //有了角色之后我就知道我有哪些权限

        $arr = [];
        
        $per = RP::where('r_id',$role)->get();

        foreach($per as $k=>$v){

           $arr[] = Premission::where('id',$v->p_id)->value('p_url');
        }



        //获取权限
        $arrs = array_unique($arr);

        //获取当前控制器方法的路径(url);

         // $urs = \Route::current()->getActionName();

        $uls = \Route::current()->getActionName();

        // dump($uls);

        //判断
        if(in_array($uls,$arrs)){

            return $next($request);
            
        } else {
            if ($uls == 'App\Http\Controllers\Student\StuSclassController@create') {
                return redirect('/nopermission');
            }
            return back()->with('errors','您登陆的是游客模式，无权限预约，请您点击右上角退出，点击“Study”登陆自己的账号哈！');
        }
        return $next($request);
    }
}
