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
                <div class="widget-title  am-cf">助教用户管理</div>
            </div>
            <div class="widget-body  am-fr">
                <div class="am-u-sm-12 am-u-md-6 am-u-lg-6">
                    <div class="am-form-group">
                        <div class="am-btn-toolbar">
                            <div class="am-btn-group am-btn-group-xs">
                                <a href="/admin/adminuser/create" class="am-btn am-btn-default am-btn-success">
                                	<!-- <button type="button" > -->
	                                	<span class="am-icon-plus"></span> 
	                                	新增
	                                <!-- </button> -->
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                

                <div class="am-u-sm-12">
                    <table class="am-table am-table-compact am-table-striped tpl-table-black " width="100%">
                        <thead>
                            <tr>
                                <th>头像</th>
                                <th>用户名</th>
                                <th>身份</th>
                                <th>状态</th>
                                <th>操作</th>
                                <th>添加时间</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach ($res as $k => $v)
                            <tr class="gradeX">
                                <td>
                                    <img src="{{$v->img}}" class="tpl-table-line-img" width="50px" alt="">
                                </td>
                                <td class="am-text-middle">{{$v->username}}</td>
                                <td class="am-text-middle">
                                	@foreach($role as $kr=>$vr)
									@if($v->roles==$vr->id)
									{{$vr->name}}
									@endif
                                	@endforeach
                                </td>
                                <td class="am-text-middle">
                                	@if($v->status == 1)启用 @else 禁用 @endif
                                </td>
                                <td class="am-text-middle">
                                    <div class="tpl-table-black-operation">
                                        <a href="/admin/adminuser/{{$v->id}}">
                                            <i class="am-icon-pencil"></i> 编辑
                                        </a>
                                        <form action="/admin/adminuser/{{$v->id}}" method="post"style="display: inline">
				                    		{{csrf_field()}}
				                    		{{method_field('delete')}}
				                    		<button class="delete-button"><i class="am-icon-trash" type="submit"></i> 删除</button>
				                    	</form>
                                        
                                    </div>
                                </td>
                                <td class="am-text-middle">{{date('Y-m-d H:i',$v->addtime)}}</td>
                            </tr>
                            @endforeach
                            <!-- more data -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="am-u-lg-12 am-cf">
	    <div class="am-fr">
	    	{!! $res->links() !!}
	    </div>
	</div>
    
@endsection
@section('js')
<script>

    $('.alert-success').delay(2000).fadeOut(1000);
    $('.alert-warning').delay(2000).fadeOut(1000);
    $('#pagenum ul').addClass("am-pagination tpl-pagination");
    
</script>

@stop