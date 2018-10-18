@include('public.student.yuyue.head')
<body class="stretched">
    <!-- Document Wrapper
    ============================================= -->
    <div id="wrapper" class="clearfix">
        <!-- Header
        ============================================= -->
        @include('public.student.yuyue.header')
        <!-- #header end -->
        <section id="slider" class="slider-parallax full-screen dark error404-wrap">
            <div class="container vertical-middle center clearfix">
                <div class="error404">@yield('con')</div>
                <div class="heading-block nobottomborder">
                    <h4>@yield('notice')</h4>
                    <span><b style="color: red;" id="miao"></b>秒后跳转到<a href="" id="zhuye">官网主页</a></span>
                </div>
            </div>
            <div class="video-wrap">
                <video poster="/student/function/images/videos/explore-poster.jpg" preload="auto" loop autoplay muted>
                    <source src='/student/function/images/videos/explore.mp4' type='video/mp4' />
                    <source src='/student/function/images/videos/explore.webm' type='video/webm' />
                </video>
                <div class="video-overlay" style="background-color: rgba(0,0,0,0.3);"></div>
            </div>
        </section>
        <!-- Footer
        ============================================= -->
        @include('public.student.yuyue.footer')
        <!-- #footer end -->
    </div><!-- #wrapper end -->
    <!-- Go To Top
    ============================================= -->
    <div id="gotoTop" class="icon-angle-up"></div>
    <!-- Footer Scripts
    ============================================= -->
    @include('public.student.yuyue.js_end')
    <script>
        $(function(){
            var t = 10;
            var daojishi = null;
            $('#zhuye').attr('href','/');
            daojishi = window.setInterval(function(){
                t--;
                $('#miao').html(t);
            },1000);
            window.setTimeout(function(){
                clearInterval(daojishi);
                window.location.href = '/';
            },10000);
        })
    </script>
</body>

</html>