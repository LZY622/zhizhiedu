@extends('layouts.student.studentyuyue')
@section('title','慧盈英语教育')
@section('page_title','雅思作文批改预约')
@section('num_name1','小作文批改剩余篇数')
@section('num_name2','大作文批改剩余篇数')
@section('num1',$sw_num)
@section('num2',$bw_num)
<meta name="csrf-token" content="{{csrf_token()}}">
<div id="xinxi" style="position: fixed;top: 50%;width: 100%;z-index: 100;text-align: center;" >
	@if(session('success') || (!empty($success)))  
	<div class="alert alert-success" role="alert">
	    {{session('success')?session('success'):$success}}  
	</div>
	@endif
	@if (count($errors) > 0)
	    <div class="alert alert-danger" role="alert">
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
@section('sidenav')
	@include('public.student.yuyue.sidenav_correct')
@stop
@section('content1')
<style>
	.button-leaf{
		cursor: no-drop;
	}
	.table button{
		margin-top:0px; 
		margin-bottom:0px; 
	}
	
</style>
<div class="fc-toolbar">
	<div>
		<h5>选择作文类型：</h5>
		<select  name="cateid" class="sm-form-control"  oldid="{{$cateid}}">
			<option value="13" @if($cateid==13) selected @endif>大作文批改</option>
			<option value="15" @if($cateid==15) selected @endif>小作文批改</option>
        </select>
	</div>
	<div class="line" style="margin:20px 0 20px 0;"></div>
	<h2>@if($cateid==13)大作文批改老师@elseif($cateid==15)小作文批改老师@endif未来5日空课表</h2>
	
</div>
<table class="table">
    <thead>
        <tr class="info">
            <th></th>
            @for ($i = 0; $i < 5; $i++)

			    <th>{{date('Y-m-d',$start+24*3600*$i)}}</th>

			@endfor
        </tr>
    </thead>
    <tbody>
    	@foreach ($res_tids as $k => $v)
        	<tr>
        		<th>{{$tea[$v]}}</th>
        		@for ($i = 0; $i < 5; $i++)
        			@php
					$result = DB::table('tea_wcorrect')->where('tid',$v)->where('classtime',($start+24*3600*$i))->first();
        			@endphp
    				@if(!$result)
    					<td>
							<button class="button button-3d button-small button-rounded button-leaf" style="font-size: 12px;" >
								未开放
							</button>
						</td>
					@else
						@if($result->status == 1)
						<td>
							<button class="button button-3d button-small button-rounded button-green" data-toggle="modal" data-target=".bs-modal-lg" style="font-size: 12px;" classtime="{{$start+24*3600*$i}}" tid="{{$v}}"  cateid="{{$teacateid[$v]}}" tea="{{$tea[$v]}}" date="{{date('Y-m-d',$start+24*3600*$i)}}">
								正常 ({{$result->num}} / {{$result->total_num}})
							</button>
						</td>
						@elseif($result->status == 2)
						<td>
							<button class="button button-3d button-small button-rounded button-red" data-toggle="modal" data-target=".bs-modal-lg" style="font-size: 12px;" classtime="{{$start+24*3600*$i}}" tid="{{$v}}"  cateid="{{$teacateid[$v]}}" tea="{{$tea[$v]}}" date="{{date('Y-m-d',$start+24*3600*$i)}}" >
								即将约满还有1篇
							</button>
						</td>
						@elseif($result->status == 3)
						<td>
							<button class="button button-3d button-small button-rounded button-info" style="font-size: 12px;">
								已约满
							</button>
						</td>
						@elseif($result->status == 4)
						<td>
							<button class="button button-3d button-small button-rounded button-leaf" style="font-size: 12px;">
								暂未开放
							</button>
						</td>
						@endif
    				@endif
        			
        		@endfor
        	</tr>
        @endforeach
        <!-- more data -->
    </tbody>
