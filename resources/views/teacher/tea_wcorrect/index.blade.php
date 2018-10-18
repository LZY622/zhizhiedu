@extends('layouts.teacher.admins')
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
                	
					{{$tea[$id]}}老师未来七天作文篇数开放管理【@if($cateid==13)大作文@elseif($cateid==15)小作文@endif】
				</div>
            </div>
            <!-- <div class="widget-body  am-fr"> -->
                <div class="am-u-sm-12">
                	<form action="/teacher/tea_wcorrect" method="POST" id="pianshu">
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
                            
                        </tbody>
                    </table>
                    <input class="am-btn am-btn-primary" form="pianshu" type="submit" value="提交">
                    </form>
                </div>
            <!-- </div> -->
        </div>
    </div>
    
    
@endsection
@section('js')
<script>

    $('.alert-success').delay(2000).fadeOut(1000);
    $('.alert-warning').delay(2000).fadeOut(1000);
    

	
</script>

@stop