@extends('layouts.student.studentzhu')
@section('title','慧盈英语教育个人信息')
@section('content')

<link rel="stylesheet" href="/assets/css/amazeui.min.css" />

<div class="tpl-block " style="margin-top: 40%">

    <div class="am-g tpl-amazeui-form">


        <div class="am-u-sm-12 am-u-md-9">
            <form class="am-form am-form-horizontal">
                <div class="am-form-group">
                    <label for="user-name" class="am-u-sm-3 am-form-label">姓名 / Name</label>
                    <div class="am-u-sm-9">
                        <input type="text" id="user-name" placeholder="{{$res->mname}}">
                        <small>输入你的名字，让我们记住你。</small>
                    </div>
                </div>

                <div class="am-form-group">
                    <label for="user-password" class="am-u-sm-3 am-form-label">密码 / Password</label>
                    <div class="am-u-sm-9">
                        <input type="password" id="user-password" placeholder="请输入密码 / Password">
                        <small>记住这个密码哦...</small>
                    </div>
                </div>

                <div class="am-form-group">
                    <label for="user-sex" class="am-u-sm-3 am-form-label">性别 / Sex</label>
                    <div class="am-u-sm-9">
                        <input id="man" type="radio" name="1" {if value="1" } />男 
                        <input id="woman" type="radio" checked="checked" name="1"/>女
                    </div>
                </div>

                <div class="am-form-group">
                    <label for="user-phone" class="am-u-sm-3 am-form-label">电话 / Phone</label>
                    <div class="am-u-sm-9">
                        <input type="tel" id="user-phone" placeholder="{{$rs->phone}}">
                    </div>
                </div>

                <div class="am-form-group">
                    <label for="user-qq" class="am-u-sm-3 am-form-label">QQ</label>
                    <div class="am-u-sm-9">
                        <input type="text" id="user-qq" placeholder="{{$res->qq}}">
                    </div>
                </div>

                <div class="am-form-group">
                    <label for="user-taobaoID" class="am-u-sm-3 am-form-label">淘宝ID / TaobaoID</label>
                    <div class="am-u-sm-9">
                        <input type="text" id="user-taobaoID" placeholder="{{$res->taobaoID}}">
                    </div>
                </div>

                <div class="am-form-group">
                    <label for="user-exam_date" class="am-u-sm-3 am-form-label">考试时间 / Exam_date</label>
                    <div class="am-u-sm-9">
                        <input type="date" id="user-exam_date" placeholder="{{$res->exam_date}}">
                    </div>
                </div>

                <div class="am-form-group">
                    <div class="am-u-sm-9 am-u-sm-push-3">
                        <button type="button" class="am-btn am-btn-primary">保存修改</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@stop