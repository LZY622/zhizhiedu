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
                <div class="widget-title  am-cf">课时添加记录管理</div>
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
                
                <form action="/admin/stuuser/select_all" method="get">
                	
		            
                	
					<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
	                    <div class="am-form-group tpl-table-list-select">
	                    	时间范围：
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
							<select data-am-selected="{btnSize: 'sm'}"  name="jname">
	                        	<option value="0" selected>所有助教</option>
								@foreach($admin as $k=>$v)
								<option value="{{$v}}" @if($request->jname == $v) selected @endif>{{$v}}</option>
								@endforeach
							</select>
							<select data-am-selected="{btnSize: 'sm'}"  name="type">
	                        	<option value="0" selected>所有类型</option>
	                        	<!-- '1正常 2转让 3操作失误 4退款 5补偿 6其他' -->
	                        	<option value="1" @if($request->type == 1) selected @endif>正常</option>
	                        	<option value="2" @if($request->type == 2) selected @endif>转让</option>
	                        	<option value="3" @if($request->type == 3) selected @endif>操作失误</option>
	                        	<option value="4" @if($request->type == 4) selected @endif>退款</option>
	                        	<option value="5" @if($request->type == 5) selected @endif>补偿</option>
	                        	<option value="6" @if($request->type == 6) selected @endif>其他</option>
							</select>
							<select data-am-selected="{btnSize: 'sm'}"  name="cateid">
	                    		<option value="a" @if($cateid=='a') selected @endif>所有课程类型</option>
	                            <option value="0" @if($cateid==='0') selected @endif>试听</option>
	                            <option value="4" @if($cateid==4) selected @endif>口语课</option>
	                            <option value="5" @if($cateid==5) selected @endif>口语模考</option>
	                            <option value="7" @if($cateid==7) selected @endif>写作课</option>
	                            <option value="13" @if($cateid==13) selected @endif>大作文批改</option>
	                            <option value="15" @if($cateid==15) selected @endif>小作文批改</option>
							</select>
						</div>
					</div>
					
					<div class="am-u-sm-12 am-u-md-12 am-u-lg-6" style="">
	                    <div class="am-input-group am-input-group-sm tpl-form-border-form cl-p">
	                        <input class="am-form-field " type="text" name="username" value="{{$request->username}}" placeholder="请输入用户名/淘宝ID/qq/英文名">
	                        <span class="am-input-group-btn">
								<button class="am-btn  am-btn-default am-btn-success tpl-table-list-field am-icon-search" type="submit"> 搜索</button>
							</span>
	                    </div>
	                </div>
				</form>
                <div class="am-u-sm-12">
                    <table class="am-table am-table-compact am-table-striped tpl-table-black " width="100%">
                        <thead>
                            <tr>
                                <th>添加者</th>
                                <th>学生电话</th>
                                <th>学生淘宝ID</th>
                                <th>课程类型</th>
                                <th>数量</th>
                                <th>添加时间</th>
                                <th>状态</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach ($res as $k => $v)
                            <tr class="gradeX">
                                <td class="am-text-middle">{{$v->jname}}</td>
                                <td class="am-text-middle">{{$users[$v->uid]['phone']}}</td>
                                <td class="am-text-middle">{{$users[$v->uid][0]->taobaoID}}</td>
                                <td class="am-text-middle">
                                	@if($v->cateid==0)口语试听
                                	@elseif($v->cateid==4)口语课
                                	@elseif($v->cateid==5)口语模考
                                	@elseif($v->cateid==7)写作课
                                	@elseif($v->cateid==13)大作文批改
                                	@elseif($v->cateid==15)小作文批改
                                	@endif
                                </td>
                                <!-- 1：已预约 2：已完成 3：已取消 4：老师缺席 5：学生缺席 6：老师紧急取消 7：学生紧急取消  -->
                                <td class="am-text-middle">{{$v->num}}</td>
                                <td class="am-text-middle">{{date('Y-m-d H:i:s',$v->addtime)}}</td>
                                <!-- 1正常 2转让 3操作失误 4退款 5补偿 6其他 -->
                                <td class="am-text-middle">
                                	@if($v->type==1)正常
                                	@elseif($v->type==2)转让
                                	@elseif($v->type==3)操作失误
                                	@elseif($v->type==4)退款
                                	@elseif($v->type==5)补偿
                                	@elseif($v->type==6)其他
                                	@endif
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

@endsection
@section('js')
<script>

    $('.alert-success').delay(2000).fadeOut(1000);
    $('.alert-warning').delay(2000).fadeOut(1000);
    $('.am-fr ul').addClass("am-pagination tpl-pagination");

</script>

@stop