</table>
<div class="modal fade bs-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none; padding-right: 17px;">
	<div class="modal-dialog modal-ml">
		<div class="modal-body">
			<div class="modal-content">
    			<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
		        <div class="modal-body">
                    <input type="hidden" value="" name="tid">
                    <input type="hidden" value="" name="cateid">
                    <input type="hidden" value="" name="classtime" id="classtime">
	                <button type="button" class="button button-3d button-small button-rounded button-blue" style="margin-left:40%" id="book_stu" data-dismiss="modal" aria-hidden="true">确&nbsp;&nbsp;定</button>
				</div>
			</div>
	    </div>
	</div>
</div>
@stop
@section('content2')
<div class="tabs tabs-alt clearfix ui-tabs ui-widget ui-widget-content ui-corner-all" id="tab-7">
	<ul class="tab-nav clearfix ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
		<li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active" role="tab" tabindex="0" aria-controls="tabs-25" aria-labelledby="ui-id-9" aria-selected="true" status="1">
			<a href="#tabs-25" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-9">
				<i class="icon-home2 norightmargin"></i>&nbsp;&nbsp;待上传
			</a>
		</li>
		<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-26" aria-labelledby="ui-id-10" aria-selected="false" status="2">
			<a href="#tabs-26" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-10">待回稿</a>
		</li>
		<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-27" aria-labelledby="ui-id-11" aria-selected="false" status="3">
			<a href="#tabs-27" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-11">已回稿</a>
		</li>
		<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-28" aria-labelledby="ui-id-12" aria-selected="false" status="4">
			<a href="#tabs-28" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-12">已取消</a>
		</li>
	</ul>

	<div class="tab-container">
		<div class="tab-content clearfix ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-25" aria-labelledby="ui-id-9" role="tabpanel" aria-expanded="true" aria-hidden="false" style="display: block;">
			<table class="table table-hover" id="finishing">
				<thead>
					<tr class="danger">
						<th>上传最后期限</th>
						<th>老师</th>
						<th>作文类型</th>
						<th>上传作文</th>
						<th>取消</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
		<div class="tab-content clearfix ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-26" aria-labelledby="ui-id-10" role="tabpanel" style="display: none;" aria-expanded="false" aria-hidden="true">
			<table class="table table-hover" id="feedback">
				<thead>
					<tr class="success">
						<th>上传日期</th>
						<th>回稿最后期限</th>
						<th>老师</th>
						<th>作文类型</th>
						<th>状态</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
		<div class="tab-content clearfix ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-27" aria-labelledby="ui-id-11" role="tabpanel" style="display: none;" aria-expanded="false" aria-hidden="true">
			<table class="table table-hover" id="finished">
				<thead>
					<tr class="warning">
						<th>上传日期</th>
						<th>老师</th>
						<th>作文类型</th>
						<th>下载回稿</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
		<div class="tab-content clearfix ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-28" aria-labelledby="ui-id-12" role="tabpanel" style="display: none;" aria-expanded="false" aria-hidden="true">
			<table class="table table-hover" id="cb">
				<thead>
					<tr class="info">
						<th>原预约时间</th>
						<th>老师</th>
						<th>作文类型</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>

	</div>
</div>
<!-- 取消模态框 -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none; padding-right: 17px;">
	<div class="modal-dialog modal-ml">
		<div class="modal-body">
			<div class="modal-content">
    			<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title"></h4>
                </div>
		        <div class="modal-body">
                    <input type="hidden" value="" name="cateid_s">
	                <button type="button" class="button button-3d button-small button-rounded button-blue" style="margin-left:40%" data-dismiss="modal" aria-hidden="true" id="upd_num">确&nbsp;&nbsp;定</button>
				</div>
			</div>
	    </div>
	</div>
