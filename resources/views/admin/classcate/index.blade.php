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
	            <div class="widget-title am-fl">添加课程分类</div>
	        </div>
	        <div class="widget-body am-fr">
	            <form class="am-form tpl-form-border-form tpl-form-border-br" action="/admin/classcate" method="post">
	                {{csrf_field()}}
	                <div class="am-form-group">
	                    <label for="user-name" class="am-u-sm-3 am-form-label">分类名 <span class="tpl-form-line-small-title">catename</span></label>
	                    <div class="am-u-sm-9">
	                        <input class="tpl-form-input" name="catename" placeholder="请输入分类名" type="text">
	                    </div>
	                </div>
	                <div class="am-form-group">
	                    <label for="user-phone" class="am-u-sm-3 am-form-label">
	                        课程分类 
	                        <span class="tpl-form-line-small-title">cate</span>
	                    </label>
	                    <div class="am-u-sm-9">
	                        <select data-am-selected="{searchBox: 1}" style="display: none;" name="pid">
	                        	@foreach($res as $k => $v)
	                            <option value="{{$v['cateid']}}">{{str_repeat('&nbsp;', 8*$v['level']).'--|'.$v['catename']}}</option>
	                            @endforeach
	                        </select>
	                    </div>
	                </div>
	                <div class="am-form-group">
	                    <div class="am-u-sm-9 am-u-sm-push-3">
	                        <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success am-icon-plus"> 添加</button>
	                    </div>
	                </div>
	            </form>
	        </div>
	    </div>
	</div>
	<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
        <div class="widget am-cf">
            <div class="widget-head am-cf">
                <div class="widget-title  am-cf">课程分类列表</div>
            </div>
            <div class="widget-body  am-fr">
                
                

                <div class="am-u-sm-12">
                    <table class="am-table am-table-compact am-table-striped tpl-table-black " width="100%">
                        <thead>
                            <tr>
                                <th>排序</th>
                                <th>分类名</th>
                                <th>删除</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<form action="/admin/classcate/{{$res[1]['cateid']}}" method="post" id="update_cate">
                        		{{ csrf_field() }}
                				{{ method_field('PUT') }}
                        	</form>
                        	@foreach ($res as $k => $v)
                            <tr class="gradeX">
                                <td style="width: 10%">
                                	<input type="text" value="{{$v['ord']}}" class="am-text-middle" style="width: 50%;" form="update_cate" name="ord[]">
                                    
                                </td>
                                <td>
                                	<input type="text" value="{{str_repeat('&nbsp;', 8*$v['level']).'--|'.$v['catename']}}" class="am-text-middle" style="width: 70%;" form="update_cate" name="catename[]">
                                </td>
                                <input type="hidden" value="{{$v['cateid']}}" name="cateid[]" form="update_cate">
                                <td>
                                	@if(empty($v['child']))
                                	<form action="/admin/classcate/{{$v['cateid']}}" method="post"style="display: inline">
			                    		{{csrf_field()}}
			                    		{{method_field('delete')}}
			                    		<button class="delete-button"><i class="am-icon-trash" type="submit"></i> 删除</button>
			                    	</form>
			                    	@endif
                                </td>
                            </tr>   
                            @endforeach
                            <!-- more data -->
                        </tbody>
                    </table>
                </div>
                <div class="am-u-sm-12 am-u-md-6 am-u-lg-6" style="float: left;">
                    <div class="am-form-group">
                        <div class="am-btn-toolbar">
                            <div class="am-btn-group am-btn-group-xs">
                                <button type="submit" class="am-btn am-btn-default am-btn-success" form="update_cate">
                                	<!-- <button type="button" > -->
	                                	<span class="am-icon-pencil"></span> 
	                                	修改
	                                <!-- </button> -->
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
@endsection
@section('js')
<script>

    $('.alert-success').delay(2000).fadeOut(1000);
    $('.alert-warning').delay(2000).fadeOut(1000);
    $('.am-fr ul').addClass("am-pagination tpl-pagination");
    
</script>

@stop