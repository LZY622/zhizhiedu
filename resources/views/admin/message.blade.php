@extends('layouts.admin.admins')
@section('title','吱吱英语后台管理')
@section('content')
<style type="text/css" media="screen">
	.delete-button{
		background-attachment: scroll;
		background-clip: border-box;
		background-color: rgb(231, 80, 90);
		background-image: none;
		background-origin: padding-box;
		background-position: 0% 0%;
		background-position-x: 0%;
		background-position-y: 0%;
		background-repeat: repeat;
		background-size: auto auto;
		border-bottom-color: rgb(231, 80, 90);
		border-bottom-style: solid;
		border-bottom-width: 1px;
		border-collapse: separate;
		border-image-outset: 0;
		border-image-repeat: stretch stretch;
		border-image-slice: 100%;
		border-image-source: none;
		border-image-width: 1;
		border-left-color: rgb(231, 80, 90);
		border-left-style: solid;
		border-left-width: 1px;
		border-right-color: rgb(231, 80, 90);
		border-right-style: solid;
		border-right-width: 1px;
		border-spacing: 0px 0px;
		border-top-color: rgb(231, 80, 90);
		border-top-style: solid;
		border-top-width: 1px;
		box-sizing: border-box;
		color: rgb(255, 255, 255);
		display: inline-block;
		empty-cells: show;
		font-family: "Segoe UI", "Lucida Grande", Helvetica, Arial, "Microsoft YaHei", FreeSans, Arimo, "Droid Sans", "wenquanyi micro hei", "Hiragino Sans GB", "Hiragino Sans GB W3", FontAwesome, sans-serif;
		font-feature-settings: "liga", "kern";
		font-size: 12px;
		font-weight: 400;
		line-height: 12px;
		outline-color: rgb(255, 255, 255);
		outline-style: none;
		outline-width: 0px;
		padding-bottom: 5px;
		padding-left: 6px;
		padding-right: 6px;
		padding-top: 5px;
		text-decoration: none;
		text-decoration-color: rgb(255, 255, 255);
		text-decoration-line: none;
		text-decoration-style: solid;
		text-rendering: optimizelegibility;
	}

</style>
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
	<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
        <div class="widget am-cf">
            <div class="widget-head am-cf">
                <div class="widget-title  am-cf">@if($status)已处理@else未处理@endif消息管理</div>
            </div>
            <div class="widget-body  am-fr">
                <div class="am-u-sm-12 am-u-md-6 am-u-lg-6">
                    <div class="am-form-group">
                        <div class="am-btn-toolbar">
                            <div class="am-btn-group am-btn-group-xs">
                            	@if(!$status)
                                <a href="/admin/message?status=1" class="am-btn am-btn-default am-btn-success">
                                	<!-- <button type="button" > -->
	                                	<span class="am-icon-book"></span> 
	                                	查看已处理
	                                <!-- </button> -->
                                </a>
                                @else
                                <a href="/admin/message?status=0" class="am-btn am-btn-default am-btn-success">
                                	<!-- <button type="button" > -->
	                                	<span class="am-icon-book"></span> 
	                                	查看未处理
	                                <!-- </button> -->
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                

                <div class="am-u-sm-12">
                    <table class="am-table am-table-compact am-table-striped tpl-table-black " width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>添加时间</th>
                                <th>消息类型</th>
                                <th>用户名</th>
                                <th>内容</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach ($res as $k => $v)
                            <tr class="gradeX">
                                <td>
                                    {{$v->id}}
                                </td>
                                <td class="am-text-middle">{{date('Y-m-d H:i',$v->addtime)}}</td>
                                <td class="am-text-middle">
                                	@if($v->message==1)重置密码
                                	@elseif($v->message==2)申请取消作文
                                	@endif
                                </td>
                                <td class="am-text-middle">
                                	{{$user[$v->uid]}}
                                </td>
                                <td class="am-text-middle">
                                	@if($v->others)
									申请取消{{date('Y年m月d日',$class[$v->id]->classtime)}}{{$tea[$class[$v->id]->tid]}}的作文
                                	@endif
                                </td>
                                <td class="am-text-middle">
                                    <div class="tpl-table-black-operation">
                                        <a href="/admin/message/{{$v->id}}">
                                            <i class="am-icon-pencil"></i>
											@if($status)
                                            标记未处理
                                            @else
                                            标记已处理
                                            @endif
                                        </a>
                                    </div>
                                </td>
                                
                            </tr>
                            @endforeach
                            <!-- more data -->
                        </tbody>
                    </table>
                </div>
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