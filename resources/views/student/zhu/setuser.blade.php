@extends('layouts.student.studentzhu')
@section('title','慧盈英语教育个人信息')
@section('content')

<link rel="stylesheet" href="/assets/css/amazeui.min.css" / >

<div class="tpl-block ">
    <div style="margin:0 auto;width: 80%; text-align: center;margin-top: 30px">
        <h1 style="font-size: 4rem;color: #999999;">修改您的信息</h1>
    </div>
    <div class="line" style="margin-top: 30px"></div>
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
    <div class="am-g tpl-amazeui-form">
        <div class="am-u-sm-12 am-u-md-9" style="width: 100%;background-color: #ccc">
            <form class="am-form am-form-horizontal" action="/students/do_setuser" method="post" enctype="multipart/form-data" style="margin-top: 4%; width: 100%">
                {{csrf_field()}}
                <div class="am-form-group">
                    <label for="user-name" class="am-u-sm-3 am-form-label">英文名 / Name</label>
                    <div class="am-u-sm-9">
                        <input type="text" name="mname" id="user-name" value="{{$res->mname}}">
                        <small>输入你的名字，让我们记住你。</small>
                    </div>
                        
                </div>

                <div class="am-form-group">
                    <label for="user-password" class="am-u-sm-3 am-form-label">新密码 / Password</label>
                    <div class="am-u-sm-9">
                        <input type="password" name="password" id="user-password" placeholder="请输入新密码 / Password">
                        <small>若不修改密码请填写原密码</small>
                    </div>
                </div>

                <div class="am-form-group">
                    <label for="user-password" class="am-u-sm-3 am-form-label">确认密码 / Repass</label>
                    <div class="am-u-sm-9">
                        <input type="password" name="repass" id="user-password" placeholder="请再次输入密码 / Repass">
                        <small>与上面的密码框填写一致哦</small>
                    </div>
                </div>

                <div class="am-form-group">
                    <label for="user-sex" class="am-u-sm-3 am-form-label">性别 / Sex</label>
                    <div class="am-u-sm-9">
                        <input type="radio" name="sex" value="1" @if($res->sex==1) checked @endif/>男 
                        <input type="radio" name="sex" value="0" @if($res->sex==0) checked @endif/>女
                    </div>
                </div>

                <div class="am-form-group">
                    <label class="am-u-sm-3 am-form-label">头像 / Img</label>
                    <div class="am-u-sm-9">
                        <div class="am-form-group am-form-file">
                            <button type="button" class="am-btn am-btn-danger am-btn-sm">
                                <i class="am-icon-cloud-upload"></i> 
                                上传头像图片
                            </button>
                            <input id="doc-form-file" multiple="" type="file" name="img">
                        </div>
                    </div>
                </div>

                <div class="am-form-group">
                    <label for="user-phone" class="am-u-sm-3 am-form-label">电话 / Phone</label>
                    <div class="am-u-sm-9">
                        <input type="tel" name="phone" id="user-phone" value="{{$rs->phone}}">
                    </div>
                </div>

                <div class="am-form-group">
                    <label for="user-qq" class="am-u-sm-3 am-form-label">QQ</label>
                    <div class="am-u-sm-9">
                        <input type="text" name="qq" id="user-qq" value="{{$res->qq}}">
                    </div>
                </div>

                <div class="am-form-group">
                    <label for="user-taobaoID" class="am-u-sm-3 am-form-label">淘宝ID / TaobaoID</label>
                    <div class="am-u-sm-9">
                        <input type="text" name="taobaoID" id="user-taobaoID" value="{{$res->taobaoID}}">
                    </div>
                </div>

                <div class="am-form-group">
                    <label for="user-exam_date" class="am-u-sm-3 am-form-label">考试时间 / Date</label>
                    <div class="am-u-sm-9">
                        <input type="date" name="exam_date" id="user-exam_date" value="{{$res->exam_date}}">
                    </div>
                </div>

                <div class="am-form-group">
                    <label for="user-Sgoal" class="am-u-sm-3 am-form-label">口语目标分 / Sgoal</label>
                    <div class="am-u-sm-9">
                        <input type="number" oninput="if(value>9)value=9;if(value<1)value=1;" id="user-Sgoal" name="sgoal" value="{{$res->sgoal}}" step = "0.5">
                    </div>
                </div>

                <div class="am-form-group">
                    <label for="user-Wgoal" class="am-u-sm-3 am-form-label">作文目标分 / Wgoal</label>
                    <div class="am-u-sm-9">
                        <input type="number" oninput="if(value>9)value=9;if(value<1)value=1;" id="user-Wgoal" name="wgoal" value="{{$res->wgoal}}" step = "0.5">
                    </div>
                </div>

                <button type="submit" class="am-btn am-btn-primary" style="margin-left: 35%;width: 30%">保存修改</button>
            </form>
        </div>
    </div>
</div>
@stop


@section('js')
<script>

    $('.alert-success').delay(2000).fadeOut(1000);
    $('.alert-warning').delay(2000).fadeOut(1000);
    
</script>

@stop