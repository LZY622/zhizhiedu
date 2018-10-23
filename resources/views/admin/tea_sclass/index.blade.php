@extends('layouts.admin.admins')
@section('title','吱吱英语后台管理')
@section('content')
<link rel="stylesheet" href="/assets/css/fullcalendar.min.css" />
<link rel="stylesheet" href="/assets/css/fullcalendar.print.css" media='print' />
<meta name="csrf-token" content="{{csrf_token()}}">
<style>
	.time{
		height: 35px;
		font-weight: 900;
		background: #32C5D2;
		color:white;
		text-align: center;
		line-height: 35px
	}
	.book{
		height: 35px;
		font-weight: 900;
		text-align: center;
		line-height: 35px;
		cursor:pointer;
	}
	.grey{
		cursor:no-drop;
		color: white;
	}
	
</style>
<div id="calendar" class="fc fc-unthemed fc-ltr">
	<div class="fc-toolbar">
		<div class="fc-left" >
			<div class="fc-button-group">
				<!-- <a href="/admin/teauser"> -->
				<button type="button" class="fc-prev-button fc-button fc-state-default fc-corner-left" id="back">
					<<<
				</button>
				<!-- </a> -->
			</div>
			<button type="button" class="fc-today-button fc-button fc-state-default fc-corner-left fc-corner-right">
				空课率： {{$empty}}%
			</button>
			<select  name="tea_name" class="fc-today-button fc-button fc-state-default fc-corner-left fc-corner-right" style="height: 30px">
				@foreach($tea as $k=>$v)
                <option value="{{$k}}" @if($k==$id) selected @endif>
                {{$v}}
            	</option>
                @endforeach
            </select>
		</div>
		<div class="fc-clear"></div>
		<div class="fc-center">
    		<h2>{{$tea[$id]}}未来7日空课表</h2>
    	</div>
		<div class="fc-clear"></div>
	</div>
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
	<div class="fc-view-container" style="">
	    <div class="fc-view fc-month-view fc-basic-view" style="">
	        <table>
	            <thead class="fc-head">
	                <tr>
	                	<th class="fc-day-header fc-widget-header fc-mon">Time</th>
	                	@for ($i = 0; $i < 7; $i++)
	                    <th class="fc-day-header fc-widget-header fc-mon">
	                        <span>{{date('Y/m/d (D)',$today+24*3600*$i)}}</span>
	                    </th>
	                    @endfor
	                </tr>
	                      
	            </thead>
	            <tbody class="fc-body">
	            	<td>
		            	<table>
		            		@for ($i = 0; $i < 33; $i++)
   
			                <tr>
			                    <td class="fc-widget-content time">
		                            {{date('H:i',-3600+($i*1800))}}
			                    </td>
		                	</tr>
							@endfor
	                	</table>
	                </td>
	                @for($i = 0; $i < 7; $i++)
						@php
					$date = strtotime(date('Y-m-d',time()))+($i*86400);
						@endphp
		                <td>
			                <table>
			                	@for ($j = 0; $j < 33; $j++)
			                	@php
									$time = -3600+($j*1800);
								@endphp
			                	<tr>
			                    	@if($tea_sclass)
	                                    @if(in_array($date.'|'.$time,$tea_sclass))
											@if(in_array($date.'|'.$time,$tea_sclass_booked))
											<td class="fc-widget-content book am-btn-danger booked" classtime="{{$date.'|'.$time}}">
												booked
											@else
											<td class="fc-widget-content book am-btn-primary opened" classtime="{{$date.'|'.$time}}" tea="{{$tea[$id]}}" date_date="{{date('Y-m-d',$date)}}" date_time="{{date(' H:i',$time)}}" >
												opened
											@endif
										@else
										<td class="fc-widget-content book am-btn-default closed" classtime="{{$date.'|'.$time}}">
											closed
	                                    @endif 
	                                @else
	                                <td class="fc-widget-content book am-btn-default closed" classtime="{{$date.'|'.$time}}">
										closed
	                                @endif
				                    </td>
			                	</tr>
			                	@endfor
			                </table>
			            </td>
		            @endfor
	            </tbody>
	        </table>
	    </div>
	</div>
