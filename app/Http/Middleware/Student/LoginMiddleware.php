<?php

namespace App\Http\Middleware\Student;

use Closure;
use \DB;

class LoginMiddleware
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
        if (empty(session('user_stu')) || session('user_stu')->status == 0) {
            return redirect('/login')->with('errors', '请使用有效账号登录后访问');
        }
        // $res = DB::table('stu_users')->where('id',session('user_stu')->id)->first();
        // if (is_object($res) && $res->roles == session('user_stu')->roles) {
            return $next($request);
        // }else{
        //     return redirect('/login')->with('errors', '请使用有效账号登录后访问');
        // }
    }
}
