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
	            <div class="widget-title am-fl">添加角色</div>
	        </div>
	        <div class="widget-body am-fr">
	            <form class="am-form tpl-form-border-form tpl-form-border-br" action="/rp/role" method="post">
	                {{csrf_field()}}
	                <div class="am-form-group">
	                    <label for="user-name" class="am-u-sm-3 am-form-label">角色名 <span class="tpl-form-line-small-title">role_name</span></label>
	                    <div class="am-u-sm-9">
	                        <input class="tpl-form-input" name="name" placeholder="请输入角色名" type="text">
	                    </div>
	                </div>
	                
	                <div class="am-form-group">
	                    <div class="am-u-sm-9 am-u-sm-push-3">
	                        <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success am-icon-plus" id="add" disabled="disabled"> 添加</button>
	                    </div>
	                </div>
	            </form>
	        </div>
	    </div>
	</div>
	<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
        <div class="widget am-cf">
            <div class="widget-head am-cf">
                <div class="widget-title  am-cf">角色列表</div>
            </div>
            <div class="widget-body  am-fr">
                
                

                <div class="am-u-sm-12">
                    <table class="am-table am-table-compact am-table-striped tpl-table-black " width="100%">
                        <thead>
                            <tr>
                                <th>角色ID</th>
                                <th>角色名</th>
                                <th>
                                	<button type="button" class="btn btn-info" data-toggle="modal" data-target=".bs-example-modal-lg" style="font-size: 12px;" id="role_p_look"><i  ></i>可用权限（点此可添加修改全部权限）
                                	</button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        	
                        	@foreach ($res as $k => $v)
                            <tr class="gradeX">
                            	<td>{{$v->id}}</td>
                                <td style="width: 10%">
                                	<input type="text" value="{{$v->name}}" class="am-text-middle" rid="{{$v->id}}" name="upd_name">
                                </td>
                                <td>
                                	<button type="button" class="btn btn-danger" data-toggle="modal" data-target=".bs-modal-lg" style="font-size: 12px;" rid="{{$v->id}}" rolename="{{$v->name}}">
                                		<i class="am-icon-pencil"></i> 查看此角色权限
                                	</button>
                                	<form action="/rp/role/{{$v->id}}" method="post"style="display: inline">
			                    		{{csrf_field()}}
			                    		{{method_field('delete')}}
			                    		<button class="delete-button"><i class="am-icon-trash" type="submit"></i> 删除</button>
			                    	</form>
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
    <!-- 权限模态框 -->
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="margin-top:100px;margin-left:300px;">
  		<div class="modal-dialog modal-lg" role="document">
    		<div class="modal-content">
    			<div class="widget am-cf">
    			<div class="widget-head am-cf">
		            <div class="widget-title am-fl">全部权限列表</div>
		        </div>

		        <div class="widget-body am-fr">
		            <form class="am-form tpl-form-border-form tpl-form-border-br" action="" method="">
		                <div class="am-form-group">
		                    <label for="user-name" class="am-u-sm-3 am-form-label">权限名 <span class="tpl-form-line-small-title">p_title</span></label>
		                    <div class="am-u-sm-9">
		                        <input class="tpl-form-input" name="p_title_add" placeholder="请输入权限名" type="text">
		                    </div>
		                </div>
		                <div class="am-form-group">
		                    <label for="user-name" class="am-u-sm-3 am-form-label">权限URL <span class="tpl-form-line-small-title">p_url</span></label>
		                    <div class="am-u-sm-9">
		                        <input class="tpl-form-input" name="p_url_add" placeholder="请输入权限URL" type="text">
		                    </div>
		                </div>
		                <div class="am-form-group">
		                    <div class="am-u-sm-9 am-u-sm-push-3">
		                        <button type="button" class="am-btn am-btn-primary tpl-btn-bg-color-success am-icon-plus" id="addp" disabled="disabled"> 添加</button>
		                    </div>
		                </div>
		            </form>
		        </div>
		        <div class="widget-body am-fr">
		        	<table class="am-table am-table-compact am-table-striped tpl-table-black " width="100%">
		        		<thead>
                            <tr>
                                <th>权限名</th>
                                <th>权限URL</th>
                                <th>删除</th>
                            </tr>
                        </thead>
                        <tbody id="quan">
				            
				            	@foreach($res_p as $k=>$v)
				            	<tr>
								<td style="width: 200px"><input type="text" value="{{$v->p_title}}" name="p_title" pid="{{$v->id}}"style="width: 90%"></td>
								<td><input type="text" value="{{$v->p_url}}" name="p_url" pid="{{$v->id}}" style="width: 100%"></td>
								<td>
									<form action="/rp/role/deletep/{{$v->id}}" method="post" style="display: inline">
			                    		{{csrf_field()}}
			                    		<button class="delete-button"><i class="am-icon-trash" type="submit"></i> 删除</button>
			                    	</form>
			                    </td>
				                </tr>
				                @endforeach

						</tbody>
					</table>
				</div>
			</div>
		    </div>
  		</div>
	</div>
	<!-- 角色权限对应关系模态框 -->
    <div class="modal fade bs-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="margin-top:100px;margin-left:300px;" id="identifier">
  		<div class="modal-dialog modal-lg" role="document">
    		<div class="modal-content">
    			<div class="widget am-cf">
    			<div class="widget-head am-cf">
		            <div class="widget-title am-fl" id="quanxian"></div>
		        </div>
		        <div class="widget-body am-fr">
		        	<table class="am-table am-table-compact am-table-striped tpl-table-black " width="100%">
		        		<thead>
                            <tr>
                                <th>
                                	<button id="quanxuan" class="btn btn-default-sm">全选</button>
                                	 <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success am-icon-plus" id="addrp" rid="">添加</button>
                                </th>
                                <th>权限名</th>
                                <th>权限URL</th>
                            </tr>
                        </thead>
                        <tbody>
				            <form class="am-form tpl-form-border-form tpl-form-border-br" action="" method="" id="">
				            	@foreach($res_p as $k=>$v)
				            	<tr>
								<td><input name="p_id[]" type="checkbox" value="{{$v->id}}" /></td>
								<td>{{$v->p_title}}</td>
								<td>{{$v->p_url}}</td>
				                </tr>
				                @endforeach
							</form>
						</tbody>
					</table>
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
    // 判断是否填入角色名
    $('input[name=name]').change(function(){
    	if ($(this).val()) {
    		$('#add').removeAttr('disabled');
    	}else{
    		$('#add').attr('disabled','disabled');
    	}
    });
    // 判断是否填入权限名
    $('input[name=p_title_add]').change(function(){
    	if ($(this).val() && $('input[name=p_url_add]').val()) {
    		$('#addp').removeAttr('disabled');
    	}else{
    		$('#addp').attr('disabled','disabled');
    	}
    });
    // 判断是否填入权限URL
    $('input[name=p_url_add]').change(function(){
    	if ($(this).val() && $('input[name=p_title_add]').val()) {
    		$('#addp').removeAttr('disabled');
    	}else{
    		$('#addp').attr('disabled','disabled');
    	}
    });
    // 添加权限按钮
    $('#addp').click(function(){
    	var p_title = $('input[name=p_title_add]').val();
    	var p_url = $('input[name=p_url_add]').val();
    	$.ajax({
		    type:'POST',
		    url:'/rp/role/addp',
		    dataType:'json',
		    headers:{
		        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
		    },
		    data:{'p_title':p_title,'p_url':p_url}, 
		    success:function(data){
		        if(data.status == 1){
		        	var v = data.con;
					var form = $('#quan');
		        	var tr = $('<tr><td><input type="text" value="'+v.p_title+'" name="p_title" pid="'+v.id+'"></td><td><input type="text" value="'+v.p_url+'" name="p_url" pid="'+v.id+'"></td><td></td></tr>');
		        	// console.log(tr);
		        	tr.appendTo(form);
		            // form.prepend(tr);
		        }else{
		        	alert(data.status);
		        }
		    },
		    error:function(data){
		        //错误信息
		    }
		});
    });
    // 修改角色名
    $('input[name=upd_name]').change(function(){
    	var id = $(this).attr('rid');
    	var name = $(this).val();
    	$.ajax({
		    type:'GET',
		    url:'/rp/role/'+id,
		    dataType:'json',
		    data:{'name':name}, 
		    success:function(data){
		        if(data.status == 1){
		            alert(data.con);
		        }else{
		        	alert(data.con);
		        }
		    },
		    error:function(data){
		        //错误信息
		    }
		});
    });
    // 全部权限模态框
    // $().click(function(){

    // });
    // 修改权限名
    $('input[name=p_title]').change(function(){
    	var id = $(this).attr('pid');
    	var p_title = $(this).val();
    	$.ajax({
		    type:'GET',
		    url:'/rp/role/create',
		    dataType:'json',
		    data:{'p_title':p_title,'id':id}, 
		    success:function(data){
		        if(data.status == 1){
		            alert(data.con);
		        }else{
		        	alert(data.con);
		        }
		    },
		    error:function(data){
		        //错误信息
		    }
		});
    });
    // 修改权限url
    $('input[name=p_url]').change(function(){
    	var id = $(this).attr('pid');
    	var p_url = $(this).val();
    	$.ajax({
		    type:'GET',
		    url:'/rp/role/create',
		    dataType:'json',
		    data:{'id':id,'p_url':p_url}, 
		    success:function(data){
		        if(data.status == 1){
		            alert(data.con);
		        }else{
		        	alert(data.con);
		        }
		    },
		    error:function(data){
		        //错误信息
		    }
		});
    });
    $('#identifier').on('hide.bs.modal', function () {
		location.replace(location.href);
	})
    // 查看角色对应的权限
    $('button[data-target=".bs-modal-lg"]').click(function(){
    	var rid = $(this).attr('rid');
    	$('#addrp').attr('rid',rid);
    	var rolename = $(this).attr('rolename');
    	$('#quanxian').html('"'+rolename+'"角色的权限表');
    	$.ajax({
		    type:'POST',
		    url:'/rp/role/'+rid+'/showp',
		    dataType:'json',
		    headers:{
		        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
		    },
		    data:{}, 
		    success:function(data){
		        if(data.status == 1){
		            for (var i = data.con.length - 1; i >= 0; i--) {
		            	console.log($('input[type=checkbox][value="'+data.con[i]+'"]').val());
		            	$('input[type=checkbox][value="'+data.con[i]+'"]').attr('checked','checked');
		            }
		        }else{
		        	alert(0);
		        }
		    },
		    error:function(data){
		        //错误信息
		    }
		});
    });
    // 全选按钮
    $('#quanxuan').click(function(){
    	$('input[type=checkbox]').each(function(){
    		$(this).attr('checked','checked');
    	});
    });
    // 修改r-p对应
    $('#addrp').click(function(){
    	var rid = $(this).attr('rid');
    	var arr = [];
    	$('input[type=checkbox]:checked').each(function(){
    		
    			arr.push($(this).val());
    			

    	});
    	$.ajax({
		    type:'POST',
		    url:'/rp/role/'+rid,
		    dataType:'json',
		    headers:{
		        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
		    },
		    data:{'pid':arr,'_method':"PUT"}, 
		    success:function(data){
		        if(data.status == 1){

		            alert('修改角色对应权限成功');
		        }else{
		        	alert('修改角色对应权限失败');
		        }
		    },
		    error:function(data){
		        //错误信息
		    }
		});
    });
</script>

@stop