</div>
<!-- 学生作文模态框 -->
<div class="modal fade bs-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none; padding-right: 17px;">
	<div class="modal-dialog modal-lg">
		<div class="modal-body">
			<div class="modal-content">
    			<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title"></h4>
                    <span>当日22点之后将不允许再修改和上传，如有必须要改的地方请联系助教客服</span>
                </div>
		        <div class="modal-body">
                    <!-- 配置文件 -->
				    <script type="text/javascript" src="/ueditor/ueditor.config.js"></script>
				    <!-- 编辑器源码文件 -->
				    <script type="text/javascript" src="/ueditor/ueditor.all.js"></script>
				    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
				    <script type="text/javascript" charset="utf-8" src="/ueditor/lang/zh-cn/zh-cn.js"></script>
				    <!-- 实例化编辑器 -->

					<h4>请填写题目</h4>
					<script id="title" name="title" type="text/plain">
				        
				    </script>
				    <div class="line" style="margin:20px 0 20px 0;"></div>
				    <h4>请输入内容</h4>
				    
				    <script id="container" name="content" type="text/plain">
				        
				    </script>
                    <button type="button" class="button button-3d button-small button-rounded button-leaf" style="margin-left:40%" data-dismiss="modal" aria-hidden="true" id="submit_stu" disabled="">确&nbsp;&nbsp;定</button>
		
				</div>
			</div>
	    </div>
	</div>
