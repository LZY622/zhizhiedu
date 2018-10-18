@include('public.student.yuyue.head')

<body class="stretched">
    <!-- Document Wrapper
    ============================================= -->
    <div id="wrapper" class="clearfix">
        <!-- Header
        ============================================= -->
        @include('public.student.yuyue.header')<!-- #header end -->
        <!-- Page Title
        ============================================= -->
        @include('public.student.yuyue.page_title')
        <!-- #page-title end -->
        <!-- Content
        ============================================= -->
        <section id="content">
            <div class="content-wrap">
                <div class="container clearfix">
                    <div id="side-navigation">
                        <div class="col_one_third nobottommargin">
                            @section('sidenav')
                            @show
                        </div>
                        <div class="col_two_third col_last nobottommargin">
                            <div id="snav-content1">
                                @section('content1')
                                @show
                            </div>
                            <div id="snav-content2">
                                @section('content2')
                                @show
                            </div>
                            <div id="snav-content3">
                                @section('content3')
                                @show
                            </div>
                        </div>
                    </div>
                    <script>
                        $(function() {
                            $( "#side-navigation" ).tabs({ show: { effect: "fade", duration: 400 } });
                        });
                    </script>
                </div>
            </div>
        </section><!-- #content end -->
        <!-- Footer
        ============================================= -->
        @include('public.student.yuyue.footer')<!-- #footer end -->
    </div><!-- #wrapper end -->
    <!-- Go To Top
    ============================================= -->
    <div id="gotoTop" class="icon-angle-up"></div>
    <!-- Footer Scripts
    ============================================= -->
    @include('public.student.yuyue.js_end')
    @section('js')
    @show
</body>

</html>