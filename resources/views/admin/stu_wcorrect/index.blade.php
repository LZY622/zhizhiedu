@extends('layouts.admin.admins')
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

                <div class="widget-title  am-cf">
					<button type="button" class="am-btn am-btn-info" id="back">
						<<<
					</button>
	                已预约作文批改管理
	            </div>
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
                
                <form action="/admin/stu_wcorrect/create" method="get">
                	
		            
                	
					<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
	                    <div class="am-form-group tpl-table-list-select">
	                    	日期：
	                    	<input type="text" id="test10" name="range" style="width: 30%;height: 35px" value="{{$range}}">
 				
							<script src="/laydate/laydate.js"></script>
							<script>
							//执行一个laydate实例
								laydate.render({
								  elem: '#test10'
								  ,type: 'date'
								  ,range: true
								}); 
							</script>
	                        <select data-am-selected="{btnSize: 'sm'}"  name="tid">
	                        	<option value="0" selected>所有作文批改老师</option>
	                        	@foreach($tea as $k=>$v)
				                <option value="{{$k}}" @if($k==$tid) selected @endif>
				                {{$v}}
				            	</option>
				                @endforeach
							</select>

							<select  name="cateid" data-am-selected="{btnSize: 'sm'}">
	                            <option value="13" @if($cateid==13) selected @endif>大作文批改</option>
	                            <option value="15" @if($cateid==15) selected @endif>小作文批改</option>
	                        </select>
	                        <select data-am-selected="{btnSize: 'sm'}"  name="status">
