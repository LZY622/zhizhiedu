@extends('layouts.teacher.admins')
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


			</div>
			<button type="button" class="fc-today-button fc-button fc-state-default fc-corner-left fc-corner-right">
				空课率： {{$empty}}%
			</button>
			
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

		
		// 改变booked填充内容
		var booked = $('.booked');
		for (var i = booked.length - 1; i >= 0; i--) {
			// 获取表格中对应的时间戳
			// console.log($(booked[i]));
			var bookedtime = $(booked[i]).attr('classtime');
			var bookedtime_arr = bookedtime.split('|');
			var table_bookedtime = Number(bookedtime_arr[0])+8*60*60+Number(bookedtime_arr[1]);
			var tid_booked = $('input[name=tid]').val();
			// console.log(tid_booked);
			$.ajax({
			    type:'GET',
			    url:'/teacher/stu_sclass/book_info',
			    dataType:'json',
			    
			    data:{"classtime":table_bookedtime,"bookedtime":bookedtime,"tid":tid_booked},
			    success:function(data){
			    	// console.log($('td [classtime=classtime]'));
			    	if (data.status == 1) {
			    		// console.log($('.booked[classtime="1538668800|5400"]'));
			    		$('.booked[classtime="'+data.bookedtime+'"]').html('<span style="font-size:10px;">'+data.phone+'||'+data.catename+'</span>');
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
					    url:'/teacher/tea_sclass/'+classtime,
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
			    url:'/teacher/tea_sclass',
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