<style>
    .button-teal{
        cursor: no-drop;
    }
    .table button{
        margin-top:0px; 
        margin-bottom:0px; 
    }
    
</style>
<div class="fc-toolbar">
    <div>
        <h5>选择老师：</h5>
        <select  name="tea_name" class="sm-form-control" oldid="{{$id}}">
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
    <tbody>
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
                                <button class="button button-3d button-small button-rounded button-green opened" classtime="{{$date.'|'.$time}}" tea="{{$tea[$id]}}" date_date="{{date('Y-m-d',$date)}}" date_time="{{date(' H:i',$time)}}">
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
<div class="modal fade chooseclass" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none; padding-right: 17px;">
    <div class="modal-dialog modal-sm">
        <div class="modal-body">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body">
                     data-toggle="modal" data-target=".chooseclass"
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.alert-success').delay(2000).fadeOut(1000);
    $('.alert-danger').delay(2000).fadeOut(1000);
    $(function(){
        // 页面刷新显示要与传来的id的值一致
        var old_id = $('select[name=tea_name]').attr('oldid');
        $('select[name=tea_name]').val(old_id);
        // 老师下拉框的改变值的事件
        $(document).on('change','select[name=tea_name]',function(){
            var id = $('select[name=tea_name]').val();
            $.ajax({
                type:'GET',
                url:'/students/stu_sclass',
                dataType:'html',
                
                data:{"id":id},
                success:function(data){
                    $('#snav-content1').html('');
                    $('#snav-content1').html(data);
                    // 第一步：匹配加载的页面中是否含有js
                    var regDetectJs = /<script(.|\n)*?>(.|\n|\r\n)*?<\/script>/ig;
                    var jsContained = data.match(regDetectJs);
                     
                    // 第二步：如果包含js，则一段一段的取出js再加载执行
                    if(jsContained) {
                        // 分段取出js正则
                        var regGetJS = /<script(.|\n)*?>((.|\n|\r\n)*)?<\/script>/im;
                     
                        // 按顺序分段执行js
                        var jsNums = jsContained.length;
                        for (var i=0; i<jsNums; i++) {
                            var jsSection = jsContained[i].match(regGetJS);
                     
                            if(jsSection[2]) {
                                if(window.execScript) {
                                    // 给IE的特殊待遇
                                    window.execScript(jsSection[2]);
                                } else {
                                    // 给其他大部分浏览器用的
                                    window.eval(jsSection[2]);
                                }
                            }
                        }
                    }

                },
                error:function(data){
                }
            });             
        });
        
        
        // 时间在当前时间之前的单元格添加一个不能用的类同时删除opened类
            //获取当前时间并转化为php时间戳
        var times = new Date().getTime();
        var time = String(times);
        // var type = typeof(time);
        var phptime = time.slice(0,-3);
        var book = $('td>button');
        // console.log(book);
        for (var i = book.length - 1; i >= 0; i--) {
            // 获取表格中对应的时间戳
            var booktime = $(book[i]).attr('classtime');
            var booktime_arr = booktime.split('|');
            var table_time = Number(booktime_arr[0])+8*60*60+Number(booktime_arr[1]);
            if (table_time-phptime <= 2*3600) {
                $(book[i]).removeClass('opened');
                $(book[i]).removeClass('button-leaf');
                $(book[i]).removeClass('button-red');
                $(book[i]).removeClass('button-green');
                $(book[i]).addClass('button-teal');
                $(book[i]).html('overtime');
            }
            // console.log(booktime);
        }
        //对opened的单元格的单击双击事件
        $(document).on('mouseup','.opened',function() {         
            clickOrDblClick($(this));       
        });         
        

        // var count = 0;       
        // var timer;
        // //判断单击双击事件的函数    
        // function clickOrDblClick(s) {            
        //  count++;            
        //  timer = window.setTimeout(function() {
        //      if (count == 1) {                   
        //          var classtime = s.attr('classtime');
        //          s.addClass('checked');
        //          $.ajax({
        //              type:'POST',
        //              url:'/admin/tea_sclass/'+classtime,
        //              dataType:'json',
                        
        //              headers:{
        //                  'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        //              },
        //              data:{"_method":"delete",'tid':tid[3]},
        //              success:function(data){
        //                  if (data.status == 1) {
        //                      $('.checked').removeClass('am-btn-primary');
        //                      $('.checked').removeClass('opened');
        //                      $('.checked').addClass('am-btn-default');
        //                      $('.checked').addClass('closed');
        //                      $('.checked').html('closed');
        //                      $('.checked').removeClass('checked');
        //                  }else if(data.status == 0){
        //                      location.reload();
        //                  }
        //              },
        //              error:function(data){
        //                  console.log(data.status);
        //                  location.reload();
        //              }
        //          });             
        //      } else {                    
        //          $('.modal').addClass('in');             
        //          $('.modal').attr('style','margin-top:200px;margin-left:300px;display:block;');
        //          var tea = s.attr('tea');
        //          var date_time = s.attr('date_time');
        //          var date_date = s.attr('date_date');
        //          console.log(tea);   
        //          var clicktime = s.attr('classtime');
        //          var clicktime_arr = clicktime.split('|');
        //          var click_classtime = Number(clicktime_arr[0])+8*60*60+Number(clicktime_arr[1]);
        //          $('#classtime').attr('value',click_classtime);
        //          $('#model_title').html('您将预约 <b style="color:red;">'+tea+'</b>老师<b style="color:red;">'+date_date+' '+date_time+'</b>的课程');
        //      }               
        //      window.clearTimeout(timer)              
        //      count = 0           
        //  }, 300)     
        // }
    }); 
</script>