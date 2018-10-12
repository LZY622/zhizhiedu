@extends('layouts.teacher.admin_login')
@section('title','吱吱英语登录')
@section('content')
<div class="tpl-login">
    <div class="tpl-login-content">
        <div class="tpl-login-logo">
        </div>
        <span class="tpl-login-content-info">
          我没有账号请>>><a href="/teacher/signup"> 注册</a>
        </span>
        @if(session('success'))  
        <div class="alert alert-success" role="alert">
            {{session('success')}}  

        </div>
        @endif
        @if (count($errors) > 0)
            <div class="alert alert-warning" role="alert">
                <ul>
                    @if(is_object($errors))
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    @else
                        <li>{{ $errors }}</li>
                    @endif
                </ul>
            </div>
        @endif
        <form class="am-form tpl-form-line-form" action="/teacher/do_login" method="post">
            {{csrf_field()}}
            <div class="am-form-group">
                <input type="text" class="tpl-form-input" id="user-name" placeholder="请输入账号" name="username">

            </div>

            <div class="am-form-group">
                <input type="password" class="tpl-form-input" id="user-name" placeholder="请输入密码" name="password">

            </div>
            <div class="am-form-group tpl-login-remember-me">
                <input id="remember-me" type="checkbox">
                <label for="remember-me">

                记住密码
                 </label>

            </div>






            <div class="am-form-group">

                <button type="submit" class="am-btn am-btn-primary  am-btn-block tpl-btn-bg-color-success  tpl-login-btn">提交</button>

            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>

    $('.alert-success').delay(2000).fadeOut(1000);
    $('.alert-warning').delay(2000).fadeOut(1000);
    
</script>

@stop