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
                <div class="widget-title  am-cf">
                	<button type="button" class="am-btn am-btn-info" id="back">
						<<<
					</button>
					<select data-am-selected="{btnSize: 'sm'}"  name="tid">
                    	@foreach($tea as $k=>$v)
		                <option value="{{$k}}" @if($k==$id) selected @endif>
		                {{$v}}老师
		            	</option>
		                @endforeach
					</select>
					未来七天作文篇数开放管理【@if($cateid==13)大作文@elseif($cateid==15)小作文@endif】
				</div>
            </div>
            <!-- <div class="widget-body  am-fr"> -->
                <div class="am-u-sm-12">
                	<form action="/admin/tea_wcorrect" method="POST" id="pianshu">
                	{{csrf_field()}}
                	<input type="hidden" name="tid" value="{{$id}}" form="pianshu">
                    <table class="am-table am-table-compact am-table-striped tpl-table-black " width="100%">
                        <thead>
                            <tr>
                                <th>时间</th>
                                @for ($i = 0; $i < 7; $i++)
								    <th>{{date('Y-m-d',$date+24*3600*$i)}}</th>
								@endfor
                            </tr>
                        </thead>
                        <tbody>
                        	<tr class="gradeX">
                            	<th>总数</th>
                                @foreach ($res_total as $k => $v)
                                <td>{{$v}}</td>
                                @endforeach
                            </tr>
                           	<tr class="gradeX">
                            	<th>剩余</th>
                                @foreach ($res as $k => $v)
                                <td>{{$v}}</td>
                                @endforeach
                            </tr>
                            <tr class="gradeX">
                            	<th>添加</th>
                                @for ($i = 0; $i < 7; $i++)
								    <td><input type="text" name="{{$date+24*3600*$i}}" placeholder="添加" value="" style="width: 30%;border: 1px red solid" form="pianshu"></td>
								@endfor
                            </tr>
                            <tr class="gradeX">
                            	<th>预约</th>
                                @for ($i = 0; $i < 7; $i++)
								    <td>
								    	<button type="button" class="btn btn-danger" data-toggle="modal" data-target=".bs-modal-lg" style="font-size: 12px;" classtime="{{$date+24*3600*$i}}">预约</button>
								    </td>
								@endfor
                            </tr>
							
                            
                            <!-- more data -->
                        </tbody>
                    </table>
                    <input class="am-btn am-btn-primary" form="pianshu" type="submit" value="提交">
                    </form>
                </div>
            <!-- </div> -->
        </div>
    </div>
    
    <div class="modal fade bs-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="margin-top:100px;margin-left:300px;">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="widget am-cf">
	    			<div class="widget-head am-cf">
			            <div class="widget-title am-fl" id="model_title"></div>
			        </div>
			        <div class="am-u-sm-1 ">
	                    
	                </div>
			        <div class="widget-body am-fr">

			            <form class="am-form tpl-form-border-form tpl-form-border-br" action="/admin/stu_wcorrect" method="get"  id="upd_num">
		                    <label for="user-name" class="am-u-sm-3 am-form-label">用户名(手机) <span class="tpl-form-line-small-title">phone</span></label>
		                    <div class="am-u-sm-9">
		                        <input class="tpl-form-input" name="phone" value="" type="text" >
		                    </div>
		                    <label for="user-name" class="am-u-sm-3 am-form-label">淘宝ID <span class="tpl-form-line-small-title">taobaoID</span></label>
		                    <div class="am-u-sm-9">
		                        <input class="tpl-form-input" name="taobaoID" value="" type="text" >
		                    </div>
		                    
		                    <!-- <div class="am-u-sm-9"> -->
	                        
		                    <input type="hidden" value="{{$id}}" name="tid">
		                    <input type="hidden" value="{{$cateid}}" name="cateid">
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
    $('#back').click(function(){
		window.history.back(-1);
	});
	// 老师下拉框的改变值的事件
	var url = window.location.href;
	var param_arr = url.split('?');
	if(param_arr.length>1){
		var param = param_arr[1];
	}else{
		var param = '';
	}
	$('select[name=tid]').change(function(){
		
		// if (count(param_arr)>1) {}
		var newhref = '/admin/tea_wcorrect/'+$('select[name=tid]').val()+'?'+ param;
		window.location.replace(newhref);
		// alert($('select[name=tea_name]').val());
	});
	// 模态框事件
	$('button[data-target=".bs-modal-lg"]').click(function(){
   		
   		$('input[name=classtime]').val($(this).attr('classtime'));
   		
   	});
</script>

@stop