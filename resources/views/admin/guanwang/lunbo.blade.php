@extends('layouts.admin.admins')
@section('title','吱吱英语后台管理')
@section('content')
<meta name="csrf-token" content="{{csrf_token()}}">
	<div id="xinxi">
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
	</div>
	<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
        <div class="widget am-cf">
            <div class="widget-head am-cf">
                <div class="widget-title  am-cf">学生主页轮播图管理</div>
            </div>
            <div class="widget-body  am-fr">
                <div class="am-u-sm-12 am-u-md-6 am-u-lg-6">
                    <div class="am-form-group">
                        <div class="am-btn-toolbar">
                            <div class="am-btn-group am-btn-group-xs">
                            	@if($count<5)
                                <a href="/admin/guanwang/add_lunbo" class="am-btn am-btn-default am-btn-success">
                                	<span class="am-icon-plus"></span> 
                                	新增
                                </a>
                                @else
                                <button type="button" class="am-btn am-btn-default am-btn-success">
	                                不可超过5个轮播图
	                            </button>
	                            @endif
                            </div>
                        </div>
                    </div>
                </div>
                

                <div class="am-u-sm-12">
                    <table class="am-table am-table-compact am-table-striped tpl-table-black " width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>图片 url（2000*1333px）</th>
                                <th>图片标题 h2</th>
                                <th>图片副标题 p</th>
                            </tr>
                        </thead>
                        <tbody id="biaoge">
                        	@foreach ($res as $k => $v)
                            <tr class="gradeX">
                                <td class="am-text-middle">
                                	{{$v->id}}
                                </td>
                                <td class="am-text-middle">
	                                <form class="am-form tpl-form-border-form tpl-form-border-br" action="" method="post" enctype="multipart/form-data" id="art_form_{{$v->id}}">
	                					{{csrf_field()}}
	                                	<div class="am-form-group am-form-file">
				                            <div class="tpl-form-file-img">
				                                <img src="{{$v->url}}" alt="" width="200px" id="img{{$v->id}}">
				                            </div>
				                            <input id="file_upload_{{$v->id}}" multiple="" type="file" name="file_upload_{{$v->id}}" lid="{{$v->id}}">
				                            <input type="hidden" name="id" value="{{$v->id}}">
				                        </div>
				                    </form>
                                </td>
                                <td class="am-text-middle">
                                	<input type="text" name="h2" lid="{{$v->id}}" value="{{$v->h2}}">
                                </td>
                                <td class="am-text-middle">
                                	<input type="text" name="p" lid="{{$v->id}}" value="{{$v->p}}">
                                </td>
                                <td class="am-text-middle">
                                    <div class="tpl-table-black-operation">
                                        <a href="/admin/guanwang/lunbo_shan/{{$v->id}}">
                                            <i class="am-icon-pencil"></i> 删除
                                        </a>
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
    
    
@endsection
@section('js')
<script>
$(function(){
    $('.alert-success').delay(2000).fadeOut(1000);
    $('.alert-warning').delay(2000).fadeOut(1000);
    $('#biaoge input[type=text]').change(function(){
		$.ajax({
		    type:'POST',
		    url:'/admin/guanwang/up_lunbo',
		    dataType:'json',
		    //引入token，在头部写一个meta标签
		    //<meta name="csrf-token" content="{{csrf_token()}}">
		    headers:{
		        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
		    },
		    data:{'id':$(this).attr('lid'),'name':$(this).attr('name'),'value':$(this).val()},//layui的表单submit监听
		    success:function(data){
		        if(data.status == 1){
		            var div = $('<div class="alert alert-success" role="alert">修改成功</div>');
		        }else{
		            var div = $('<div class="alert alert-warning" role="alert">修改失败</div>');
		        }
		        $('#xinxi div').remove();
	            $('#xinxi').append(div);
	            $('.alert-success').delay(2000).fadeOut(1000);
	            $('.alert-warning').delay(2000).fadeOut(1000);
		    },
		    error:function(data){
		    }
		});
	});

	$('#biaoge input[type=file]').change(function(){
	    uploadImage($(this).attr('lid'));
	});
	// });
});
function uploadImage(d) {
    //获取表单元素
    var formElement = document.querySelector("#art_form_"+d);
    //生成formData对象，并将表单元素传入
    var formData = new FormData(formElement);
    //创建xhr对象用于ajax
    var request = new XMLHttpRequest();
    //监听响应状态变化
    request.onreadystatechange=function()
    {
        if (request.readyState==4 && request.status==200)
        {
            var obj = JSON.parse(request.responseText);
            if (obj.status) {
                $('#img'+d).attr('src',obj.filepath);
                var div = $('<div class="alert alert-success" role="alert">修改成功</div>');
                $('#xinxi div').remove();
                $('#xinxi').append(div);
                $('.alert-success').delay(2000).fadeOut(1000);
                $('.alert-warning').delay(2000).fadeOut(1000);
            }else{
                var div = $('<div class="alert alert-warning" role="alert">修改失败</div>');
                $('#xinxi div').remove();
                $('#xinxi').append(div);
                $('.alert-success').delay(2000).fadeOut(1000);
                $('.alert-warning').delay(2000).fadeOut(1000);  
            }
            
            
        }
    }
    //以post方式向/admin/upload路由发送请求
    request.open("POST", "/admin/guanwang/up_lunbo");
    //发送请求
    request.send(formData);
}
</script>

@stop