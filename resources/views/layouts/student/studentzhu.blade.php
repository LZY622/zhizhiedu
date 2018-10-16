@include('public.student.yuyue.head')

<body class="stretched">

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">

		<!-- Header
		============================================= -->
		@include('public.student.yuyue.header')<!-- #header end -->

		@include('public.student.yuyue.banner')

		<!-- Content
		============================================= -->
		@section('content')
		@show
		<!-- #content end -->

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
	@section('js')
	@show
</body>
</html>