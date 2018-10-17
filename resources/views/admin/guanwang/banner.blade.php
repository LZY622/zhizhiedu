@extends('layouts.admin.admins')
@section('title','吱吱英语后台管理')
@section('content')
<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
    <div class="widget am-cf">
        <div class="widget-head am-cf">
            <div class="widget-title am-fl">个人信息设置</div>
        </div>
        <div id="xinxi">
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
        </div>
        <div class="widget-body am-fr">
            <form class="am-form tpl-form-border-form tpl-form-border-br" action="" method="post" enctype="multipart/form-data" id="art_form">
                {{csrf_field()}}
                

                <div class="am-form-group">
                    <label for="user-weibo" class="am-u-sm-3 am-form-label">
                        主页banner图（背景图）
                        <span class="tpl-form-line-small-title">1280*728px</span>
                    </label>
                    <div class="am-u-sm-9">
                        <div class="am-form-group am-form-file">
                            <div class="tpl-form-file-img">
                                <img src="/student/images/bann.jpg" alt="" height="400px" id="img1">
                            </div>
                            <button type="button" class="am-btn am-btn-danger am-btn-sm">
                                <i class="am-icon-cloud-upload"></i> 
                                上传新的banner图片
                            </button>
                            <input id="file_upload" multiple="" type="file" name="file_upload">
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(function () {
        $("#file_upload").change(function () {
            uploadImage();
        })
    })
    function uploadImage() {
        //获取表单元素
        var formElement = document.querySelector("#art_form");
        //生成formData对象，并将表单元素传入
        var formData = new FormData(formElement);
        //创建xhr对象用于ajax
        var request = new XMLHttpRequest();
        //监听响应状态变化
        request.onreadystatechange=function()
        {
            if (request.readyState==4 && request.status==200)
            {
                var obj = JSON.parse(request.responseText);
                if (obj.status) {
                    $('#img1').attr('src',obj.filepath);
                    var div = $('<div class="alert alert-success" role="alert">修改成功</div>');
                    $('#xinxi div').remove();
                    $('#xinxi').append(div);
                    $('.alert-success').delay(2000).fadeOut(1000);
                    $('.alert-warning').delay(2000).fadeOut(1000);
                    window.location.reload();  
                }else{
                    var div = $('<div class="alert alert-warning" role="alert">修改失败</div>');
                    $('#xinxi div').remove();
                    $('#xinxi').append(div);
                    $('.alert-success').delay(2000).fadeOut(1000);
                    $('.alert-warning').delay(2000).fadeOut(1000);  
                }
                
                
            }
        }
        //以post方式向/admin/upload路由发送请求
        request.open("POST", "/admin/guanwang/up_banner");
        //发送请求
        request.send(formData);
    }
</script>

@stop