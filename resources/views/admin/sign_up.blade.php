@extends('layouts.admin.admin_login')
@section('title','吱吱英语注册')
<meta name="csrf-token" content="{{csrf_token()}}">
@section('content')
<div class="tpl-login">
    <div class="tpl-login-content">
        <div class="tpl-login-title">注册用户</div>
        <span class="tpl-login-content-info">
          我已经有账号请>>><a href="/admin/login"> 登录</a>
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

        <form class="am-form tpl-form-line-form" action="/admin/signup" method="post">
            {{csrf_field()}}
            <div class="am-form-group">
                <input type="text" class="tpl-form-input" id="username" placeholder="用户名" name="username">
            </div>

            <div class="am-form-group">
                <input type="password" class="tpl-form-input" id="user-name" placeholder="请输入密码" name="password">
            </div>

            <div class="am-form-group">
                <input type="password" class="tpl-form-input" id="user-name" placeholder="再次输入密码" name="repass">
            </div>

            <div class="am-form-group">
                <input type="text" class="tpl-form-input" id="user-name" placeholder="验证码(点击图片刷新)" style="width: 70%;display: inline;" name="code">
                <img src="/admin/code" alt="" style="display: inline;" onclick="this.src=this.src+='?1'">
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