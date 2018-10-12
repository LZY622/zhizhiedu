<?php

namespace App\Http\Middleware\Teacher;

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


        //知道我有哪些角色 1 2 3 4
        $role = session('user')->roles;

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

        $uls = \Request::getRequestUri();

        // dump($uls);

        //判断
        if(in_array($uls,$arrs)){

            return $next($request);
            
        } else {

            return redirect('/teacher/nopermission');
        }
        return $next($request);
    }
}
