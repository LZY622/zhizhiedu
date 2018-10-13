@extends('layouts.admin.admins')
@section('title','吱吱英语后台管理')
@section('content')
<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
    <div class="widget am-cf">
        <div class="widget-head am-cf">
            <div class="widget-title am-fl">个人信息设置</div>
        </div>
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
        <div class="widget-body am-fr">
            <form class="am-form tpl-form-border-form tpl-form-border-br" action="/admin/setuser" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="am-form-group">
                    <label for="user-name" class="am-u-sm-3 am-form-label">用户名 <span class="tpl-form-line-small-title">username</span></label>
                    <div class="am-u-sm-9">
                        <input class="tpl-form-input" name="username" value="{{$rs->username}}" type="text">
                        <small>6-12位字母、数字、下划线</small>
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="user-name" class="am-u-sm-3 am-form-label">原密码 <span class="tpl-form-line-small-title">old_password</span></label>
                    <div class="am-u-sm-9">
                        <input class="tpl-form-input" name="oldpassword" placeholder="请输入原密码" type="password">
                        <small>6-12位字母、数字、下划线</small>
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="user-name" class="am-u-sm-3 am-form-label">新密码 <span class="tpl-form-line-small-title">new_password</span></label>
                    <div class="am-u-sm-9">
                        <input class="tpl-form-input" name="password" value="" type="password" placeholder="请输入新密码">
                        <small>6-12位字母、数字、下划线</small>
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="user-name" class="am-u-sm-3 am-form-label">重复新密码 <span class="tpl-form-line-small-title">new_repass</span></label>
                    <div class="am-u-sm-9">
                        <input class="tpl-form-input" name="repass" value="" type="password" placeholder="请重新输入新密码" >
                        <small>请与新密码一致</small>
                    </div>
                </div>

                <div class="am-form-group">
                    <label for="user-weibo" class="am-u-sm-3 am-form-label">
                        头像 
                        <span class="tpl-form-line-small-title">Images</span>
                    </label>
                    <div class="am-u-sm-9">
                        <div class="am-form-group am-form-file">
                           <!--  <div class="tpl-form-file-img">
                                <img src="{{$rs->img}}" alt="" height="80px" width="80px">
                            </div> -->
                            <button type="button" class="am-btn am-btn-danger am-btn-sm">
                                <i class="am-icon-cloud-upload"></i> 
                                上传头像图片
                            </button>
                            <input id="doc-form-file" multiple="" type="file" name="img">
                        </div>
                    </div>
                </div>

                <div class="am-form-group">
                    <div class="am-u-sm-9 am-u-sm-push-3">
                        <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success ">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>

    $('.alert-success').delay(2000).fadeOut(1000);
    $('.alert-warning').delay(2000).fadeOut(1000);
    
</script>

@stop