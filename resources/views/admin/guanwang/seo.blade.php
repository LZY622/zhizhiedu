@extends('layouts.admin.admins')
@section('title','吱吱英语后台管理')
@section('content')
<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
    <div class="widget am-cf">
        <div class="widget-head am-cf">
            <div class="widget-title am-fl">SEO信息设置</div>
        </div>
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
        <div class="widget-body am-fr">
            <form class="am-form tpl-form-border-form tpl-form-border-br" action="/admin/guanwang/seo" method="post" enctype="multipart/form-data">
                <div class="am-form-group">
                    <label for="user-name" class="am-u-sm-3 am-form-label">TITLE <span class="tpl-form-line-small-title">title</span></label>
                    <div class="am-u-sm-9">
                        <input class="tpl-form-input" name="title" value="{{$res->title}}" type="text">
                        <small></small>
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="user-name" class="am-u-sm-3 am-form-label">KEYWORDS <span class="tpl-form-line-small-title">keywords</span></label>
                    <div class="am-u-sm-9">
                        <input class="tpl-form-input" name="keywords" placeholder="" value="{{$res->keywords}}" type="text">
                        <small>用英文','隔开</small>
                    </div>
                </div>
                <div class="am-form-group">
                    <label for="user-name" class="am-u-sm-3 am-form-label">DESCRIPTION <span class="tpl-form-line-small-title">description</span></label>
                    <div class="am-u-sm-9">
                        <input class="tpl-form-input" name="description" value="{{$res->description}}" type="text" placeholder="">
                        <small>标点用英文</small>
                    </div>
                </div>
                <!-- <div class="am-form-group">
                    <label for="user-name" class="am-u-sm-3 am-form-label">STATUS <span class="tpl-form-line-small-title">status</span></label>
                    <div class="am-u-sm-9">
                        <select name="status">
                        	<option value="2" @if($res->status == 2) selected @endif>禁用</option>
                        	<option value="1" @if($res->status == 1) selected @endif>启用</option>
                        	option
                        </select>
                    </div>
                </div> -->
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>

    $('.alert-success').delay(2000).fadeOut(1000);
    $('.alert-warning').delay(2000).fadeOut(1000);
    $(function(){
    	$('input,select').each(function(){
    		$(this).change(function(){
    			$.ajax({
				    type:'GET',
				    url:'/admin/guanwang/seo',
				    dataType:'json',
				    data:{'con':$(this).attr('name'),'value':$(this).val()},//layui的表单submit监听
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
				        //错误信息
				    }
				});
    		});
    	});
    })
    
</script>

@stop