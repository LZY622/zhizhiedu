@include('public.student.zhu.header')
    <div class="rg2">
        <div class="rg2-img">
            <img src="/student/images/img1.png" alt="">
        </div>

        <div class="rg2-text">
            <h1>Hi, <span>{{$rs[0]->phone}}</span></h1>
            <h1>QQ号：<span>U26123698135</span></h1>
            <ul>
                <li class="rg2-li1" data-date1="2017-12-15" data-date2="2017-12-09"><p>考试日期</p><span>S=2017-12-15<br /> W=2017-12-09</span></li>
                <li class="rg2-li2" data-score="0" data-score2="0"><p>目标分数</p><span>S=0分 <br /> W=0分</span></li>
            </ul>
        </div>
    </div>
@include('public.student.zhu.footer')