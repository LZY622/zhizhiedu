@extends('layouts.admin.admins')
@section('title','吱吱英语后台管理')
@section('content')
<!-- <link rel="stylesheet" href="/assets/css/fullcalendar.min.css" /> -->
<!-- <link rel="stylesheet" href="/assets/css/fullcalendar.print.css" media='print' /> -->
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
                <div class="widget-title  am-cf">学生管理</div>
            </div>
            <div class="widget-body  am-fr">
                <div class="am-u-sm-12 am-u-md-6 am-u-lg-3">
                    <div class="am-form-group">
                        <div class="am-btn-toolbar">
                            <div class="am-btn-group am-btn-group-xs">
                                <a href="/admin/stuuser/create" class="am-btn am-btn-default am-btn-success">
                                	<!-- <button type="button" > -->
	                                	<span class="am-icon-plus"></span> 
	                                	新增学生
	                                <!-- </button> -->
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="/admin/stuuser" method="get">
                	<div class="am-u-sm-12 am-u-md-6 am-u-lg-3">
	                    <div class="am-form-group tpl-table-list-select">
	                        <select data-am-selected="{btnSize: 'sm'}" style="display: none;" name="status"> 
	                        	<option value="1" @if($status == 1) selected @endif>启用</option>
	                        	<option value="0" @if($status == 0)selected @endif>禁用</option>
	                        	
							</select>
							
						</div>
					</div>
					<div class="am-u-sm-12 am-u-md-12 am-u-lg-6" style="">
	                    <div class="am-input-group am-input-group-sm tpl-form-border-form cl-p">
	                        <input class="am-form-field " type="text" name="username" value="{{$req->username}}" placeholder="请输入用户名/QQ号/淘宝ID/英文名">
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
                                <th>口语管理</th>
                                <th>作文管理</th>
                                <th>添加课时</th>
                                <th>头像</th>
                                <th>英文名</th>
                                <th>手机</th>
                                <th>淘宝ID</th>
                                <th>QQ号</th>
                                <th>操作</th>
                                <th>添加时间</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach ($res as $k => $v)
                            <tr class="gradeX">
                            	<td class="am-text-middle">
                                    <a href="/admin/stu_sclass/create?username={{$v->phone}}" class="am-btn  am-btn-default am-btn-primary" style="font-size: 12px;">
                                        <i class="am-icon-pencil"></i> Class
                                    </a>
                                
                                    <a href="/admin/tea_sclass/{{$chushi_id}}/edit?id={{$v->id}}" class="am-btn  am-btn-default am-btn-info" style="font-size: 12px;">
                                        <i class="am-icon-pencil"></i> Book
                                    </a>
								</td>
								<td class="am-text-middle">
                                    <a href="/admin/stu_wcorrect/create?username={{$v->phone}}&status=0" class="am-btn  am-btn-default am-btn-primary" style="font-size: 12px;">
                                        <i class="am-icon-pencil"></i> Tasks
                                    </a>
                                
                                    <a href="/admin/tea_wcorrect?cateid=15&username={{$v->phone}}" class="am-btn  am-btn-default am-btn-info" style="font-size: 12px;">
                                        <i class="am-icon-pencil"></i> Book
                                    </a>
								</td>
								<td>
                                    <!-- Large modal -->
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg" style="font-size: 12px;" uid="{{$v->id}}">AddNum</button>
									<a href="/admin/stuuser/select_all?range={{date('Y-m-d',0)}}+-+{{date('Y-m-d',time())}}&username={{$v->phone}}" class="am-btn  am-btn-default am-btn-info" style="font-size: 12px;">
                                        添加记录
                                    </a>

                                </td>
                                <td>
                                    <img src="{{$v->img}}" class="tpl-table-line-img" width="50px" alt="">
                                </td>
                                <td class="am-text-middle">{{$v['user_message']->mname}}</td><td class="am-text-middle">{{$v->phone}}</td>
                                <td class="am-text-middle">{{$v['user_message']->taobaoID}}</td>
                                <td class="am-text-middle">{{$v['user_message']->qq}}</td>
                                <td class="am-text-middle">
                                    <div class="tpl-table-black-operation">
                                        
                                        <a href="/admin/stuuser/{{$v->id}}">
                                            <i class="am-icon-pencil"></i> 编辑资料
                                        </a>
                                        <form action="/admin/stuuser/{{$v->id}}" method="post"style="display: inline">
				                    		{{csrf_field()}}
				                    		{{method_field('delete')}}
				                    		<button class="delete-button"><i class="am-icon-trash" type="submit"></i> 重置密码</button>
				                    	</form>
                                        
                                    </div>
                                </td>
                                <td class="am-text-middle">{{date('Y-m-d H:i',$v->addtime)}}</td>
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
	    	{!! $res->appends($req->all())->links() !!}
	    </div>
	</div>
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="margin-top:100px;margin-left:300px;">
  		<div class="modal-dialog modal-lg" role="document">
    		<div class="modal-content">
    			<div class="widget am-cf">
    			<div class="widget-head am-cf">
		            <div class="widget-title am-fl" id="model_title"></div>
		        </div>
		        <div class="widget-body am-fr">
		            <form class="am-form tpl-form-border-form tpl-form-border-br" action="" method="get" enctype="multipart/form-data" id="upd_num">
	                    <label for="user-name" class="am-u-sm-3 am-form-label">用户名(手机) <span class="tpl-form-line-small-title">username</span></label>
	                    <div class="am-u-sm-3">
	                        <input class="tpl-form-input" name="phone" value="" type="text" disabled>
	                    </div>
	                    <label for="user-name" class="am-u-sm-3 am-form-label">淘宝ID <span class="tpl-form-line-small-title">taobaoID</span></label>
	                    <div class="am-u-sm-3">
	                        <input class="tpl-form-input" name="taobaoID" value="" type="text" disabled>
	                    </div>
	                    <label for="user-name" class="am-u-sm-2 am-form-label">口语课课时数 </label>
	                    <div class="am-u-sm-1">
	                        <input class="tpl-form-input" name="s_num_old" value="" type="text" disabled>
	                    </div>
	                    <div class="am-u-sm-1" style="text-align: center;font-size: 18px">+</div>
	                    <div class="am-u-sm-2">
	                        <input class="tpl-form-input" name="s_num" value="0" type="text">
	                    </div>
	                    <label for="user-name" class="am-u-sm-2 am-form-label">口语模考课时数 </label>
	                    <div class="am-u-sm-1">
	                        <input class="tpl-form-input" name="m_num_old" value="" type="text" disabled>
	                    </div>
						<div class="am-u-sm-1" style="text-align: center;font-size: 18px">+</div>
	                    <div class="am-u-sm-2">
	                        <input class="tpl-form-input" name="m_num" value="0" type="text">
	                    </div>
	                    <label for="user-name" class="am-u-sm-2 am-form-label">写作课课时数 </label>
	                    <div class="am-u-sm-1">
	                        <input class="tpl-form-input" name="w_num_old" value="" type="text" disabled>
	                    </div>
	                    <div class="am-u-sm-1" style="text-align: center;font-size: 18px">+</div>
	                    <div class="am-u-sm-2">
	                        <input class="tpl-form-input" name="w_num" value="0" type="text">
	                    </div>
	                    <label for="user-name" class="am-u-sm-2 am-form-label">大作文批改篇数</label>
	                    <div class="am-u-sm-1">
	                        <input class="tpl-form-input" name="bw_num_old" value="" type="text" disabled>
	                    </div>
	                    <div class="am-u-sm-1" style="text-align: center;font-size: 18px">+</div>
	                    <div class="am-u-sm-2">
	                        <input class="tpl-form-input" name="bw_num" value="0" type="text">
	                    </div>
	                    <label for="user-name" class="am-u-sm-2 am-form-label">小作文批改篇数 </label>
	                    <div class="am-u-sm-1">
	                        <input class="tpl-form-input" name="sw_num_old" value="" type="text" disabled>
	                    </div>
						<div class="am-u-sm-1" style="text-align: center;font-size: 18px">+</div>
	                    <div class="am-u-sm-2">
	                        <input class="tpl-form-input" name="sw_num" value="0" type="text">
	                    </div>
	                
	                    <label for="user-phone" class="am-u-sm-2 am-form-label">
	                        试听权限 
	                        <!-- <span class="tpl-form-line-small-title">st_sta</span> -->
	                    </label>
	                    <!-- <div class="am-u-sm-9"> -->
                        <select  name="st_sta" style="width: 20%;">
                            <option value="1">已试听</option>
                            <option value="0">未试听</option>
                        </select>
	                    <!-- </div> -->
	                    <label for="user-phone" class="am-u-sm-2 am-form-label">
	                        更改类型 
	                    </label>
	                    <!-- <div class="am-u-sm-9"> -->
                        <select  name="type" style="width: 50%">
                            <option value="1">正常</option>
                            <option value="2">转让</option>
                            <option value="3">操作失误</option>
                            <option value="4">退款</option>
                            <option value="5">补偿</option>
                            <option value="6">其他</option>
                        </select>
		                <div class="am-form-group">
		                    <div class="am-u-sm-9 am-u-sm-push-3">
		                        <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success ">提交</button>
		                    </div>
		                </div>
					</form>
					<!-- <div class="fc-view fc-month-view fc-basic-view" style=""> -->
					<table class="am-table am-table-compact am-table-striped tpl-table-black " width="100%">
						<thead class="fc-head">
							<tr>
								<th></th>
								<th>口语课</th>
								<th>口语试听</th>
								<th>口语模考</th>
								<th>写作课</th>
								<th>大作文批改</th>
								<th>小作文批改</th>
							</tr>
						</thead>
						<tbody class="fc-head" id="add_jilu">
							<tr id="total_yimai">
								<th>已购买</th>
								<td class="add_s"></td>
								<td class="add_st"></td>
								<td class="add_m"></td>
								<td class="add_w"></td>
								<td class="add_bw"></td>
								<td class="add_sw"></td>
							</tr>
							<tr id="total_zhuanrang">
								<th>转让</th>
								<td class="add_s"></td>
								<td class="add_st"></td>
								<td class="add_m"></td>
								<td class="add_w"></td>
								<td class="add_bw"></td>
								<td class="add_sw"></td>
							</tr>
							<tr id="total_tuikuan">
								<th>退款</th>
								<td class="add_s"></td>
								<td class="add_st"></td>
								<td class="add_m"></td>
								<td class="add_w"></td>
								<td class="add_bw"></td>
								<td class="add_sw"></td>
							</tr>
							<tr id="total_buchang">
								<th>补偿</th>
								<td class="add_s"></td>
								<td class="add_st"></td>
								<td class="add_m"></td>
								<td class="add_w"></td>
								<td class="add_bw"></td>
								<td class="add_sw"></td>
							</tr>
						</tbody>
					</table>
					<!-- </div> -->
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
   		var id = $(this).attr('uid');
   		$('#model_title').html('添加'+id+'号学生课时');
    	$('#upd_num').attr('action','/admin/stuuser/'+id+'/edit');
   		// console.log(id);
   		$.ajax({
		    type:'GET',
		    url:'/admin/stuuser/select_num/'+id,
		    dataType:'json',
		    data:{},
		    success:function(data){
		    	if (data.status == 1) {
		    		$('input[name=phone]').val(data.phone);
		    		$('input[name=taobaoID]').val(data.taobaoID);
		    		$('input[name=s_num_old]').val(data.con[0].s_num);
		    		$('input[name=m_num_old]').val(data.con[0].m_num);
		    		$('input[name=w_num_old]').val(data.con[0].w_num);
		    		$('input[name=bw_num_old]').val(data.con[0].bw_num);
		    		$('input[name=sw_num_old]').val(data.con[0].sw_num);
		    		$('select[name=st_sta]').val(data.con[0].st_sta);
		    		$('#add_jilu td').each(function(){
		    			var classname = $(this).attr('class');
		    			var idname = $(this).parent().attr('id');
		    			
		    			// 将字符串转化为变量名
		    			
		    			$(this).html(eval('data.'+idname+'[\''+classname+'\']'));
		    		});
		    		// 
		    	}
		    },
		    error:function(data){
		        console.log(data.status);
		    }
		});
   	});
</script>

@stop