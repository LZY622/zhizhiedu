@extends('layouts.teacher.admins')
@section('title','吱吱英语后台管理')
@section('content')

<meta name="csrf-token" content="{{csrf_token()}}">
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
                <div class="widget-title  am-cf">口语课程管理</div>
            </div>
            <div class="widget-body  am-fr">
                <!-- <div class="am-u-sm-12 am-u-md-6 am-u-lg-3">
                    <div class="am-form-group">
                        <div class="am-btn-toolbar">
                            <div class="am-btn-group am-btn-group-xs">
                                
                            </div>
                        </div>
                    </div>
                </div> -->
                
                <form action="/teacher/stu_sclass/create" method="get">
                	
		            
                	
					<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
	                    <div class="am-form-group tpl-table-list-select">
	                    	时间范围：
	                    	<input type="text" id="test10" name="range" style="width: 30%;height: 35px" value="{{$range}}">
 				
							<script src="/laydate/laydate.js"></script>
							<script>
							//执行一个laydate实例
								laydate.render({
								  elem: '#test10'
								  ,type: 'datetime'
								  ,range: true

								}); 
							</script>
	                        

							<select  name="cateid" data-am-selected="{btnSize: 'sm'}">
	                    		<option value="a" @if($cateid=='a') selected @endif>课程类型</option>
	                            <option value="0" @if($cateid==='0') selected @endif>试听</option>
	                            <option value="4" @if($cateid==4) selected @endif>口语课</option>
	                            <option value="5" @if($cateid==5) selected @endif>口语模考</option>
	                        </select>
	                        <select data-am-selected="{btnSize: 'sm'}"  name="status">