</div>
<!-- 模态框 -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="margin-top:200px;margin-left:300px;">
		<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="widget am-cf">
    			<div class="widget-head am-cf">
		            <div class="widget-title am-fl" id="model_title"></div>
		            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">关闭</button>
		        </div>
		        <div class="am-u-sm-1 ">
                    <button type="button" class="am-btn am-btn-danger tpl-btn-bg-color-success " id="close"style="border-radius:50%;"><<<</button>
                </div>
		        <div class="widget-body am-fr">

		            <form class="am-form tpl-form-border-form tpl-form-border-br" action="/admin/stu_sclass" method="get" enctype="multipart/form-data" id="upd_num">
	                    <label for="user-name" class="am-u-sm-3 am-form-label">用户名(手机) <span class="tpl-form-line-small-title">phone</span></label>
	                    <div class="am-u-sm-9">
	                        <input class="tpl-form-input" name="phone" value="{{$username}}" type="text" >
	                    </div>
	                    <label for="user-name" class="am-u-sm-3 am-form-label">淘宝ID <span class="tpl-form-line-small-title">taobaoID</span></label>
	                    <div class="am-u-sm-9">
	                        <input class="tpl-form-input" name="taobaoID" value="" type="text" >
	                    </div>
	                    <label for="user-phone" class="am-u-sm-3 am-form-label">
	                        口语课程类型 
	                        <span class="tpl-form-line-small-title">cateid</span>
	                    </label>
	                    <!-- <div class="am-u-sm-9"> -->
                        <select  name="cateid" style="width: 20%;">
                            <option value="0">试听</option>
                            <option value="4">口语课</option>
                            <option value="5">口语模考</option>
                        </select>
	                    <input type="hidden" value="{{$id}}" name="tid">
	                    <input type="hidden" value="" name="classtime" id="classtime">
	                    <div class="am-form-group">
		                    
		                    <div class="am-u-sm-9 am-u-sm-push-3">
		                        <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success " id="close" style="margin-left:30px">提交</button>
		                    </div>
		                </div>
	                </form>
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
	$(function(){
		$('.row').addClass('tpl-calendar-box');
		$('.row').removeClass('row');
		//获取老师id
		var path = window.location.pathname;
		var url = window.location.href;
		var tid = path.split('/');
		var param_arr = url.split('?');
		if(param_arr.length>1){
			var param = param_arr[1];
		}else{
			var param = '';
		}
		// console.log(param_arr);
		// 返回按钮单击事件
		$('#back').click(function(){
			window.history.back(-1);
		});
		// 老师下拉框的改变值的事件
		$('select[name=tea_name]').change(function(){
			
			// if (count(param_arr)>1) {}
			var newhref = '/admin/tea_sclass/'+$('select[name=tea_name]').val()+'/edit?'+ param;
			window.location.replace(newhref);
			// alert($('select[name=tea_name]').val());
		});
		
		// 改变booked填充内容
		var booked = $('.booked');
		for (var i = booked.length - 1; i >= 0; i--) {
			// 获取表格中对应的时间戳
			// console.log($(booked[i]));
			var bookedtime = $(booked[i]).attr('classtime');
			var bookedtime_arr = bookedtime.split('|');
			var table_bookedtime = Number(bookedtime_arr[0])+8*60*60+Number(bookedtime_arr[1]);
			var tid_booked = $('input[name=tid]').val();
			console.log(tid_booked);
			$.ajax({
			    type:'GET',
			    url:'/admin/stu_sclass/book_info',
			    dataType:'json',
			    
			    data:{"classtime":table_bookedtime,"bookedtime":bookedtime,"tid":tid_booked},
			    success:function(data){
			    	// console.log($('td [classtime=classtime]'));
			    	if (data.status == 1) {
			    		// console.log($('.booked[classtime="1538668800|5400"]'));
			    		$('.booked[classtime="'+data.bookedtime+'"]').html('<span style="font-size:10px">'+data.phone+'||'+data.catename+'</span>');
			    		$('.booked[classtime="'+data.bookedtime+'"]').click(function(){
			    			alert('淘宝ID：'+data.taobaoID);
			    		});
			    	}
			    },
			    error:function(data){
			        console.log(data.status);
			    }
			});
			// console.log(booktime);
		}
		// 时间在当前时间之前的单元格添加一个不能用的类同时删除openedclosedbooked三个类
			//获取当前时间并转化为php时间戳
		var times = new Date().getTime();
		var time = String(times);
		// var type = typeof(time);
		var phptime = time.slice(0,-3);
		var book = $('.book');
		// console.log(book);
		for (var i = book.length - 1; i >= 0; i--) {
			// 获取表格中对应的时间戳
			var booktime = $(book[i]).attr('classtime');
			var booktime_arr = booktime.split('|');
			var table_time = Number(booktime_arr[0])+8*60*60+Number(booktime_arr[1]);
			if (table_time <= phptime) {
				$(book[i]).removeClass('opened');
				$(book[i]).removeClass('closed');
				$(book[i]).removeClass('am-btn-default');
				$(book[i]).removeClass('am-btn-danger');
				$(book[i]).removeClass('am-btn-primary');
				$(book[i]).addClass('grey');
				$(book[i]).addClass('am-btn-default');
			}
			// console.log(booktime);
		}
		//对opened的单元格的单击双击事件
		$(document).on('mouseup','.opened',function() {			
			clickOrDblClick($(this));		
		}); 		
		// 模态框的关闭
		$('#close').click(function(){
			$('.modal').removeClass('in');				
			$('.modal').attr('style','margin-top:200px;margin-left:300px;');
		});

		var count = 0;		
		var timer;
		//判断单击双击事件的函数	
		function clickOrDblClick(s) {			
			count++;			
			timer = window.setTimeout(function() {
				if (count == 1) {					
					var classtime = s.attr('classtime');
					s.addClass('checked');
					$.ajax({
					    type:'POST',
					    url:'/admin/tea_sclass/'+classtime,
					    dataType:'json',
					    
					    headers:{
					        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
					    },
					    data:{"_method":"delete",'tid':tid[3]},
					    success:function(data){
					        if (data.status == 1) {
					    		$('.checked').removeClass('am-btn-primary');
					    		$('.checked').removeClass('opened');
					    		$('.checked').addClass('am-btn-default');
					    		$('.checked').addClass('closed');
					    		$('.checked').html('closed');
					    		$('.checked').removeClass('checked');
					    	}else if(data.status == 0){
					    		location.reload();
					    	}
					    },
					    error:function(data){
					        console.log(data.status);
					        location.reload();
					    }
					});				
				} else {					
					$('.modal').addClass('in');				
					$('.modal').attr('style','margin-top:200px;margin-left:300px;display:block;');
					var tea = s.attr('tea');
					var date_time = s.attr('date_time');
					var date_date = s.attr('date_date');
					console.log(tea);	
					var clicktime = s.attr('classtime');
					var clicktime_arr = clicktime.split('|');
					var click_classtime = Number(clicktime_arr[0])+8*60*60+Number(clicktime_arr[1]);
					$('#classtime').attr('value',click_classtime);
					$('#model_title').html('您将预约 <b style="color:red;">'+tea+'</b>老师<b style="color:red;">'+date_date+' '+date_time+'</b>的课程');
				}				
				window.clearTimeout(timer)				
				count = 0 			
			}, 300)		
		}
		

		// closed单元格的单击事件
		$(document).on('click','.closed',function(){
			var classtime = $(this).attr('classtime');
			$(this).addClass('checked');
			// console.log(classtime);
			$.ajax({
			    type:'POST',
			    url:'/admin/tea_sclass',
			    dataType:'json',
			    
			    headers:{
			        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			    },
			    data:{"classtime":classtime,'tid':tid[3]},
			    success:function(data){
			    	// console.log($('td [classtime=classtime]'));
			    	if (data.status == 1) {
			    		$('.checked').removeClass('am-btn-default');
			    		$('.checked').removeClass('closed');
			    		$('.checked').addClass('am-btn-primary');
			    		$('.checked').addClass('opened');
			    		$('.checked').html('opened');
			    		$('.checked').removeClass('checked');
			    	}else if(data.status == 0){
			    		location.reload();
			    	}
			    },
			    error:function(data){
			        console.log(data.status);
			        location.reload();
			    }
			});
		});
	});	
</script>
@stop