</div>
@stop
@section('content3')
@stop
@section('content4')
@stop
@section('js')
<script>
$(function(){
  	$('.alert-success').delay(2000).fadeOut(1000);
  	$('.alert-danger').delay(2000).fadeOut(1000);
  	// 页面刷新显示要与传来的id的值一致
	var old_id = $('select[name=cateid]').attr('oldid');
	$('select[name=cateid]').val(old_id);
   // 模态框单击事件
    $(document).on('click','button[data-target=".bs-modal-lg"]',function(){
   		$('input[name=classtime]').val($(this).attr('classtime'));
   		$('input[name=cateid]').val($(this).attr('cateid'));
   		$('input[name=tid]').val($(this).attr('tid'));
   		var tea = $(this).attr('tea');
   		var date = $(this).attr('date');
   		var cateid = $(this).attr('cateid');
   		if (cateid == 13) {
   			var catename = '大作文';
   		}else{
   			var catename = '小作文';
   		}
   		$('.bs-modal-lg #myModalLabel').html('您将预约'+tea+'老师'+date+'的<b style="color:red">【'+catename+'】</b>需在当日晚22点前上传，否则视为作废');
   	});
   	// 作文类型下拉框改变值事件
   	$(document).on('change','select[name=cateid]',function(){
		var cateid = $('select[name=cateid]').val();
		$.ajax({
		    type:'GET',
		    url:'/students/stu_wcorrect',
		    dataType:'html',
		    
		    data:{"cateid":cateid},
		    success:function(data){
		    	$('#snav-content1').html('');
	    		$('#snav-content1').html(data);
		    	// 第一步：匹配加载的页面中是否含有js
				var regDetectJs = /<script(.|\n)*?>(.|\n|\r\n)*?<\/script>/ig;
				var jsContained = data.match(regDetectJs);
				 
				// 第二步：如果包含js，则一段一段的取出js再加载执行
				if(jsContained) {
					// 分段取出js正则
					var regGetJS = /<script(.|\n)*?>((.|\n|\r\n)*)?<\/script>/im;
				 
					// 按顺序分段执行js
					var jsNums = jsContained.length;
					for (var i=0; i<jsNums; i++) {
						var jsSection = jsContained[i].match(regGetJS);
				 
						if(jsSection[2]) {
							if(window.execScript) {
								// 给IE的特殊待遇
								window.execScript(jsSection[2]);
							} else {
								// 给其他大部分浏览器用的
								window.eval(jsSection[2]);
							}
						}
					}
				}

		    },
		    error:function(data){
		    }
		});				
	});
	// 绑定学生预约确定按钮按钮
	$(document).on('click','#book_stu',function(){
		var t = $(this);
		$.ajax({
		    type:'GET',
		    url:'/students/stu_wcorrect/create',
		    dataType:'html',
		    data:{'tid':$('input[name=tid]').val(),'cateid':$('input[name=cateid]').val(),'classtime':$('input[name=classtime]').val()},
		    success:function(data){
		    	$('#snav-content1').html('');
	    		$('#snav-content1').html(data);
		    	// 第一步：匹配加载的页面中是否含有js
				var regDetectJs = /<script(.|\n)*?>(.|\n|\r\n)*?<\/script>/ig;
				var jsContained = data.match(regDetectJs);
				 
				// 第二步：如果包含js，则一段一段的取出js再加载执行
				if(jsContained) {
					// 分段取出js正则
					var regGetJS = /<script(.|\n)*?>((.|\n|\r\n)*)?<\/script>/im;
				 
					// 按顺序分段执行js
					var jsNums = jsContained.length;
					for (var i=0; i<jsNums; i++) {
						var jsSection = jsContained[i].match(regGetJS);
				 
						if(jsSection[2]) {
							if(window.execScript) {
								// 给IE的特殊待遇
								window.execScript(jsSection[2]);
							} else {
								// 给其他大部分浏览器用的
								window.eval(jsSection[2]);
							}
						}
					}
				}
		    },
		    error:function(data){
		        //错误信息
		    }
		});
	});
	// content2
	$(document).on('click','a[href="#snav-content2"]',function(){
		$.ajax({
		    type:'POST',
		    url:'/students/stu_wcorrect',
		    dataType:'json',
		    headers:{
		        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
		    },
		    data:{'status':1},
		    success:function(data){
		    	if (data.status == '1') {
		    		$('#finishing tbody tr').remove();
		    		for (var i = 0; i < data.con.length; i++) {
		    			var d = new Date(Number(data.con[i].classtime+'000'));
		    			var tr = $('<tr><td>'+formatDate(d)+' 22:00</td><td>'+data.tea[data.con[i].tid]+'</td><td>'+data.cateid[data.tea_cate[data.con[i].tid]]+'</td><td><button class="button button-3d button-small button-rounded button-red" data-toggle="modal" data-target=".bs-modal" style="font-size: 12px;" cid="'+data.con[i].cid+'" tea="'+data.tea[data.con[i].tid]+'" classtime="'+formatDate(d)+'" cateid="'+data.tea_cate[data.con[i].tid]+'">上传 / 修改作文</button></td><td><button class="button button-3d button-small button-rounded button-blue" data-toggle="modal" data-target=".bs-example-modal-lg" style="font-size: 12px;" cid="'+data.con[i].cid+'"  tea="'+data.tea[data.con[i].tid]+'" classtime="'+formatDate(d)+'" cateid="'+data.tea_cate[data.con[i].tid]+'">取消</button></td></tr>');
		    			// // console.log(1);
		    			$('#finishing tbody').append(tr);
		    		}
		    	}
		    },
		    error:function(data){
		        //错误信息
		    }
		});
	});
	$(document).on('click','li[status="1"],li[status="2"],li[status="3"],li[status="4"]',function(){
		var t = $(this);
		$.ajax({
		    type:'POST',
		    url:'/students/stu_wcorrect',
		    dataType:'json',
		    headers:{
		        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
		    },
		    data:{'status':t.attr('status')},
		    success:function(data){
		    	if (data.status == '1') {
		    		$('#finishing tbody tr').remove();
		    		for (var i = 0; i < data.con.length; i++) {
		    			var d = new Date(Number(data.con[i].classtime+'000'));
		    			var tr = $('<tr><td>'+formatDate(d)+' 22:00</td><td>'+data.tea[data.con[i].tid]+'</td><td>'+data.cateid[data.tea_cate[data.con[i].tid]]+'</td><td><button class="button button-3d button-small button-rounded button-red" data-toggle="modal" data-target=".bs-modal" style="font-size: 12px;" cid="'+data.con[i].cid+'" tea="'+data.tea[data.con[i].tid]+'" classtime="'+formatDate(d)+'" cateid="'+data.tea_cate[data.con[i].tid]+'">上传 / 修改作文</button></td><td><button class="button button-3d button-small button-rounded button-blue" data-toggle="modal" data-target=".bs-example-modal-lg" style="font-size: 12px;" cid="'+data.con[i].cid+'"  tea="'+data.tea[data.con[i].tid]+'" classtime="'+formatDate(d)+'" cateid="'+data.tea_cate[data.con[i].tid]+'">取消</button></td></tr>');
		    			// console.log(1);
		    			$('#finishing tbody').append(tr);
		    		}
		    	}
		    	if (data.status == '2') {
		    		$('#feedback tbody tr').remove();
		    		for (var i = 0; i < data.con.length; i++) {
		    			var d = new Date(Number(data.con[i].classtime+'000')+48*3600000);
		    			var k = new Date(Number(data.con[i].classtime+'000'));
		    			var tr = $('<tr><td>'+formatDate(k)+'</td><td>'+formatDate(d)+' 00:00</td><td>'+data.tea[data.con[i].tid]+'</td><td>'+data.cateid[data.tea_cate[data.con[i].tid]]+'</td><td>'+data.sta[data.con[i].status]+'</td></tr>');
		    			// console.log(1);
		    			$('#feedback tbody').append(tr);
		    		}
		    	}
		    	if (data.status == '3') {
		    		$('#finished tbody tr').remove();
		    		for (var i = data.con.length-1; i >= 0; i--) {
		    			var d = new Date(Number(data.con[i].classtime+'000'));
		    			var tr = $('<tr><td>'+formatDate(d)+'</td><td>'+data.tea[data.con[i].tid]+'</td><td>'+data.cateid[data.tea_cate[data.con[i].tid]]+'</td><td><a href="/students/stu_wcorrect/'+data.con[i].cid+'/edit?type=word"><button class="button button-3d button-small button-rounded button-blue">word</button></a><a href="/students/stu_wcorrect/'+data.con[i].cid+'/edit?type=pdf"><button class="button button-3d button-small button-rounded button-red">pdf</button></a></td></tr>');
		    			// console.log(1);
		    			$('#finished tbody').append(tr);
		    		}
		    	}
		    	if (data.status == '4') {
		    		$('#cb tbody tr').remove();
		    		for (var i = data.con.length-1; i >= 0; i--) {
		    			var d = new Date(Number(data.con[i].classtime+'000'));
		    			var tr = $('<tr><td>'+formatDate(d)+'</td><td>'+data.tea[data.con[i].tid]+'</td><td>'+data.cateid[data.tea_cate[data.con[i].tid]]+'</td>');
		    			// console.log(1);
		    			$('#cb tbody').append(tr);
		    		}
		    	}
		    },
		    error:function(data){
		        //错误信息
		    }
		});
	});
	// 取消按钮
	$(document).on('click','button[data-target=".bs-example-modal-lg"]',function(){
   		
   		var tea = $(this).attr('tea');
   		var classtime = $(this).attr('classtime');
   		var cid = $(this).attr('cid');
   		var cateid = $(this).attr('cateid');
   		if (cateid == 13) {
   			var cate = '大作文';
   		}else{
   			var cate = '小作文';
   		}
   		$('.bs-example-modal-lg .modal-title').html('您确定取消<b style="color:red;">'+tea+'</b>老师<b style="color:red;">'+classtime+'</b>的作文批改【'+cate+'】吗？(课程id为'+cid+')');
    	$('#upd_num').attr('cid',cid);
    	$('input[name=cateid_s]').val(cateid);
   		
   	});
   	// 取消确定按钮
   	$(document).on('click','#upd_num',function(){
   		// console
   		$.ajax({
   			type:'POST',
   			url:'/students/stu_wcorrect/'+$(this).attr('cid'),
   			dataType:'json',
   			headers:{
		        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
		    },
		    data:{"_method":"delete",'cateid':$('input[name=cateid_s]').val()},
		    success:function(data){
		    	if (data.status == 1) {
		    		$('#xinxi div').remove();
		    		var div = '<div class="alert alert-success" role="alert">取消成功</div>'
		    		$('#xinxi').append(div);
		    		$('li[status="1"]').trigger('click');
		    		$('.alert-success').delay(2000).fadeOut(1000);
					$('.alert-danger').delay(2000).fadeOut(1000);
		    	}else{
		    		$('#xinxi div').remove();
		    		var div = '<div class="alert alert-danger" role="alert">'+data.con+'</div>'
		    		$('#xinxi').append(div);
		    		$('.alert-success').delay(2000).fadeOut(1000);
					$('.alert-danger').delay(2000).fadeOut(1000);
		    	}
		    },
		    error:function(data){
		        //错误信息
		    }
   		});
   	});
   	// 上传作文按钮
   	$(document).on('click','button[data-target=".bs-modal"]',function(){

   		var tea_s = $(this).attr('tea');
   		var classtime_s = $(this).attr('classtime');
   		var cid_s = $(this).attr('cid');
   		var cateid_s = $(this).attr('cateid');
   		if (cateid_s == 13) {
   			var cate_s = '大作文';
   		}else{
   			var cate_s = '小作文';
   		}
   		$('.bs-modal .modal-title').html('您查看或修改上传的是<b style="color:red;">'+tea_s+'</b>老师<b style="color:red;">'+classtime_s+'</b>的作文批改<b style="color:red;">【'+cate_s+'】</b>(课程id为'+cid_s+')');
    	$('#submit_stu').attr('cid',cid_s);
    	$.ajax({
		    type:'GET',
		    url:'/students/stu_wcorrect/'+cid_s,
		    dataType:'json',
		    data:{'classtime':classtime_s},
		    success:function(data){
	    		var ue = UE.getEditor('container');
		        var uee = UE.getEditor('title');
		        ue.ready(function() {
		            if (data.submited) {
		            	$('#submit_stu').removeClass('button-leaf');
		            	$('#submit_stu').addClass('button-blue');
		            	$('#submit_stu').removeAttr('disabled');
		            	ue.setEnabled();
		            }else{
		            	$('#submit_stu').removeClass('button-blue');
		            	$('#submit_stu').addClass('button-leaf');
		            	$('#submit_stu').attr('disabled','disabled');
		            	ue.setDisabled();
		            }
		            ue.setContent(data.content);
		        });
		        uee.ready(function() {
		            if (data.submited) {
		            	$('#submit_stu').removeAttr('disabled');
		            	uee.setEnabled();
		            }else{
		            	$('#submit_stu').attr('disabled','disabled');
		            	uee.setDisabled();
		            }
		            uee.setContent(data.title);
		        });

		    },
		    error:function(data){
		        
		    }
		});	
   	});
   	// 上传确定按钮
   	$(document).on('click','#submit_stu',function(){
   		$.ajax({
		    type:'POST',
		    url:'/students/stu_wcorrect/'+$(this).attr('cid'),
		    dataType:'json',
		    headers:{
		        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
		    },
		    data:{'_method':"PUT",'title':UE.getEditor('title').getContent(),'content':UE.getEditor('container').getContent()},
		    success:function(data){
	    		if (data.status == 1) {
		    		$('#xinxi div').remove();
		    		var div = '<div class="alert alert-success" role="alert">'+data.con+'</div>'
		    		$('#xinxi').append(div);
		    		$('li[status="1"]').trigger('click');
		    		$('.alert-success').delay(2000).fadeOut(1000);
					$('.alert-danger').delay(2000).fadeOut(1000);
		    	}else{
		    		$('#xinxi div').remove();
		    		var div = '<div class="alert alert-danger" role="alert">'+data.con+'</div>'
		    		$('#xinxi').append(div);
		    		$('.alert-success').delay(2000).fadeOut(1000);
					$('.alert-danger').delay(2000).fadeOut(1000);
		    	}
		    },
		    error:function(data){
		        
		    }
		});	
   	});
	// 时间戳转时间
	function formatDate(now) {
		var year=now.getFullYear();
		var month=now.getMonth()+1;
		var date=now.getDate();
		var hour=now.getHours();
		var minute=now.getMinutes();
		if (String(hour).length == 1) {
			hour = '0'+hour;
		}
		if (minute == 0) {
			minute = '00';
		}
		var second=now.getSeconds();
		return year+"-"+month+"-"+date;
	} 
});
</script>
@stop