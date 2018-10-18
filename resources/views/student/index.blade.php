@extends('layouts.student.students')
@foreach($head as $k=>$v)
    @section($k,$v)
@endforeach
@section('content')
<link rel="stylesheet" href="https://img.acadsoc.com.cn/web/lps/om-tg/css/style.css"/>
<!--baner-info start here-->
<div class="banner-info">
	<div class="container">
		<div class="banner-info-main">
			<div class="col-md-6 bann-info-left">
				<img src="/student/images/2.jpg" alt="" class="img-responsive">

				<p>工作繁忙,没时间?</p>
				<h4>每天25min,随时随地利用碎片时间学习</h4>
				<p>读写强,听说弱,无法用英语商务交流?</p>
				<h4>专属私人外教1对1实战教学</h4>
			</div>
			<div class="col-md-6 bann-info-left">
				<img src="/student/images/balance.jpg" alt="" class="img-responsive">
				<p>听不懂,没信心?</p>
				<h4>课后效果全程跟踪,效果看得见</h4>
				<p>无演练环境,口语提升困难?</p>
				<h4>外教一对一,口语模考</h4>
			</div>
		  <div class="clearfix"> </div>
		</div>
	</div>
</div>
<!--banner-info end here-->
<!--we work strat her-->
	<div class="shizi">
        <div class="container">
            <div class="title">
                <h3>在这里遇见更好的外教</h3>
                <h4>汇集多位优质外教</h4>
            </div>
            <div class="main-con">
                <ul>
                    <li>
                        <div class="img-wrap">
                            <img alt="" src="https://img.acadsoc.com.cn/web/lps/om-tg/img/shizi-ico1.png"></div>
                        <div class="txt-wrap">
                            <strong>纯正地道口语</strong>
                            <p>
                                多位全球外籍教师团队，来自美国、英国、菲律宾等国家。</p>
                        </div>
                    </li>
                    <li>
                        <div class="img-wrap">
                            <img alt="" src="https://img.acadsoc.com.cn/web/lps/om-tg/img/shizi-ico2.png"></div>
                        <div class="txt-wrap">
                            <strong>执教经验丰富</strong>
                            <p>
                                根据中国学生的特点，甄选多年执教经验的优秀外教给每一位学习者带来互动式学习体验，能够采取各类有针对性的教学方式。</p>
                        </div>
                    </li>
                    <li>
                        <div class="img-wrap">
                            <img alt="" src="https://img.acadsoc.com.cn/web/lps/om-tg/img/shizi-ico3.png"></div>
                        <div class="txt-wrap">
                            <strong>层层严格筛选</strong>
                            <p>
                                所有外教都要经历至少5轮以上资格审查才能进入到慧盈英语教育进行试讲课阶段，严格的外教管理制度，外教录取率仅3%。</p>
                        </div>
                    </li>
                    <li>
                        <div class="img-wrap">
                            <img alt="" src="https://img.acadsoc.com.cn/web/lps/om-tg/img/shizi-ico4.png"></div>
                        <div class="txt-wrap">
                            <strong>教师终身培训计划</strong>
                            <p>
                                参考CEFR(欧洲语言共同框架)及TESOL(国际对外英语教学专业)标准，全新研发了适合线上用户的教学模式，对所有外教实施全日制的岗前培训、课中指引以及课后培养。利用先进的AI技术和海量教学数据，不断提升外教的授课表现。</p>
                        </div>
                    </li>
                </ul>
                <div class="shizi-img">
                    <img alt="" src="https://img.acadsoc.com.cn/web/lps/om-tg/img/girl.png">
                </div>
            </div>
        </div>
    </div>
    <div class="bg2">
        <div class="container">
            <div class="title">
                <h3>让每个人都能享受到高品质在线英语教育</h3>
                <h4> 慧盈英语教育 8 大优势</h4>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="ys">
                        <img src="https://img.acadsoc.com.cn/web/lps/om-tg/img/ys1.png">
                        <p>全球外教一对一</p>
                        <div class="ys-text">
                            甄选全球3000+专业外教在线一对一授课，您可以根据需求挑选合适的外教，同时，采取非常严苛的内部考核机制，不定期淘汰不合适的外教
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="ys">
                        <img src="https://img.acadsoc.com.cn/web/lps/om-tg/img/ys2.png">
                        <p>随时随地在线学</p>
                        <div class="ys-text">
                            打破时间与空间的限制，利用喝咖啡、散步、刷微信的碎片化时间，随时随地用平板电脑、手机、电脑在线自主约课上课，每天25分钟，高效利用碎片化学习时间
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="ys">
                        <img src="https://img.acadsoc.com.cn/web/lps/om-tg/img/ys3.png">
                        <p>纯英文语言环境</p>
                        <div class="ys-text">
                            所有的外教均来自全球官方语言或母语为英语的国家，保证外教的口音地道且原汁原味，并且致力为每一位想要练习口语的学习者提供本土化的语言环境
                        </div>
                    </div>
                </div>
                 <div class="col-md-3">
                    <div class="ys">
                        <img src="https://img.acadsoc.com.cn/web/lps/om-tg/img/ys4.png">
                        <p>外教持证上岗</p>
                        <div class="ys-text">
                            外教来自世界各国，他们拥有良好的教育背景、丰富的教学经验以及独到的教学方法
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="ys">
                        <img src="https://img.acadsoc.com.cn/web/lps/om-tg/img/ys5.png">
                        <p>2对1贴心服务</p>
                        <div class="ys-text">
                           学习顾问会为您高效定制专属的学习计划、贴心客服全程跟进学习效果以及专业外教在线一对一教学，全方位个性化服务为您学习口语保驾护航
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="ys">
                        <img src="https://img.acadsoc.com.cn/web/lps/om-tg/img/ys6.png">
                        <p>国际原版教材</p>
                        <div class="ys-text">
                            我们拥有专业的教研团队，教学所用教材均来自教研团队引进或改编国际原版教材，更有特色原创教材，让您在家就能体验名校教学内容
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="ys">
                        <img src="https://img.acadsoc.com.cn/web/lps/om-tg/img/ys7.png">
                        <p>超高的性价比</p>
                        <div class="ys-text">
                            精选英语课程类别，包含近百门主推精品课程，可以满足各个年龄群学习的需求，且课程性价比超高，质优价廉保证每一个家庭都能负担得起
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="ys">
                        <img src="https://img.acadsoc.com.cn/web/lps/om-tg/img/ys8.png">
                        <p>量需个性化定制</p>
                        <div class="ys-text">
                            为了满足学习者的各种不同需求，无论您是都市白领、家庭主妇或者是在校学生，只要您需要提升英语口语水平，我们会为您量身定制专属的个性化课程
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a id="about"></a>
    <!-- <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <a href="#zc" data-toggle="modal" class="to-reg">免费申请试听课</a>
        </div>
   </div> -->

<!--we work end here-->
<!--feature start here-->

@endsection