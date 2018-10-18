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
                <div class="widget-title  am-cf">未预约批改篇数管理</div>
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
                
                <form action="/admin/tea_wcorrect" method="get">
                	
		            
					<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
	                    <div class="am-form-group tpl-table-list-select" >
	                    	从几号开始：
	                    	<input type="text" id="test10" name="range" style="width: 30%;height: 35px" value="{{$range}}">
							<input type="hidden" name="username" value="{{$username}}">
 				
							<script src="/laydate/laydate.js"></script>
							<script>
							//执行一个laydate实例
								laydate.render({
								  elem: '#test10'
								  ,type: 'date'

								});
							</script>
							<select data-am-selected="{btnSize: 'sm'}"  name="cateid">
	                        	<option value="0" selected>老师类型</option>
				                <option value="13" @if($cateid==13) selected @endif>大作文</option>
				                <option value="15" @if($cateid==15) selected @endif>小作文</option>
							</select>
	                        <select data-am-selected="{btnSize: 'sm'}"  name="tid">
	                        	<option value="0" selected>所有作文批改老师</option>
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
                                <th></th>
	                            @for ($i = 0; $i < 7; $i++)

								    <th>{{date('Y-m-d',$start+24*3600*$i)}}</th>

								@endfor
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach ($res_tids as $k => $v)
                            	<tr>
                            		<th>{{$tea[$v] }} @if($teacateid[$v] == 13) (大作文) @elseif($teacateid[$v] == 15) (小作文) @endif</th>
                            		@for ($i = 0; $i < 7; $i++)
                            			@php
										$result = DB::table('tea_wcorrect')->where('tid',$v)->where('classtime',($start+24*3600*$i))->first();
                            			@endphp
                        				@if(!$result)
                        					<td>
												<button class="btn btn-default" style="font-size: 12px;" >
													未开放
												</button>
											</td>
										@else
											@if($result->status == 1)
											<td>
												<button class="btn btn-primary" data-toggle="modal" data-target=".bs-modal-lg" style="font-size: 12px;" classtime="{{$start+24*3600*$i}}" tid="{{$v}}"  cateid="{{$teacateid[$v]}}" tea="{{$tea[$v]}}" date="{{date('Y-m-d',$start+24*3600*$i)}}">
													正常 ({{$result->num}} / {{$result->total_num}})
												</button>
											</td>
											@elseif($result->status == 2)
											<td>
												<button class="btn btn-danger" data-toggle="modal" data-target=".bs-modal-lg" style="font-size: 12px;" classtime="{{$start+24*3600*$i}}" tid="{{$v}}"  cateid="{{$teacateid[$v]}}" tea="{{$tea[$v]}}" date="{{date('Y-m-d',$start+24*3600*$i)}}" >
													即将约满还有1篇
												</button>
											</td>
											@elseif($result->status == 3)
											<td>
												<button class="btn btn-info" style="font-size: 12px;">
													已约满
												</button>
											</td>
											@elseif($result->status == 4)
											<td>
												<button class="btn btn-default" style="font-size: 12px;">
													暂未开放
												</button>
											</td>
											@endif
                        				@endif
                            			
                            		@endfor
                            	</tr>
                            @endforeach
                            <!-- more data -->
                        </tbody>
                    </table>
                </div>
            </div>
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
		                        <input class="tpl-form-input" name="phone" value="{{$username}}" type="text" >
		                    </div>
		                    <label for="user-name" class="am-u-sm-3 am-form-label">淘宝ID <span class="tpl-form-line-small-title">taobaoID</span></label>
		                    <div class="am-u-sm-9">
		                        <input class="tpl-form-input" name="taobaoID" value="" type="text" >
		                    </div>
		                    
		                    <!-- <div class="am-u-sm-9"> -->
	                        
		                    <input type="hidden" value="" name="tid">
		                    <input type="hidden" value="" name="cateid">
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
   
  $('button[data-target=".bs-modal-lg"]').click(function(){
   		
   		$('input[name=classtime]').val($(this).attr('classtime'));
   		$('input[name=cateid]').val($(this).attr('cateid'));
   		$('input[name=tid]').val($(this).attr('tid'));
   		var tea = $(this).attr('tea');
   		var date = $(this).attr('date');
   		var cateid = $(this).attr('cateid');
   		if (cateid == 13) {
   			var catename = '大作文';
   		}else{
   			var catename = '小作文';
   		}
   		$('#model_title').html('您将预约'+tea+'老师'+date+'的<b style="color:red">【'+catename+'】</b>需在当日晚22点前上传，否则视为作废');
   	});
</script>

@stop