<!-- '1：未上传 2：已上传 3：已取消 4：待审核 5：已完成'  -->
	                        	<option value="1" @if($status == 1) selected @endif>未上传</option>
	                        	<option value="2" @if($status == 2) selected @endif>已上传</option>
	                        	<option value="3" @if($status == 3) selected @endif>已取消</option>
	                        	<option value="4" @if($status == 4) selected @endif>待审核</option>
	                        	<option value="5" @if($status == 5) selected @endif>已完成</option>
	                        	<option value="0" @if($status === '0') selected @endif>全部状态</option>
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
                                <th>批改类型</th>
                                <th>状态</th>
                                <th>学生文件</th>
                                <th>老师文件</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach ($res as $k => $v)
                            <tr class="gradeX">
                                <td class="am-text-middle">{{date('Y-m-d',$v->classtime)}}</td>
                                <td class="am-text-middle">{{$users[$v->uid]['phone']}}</td>
                                <td class="am-text-middle">{{$users[$v->uid][0]->taobaoID}}</td>
                                <td class="am-text-middle">{{$users[$v->uid][0]->qq}}</td>
                                <td class="am-text-middle">{{$users[$v->uid][0]->mname}}</td>
                                <td class="am-text-middle">{{$tea[$v->tid]}}</td>
                                <td class="am-text-middle">
                                	@if($tea_cate[$v->tid]==13)大作文批改
                                	@elseif($tea_cate[$v->tid]==15)小作文批改
                                	@endif
                                </td>
                                <!-- 1：未上传 2：已上传 3：已取消 4：待审核 5：已完成  -->
                                <td class="am-text-middle">
                                	@if($v->status==1)未上传
                                	@elseif($v->status==2)已上传
                                	@elseif($v->status==3)已取消
                                	@elseif($v->status==4)待审核
                                	@elseif($v->status==5)已完成
                                	@endif
                                </td>
                                <td class="am-text-middle">
                                	<div class="tpl-table-black-operation">
                                    	@if($v->status != 3)
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target=".bs-modal" style="font-size: 12px;" taobaoID="{{$users[$v->uid][0]->taobaoID}}" mname="{{$users[$v->uid][0]->mname}}" phone="{{$users[$v->uid]['phone']}}" cid="{{$v->cid}}" qq="{{$users[$v->uid][0]->qq}}" tea="{{$tea[$v->tid]}}" classtime="{{date('Y-m-d',$v->classtime)}}" cateid="{{$tea_cate[$v->tid]}}">查看 / 提交</button>
                                        @endif
                                    </div>
                                </td>
                                <td class="am-text-middle">
                                	<div class="tpl-table-black-operation">
                                    	@if($v->status != 3 && $v->status != 1)
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target=".bs-modal-lg" style="font-size: 12px;" taobaoID="{{$users[$v->uid][0]->taobaoID}}" mname="{{$users[$v->uid][0]->mname}}" phone="{{$users[$v->uid]['phone']}}" cid="{{$v->cid}}" qq="{{$users[$v->uid][0]->qq}}" tea="{{$tea[$v->tid]}}" classtime="{{date('Y-m-d',$v->classtime)}}" cateid="{{$tea_cate[$v->tid]}}">上传下载回稿</button>
                                        @endif
                                    </div>
                                </td>
                                <td class="am-text-middle">
                                    <div class="tpl-table-black-operation">
                                    	@if($v->status<=2)
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target=".bs-example-modal-lg" style="font-size: 12px;" taobaoID="{{$users[$v->uid][0]->taobaoID}}" mname="{{$users[$v->uid][0]->mname}}" phone="{{$users[$v->uid]['phone']}}" cid="{{$v->cid}}" qq="{{$users[$v->uid][0]->qq}}" tea="{{$tea[$v->tid]}}" classtime="{{date('Y-m-d',$v->classtime)}}" cateid="{{$tea_cate[$v->tid]}}">取消</button>
                                        @elseif($v->status==4)
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target=".bs-lg" style="font-size: 12px;" taobaoID="{{$users[$v->uid][0]->taobaoID}}" mname="{{$users[$v->uid][0]->mname}}" phone="{{$users[$v->uid]['phone']}}" cid="{{$v->cid}}" qq="{{$users[$v->uid][0]->qq}}" tea="{{$tea[$v->tid]}}" classtime="{{date('Y-m-d',$v->classtime)}}" cateid="{{$tea_cate[$v->tid]}}">审核通过</button>
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
	<!-- 取消模态框 -->
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="margin-top:100px;margin-left:300px;">
  		<div class="modal-dialog modal-lg" role="document">
    		<div class="modal-content">
    			<div class="widget am-cf">
    			<div class="widget-head am-cf">
		            <div class="widget-title am-fl" id="model_title"></div>
		        </div>
		        <div class="widget-body am-fr">
		            <form class="am-form tpl-form-border-form tpl-form-border-br" action="" method="post" id="upd_num">
		            	{{csrf_field()}}
		            	{{ method_field('DELETE') }}
	                    
						<input type="hidden" value="" name="cateid">
	                    <!-- </div> -->
		                <div class="am-form-group">
		                    <div class="am-u-sm-9 am-u-sm-push-3">
		                        <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success ">确定</button>
		                    </div>
		                </div>
					</form>
				</div>
			</div>
		    </div>
  		</div>
	</div>
	<!-- 审核模态框 -->
	<div class="modal fade bs-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="margin-top:100px;margin-left:300px;">
  		<div class="modal-dialog modal-lg" role="document">
    		<div class="modal-content">
    			<div class="widget am-cf">
    			<div class="widget-head am-cf">
		            <div class="widget-title am-fl" id="shenhe_model_title"></div>
		        </div>
		        <div class="widget-body am-fr">
		            <form class="am-form tpl-form-border-form tpl-form-border-br" action="" method="get" id="shenhe_upd_num">
		                <div class="am-form-group">
		                    <div class="am-u-sm-9 am-u-sm-push-3">
		                        <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success ">确定</button>
		                    </div>
		                </div>
					</form>
				</div>
			</div>
		    </div>
  		</div>
	</div>
	<!-- 学生作文模态框 -->
	<div class="modal fade bs-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="margin-top:100px;margin-left:300px;">
  		<div class="modal-dialog modal-lg" role="document">
    		<div class="modal-content">
    			<div class="widget am-cf">
	    			<div class="widget-head am-cf">
			            <div class="widget-title am-fl" id="stu_model_title"></div>
			        </div>
			        <div class="widget-body am-fr">
			        	<!-- 配置文件 -->
					    <script type="text/javascript" src="/ueditor/ueditor.config.js"></script>
					    <!-- 编辑器源码文件 -->
					    <script type="text/javascript" src="/ueditor/ueditor.all.js"></script>
					    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
					    <script type="text/javascript" charset="utf-8" src="/ueditor/lang/zh-cn/zh-cn.js"></script>
					    <!-- 实例化编辑器 -->
					    
			            <form class="am-form tpl-form-border-form tpl-form-border-br" action="" method="post" id="stu_upd_num">
							{{csrf_field()}}
							{{method_field('PUT')}}
							<h3 id="wenjian_name">文件名</h3>
							<h4>请填写题目</h4>
							<script id="title" name="title" type="text/plain">
						        
						    </script>
						    <h4>请输入内容</h4>
						    
						    <script id="container" name="content" type="text/plain">
						        
						    </script>
						    <div class="am-u-sm-9 am-u-sm-push-3">
		                        <button type="submit" class="am-btn am-btn-primary am-btn-sm" id="submit_stu" disabled>提交</button>
		                    </div>
						</form>
					</div>
				</div>
		    </div>
  		</div>
	</div>
	<!-- 老师回稿模态框 -->
	<div class="modal fade bs-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="margin-top:100px;margin-left:300px;">
		<div class="modal-dialog modal-lg" role="document">
    		<div class="modal-content">
    			<div class="widget am-cf">
    			<div class="widget-head am-cf">
		            <div class="widget-title am-fl" id="con">
		            	<!-- <span style="color:red;font-weight:900">上传成功</span> -->
		            </div>
		        </div>
				<div class="widget-body am-fr">
					<a href="" class="btn btn-info" id="word_file"></a>
					<a href="" class="btn btn-info" id="pdf_file"></a>
					<br>
					<hr>
					<form action="/admin/stu_wcorrect/upload_update" method="post" enctype="multipart/form-data" id="file">
						{{ csrf_field() }}
						<div class="am-form-group am-form-file">
							<div class="tpl-form-file-img" style="display: none;" id="word_img">
                                <img src="/uploads/class_files/word.jpg" alt="" height="80px" width="80px">
                            </div>
                           <button type="button" class="am-btn am-btn-danger am-btn-sm">
                                <i class="am-icon-cloud-upload"></i> 
                                上传 / 重新上传word文件
	                        </button>
	                        <input id="doc-form-file" name="word_files" type="file">
                        </div>
                        <div class="am-form-group am-form-file">
							<div class="tpl-form-file-img" style="display: none;" id="pdf_img">
                                <img src="/uploads/class_files/pdf.jpg" alt="" height="80px" width="80px">
                            </div>
                           <button type="button" class="am-btn am-btn-danger am-btn-sm">
                                <i class="am-icon-cloud-upload"></i> 
                                上传 / 重新上传pdf文件
	                        </button>
	                        <input id="doc-form-file" name="pdf_files" type="file">
                        </div>
                        <input type="hidden" name="taobaoID_u" value="">
                        <input type="hidden" name="phone_u" value="">
                        <input type="hidden" name="tea_u" value="">
                        <input type="hidden" name="cateid_u" value="">
                        <input type="hidden" name="classtime_u" value="">
                        <input type="hidden" name="cid_u" value="">
                        <input type="hidden" name="upload_wordname" value="">
                        <input type="hidden" name="upload_pdfname" value="">
                        <button type="submit" class="am-btn am-btn-primary am-btn-sm" disabled id="upload_button">
	                        提交
	                    </button>
					</form>
					
				</div>
				</div>
		    </div>
  		</div>
	</div>