<!-- 1：已预约 2：已完成 3：已取消 4：老师缺席 5：学生缺席 6：老师紧急取消 7：学生紧急取消  -->
	                        	<option value="1" @if($status == 1) selected @endif>已预约</option>
	                        	<option value="2" @if($status == 2) selected @endif>已完成</option>
	                        	<option value="3" @if($status == 3) selected @endif>已取消</option>
	                        	<option value="4" @if($status == 4) selected @endif>老师缺席</option>
	                        	<option value="5" @if($status == 5) selected @endif>学生缺席</option>
	                        	<option value="6" @if($status == 6) selected @endif>老师紧急取消</option>
	                        	<option value="7" @if($status == 7) selected @endif>学生紧急取消</option><option value="0" @if($status === '0') selected @endif>全部状态</option>
							</select>
						</div>
					</div>
					
					<div class="am-u-sm-12 am-u-md-12 am-u-lg-6" style="">
	                    <div class="am-input-group am-input-group-sm tpl-form-border-form cl-p">
	                        <input class="am-form-field " type="text" name="username" value="{{$request->username}}" placeholder="请输入用户名/QQ号/淘宝ID/英文名">
	                        <span class="am-input-group-btn">
								<button class="am-btn  am-btn-default am-btn-success tpl-table-list-field am-icon-search" type="submit"> 搜索</button>
							</span>
	                    </div>
	                </div>
				</form>
                <div class="am-u-sm-12">
                    <table class="am-table am-table-compact am-table-striped tpl-table-black " width="100%">
                        <thead>
                            <tr>
                                <th>课程时间</th>
                                <th>手机</th>
                                <th>淘宝ID</th>
                                <th>QQ号</th>
                                <th>英文名</th>
                                <th>老师</th>
                                <th>课程类型</th>
                                <th>状态</th>
                                <th>课程文件</th>
                                <!-- <th>操作</th> -->
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach ($res as $k => $v)
                            <tr class="gradeX">
                                <td class="am-text-middle">{{date('Y-m-d >> H:i',$v->classtime)}}</td>
                                <td class="am-text-middle">
                                	<button type="button" class="btn btn-info" data-toggle="modal" data-target=".bs-lg" style="font-size: 12px;" uid="{{$v->uid}}" phone="{{$users[$v->uid]['phone']}}">
                                		{{$users[$v->uid]['phone']}}
                                	</button>
                                </td>
                                <td class="am-text-middle">{{$users[$v->uid][0]->taobaoID}}</td>
                                <td class="am-text-middle">{{$users[$v->uid][0]->qq}}</td>
                                <td class="am-text-middle">{{$users[$v->uid][0]->mname}}</td>
                                <td class="am-text-middle">{{$tea[$v->tid]}}</td>
                                <td class="am-text-middle">
                                	@if($v->cateid==0)试听
                                	@elseif($v->cateid==4)口语正式课
                                	@elseif($v->cateid==5)口语模考
                                	@endif
                                </td>
                                <!-- 1：已预约 2：已完成 3：已取消 4：老师缺席 5：学生缺席 6：老师紧急取消 7：学生紧急取消  -->
                                <td class="am-text-middle">
                                	@if($v->status==1)已预约
                                	@elseif($v->status==2)已完成
                                	@elseif($v->status==3)已取消
                                	@elseif($v->status==4)老师缺席
                                	@elseif($v->status==5)学生缺席
                                	@elseif($v->status==6)老师紧急取消
                                	@elseif($v->status==7)学生紧急取消
                                	@endif
                                </td>
                                <td class="am-text-middle">
                                	<div class="tpl-table-black-operation">
                                    	@if($v->status<=2)
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target=".bs-modal-lg" style="font-size: 12px;" cid="{{$v->cid}}" taobaoID="{{$users[$v->uid][0]->taobaoID}}" phone="{{$users[$v->uid]['phone']}}"tea="{{$tea[$v->tid]}}"classtime="{{date('Y-m-d-H-i',$v->classtime)}}"cateid="{{$v->cateid}}">上传下载课件</button>
                                        @endif
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
    <div class="am-u-lg-12 am-cf">
	    <div class="am-fr">
	    	{!! $res->appends($request->all())->links() !!}
	    </div>
	</div>
	
	<!-- 文件模态框 -->
	<div class="modal fade bs-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="margin-top:100px;margin-left:300px;">
		<div class="modal-dialog modal-lg" role="document">
    		<div class="modal-content">
    			<div class="widget am-cf">
	    			<div class="widget-head am-cf">
			            <div class="widget-title am-fl" id="con">
			            	<!-- <span style="color:red;font-weight:900">上传成功</span> -->
			            </div>
			            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">Close</button>
			        </div>
					<div class="widget-body am-fr">
						<a href="" class="btn btn-info"></a>
						<br>
						<hr>
						<form action="/teacher/stu_sclass/upload_update" method="post" enctype="multipart/form-data" id="file">
							{{ csrf_field() }}
							<div class="am-form-group am-form-file">
								<div class="tpl-form-file-img" style="display: none;">
	                                <img src="/uploads/class_files/word.jpg" alt="" height="80px" width="80px">
	                            </div>
	                           <button type="button" class="am-btn am-btn-danger am-btn-sm">
	                                <i class="am-icon-cloud-upload"></i> 
	                                上传 / 重新上传文件
		                        </button>
		                        <input id="doc-form-file" name="files" type="file">
	                        </div>
	                        <input type="hidden" name="taobaoID_u" value="">
	                        <input type="hidden" name="phone_u" value="">
	                        <input type="hidden" name="tea_u" value="">
	                        <input type="hidden" name="cateid_u" value="">
	                        <input type="hidden" name="classtime_u" value="">
	                        <input type="hidden" name="cid_u" value="">
	                        <input type="hidden" name="upload_filename" value="">
	                        <button type="submit" class="am-btn am-btn-primary am-btn-sm" disabled id="upload_button">
		                        提交
		                    </button>
						</form>
						
					</div>
				</div>
		    </div>
  		</div>
	</div>
	<!-- 学生已完成课程的列表 -->
	<div class="modal fade bs-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="margin-top:100px;margin-left:300px;">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="widget am-cf">
	    			<div class="widget-head am-cf">
			            <div class="widget-title am-fl" id="cont">
			            	
			            </div>
			            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">Close</button>
			        </div>
				    <div class="widget-body am-fr">
				    	<table class="am-table am-table-compact am-table-striped tpl-table-black " width="100%">
				    		<thead>
				    			<tr>
				    				<th>课程时间</th>
	                                <th>老师</th>
	                                <th>课程类型</th>
	                                <th>状态</th>			
				    			</tr>
				    		</thead>
				    		<tbody id="tbody">
				    			
				    		</tbody>
				    	</table>
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
   	
   	$('button[data-target=".bs-modal-lg"]').click(function(){
   		$('input[name=taobaoID_u]').val($(this).attr('taobaoID'));
   		$('input[name=tea_u]').val($(this).attr('tea'));
   		$('input[name=phone_u]').val($(this).attr('phone'));
   		$('input[name=cateid_u]').val($(this).attr('cateid'));
   		$('input[name=classtime_u]').val($(this).attr('classtime'));
   		$('input[name=cid_u]').val($(this).attr('cid'));
   		$.ajax({
		    type:'GET',
		    url:'/teacher/stu_sclass/'+$(this).attr('cid'),
		    dataType:'json',
		    data:{},
		    success:function(data){
		    	if (data.status == 1) {
		    		var download = data.download;
		    		var con = data.con;
		    		// 'javascript:;'
		    		// console.log($('.bs-modal-lg a'));
		    		$('.bs-modal-lg a').attr('href',download);
		    		$('.bs-modal-lg a').html(con);
		    	}else{
		    		location.reload();
		    	}
		    },
		    error:function(data){
		        
		    }
		});
   	});

   	$('input[name=files]').change(function(){
   		// console.log(taobaoID);
   		var formData = new FormData($("#file")[0]);
   		$.ajax({
   			headers:{
		        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
		    },
		    type:'POST',
		    url:'/teacher/stu_sclass',
		    dataType:'json',
		    cache: false,
		    data:formData,
		    contentType: false,
            processData: false,
		    success:function(data){
		    	if (data.status==1) {
		    		$('#con>span').remove();
		    		$('input[name=upload_filename]').val(data.con);
		    		var span = $('<span style="color:red;font-weight:900">上传成功</span>');
		    		$('#con').append(span);
		    		$('.tpl-form-file-img').attr('style','display: block;')
		    		$('#upload_button').removeAttr('disabled');
		    		// span.delay(2000).remove();
		    	}else{
		    		$('#con>span').remove();
		    		$('input[name=upload_filename]').val('');	
		    		var span = $('<span style="color:red;font-weight:900">'+data.con+'</span>');
		    		// console.log(span);
		    		$('#con').append(span);
		    		$('#upload_button').attr('disabled','disabled');
		    		// span.delay(2000).remove();
		    	}
		    },
		    error:function(data){
		        
		    }
		});
   	});
   	$('button[data-target=".bs-lg"]').click(function(){
   		$('#cont').html('学生：'+$(this).attr('phone')+' 的所有预约课时');
   		$.ajax({
		    type:'GET',
		    url:'/teacher/stu_sclass',
		    dataType:'json',
		    data:{uid:$(this).attr('uid')},
		    success:function(data){
		    	if (data.status == 1) {
		    		$('#tbody>tr').remove();
		    		for (var i = data.con.length - 1; i >= 0; i--) {
		    			var tr = $('<tr class="gradeX"><td class="am-text-middle">'+data.con[i].classtime+'</td><td class="am-text-middle">'+data.con[i].tid+'</td><td class="am-text-middle">'+data.con[i].cateid+'</td><td class="am-text-middle">'+data.con[i].status+'</td></tr>');
		    			$('#tbody').append(tr);
		    		}
		    	}else{
		    		location.reload();
		    	}
		    },
		    error:function(data){
		        
		    }
		});
   	});
</script>

@stop