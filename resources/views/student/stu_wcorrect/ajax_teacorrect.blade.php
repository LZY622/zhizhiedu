
<style>
    .button-leaf{
        cursor: no-drop;
    }
    .table button{
        margin-top:0px; 
        margin-bottom:0px; 
    }
    
</style>
<div id="xinxi" style="position: fixed;top: 50%;width: 60%;z-index: 100;text-align: center;" >
    @if(session('success') || (!empty($success)))  
    <div class="alert alert-success" role="alert">
        {{session('success')?session('success'):$success}}  
    </div>
    @endif
    @if (count($errors) > 0)
        <div class="alert alert-danger" role="alert">
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
<div class="fc-toolbar">
	<div>
		<h5>选择作文类型：</h5>
		<select  name="cateid" class="sm-form-control"  oldid="{{$cateid}}">
			<option value="13" @if($cateid==13) selected @endif>大作文批改</option>
			<option value="15" @if($cateid==15) selected @endif>小作文批改</option>
        </select>
	</div>
	<div class="line" style="margin:20px 0 20px 0;"></div>
	<h2>@if($cateid==13)大作文批改老师@elseif($cateid==15)小作文批改老师@endif未来5日空课表</h2>
	
</div>
<table class="table">
    <thead>
        <tr class="info">
            <th></th>
            @for ($i = 0; $i < 5; $i++)

			    <th>{{date('Y-m-d',$start+24*3600*$i)}}</th>

			@endfor
        </tr>
    </thead>
    <tbody>
    	@foreach ($res_tids as $k => $v)
        	<tr>
        		<th>{{$tea[$v]}}</th>
        		@for ($i = 0; $i < 5; $i++)
        			@php
					$result = DB::table('tea_wcorrect')->where('tid',$v)->where('classtime',($start+24*3600*$i))->first();
        			@endphp
    				@if(!$result)
    					<td>
							<button class="button button-3d button-small button-rounded button-leaf" style="font-size: 12px;" >
								未开放
							</button>
						</td>
					@else
						@if($result->status == 1)
						<td>
							<button class="button button-3d button-small button-rounded button-green" data-target=".bs-modal-lg" style="font-size: 12px;" classtime="{{$start+24*3600*$i}}" tid="{{$v}}"  cateid="{{$teacateid[$v]}}" tea="{{$tea[$v]}}" date="{{date('Y-m-d',$start+24*3600*$i)}}">
								正常 ({{$result->num}} / {{$result->total_num}})
							</button>
						</td>
						@elseif($result->status == 2)
						<td>
							<button class="button button-3d button-small button-rounded button-red" data-target=".bs-modal-lg" style="font-size: 12px;" classtime="{{$start+24*3600*$i}}" tid="{{$v}}"  cateid="{{$teacateid[$v]}}" tea="{{$tea[$v]}}" date="{{date('Y-m-d',$start+24*3600*$i)}}" >
								即将约满还有1篇
							</button>
						</td>
						@elseif($result->status == 3)
						<td>
							<button class="button button-3d button-small button-rounded button-info" style="font-size: 12px;">
								已约满
							</button>
						</td>
						@elseif($result->status == 4)
						<td>
							<button class="button button-3d button-small button-rounded button-leaf" style="font-size: 12px;">
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
<div class="modal fade bs-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none; padding-right: 17px;">
	<div class="modal-dialog modal-ml">
		<div class="modal-body">
			<div class="modal-content">
    			<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
		        <div class="modal-body">
                    <input type="hidden" value="" name="tid">
                    <input type="hidden" value="" name="cateid">
                    <input type="hidden" value="" name="classtime" id="classtime">
	                <button type="button" class="button button-3d button-small button-rounded button-blue" style="margin-left:40%" id="book_stu" data-dismiss="modal" aria-hidden="true">确&nbsp;&nbsp;定</button>
				</div>
			</div>
	    </div>
	</div>
</div>
<script>
  	$('.alert-success').delay(2000).fadeOut(1000);
  	$('.alert-danger').delay(2000).fadeOut(1000);
  	// 页面刷新显示要与传来的id的值一致
	var old_id = $('select[name=cateid]').attr('oldid');
	$('select[name=cateid]').val(old_id);
</script>