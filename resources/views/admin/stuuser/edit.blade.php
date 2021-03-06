@extends('layouts.admin.admins')
@section('title','吱吱英语后台管理')
@section('content')
<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
    <div class="widget am-cf">
        <div class="widget-head am-cf">
            <div class="widget-title am-fl">修改老师信息</div>
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
            <form class="am-form tpl-form-border-form tpl-form-border-br" action="/admin/stuuser/{{$res->id}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="am-form-group">
                    <label for="user-name" class="am-u-sm-3 am-form-label">用户名(手机) <span class="tpl-form-line-small-title">username</span></label>
                    <div class="am-u-sm-9">
                        <input class="tpl-form-input" name="phone" value="{{$res->phone}}" type="text">
                        <small>6-12位字母、数字、下划线</small>
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="user-name" class="am-u-sm-3 am-form-label">淘宝ID <span class="tpl-form-line-small-title">taobaoID</span></label>
                    <div class="am-u-sm-9">
                        <input class="tpl-form-input" name="taobaoID" value="{{$res['user_message']->taobaoID}}" type="text">
                        <small></small>
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="user-name" class="am-u-sm-3 am-form-label">QQ号 <span class="tpl-form-line-small-title">qq_num</span></label>
                    <div class="am-u-sm-9">
                        <input class="tpl-form-input" name="qq" value="{{$res['user_message']->qq}}" type="text">
                        <small></small>
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="user-name" class="am-u-sm-3 am-form-label">英文名 <span class="tpl-form-line-small-title">Eng_name</span></label>
                    <div class="am-u-sm-9">
                        <input class="tpl-form-input" name="mname" value="{{$res['user_message']->mname}}" type="text">
                        <small></small>
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="user-name" class="am-u-sm-3 am-form-label">考试时间 <span class="tpl-form-line-small-title">exam_date</span></label>
                    <div class="am-u-sm-9">
                        <input class="tpl-form-input" name="exam_date" value="{{$res['user_message']->exam_date}}" type="date">
                        <small></small>
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="user-name" class="am-u-sm-3 am-form-label">口语目标分 <span class="tpl-form-line-small-title">sgoal</span></label>
                    <div class="am-u-sm-9">
                        <input class="tpl-form-input" name="sgoal" value="{{$res['user_message']->sgoal}}" type="text">
                        <small></small>
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="user-name" class="am-u-sm-3 am-form-label">写作目标分 <span class="tpl-form-line-small-title">wgoal</span></label>
                    <div class="am-u-sm-9">
                        <input class="tpl-form-input" name="wgoal" value="{{$res['user_message']->wgoal}}" type="text">
                        <small></small>
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="user-phone" class="am-u-sm-3 am-form-label">
                        性别 
                        <span class="tpl-form-line-small-title">Sex</span>
                    </label>
                    <div class="am-u-sm-9">
                        <select data-am-selected="{searchBox: 1}" style="display: none;" name="sex">
                            <option value="1" @if($res['user_message']->sex==1)selected @endif>男</option>
                            <option value="0" @if($res['user_message']->sex==0)selected @endif>女</option>
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
                            <option value="1" @if($res->status==1)selected @endif>启用</option>
                            <option value="0" @if($res->status==0)selected @endif>禁用</option>
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