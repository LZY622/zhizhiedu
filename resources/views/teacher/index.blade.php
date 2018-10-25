@extends('layouts.teacher.admins')
@section('title','吱吱英语老师端')
@section('content')
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
	<style type="text/css">
		table tr th{
			text-align: center;
			color: #000;
		}

		table tr td{
			text-align: center;
			color: red;
		}
	</style>


	<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
        
		<div class="widget am-cf">
            <div class="widget-head am-cf" style="height: 40px">
                <div class="widget-title am-fl">数据总览</div>
            </div>
            @if($rs->cate == 2)
            <div class="widget-body am-fr">
            	<div style="margin-top: 10px">
	            	<span class="am-icon-tags" style="color:red;font-size:18px"></span>
	            	<span style="font-size:18px">&nbsp;&nbsp;未来6天（不含今天）您还有<b style="font-size: 22px;color:red"> {{$a}} </b>个时段可以预约，请速速开放课程</span>&nbsp;&nbsp;&nbsp;<a href="/teacher/tea_sclass/{{$rs->id}}/edit">点击查看</a>
            	</div>
            	<div style="margin-top: 10px">
	            	<span class="am-icon-tags" style="color:purple;font-size:18px"></span>
	            	<span style="font-size:18px">&nbsp;&nbsp;您今天还有<b style="font-size: 22px;color:red"> {{$b}} </b>个时段的课程未进行</span>&nbsp;&nbsp;&nbsp;<a href="/teacher/stu_sclass/create?range={{date('Y-m-d',time())}}+{{date('H',time())}}%3A{{date('i',time())}}%3A{{date('s',time())}}+-+{{date('Y-m-d',time()+24*3600)}}+00%3A00%3A00">点击查看</a>
            	</div>
            	<div style="margin-top: 10px">
            		<span class="am-icon-tags" style="color:green;font-size:18px"></span>
            		<span style="font-size:18px">&nbsp;&nbsp;截止至目前您一共有<b style="font-size: 22px;color:red"> {{$c}} </b>个时段的课程未上传课件或者进行其他操作</span>&nbsp;&nbsp;&nbsp;<a href="/teacher/stu_sclass/create?range=1970-01-01+00%3A00%3A00+-+{{date('Y-m-d',time())}}+{{date('H',time())}}%3A{{date('i',time())}}%3A{{date('s',time())}}">点击查看</a>
            	</div>
            	<div style="margin-top: 10px">
            		<span class="am-icon-tags" style="color:blue;font-size:18px"></span>
            		<span style="font-size:18px">&nbsp;&nbsp;截止至目前本月您的违规数为<b style="font-size: 22px;color:red"> {{$d}} </b>条</span>&nbsp;&nbsp;&nbsp;<a href="">点击查看</a>
            	</div>
            	<div style="margin-top: 10px">
            		<span class="am-icon-tags" style="color:pink;font-size:18px"></span>
            		<span style="font-size:18px">&nbsp;&nbsp;您最近两个月的试听通过率为<b style="font-size: 22px;color:red"> {{$e}}% </b></span>&nbsp;&nbsp;&nbsp;<a href="">点击查看</a>
            	</div>
            </div>
            @else
            <div class="widget-body am-fr">
            	<div style="margin-top: 10px">
	            	<span class="am-icon-tags" style="color:red;font-size:18px"></span>
	            	<span style="font-size:18px">&nbsp;&nbsp;未来6天（不含今天）您还有<b style="font-size: 22px;color:red"> {{$a}} </b>个空位可以预约，请速速开放篇数</span>&nbsp;&nbsp;&nbsp;<a href="/teacher/tea_wcorrect/{{$rs->id}}">点击查看</a>
            	</div>
            	<div style="margin-top: 10px">
	            	<span class="am-icon-tags" style="color:purple;font-size:18px"></span>
	            	<span style="font-size:18px">&nbsp;&nbsp;学生昨天以及昨天之前上传的作文还有<b style="font-size: 22px;color:red"> {{$b}} </b>篇没有批改</span>&nbsp;&nbsp;&nbsp;<a href="/teacher/stu_wcorrect/create?range=1970-01-01+-+{{date('Y-m-d',strtotime('yesterday'))}}&status=2">点击查看</a>
            	</div>
            	<div style="margin-top: 10px">
            		<span class="am-icon-tags" style="color:green;font-size:18px"></span>
            		<span style="font-size:18px">&nbsp;&nbsp;截止至目前预约今天作文的学生还有<b style="font-size: 22px;color:red"> {{$c}} </b>篇未上传</span>&nbsp;&nbsp;&nbsp;<a href="/teacher/stu_wcorrect/create?range={{date('Y-m-d',strtotime('today'))}}+-+{{date('Y-m-d',strtotime('today'))}}&status=1">点击查看</a>
            	</div>
            	<div style="margin-top: 10px">
            		<span class="am-icon-tags" style="color:blue;font-size:18px"></span>
            		<span style="font-size:18px">&nbsp;&nbsp;截止至目前本月您的违规数为<b style="font-size: 22px;color:red"> {{$d}} </b>条</span>&nbsp;&nbsp;&nbsp;<a href="">点击查看</a>
            	</div>
            </div>
            @endif
        </div>

        <div class="widget am-cf">
            <div class="widget-head am-cf">
                <div class="widget-title am-fl" style="width: 100%;text-align: center;">
                	<h3>{{$tea[$rs->id]}}老师<input type="text" id="test10" name="range" style="width: 30%;height: 35px" value="{{$range}}">工资表</h3>
                </div>
                <script src="/laydate/laydate.js"></script>
				<script>
				//执行一个laydate实例
					laydate.render({
					  elem: '#test10'
					  ,type: 'date'
					  ,range: true
					  ,done:function(value,date){
					        window.location.href = '/teacher?range='+value;
					    }
					}); 
				</script>
            </div>
            @if($rs->cate == 2)
            <div class="widget-body  widget-body-lg am-fr">
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
                            <th class="am-text-middle" style="border-bottom: 3px black solid;" >{{$s*env($price[0])+$c*env($price[4])+$m*env($price[5])}}&nbsp;&nbsp;元</th>
                        </tr>
                        
                            
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
            @else
			<div class="widget-body  widget-body-lg am-fr">
                <table class="am-table am-table-compact am-table-striped tpl-table-black " width="100%">
                    <thead>
                        <tr>
                            <th>老师</th>
                            <th>批改类型</th>
                            <th>批改篇数</th>
							<th>工资(元)</th>
                        </tr>
                    </thead>
                    <tbody>
                    	@foreach ($res as $k => $v)
                        <tr class="gradeX">
                            <td class="am-text-middle">{{$tea[$v->tid]}}</td>
                            <td class="am-text-middle">
                            	@if($tea_cate[$v->tid]==13)大作文批改
                            	@elseif($tea_cate[$v->tid]==15)小作文批改
                            	@endif
                            </td>
								<td>{{$v->total}}</td>
                            <td class="total">{{env($price[$tea_cate[$v->tid]])*$v->total}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

    </div>
@endsection
@section('js')
<script>
$(function(){
	$('.alert-success').delay(2000).fadeOut(1000);
    $('.alert-warning').delay(2000).fadeOut(1000);
});
    
</script>

@stop