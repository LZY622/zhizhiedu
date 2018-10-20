@extends('layouts.teacher.admins')
@section('title','吱吱英语后台管理')
@section('content')
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
                <div class="widget-title am-fl">待办事项</div>
            </div>
            <div class="widget-body am-fr">
            	<li class="am-icon-tags" style="color:red;"></li><br>
            	<li class="am-icon-tags" style="color:green;"></li><br>
            	<li class="am-icon-tags" style="color:blue;"></li><br>
            	<li class="am-icon-tags" style="color:pink;"></li><br>
            	<li class="am-icon-tags" style="color:#000;"></li><br>
            	<li class="am-icon-tags" style="color:#2bf666;"></li><br>
            	<li class="am-icon-tags" style="color:#ccc;"></li><br>
            	<li class="am-icon-tags" style="color:#c71585;"></li><br>
            	<li class="am-icon-tags" style="color:#ff00ff;"></li><br>
            	<li class="am-icon-tags" style="color:#ffa500;"></li><br>
            </div>
        </div>

        <div class="widget am-cf" style="height: 280px">
            <div class="widget-head am-cf">
                <div class="widget-title am-fl" style="margin-left: 38%">
                	<h3>一个有想法的表格</h3>
                </div>
            </div>
            <div class="widget-body  widget-body-lg am-fr">

                <table width="100%" class="am-table am-table-compact tpl-table-black " id="example-r">
                    <thead>
                        <tr>
                            <th>课程类型</th>
	            			<th>已完成</th>
	            			<th>老师缺席</th>
	            			<th>学生缺席</th>
	            			<th>老师紧急取消</th>
	            			<th>学生紧急取消</th>
	            			<th>实际课时数</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="gradeX">
                            <th>试听</th>
	            			<td>李子越智障</td>
	            			<td>李子越智障</td>
	            			<td>李子越智障</td>
	            			<td>李子越智障</td>
	            			<td>李子越智障</td>
	            			<td>李子越智障</td>
                        </tr>
                        <tr class="even gradeC">
                            <th>正式课</th>
	            			<td>李子越真丑</td>
	            			<td>李子越真丑</td>
	            			<td>李子越真丑</td>
	            			<td>李子越真丑</td>
	            			<td>李子越真丑</td>
	            			<td>李子越真丑</td>
                        </tr>
                        <tr class="gradeX">
                            <th>模考</th>
	            			<td>李子越真不要脸</td>
	            			<td>李子越真不要脸</td>
	            			<td>李子越真不要脸</td>
	            			<td>李子越真不要脸</td>
	            			<td>李子越真不要脸</td>
	            			<td>李子越真不要脸</td>
                        </tr>
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
    
</script>

@stop