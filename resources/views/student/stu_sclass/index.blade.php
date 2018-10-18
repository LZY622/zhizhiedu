@extends('layouts.student.studentyuyue')
@section('title','慧盈英语教育')
@section('page_title','雅思口语预约')
@section('num_name1','口语课剩余课时')
@section('num_name2','口语模考剩余课时')
@section('num1',$s_num)
@section('num2',$m_num)
<meta name="csrf-token" content="{{csrf_token()}}">
<!-- 起初提醒的模态框 -->
<div class="modal fade notice" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none; padding-right: 17px;">
	<div class="modal-dialog modal-ml">
		<div class="modal-body">
			<div class="modal-content">
    			<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">雅思口语预约前请仔细阅读</h4>
                </div>
		        <div class="modal-body">
                    <div id="notice_con" class="modal-body"></div>
                    <input type="hidden" name="notice_con" value="{{$modal_con}}">
                    <button type="button" class="button button-3d button-small button-rounded button-blue" data-dismiss="modal" aria-hidden="true" id="notice_close">已经晓得，谢谢！</button>
                    <label><input type="checkbox" name="tan" value="1"> 不再自动弹出</label>
				</div>
			</div>
	    </div>
	</div>
</div>
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
	@include('public.student.yuyue.sidenav_speak')
@stop
@section('content1')

<style>
	.button-teal{
		cursor: no-drop;
	}
	.table button{
		margin-top:0px; 
		margin-bottom:0px; 
	}
	
</style>
<div class="fc-toolbar">
	<div>
		<h5>选择老师：</h5>
		<select  name="tea_name" class="sm-form-control"  oldid="{{$id}}">
			@foreach($tea as $k=>$v)
            <option value="{{$k}}" @if($k==$id) selected @endif>
            {{$v}}
        	</option>
            @endforeach
        </select>
	</div>
	<div class="line" style="margin:20px 0 20px 0;"></div>
	<h2>{{$tea[$id]}}未来5日空课表</h2>
	
</div>


<table class="table">
    <thead>
        <tr>
        	<th class="">Time</th>
        	@for ($i = 0; $i < 5; $i++)
            <th class="info">
                <span>{{date('Y/m/d (D)',$today+24*3600*$i)}}</span>
            </th>
            @endfor
        </tr>
              
    </thead>
    <tbody id="class_book">
    	<td style="padding:0px">
        	<table class="table">
        		@for ($i = 0; $i < 33; $i++)

                <tr class="info">
                    <td>
                        {{date('H:i',-3600+($i*1800))}}
                    </td>
            	</tr>
				@endfor
        	</table>
        </td>
        @for($i = 0; $i < 5; $i++)
			@php
		$date = strtotime(date('Y-m-d',time()))+($i*86400);
			@endphp
        <td style="padding:0px">
            <table class="table">
            	@for ($j = 0; $j < 33; $j++)
            	@php
					$time = -3600+($j*1800);
				@endphp
            	<tr>
                	@if($tea_sclass)
                        @if(in_array($date.'|'.$time,$tea_sclass))
							@if(in_array($date.'|'.$time,$tea_sclass_booked))
							<td style="padding-bottom: 0px;padding-top: 4.85px">
								<button class="button button-3d button-small button-rounded button-red button-red" classtime="{{$date.'|'.$time}}">
									booked
								</button>
							@else
							<td style="padding-bottom: 0px;padding-top: 4.85px">
								<button class="button button-3d button-small button-rounded button-green" classtime="{{$date.'|'.$time}}" tea="{{$tea[$id]}}" date_date="{{date('Y-m-d',$date)}}" date_time="{{date(' H:i',$time)}}" date_time_end="{{date(' H:i',$time+25*60)}}">
									opened
								</button>
							@endif
						@else
						<td style="padding-bottom: 0px;padding-top: 4.85px">
							<button class="button button-3d button-small button-rounded button-leaf" classtime="{{$date.'|'.$time}}">
								closed
							</button>
                        @endif 
                    @else
                    <td style="padding-bottom: 0px;padding-top: 4.85px">
	                    <button class="button button-3d button-small button-rounded button-leaf" classtime="{{$date.'|'.$time}}">
							closed
						</button>
                    @endif
                    </td>
            	</tr>
            	@endfor
            </table>
        </td>
        @endfor
    </tbody>
