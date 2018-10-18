@extends('layouts.student.studentzhu')
@section('title','慧盈英语教育')
@section('banner')
    @include('public.student.yuyue.banner')
@stop
@section('content')
<section id="content">
    <style type="text/css">
        li,span{
            font-family: "黑体";
        }
    </style>

    <div class="content-wrap">
        <div class="row clearfix bottommargin-lg common-height">

            <div class="col-md-3 col-sm-6 dark center col-padding" style="background-color: #515875;">
                <div>
                    <i class="i-plain i-xlarge divcenter icon-line2-directions"></i>
                    <div class="counter counter-lined"><span data-from="100" data-to="{{$num->s_num}}" data-refresh-interval="50" data-speed="2000"></span>节</div>
                    <h5>剩余口语课课时</h5>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 dark center col-padding" style="background-color: #576F9E;">
                <div>
                    <i class="i-plain i-xlarge divcenter icon-line2-graph"></i>
                    <div class="counter counter-lined"><span data-from="100" data-to="{{$num->m_num}}" data-refresh-interval="100" data-speed="2500"></span>节</div>
                    <h5>剩余口语模考课时</h5>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 dark center col-padding" style="background-color: #6697B9;">
                <div>
                    <i class="i-plain i-xlarge divcenter icon-line2-layers"></i>
                    <div class="counter counter-lined"><span data-from="100" data-to="{{$num->bw_num}}" data-refresh-interval="25" data-speed="3500"></span>篇</div>
                    <h5>剩余大作文批改篇数</h5>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 dark center col-padding" style="background-color: #88C3D8;">
                <div>
                    <i class="i-plain i-xlarge divcenter icon-line2-clock"></i>
                    <div class="counter counter-lined"><span data-from="100" data-to="{{$num->sw_num}}" data-refresh-interval="30" data-speed="2700"></span>篇</div>
                    <h5>剩余小作文批改篇数</h5>
                </div>
            </div>
        </div>
        <div class="container clearfix">
            <div class="row clearfix">

                <div class="" style="width: 100%;background-color: #6dc2e7;">

                    <div style="height: 400px;width: 18%;" class="ohidden">
                        <img src="{{$rs->img}}" style="position: absolute; top: 0; left: 0;margin-top: 40%;border-radius: 50%" data-animate="fadeInUp" data-delay="100" alt="Chrome">
                    </div>

                    <div class="heading-block topmargin" style="position: absolute; top: 0; left: 20%;">
                        <h1>Hi, <span>{{$res->mname}}</span>
                            <a href="/students/setuser">
                                <button style="width: 130px" class="button button-3d button-rounded button-aqua">修改个人资料</button>
                            </a>
                        </h1>
                        <h1>电话号：<span>{{$rs->phone}}</span></h1>
                    </div>
                    <ul>
                        <li style="position: absolute; top: 55%; left: 25%;list-style: none; width: 35%;font-size: 20px;"><p>考试日期</p><span>{{$res->exam_date}}</span></li>
                        <li style="position: absolute; top: 55%; left: 60%;list-style: none; width: 35%;font-size: 20px"><p class="icol32-flag-finish">目标分数</p><span>S={{$res->sgoal}}分 <br /> W={{$res->wgoal}}分</span></li>
                    </ul>

                </div>
            </div>
        </div>
    </div>


</section>
@stop
@section('js')
<script>

</script>
@stop