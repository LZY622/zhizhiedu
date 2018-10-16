<style>
    .button-teal{
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
        <h5>选择老师：</h5>
        <select  name="tea_name" class="sm-form-control"  oldid="{{$id}}">
            @foreach($tea as $k=>$v)
            <option value="{{$k}}" @if($k==$id) selected @endif>
            {{$v}}
            </option>
            @endforeach
        </select>
    </div>
    <div class="line" style="margin:20px 0 20px 0;"></div>
    <h2>{{$tea[$id]}}未来5日空课表</h2>
    
</div>


<table class="table">
    <thead>
        <tr>
            <th class="">Time</th>
            @for ($i = 0; $i < 5; $i++)
            <th class="info">
                <span>{{date('Y/m/d (D)',$today+24*3600*$i)}}</span>
            </th>
            @endfor
        </tr>
              
    </thead>
    <tbody id="class_book">
        <td style="padding:0px">
            <table class="table">
                @for ($i = 0; $i < 33; $i++)

                <tr class="info">
                    <td>
                        {{date('H:i',-3600+($i*1800))}}
                    </td>
                </tr>
                @endfor
            </table>
        </td>
        @for($i = 0; $i < 5; $i++)
            @php
        $date = strtotime(date('Y-m-d',time()))+($i*86400);
            @endphp
        <td style="padding:0px">
            <table class="table">
                @for ($j = 0; $j < 33; $j++)
                @php
                    $time = -3600+($j*1800);
                @endphp
                <tr>
                    @if($tea_sclass)
                        @if(in_array($date.'|'.$time,$tea_sclass))
                            @if(in_array($date.'|'.$time,$tea_sclass_booked))
                            <td style="padding-bottom: 0px;padding-top: 4.85px">
                                <button class="button button-3d button-small button-rounded button-red button-red" classtime="{{$date.'|'.$time}}">
                                    booked
                                </button>
                            @else
                            <td style="padding-bottom: 0px;padding-top: 4.85px">
                                <button class="button button-3d button-small button-rounded button-green" classtime="{{$date.'|'.$time}}" tea="{{$tea[$id]}}" date_date="{{date('Y-m-d',$date)}}" date_time="{{date(' H:i',$time)}}" date_time_end="{{date(' H:i',$time+25*60)}}">
                                    opened
                                </button>
                            @endif
                        @else
                        <td style="padding-bottom: 0px;padding-top: 4.85px">
                            <button class="button button-3d button-small button-rounded button-leaf" classtime="{{$date.'|'.$time}}">
                                closed
                            </button>
                        @endif 
                    @else
                    <td style="padding-bottom: 0px;padding-top: 4.85px">
                        <button class="button button-3d button-small button-rounded button-leaf" classtime="{{$date.'|'.$time}}">
                            closed
                        </button>
                    @endif
                    </td>
                </tr>
                @endfor
            </table>
        </td>
        @endfor
    </tbody>
</table>
<!-- 预约按钮 -->
<div style="position: fixed;bottom: 20%;left: 50%;z-index: 20;">
    <button class="button button-rounded button-reveal button-xlarge button-dirtygreen" data-toggle="modal" data-target=".chooseclass" id="book_one">
        <i class="icon-book"></i>
        <span>预&nbsp;&nbsp;&nbsp;约</span>
    </button>
</div>
<div class="modal fade chooseclass" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none; padding-right: 17px;">
    <div class="modal-dialog modal-ml">
        <div class="modal-body">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body">
                     <table class="table">
                        <thead>
                            <tr class="info">
                                <th>时间</th>
                                <th>
                                    <select name="cateid" id="class_cateid">
                                        <option value="no" selected>请选择课程类型</option>
                                        <option value="0">口语试听(1个时段=1节)</option>
                                        <option value="4">口语课(2个时段=1节)</option>
                                        <option value="5">口语模考(1个时段=1节)</option>
                                    </select>
                                    <b style="color:red">*</b>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                     </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    
    $(function(){
        $('.alert-success').delay(2000).fadeOut(1000);
        $('.alert-danger').delay(2000).fadeOut(1000);
        // 页面刷新显示要与传来的id的值一致
        var old_id = $('select[name=tea_name]').attr('oldid');
        $('select[name=tea_name]').val(old_id);
        // 时间在当前时间之前的单元格添加一个不能用的类同时删除opened类
            //获取当前时间并转化为php时间戳
        var times = new Date().getTime();
        var time = String(times);
        // var type = typeof(time);
        var phptime = time.slice(0,-3);
        var book = $('#class_book td>button');
        // console.log(book);
        for (var i = book.length - 1; i >= 0; i--) {
            // 获取表格中对应的时间戳
            var booktime = $(book[i]).attr('classtime');
            var booktime_arr = booktime.split('|');
            var table_time = Number(booktime_arr[0])+8*60*60+Number(booktime_arr[1]);
            if (table_time-phptime <= 2*3600) {
                $(book[i]).removeClass('button-leaf');
                $(book[i]).removeClass('button-red');
                $(book[i]).removeClass('button-green');
                $(book[i]).addClass('button-teal');
                $(book[i]).html('overtime');
            }
            // console.log(booktime);
        }
    });
</script>
