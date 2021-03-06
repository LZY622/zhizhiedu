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
            // 记录他点击的链接
            return redirect('/login')->with(['login_back'=>$request->path(),'errors'=>'请使用有效账号登录后访问']);
        }
        return $next($request);
    }
}
