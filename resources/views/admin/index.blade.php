@extends('layouts.admin.admins')
@section('title','吱吱英语后台管理')
@section('content')
@endsection
@section('chart')
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
	<div class="row-content am-cf" style="margin-top: 20px">
        <div class="widget am-cf">
            <div class="widget-head am-cf">
                <div class="widget-title am-fl">近半个月各课程添加情况</div>
                <div class="widget-function am-fr">
                    <!-- <a href="javascript:;" class="am-icon-cog"></a> -->
                </div>
            </div>
            <div class="widget-body am-fr">
                <div style="height: 400px" class="" id="tpl-echarts-A">

                </div>
            </div>
        </div>

<!-- 
        <div class="widget am-cf">
            <div class="widget-head am-cf">
                <div class="widget-title am-fl">雷达</div>
                <div class="widget-function am-fr">
                    <a href="javascript:;" class="am-icon-cog"></a>
                </div>
            </div>
            <div class="widget-body am-fr">
                <div style="height: 400px" id="tpl-echarts-B">

                </div>
            </div>
        </div> -->

<!-- 
        <div class="widget am-cf">
            <div class="widget-head am-cf">
                <div class="widget-title am-fl">折线柱图</div>
                <div class="widget-function am-fr">
                    <a href="javascript:;" class="am-icon-cog"></a>
                </div>
            </div>
            <div class="widget-body am-fr">
                <div style="height: 400px" id="tpl-echarts-C">

                </div>
            </div>
        </div> -->

    </div>
