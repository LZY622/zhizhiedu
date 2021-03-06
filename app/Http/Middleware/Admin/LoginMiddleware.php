<?php

namespace App\Http\Middleware\Admin;

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
        // dd(session('username'));
        if (empty(session('user')) || session('user')->status == 0) {
            return redirect('/admin/login')->with('errors', '请使用有效账号登录后访问');
        }
        $res = DB::table('admin_users')->where('id',session('user')->id)->first();
        if (is_object($res) && $res->roles == session('user')->roles) {
            return $next($request);
        }else{
            return redirect('/admin/login')->with('errors', '请使用有效账号登录后访问');
        }
        
    }
}