</table>
<!-- 预约按钮 -->
<div style="position: fixed;bottom: 20%;left: 50%;z-index: 20;">
	<button class="button button-rounded button-reveal button-xlarge button-dirtygreen" data-target=".chooseclass" id="book_one">
		<i class="icon-book"></i>
		<span>预&nbsp;&nbsp;&nbsp;约</span>
	</button>
</div>
<div class="modal fade chooseclass" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none; padding-right: 17px;">
    <div class="modal-dialog modal-ml">
        <div class="modal-body">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body">
                     <table class="table">
                     	<thead>
                     		<tr class="info">
                     			<th>时间</th>
                     			<th>
                     				<select name="cateid" id="class_cateid">
                     					<option value="no" selected>请选择课程类型</option>
                     					<option value="0">口语试听(1个时段=1节)</option>
                     					<option value="4">口语课(2个时段=1节)</option>
                     					<option value="5">口语模考(1个时段=1节)</option>
                     				</select>
                     				<b style="color:red">*</b>
                     			</th>
                     		</tr>
                     	</thead>
                     	<tbody>
                     		
                     	</tbody>
                     </table>
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
				<i class="icon-home2 norightmargin"></i>&nbsp;&nbsp;待上课
			</a>
		</li>
		<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-26" aria-labelledby="ui-id-10" aria-selected="false" status="2">
			<a href="#tabs-26" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-10">已完成</a>
		</li>
		<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-27" aria-labelledby="ui-id-11" aria-selected="false" status="3">
			<a href="#tabs-27" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-11">已取消</a>
		</li>
	</ul>

	<div class="tab-container">
		<div class="tab-content clearfix ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-25" aria-labelledby="ui-id-9" role="tabpanel" aria-expanded="true" aria-hidden="false" style="display: block;">
			<table class="table table-hover" id="finishing">
				<thead>
					<tr class="danger">
						<th>课程时间</th>
						<th>老师</th>
						<th>老师QQ</th>
						<th>课程类型</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
		<div class="tab-content clearfix ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-26" aria-labelledby="ui-id-10" role="tabpanel" style="display: none;" aria-expanded="false" aria-hidden="true">
			<table class="table table-hover" id="finished">
				<thead>
					<tr class="success">
						<th>课程时间</th>
						<th>老师</th>
						<th>老师QQ</th>
						<th>课程类型</th>
						<th>下载课件</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
		<div class="tab-content clearfix ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-27" aria-labelledby="ui-id-11" role="tabpanel" style="display: none;" aria-expanded="false" aria-hidden="true">
			<table class="table table-hover" id="cb">
				<thead>
					<tr class="info">
						<th>课程时间</th>
						<th>老师</th>
						<th>老师QQ</th>
						<th>课程类型</th>
						<th>取消类型</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>

	</div>
</div>
<div class="modal fade cb_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none; padding-right: 17px;">
    <div class="modal-dialog modal-ml">
        <div class="modal-body">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                	<button class="button button-3d button-small button-rounded button-blue" id="cb_queding" style="margin-left: 40%" data-dismiss="modal" aria-hidden="true">确定</button>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('content3')
