@extends('layouts.admin.admins')
@section('title','吱吱英语后台管理')
@section('content')
<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
    <div class="widget am-cf">
        <div class="widget-head am-cf">
            <div class="widget-title am-fl">添加老师</div>
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
            <form class="am-form tpl-form-border-form tpl-form-border-br" action="/admin/teauser" method="post">
                {{csrf_field()}}
                <div class="am-form-group">
                    <label for="user-name" class="am-u-sm-3 am-form-label">用户名 <span class="tpl-form-line-small-title">username</span></label>
                    <div class="am-u-sm-9">
                        <input class="tpl-form-input" name="username" placeholder="请输入用户名" type="text">
                        <small>3-12位字母、数字、下划线</small>
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="user-name" class="am-u-sm-3 am-form-label">QQ号 <span class="tpl-form-line-small-title">qq_num</span></label>
                    <div class="am-u-sm-9">
                        <input class="tpl-form-input" name="qq" placeholder="请输入老师的QQ号" type="text">
                        <small></small>
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="user-phone" class="am-u-sm-3 am-form-label">
                        身份 
                        <span class="tpl-form-line-small-title">Roles</span>
                    </label>
                    <div class="am-u-sm-9">
                        <select data-am-selected="{searchBox: 1}" style="display: none;" name="roles">
                            @foreach($role as $k=>$v)
                            <option value="{{$v->id}}">{{$v->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="user-phone" class="am-u-sm-3 am-form-label">
                        所属课程类别 
                        <span class="tpl-form-line-small-title">Cates</span>
                    </label>
                    <div class="am-u-sm-9">
                        <select data-am-selected="{searchBox: 1}" style="display: none;" name="cate">
                            
                            @foreach($cate as $k => $v)
                                <option value="{{$v['cateid']}}">
                                    {{str_repeat('&nbsp;', 8*$v['level']).'--|'.$v['catename']}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="user-phone" class="am-u-sm-3 am-form-label">
                        状态 
                        <span class="tpl-form-line-small-title">Status</span>
                    </label>
                    <div class="am-u-sm-9">
                        <select data-am-selected="{searchBox: 1}" style="display: none;" name="status">
                            <option value="1">启用</option>
                            <option value="0">禁用</option>
                        </select>
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