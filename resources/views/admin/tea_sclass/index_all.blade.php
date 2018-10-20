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
                <div class="widget-title  am-cf">口语空课管理</div>
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
                
                <form action="/admin/tea_sclass" method="get">
                	
		            
					<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
	                    <div class="am-form-group tpl-table-list-select" >
	                    	时间范围：
	                    	<input type="text" id="test10" name="range" style="width: 30%;height: 35px" value="{{$range}}">
							几点左右：
	                    	<input type="text" id="test1" name="time" style="width: 10%;height: 35px" value="{{$request->time}}">
 				
							<script src="/laydate/laydate.js"></script>
							<script>
							//执行一个laydate实例
								laydate.render({
								  elem: '#test10'
								  ,type: 'date'
								  ,range: true

								});
								laydate.render({
								  elem: '#test1'
								  ,type: 'time'
								  ,format: 'H:00'
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
							<div class="am-input-group am-input-group-sm tpl-form-border-form cl-p" style="display: inline;float: right">
		                        <span class="am-input-group-btn">
									<button class="am-btn  am-btn-default am-btn-success tpl-table-list-field am-icon-search" type="submit" > 搜索</button>
								</span>
		                    </div>
						</div>
						
					</div>
				</form>
                <div class="am-u-sm-12">
                    <table class="am-table am-table-compact am-table-striped tpl-table-black " width="100%">
                        <thead>
                            <tr>
                                <th>课程时间</th>
                                
                                <th>老师</th>
                                <th>老师QQ号</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach ($res as $k => $v)
                            <tr class="gradeX">
                                <td class="am-text-middle">{{date('Y-m-d',$v->classdate)}} >>> {{date(' H:i',$v->classtime)}}</td>
                                <td class="am-text-middle">{{$tea[$v->tid]}}</td>
                                <td class="am-text-middle">{{$tea_qq[$v->tid]}}</td>
                                <td class="am-text-middle">
                                    <div class="tpl-table-black-operation">
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target=".bs-example-modal-lg" style="width: 50%" classtime="{{$v->classdate}}|{{$v->classtime}}" tid="{{$v->tid}}" tea="{{$tea[$v->tid]}}" date_date="{{date('Y-m-d',$v->classdate)}}" date_time="{{date(' H:i',$v->classtime)}}">预约</button>
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
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="margin-top:100px;margin-left:300px;">
  		<div class="modal-dialog modal-lg" role="document">
    		<div class="modal-content">
    			<div class="widget am-cf">
    			<div class="widget-head am-cf">
		            <div class="widget-title am-fl" id="model_title"></div>
		            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">关闭</button>
		        </div>
		        <div class="widget-body am-fr">
		            <form class="am-form tpl-form-border-form tpl-form-border-br" action="/admin/stu_sclass" method="get" enctype="multipart/form-data" id="upd_num">
	                    <label for="user-name" class="am-u-sm-3 am-form-label">用户名(手机) <span class="tpl-form-line-small-title">phone</span></label>
	                    <div class="am-u-sm-9">
	                        <input class="tpl-form-input" name="phone" value="" type="text" >
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
	                    <input type="hidden" value="" name="tid">
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
    $('.am-fr ul').addClass("am-pagination tpl-pagination");

   	$('button[data-toggle=modal]').click(function(){
   		var tea = $(this).attr('tea');
   		var classtime = $(this).attr('classtime');
   		var tid = $(this).attr('tid');
   		var date_time = $(this).attr('date_time');
   		var date_date = $(this).attr('date_date');
    	$('input[name=tid]').val(tid);
		var classtime_arr = classtime.split('|');
		var click_classtime = Number(classtime_arr[0])+8*60*60+Number(classtime_arr[1]);
		$('#classtime').attr('value',click_classtime);
		$('#model_title').html('您将预约 <b style="color:red;">'+tea+'</b>老师<b style="color:red;">'+date_date+' '+date_time+'</b>的课程');
   	});
</script>

@stop