@endsection
@section('js')
<script>

    $('.alert-success').delay(2000).fadeOut(1000);
    $('.alert-warning').delay(2000).fadeOut(1000);
    $(function(){
    	$('body').attr('data-type','chart');
    	$('.container-fluid').attr('style','padding:0');
    	$.ajax({
		    type:'GET',
		    url:'/admin/zhexian',
		    dataType:'json',
		    data:{},
		    success:function(data){
	    		if (data.status == 1) {
	    			Xzhou = data.Xzhou;
	    			kouyu = data.kouyu;
	    			mokao = data.mokao;
	    			task1 = data.task1;
	    			task2 = data.task2;
	    			chartData(Xzhou,kouyu,mokao,task1,task2);
	    		}
		    },
		    error:function(data){
		        
		    }
		});	
    	
    	function chartData(Xzhou,kouyu,mokao,task1,task2) {

	        // var echartsC = echarts.init(document.getElementById('tpl-echarts-C'));
	        // optionC = {
	        //     tooltip: {
	        //         trigger: 'axis'
	        //     },

	        //     legend: {
	        //         data: ['蒸发量', '降水量', '平均温度']
	        //     },
	        //     xAxis: [{
	        //         type: 'category',
	        //         data: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月']
	        //     }],
	        //     yAxis: [{
	        //             type: 'value',
	        //             name: '水量',
	        //             min: 0,
	        //             max: 250,
	        //             interval: 50,
	        //             axisLabel: {
	        //                 formatter: '{value} ml'
	        //             }
	        //         },
	        //         {
	        //             type: 'value',
	        //             name: '温度',
	        //             min: 0,
	        //             max: 25,
	        //             interval: 5,
	        //             axisLabel: {
	        //                 formatter: '{value} °C'
	        //             }
	        //         }
	        //     ],
	        //     series: [{
	        //             name: '蒸发量',
	        //             type: 'bar',
	        //             data: [2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3]
	        //         },
	        //         {
	        //             name: '降水量',
	        //             type: 'bar',
	        //             data: [2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3]
	        //         },
	        //         {
	        //             name: '平均温度',
	        //             type: 'line',
	        //             yAxisIndex: 1,
	        //             data: [2.0, 2.2, 3.3, 4.5, 6.3, 10.2, 20.3, 23.4, 23.0, 16.5, 12.0, 6.2]
	        //         }
	        //     ]
	        // };
	        // echartsC.setOption(optionC);

	        // var echartsB = echarts.init(document.getElementById('tpl-echarts-B'));
	        // optionB = {
	        //     tooltip: {
	        //         trigger: 'axis'
	        //     },
	        //     legend: {
	        //         x: 'center',
	        //         data: ['某软件', '某主食手机', '某水果手机', '降水量', '蒸发量']
	        //     },
	        //     radar: [{
	        //             indicator: [
	        //                 { text: '品牌', max: 100 },
	        //                 { text: '内容', max: 100 },
	        //                 { text: '可用性', max: 100 },
	        //                 { text: '功能', max: 100 }
	        //             ],
	        //             center: ['25%', '40%'],
	        //             radius: 80
	        //         },
	        //         {
	        //             indicator: [
	        //                 { text: '外观', max: 100 },
	        //                 { text: '拍照', max: 100 },
	        //                 { text: '系统', max: 100 },
	        //                 { text: '性能', max: 100 },
	        //                 { text: '屏幕', max: 100 }
	        //             ],
	        //             radius: 80,
	        //             center: ['50%', '60%'],
	        //         },
	        //         {
	        //             indicator: (function() {
	        //                 var res = [];
	        //                 for (var i = 1; i <= 12; i++) {
	        //                     res.push({ text: i + '月', max: 100 });
	        //                 }
	        //                 return res;
	        //             })(),
	        //             center: ['75%', '40%'],
	        //             radius: 80
	        //         }
	        //     ],
	        //     series: [{
	        //             type: 'radar',
	        //             tooltip: {
	        //                 trigger: 'item'
	        //             },
	        //             itemStyle: { normal: { areaStyle: { type: 'default' } } },
	        //             data: [{
	        //                 value: [60, 73, 85, 40],
	        //                 name: '某软件'
	        //             }]
	        //         },
	        //         {
	        //             type: 'radar',
	        //             radarIndex: 1,
	        //             data: [{
	        //                     value: [85, 90, 90, 95, 95],
	        //                     name: '某主食手机'
	        //                 },
	        //                 {
	        //                     value: [95, 80, 95, 90, 93],
	        //                     name: '某水果手机'
	        //                 }
	        //             ]
	        //         },
	        //         {
	        //             type: 'radar',
	        //             radarIndex: 2,
	        //             itemStyle: { normal: { areaStyle: { type: 'default' } } },
	        //             data: [{
	        //                     name: '降水量',
	        //                     value: [2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 75.6, 82.2, 48.7, 18.8, 6.0, 2.3],
	        //                 },
	        //                 {
	        //                     name: '蒸发量',
	        //                     value: [2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 35.6, 62.2, 32.6, 20.0, 6.4, 3.3]
	        //                 }
	        //             ]
	        //         }
	        //     ]
	        // };
	        // echartsB.setOption(optionB);

	        var echartsA = echarts.init(document.getElementById('tpl-echarts-A'));
	        option = {

	            tooltip: {
	                trigger: 'axis',
	            },
	            legend: {
	                data: ['口语课', '口语模考', '大作文批改', '小作文批改']
	            },
	            grid: {
	                left: '3%',
	                right: '4%',
	                bottom: '3%',
	                containLabel: true
	            },
	            xAxis: [{
	                type: 'category',
	                boundaryGap: true,
	                data: Xzhou
	            }],

	            yAxis: [{
	                type: 'value'
	            }],
	            series: [{
	                    name: '口语课',
	                    type: 'line',
	                    stack: '总量',
	                    areaStyle: { normal: {} },
	                    data: kouyu,
	                    itemStyle: {
	                        normal: {
	                            color: '#E0C313'
	                        },
	                        emphasis: {

	                        }
	                    }
	                },
	                {
	                    name: '口语模考',
	                    type: 'line',
	                    stack: '总量',
	                    areaStyle: { normal: {} },
	                    data: mokao,
	                    itemStyle: {
	                        normal: {
	                            color: '#e7505a'
	                        }
	                    }
	                },
	                {
	                    name: '大作文批改',
	                    type: 'line',
	                    stack: '总量',
	                    areaStyle: { normal: {} },
	                    data: task2,
	                    itemStyle: {
	                        normal: {
	                            color: '#32c5d2'
	                        }
	                    }
	                },
	                {
	                    name: '小作文批改',
	                    type: 'line',
	                    stack: '总量',
	                    areaStyle: { normal: {} },
	                    data: task1,
	                    itemStyle: {
	                        normal: {
	                            color: '#32e322'
	                        }
	                    }
	                }
	            ]
	        };
	        echartsA.setOption(option);
	    }
    });

</script>

@stop