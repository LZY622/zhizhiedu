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
	@php
	function check($a,$b){
        if(count($a)){
            foreach($a as $k=>$v){
                if($v->tid == $b){

                    return $v->total;
                }
                
            }
            return 0;
        }else{
            return 0;
        }
    }
	@endphp
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
	                口语老师课时数统计
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
                
                <form action="" method="get">
                	
		            
                	
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
	                        	<option value="0" selected>所有口语老师</option>
	                        	@foreach($tea as $k=>$v)
				                <option value="{{$k}}" @if($k==$tid) selected @endif>
				                {{$v}}
				            	</option>
				                @endforeach
							</select>
	                		<span class="am-input-group-btn" style="display: inline;">
								<button class="am-btn  am-btn-default am-btn-success tpl-table-list-field am-icon-search" type="submit"> 搜索</button>
							</span>
						</div>
					</div>
					
					
				</form>
                <div class="am-u-sm-12">
                    <table class="am-table am-table-compact am-table-striped tpl-table-black " width="100%">
                        <thead>
                            <tr>
                            	<th rowspan="2"></th>
                            	<th rowspan="2">课程类型</th>
                            	<th colspan="5">课程状态</th>
                            	<th rowspan="2">实际课时数</th>
                            	<th rowspan="2">工资</th>
                            </tr>
                            <tr>
                            	<!-- <th></th> -->
                            	<!-- <th></th> -->
                                <th>已完成</th>
                                <th>老师缺席</th>
                                <th>学生缺席</th>
                                <th>老师紧急取消</th>
								<th>学生紧急取消</th>
								
								<!-- <th></th> -->
								<!-- <th></th> -->
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach ($tea_id as $k => $v)
                            <tr class="gradeX">
                                <td style="border-bottom: 3px black solid;" class="am-text-middle" rowspan="3">{{$tea[$v->tid]}}</td>
                                <th>试听</th>
                                <td class="am-text-middle">{{$s_2 = check($res['st'][2],$v->tid)}}</td>
                                <td class="am-text-middle">{{$s_4 = check($res['st'][4],$v->tid)}}</td>
                                <td class="am-text-middle">{{$s_5 = check($res['st'][5],$v->tid)}}</td>
                                <td class="am-text-middle">{{$s_6 = check($res['st'][6],$v->tid)}}</td>
                                <td class="am-text-middle">{{$s_7 = check($res['st'][7],$v->tid)}}</td>
                                <th class="am-text-middle">{{$s = $s_2-$s_4+$s_5-$s_6/2+$s_7/2}}&nbsp;&nbsp;次</th>
                                <th class="am-text-middle" rowspan="2"></th>
                            </tr>
                            <tr class="gradeX">
                                <!-- <td class="am-text-middle" rowspan="3">{{$tea[$v->tid]}}</td> -->
                                <th>正式课</th>
                                <td class="am-text-middle">{{$c_2 = check($res['cla'][2],$v->tid)/2}}</td>
                                <td class="am-text-middle">{{$c_4 = check($res['cla'][4],$v->tid)/2}}</td>
                                <td class="am-text-middle">{{$c_5 = check($res['cla'][5],$v->tid)/2}}</td>
                                <td class="am-text-middle">{{$c_6 = check($res['cla'][6],$v->tid)/2}}</td>
                                <td class="am-text-middle">{{$c_7 = check($res['cla'][7],$v->tid)/2}}</td>
                                <th class="am-text-middle">{{$c = $c_2-$c_4+$c_5-$c_6/2+$c_7/2}}&nbsp;&nbsp;次</th>
                                <!-- <th class="am-text-middle" rowspan="3">元</th> -->
                            </tr>
                            <tr class="gradeX">
                                <!-- <td class="am-text-middle" rowspan="3">{{$tea[$v->tid]}}</td> -->
                                <th style="border-bottom: 3px black solid;">模考</th>
                                <td  style="border-bottom: 3px black solid;"class="am-text-middle">{{$m_2 = check($res['mt'][2],$v->tid)}}</td>
                                <td  style="border-bottom: 3px black solid;"class="am-text-middle">{{$m_4 = check($res['mt'][4],$v->tid)}}</td>
                                <td  style="border-bottom: 3px black solid;"class="am-text-middle">{{$m_5 = check($res['mt'][5],$v->tid)}}</td>
                                <td  style="border-bottom: 3px black solid;"class="am-text-middle">{{$m_6 = check($res['mt'][6],$v->tid)}}</td>
                                <td  style="border-bottom: 3px black solid;"class="am-text-middle">{{$m_7 = check($res['mt'][7],$v->tid)}}</td>
                                <th  style="border-bottom: 3px black solid;"class="am-text-middle">{{$m = $m_2-$m_4+$m_5-$m_6/2+$m_7/2}}&nbsp;&nbsp;次</th>
                                <th class="am-text-middle total" style="border-bottom: 3px black solid;" >{{$s*env($price[0])+$c*env($price[4])+$m*env($price[5])}}&nbsp;&nbsp;元</th>
                            </tr>
                            
                                
                            @endforeach
                            <tr>
                            	<td></td>
                            	<td></td>
                            	<td></td>
                            	<td></td>
                            	<td></td>
                            	<td></td>
                            	<td></td>
                            	<td></td>
                            	<th id="all"></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="am-u-lg-12 am-cf">
	    <div class="am-fr">
	    	
	    </div>
	</div>

@endsection
@section('js')
<script>

    $('.alert-success').delay(2000).fadeOut(1000);
    $('.alert-warning').delay(2000).fadeOut(1000);
    $('#pagenum ul').addClass("am-pagination tpl-pagination");
    $(function(){
    	var all = 0;
    	$('.total').each(function(){
    		all += parseInt($(this).html());
    	});
    	$('#all').html('总和：'+all+'元');
    });
</script>

@stop