@stop
@section('js')
<script>
	$('.alert-success').delay(2000).fadeOut(1000);
    $('.alert-danger').delay(2000).fadeOut(1000);
    $(function(){
    	// 填充提示信息内容
    	$('#notice_con').html($('input[name=notice_con]').val());
    	// 判断是否自动弹出
    	if(window.sessionStorage["jizhu_speak"] && window.sessionStorage.getItem("jizhu_speak") == 1){
		}else{
			$(".notice").modal({backdrop:false}); 
		}
		// 为notice_button绑定事件
		$(document).on('click','#notice_button',function(){
			$(".notice").modal({backdrop:false}); 
		});
		// 为关掉按钮绑定事件
		$(document).on('click','#notice_close',function(){
			if ($('input[type=checkbox]:checked').length) {
				window.sessionStorage["jizhu_speak"] = 1;
			}else{
				window.sessionStorage["jizhu_speak"] = 0;
			}
		});
    	// 页面刷新显示要与传来的id的值一致
    	var old_id = $('select[name=tea_name]').attr('oldid');
    	$('select[name=tea_name]').val(old_id);

		// 老师下拉框的改变值的事件
		$(document).on('change','select[name=tea_name]',function(){
			var id = $('select[name=tea_name]').val();
			$.ajax({
			    type:'GET',
			    url:'/students/stu_sclass',
			    dataType:'html',
			    
			    data:{"id":id},
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

		// 时间在当前时间之前的单元格添加一个不能用的类同时删除opened类
            //获取当前时间并转化为php时间戳
        var times = new Date().getTime();
        var time = String(times);
        // var type = typeof(time);
        var phptime = time.slice(0,-3);
        var book = $('#class_book td>button');
        // console.log(book);
        for (var i = book.length - 1; i >= 0; i--) {
            // 获取表格中对应的时间戳
            var booktime = $(book[i]).attr('classtime');
            var booktime_arr = booktime.split('|');
            var table_time = Number(booktime_arr[0])+8*60*60+Number(booktime_arr[1]);
            if (table_time-phptime <= 2*3600) {
                $(book[i]).removeClass('button-leaf');
                $(book[i]).removeClass('button-red');
                $(book[i]).removeClass('button-green');
                $(book[i]).addClass('button-teal');
                $(book[i]).html('overtime');
            }
            // console.log(booktime);
        }
		
		//对green的单元格的单击事件
		$(document).on('click','#class_book .button-green',function() {			
			var classtime = $(this).attr('classtime');
			var date_date = $(this).attr('date_date');
			var date_time = $(this).attr('date_time');
			var tea = $(this).attr('tea');
			$(this).removeClass('button-green');
			$(this).addClass('button-lime');
			$(this).html('<i class="icon-ok"></i>'+date_date+date_time+'')
		}); 		
		// 绑定lime单元格的单击事件
		$(document).on('click','#class_book .button-lime',function(){
			$(this).removeClass('button-lime');
			$(this).addClass('button-green');
			$(this).html('opened')
		});
		// 绑定预约按钮的事件
		$(document).on('click','#book_one',function(){
			$('.chooseclass').modal({backdrop:false});
			var checked = $('#class_book .button-lime');
			var length = checked.length;
			if (length) {
				var tea = $(checked[0]).attr('tea');
				var classtime_choose = '';
				$('.chooseclass #myModalLabel').html('您确定预约'+tea+'老师的以下课程吗？');
				$('.chooseclass tbody>tr').remove();
				for (var i = 0; i < checked.length; i++) {
					var classtime = $(checked[i]).attr('classtime');
					classtime_choose += classtime+',';
					var date_date = $(checked[i]).attr('date_date');
					var date_time = $(checked[i]).attr('date_time');
					var date_time_end = $(checked[i]).attr('date_time_end');
					var tr = $('<tr><td>'+date_date+'</td><td>'+date_time+'--'+date_time_end+'</td></tr>');
					$('.chooseclass tbody').append(tr);
				}
				// 确定按钮的变化插入
				if ($('#class_cateid').val() === 'no') {
					var button = $('<tr><td colspan="2"><button class="button button-3d button-small button-rounded button-teal" disabled id="book_stu"  data-dismiss="modal" aria-hidden="true">请选择课程类型</button></td></tr>');
					$('.chooseclass tbody').append(button);
				}else{
					var button = $('<tr><td colspan="2"><button class="button button-3d button-small button-rounded button-blue" id="book_stu"  data-dismiss="modal" aria-hidden="true">确定</button></td></tr>');
					$('.chooseclass tbody').append(button);
				}
				// 添加确定按钮的属性便于传输数据
				$('#book_stu').attr('classtime',classtime_choose);
				$('#book_stu').attr('tid',$('select[name=tea_name]').val());
				$('#book_stu').attr('cateid',$('#class_cateid').val());
			}else{
				$('.chooseclass #myModalLabel').html('请您选择课时哦');
				$('.chooseclass tbody>tr').remove();
			}
			
		});
		// 绑定选择课程类型下拉框的改变事件
		$(document).on('change','#class_cateid',function(){
			if ($('#class_cateid').val() === 'no') {
				$('#book_stu').removeClass('button-blue');
				$('#book_stu').addClass('button-teal');
				$('#book_stu').attr('disabled','disabled');
				$('#book_stu').html('请选择课程类型');
			}else{
				$('#book_stu').removeClass('button-teal');
				$('#book_stu').addClass('button-blue');
				$('#book_stu').removeAttr('disabled');
				$('#book_stu').html('确定')
			}
			$('#book_stu').attr('cateid',$('#class_cateid').val());
		});
		// 绑定学生预约确定按钮按钮
		$(document).on('click','#book_stu',function(){
			$('body').removeClass('modal-open');
			$('body').attr('style','');
			var t = $(this);
			$.ajax({
			    type:'GET',
			    url:'/students/stu_sclass/create',
			    dataType:'html',
			    data:{'id':t.attr('tid'),'cateid':t.attr('cateid'),'classtime':t.attr('classtime')},
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
		// console.log($('a[href="#snav-content2"]'));
		$(document).on('click','a[href="#snav-content2"]',function(){
			$.ajax({
			    type:'POST',
			    url:'/students/stu_sclass',
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
			    			var tr = $('<tr><td>'+formatDate(d)+'</td><td>'+data.tea[data.con[i].tid]+'</td><td>'+data.tea_qq[data.con[i].tid]+'</td><td>'+data.cateid[data.con[i].cateid]+'</td><td><button class="button button-3d button-small button-rounded button-red cb_btn" cid="'+data.con[i].cid+'" tea="'+data.tea[data.con[i].tid]+'" time="'+formatDate(d)+'" catename="'+data.cateid[data.con[i].cateid]+'"  data-target=".cb_modal">取消</button></td></tr>');
			    			// console.log(1);
			    			$('#finishing tbody').append(tr);
			    		}
			    	}
			    },
			    error:function(data){
			        //错误信息
			    }
			});
		});
		$(document).on('click','li[status="1"],li[status="2"],li[status="3"]',function(){
			var t = $(this);
			$.ajax({
			    type:'POST',
			    url:'/students/stu_sclass',
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
			    			var tr = $('<tr><td>'+formatDate(d)+'</td><td>'+data.tea[data.con[i].tid]+'</td><td>'+data.tea_qq[data.con[i].tid]+'</td><td>'+data.cateid[data.con[i].cateid]+'</td><td><button class="button button-3d button-small button-rounded button-red cb_btn" cid="'+data.con[i].cid+'" tea="'+data.tea[data.con[i].tid]+'" time="'+formatDate(d)+'" catename="'+data.cateid[data.con[i].cateid]+'"  data-target=".cb_modal">取消</button></td></tr>');
			    			// console.log(1);
			    			$('#finishing tbody').append(tr);
			    		}
			    	}
			    	if (data.status == '2') {
			    		$('#finished tbody tr').remove();
			    		for (var i = data.con.length-1; i >= 0; i--) {
			    			var d = new Date(Number(data.con[i].classtime+'000'));
			    			var tr = $('<tr><td>'+formatDate(d)+'</td><td>'+data.tea[data.con[i].tid]+'</td><td>'+data.tea_qq[data.con[i].tid]+'</td><td>'+data.cateid[data.con[i].cateid]+'</td><td><a href="/students/stu_sclass/'+data.con[i].cid+'/edit"><button class="button button-3d button-small button-rounded button-red">下载课件</button></a></td></tr>');
			    			// console.log(1);
			    			$('#finished tbody').append(tr);
			    		}
			    	}
			    	if (data.status == '3') {
			    		$('#cb tbody tr').remove();
			    		for (var i = data.con.length-1; i >= 0; i--) {
			    			var d = new Date(Number(data.con[i].classtime+'000'));
			    			var tr = $('<tr><td>'+formatDate(d)+'</td><td>'+data.tea[data.con[i].tid]+'</td><td>'+data.tea_qq[data.con[i].tid]+'</td><td>'+data.cateid[data.con[i].cateid]+'</td><td>'+data.sta[data.con[i].status]+'</td></tr>');
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
		// 所有的取消按钮绑定一个事件
		$(document).on('click','button[data-target=".cb_modal"]',function(){
			$(".cb_modal").modal({backdrop:false});
			var tea = $(this).attr('tea');
			var cid = $(this).attr('cid');
			var time = $(this).attr('time');
			var catename = $(this).attr('catename');
			$('.cb_modal .modal-title').html('您确定取消'+tea+'老师'+time+'的'+catename+'吗？');
			$('#cb_queding').attr('cid',cid);
		});
		// 为取消确定按钮绑定事件
		$(document).on('click','#cb_queding',function(){
			$.ajax({
			    type:'GET',
			    url:'/students/stu_sclass/'+$(this).attr('cid'),
			    dataType:'json',
			    data:{},
			    success:function(data){
			    	if (data.status == 1) {
			    		$('#xinxi div').remove();
			    		var div = '<div class="alert alert-success" role="alert">取消成功</div>'
			    		$('#xinxi').append(div);
			    		$('button[cid="'+data.cid+'"]').parents('tr').remove();
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
			return year+"-"+month+"-"+date+"&nbsp;&nbsp;"+hour+":"+minute;
		} 
	});	
</script>
@stop