@endsection
@section('js')
<script>
	$('#back').click(function(){
		window.history.back(-1);
	});
    $('.alert-success').delay(2000).fadeOut(1000);
    $('.alert-warning').delay(2000).fadeOut(1000);
    $('.am-fr ul').addClass("am-pagination tpl-pagination");
    // 取消按钮
   	$('button[data-target=".bs-example-modal-lg"]').click(function(){
   		var taobaoID = $(this).attr('taobaoID');
   		var phone = $(this).attr('phone');
   		var qq = $(this).attr('qq');
   		var mname = $(this).attr('mname');
   		var tea = $(this).attr('tea');
   		var classtime = $(this).attr('classtime');
   		var cid = $(this).attr('cid');
   		var cateid = $(this).attr('cateid');
   		if (cateid == 13) {
   			var cate = '大作文';
   		}else{
   			var cate = '小作文';
   		}
   		$('#model_title').html('您将取消 淘宝ID：'+taobaoID+'（手机：'+phone+'，qq：'+qq+'，英文名：'+mname+'）学生的<b style="color:red;">'+tea+'</b>老师<b style="color:red;">'+classtime+'</b>的作文批改【'+cate+'】(课程id为'+cid+')');
    	$('#upd_num').attr('action','/admin/stu_wcorrect/'+cid);
    	$('input[name=cateid]').val(cateid);
   		
   	});
   	// 学生作文查看按钮
   	$('button[data-target=".bs-modal"]').click(function(){
   		var taobaoID_s = $(this).attr('taobaoID');
   		var phone_s = $(this).attr('phone');
   		var qq_s = $(this).attr('qq');
   		var mname_s = $(this).attr('mname');
   		var tea_s = $(this).attr('tea');
   		var classtime_s = $(this).attr('classtime');
   		var cid_s = $(this).attr('cid');
   		var cateid_s = $(this).attr('cateid');
   		if (cateid_s == 13) {
   			var cate_s = '大作文';
   			var cate_se = 'Task2';
   		}else{
   			var cate_s = '小作文';
   			var cate_se = 'Task1';
   		}
   		$('#stu_model_title').html('您查看或修改的是 淘宝ID：'+taobaoID_s+'（手机：'+phone_s+'，qq：'+qq_s+'，英文名：'+mname_s+'）学生的<b style="color:red;">'+tea_s+'</b>老师<b style="color:red;">'+classtime_s+'</b>的作文批改<b style="color:red;">【'+cate_s+'】</b>(课程id为'+cid_s+')');
   		$('#wenjian_name').html('文件名为：'+cid_s+'-'+phone_s+'-'+classtime_s+'-'+cate_se+'-'+tea_s);
    	$('#stu_upd_num').attr('action','/admin/stu_wcorrect/'+cid_s);
    	$.ajax({
		    type:'GET',
		    url:'/admin/stu_wcorrect/'+cid_s,
		    dataType:'json',
		    data:{'classtime':classtime_s},
		    success:function(data){
	    		var ue = UE.getEditor('container');
		        var uee = UE.getEditor('title');
		        ue.ready(function() {
		            if (data.submited) {
		            	$('#submit_stu').removeAttr('disabled');
		            	ue.setEnabled();
		            }else{
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
   	// 判断老师回稿是否上传
   	$('button[data-target=".bs-modal-lg"]').click(function(){
   		$('input[name=taobaoID_u]').val($(this).attr('taobaoID'));
   		$('input[name=tea_u]').val($(this).attr('tea'));
   		$('input[name=phone_u]').val($(this).attr('phone'));
   		$('input[name=cateid_u]').val($(this).attr('cateid'));
   		$('input[name=classtime_u]').val($(this).attr('classtime'));
   		$('input[name=cid_u]').val($(this).attr('cid'));
   		$.ajax({
		    type:'GET',
		    url:'/admin/stu_wcorrect/'+$(this).attr('cid')+'/edit',
		    dataType:'json',
		    data:{},
		    success:function(data){
		    	if (data.status == 1) {
		    		var download_word = data.download_word;
		    		var download_pdf = data.download_pdf;
		    		var con_word = data.con_word;
		    		var con_pdf = data.con_pdf;
		    		
		    		$('#word_file').attr('href',download_word);
		    		$('#word_file').html(con_word);
		    		$('#pdf_file').attr('href',download_pdf);
		    		$('#pdf_file').html(con_pdf);
		    	}else{
		    		location.reload();
		    	}
		    },
		    error:function(data){
		        
		    }
		});
   	});

   	$('input[name=word_files]').change(function(){
   		// console.log(taobaoID);
   		var formData = new FormData($("#file")[0]);
   		$.ajax({
   			headers:{
		        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
		    },
		    type:'POST',
		    url:'/admin/stu_wcorrect?name=word_files',
		    dataType:'json',
		    cache: false,
		    data:formData,
		    contentType: false,
            processData: false,
		    success:function(data){
		    	if (data.status==1) {
		    		$('#con>span').remove();
		    		$('input[name=upload_wordname]').val(data.con);
		    		var span = $('<span style="color:red;font-weight:900">上传成功</span>');
		    		$('#con').append(span);
		    		$('#word_img').attr('style','display: block;')
		    		if ($('input[name=upload_pdfname]').val()) {
			    		$('#upload_button').removeAttr('disabled');
			    	}
		    	}else{
		    		$('#con>span').remove();
		    		$('input[name=upload_wordname]').val('');	
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
   	$('input[name=pdf_files]').change(function(){
   		// console.log(taobaoID);
   		var formData = new FormData($("#file")[0]);
   		$.ajax({
   			headers:{
		        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
		    },
		    type:'POST',
		    url:'/admin/stu_wcorrect?name=pdf_files',
		    dataType:'json',
		    cache: false,
		    data:formData,
		    contentType: false,
            processData: false,
		    success:function(data){
		    	if (data.status==1) {
		    		$('#con>span').remove();
		    		$('input[name=upload_pdfname]').val(data.con);
		    		var span = $('<span style="color:red;font-weight:900">上传成功</span>');
		    		$('#con').append(span);
		    		$('#pdf_img').attr('style','display: block;')
		    		if ($('input[name=upload_wordname]').val()) {
			    		$('#upload_button').removeAttr('disabled');
			    	}
		    	}else{
		    		$('#con>span').remove();
		    		$('input[name=upload_pdfname]').val('');	
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

   	// 审核通过按钮
   	$('button[data-target=".bs-lg"]').click(function(){
   		var taobaoID = $(this).attr('taobaoID');
   		var phone = $(this).attr('phone');
   		var qq = $(this).attr('qq');
   		var mname = $(this).attr('mname');
   		var tea = $(this).attr('tea');
   		var classtime = $(this).attr('classtime');
   		var cid = $(this).attr('cid');
   		var cateid = $(this).attr('cateid');
   		if (cateid == 13) {
   			var cate = '大作文';
   		}else{
   			var cate = '小作文';
   		}
   		$('#shenhe_model_title').html('您将审核 淘宝ID：'+taobaoID+'（手机：'+phone+'，qq：'+qq+'，英文名：'+mname+'）学生的<b style="color:red;">'+tea+'</b>老师<b style="color:red;">'+classtime+'</b>的作文批改【'+cate+'】(课程id为'+cid+')');
    	$('#shenhe_upd_num').attr('action','/admin/stu_wcorrect/shenhe/'+cid);
   	});
</script>

@stop