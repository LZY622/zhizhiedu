@include('public.teacher.head')
<body data-type="widgets">
	<script src="/assets/js/theme.js"></script>
    <div class="am-g tpl-g">
    	@include('public.teacher.header')
    	@include('public.teacher.stylechange')
    	@include('public.teacher.sidebar')
        <div class="tpl-content-wrapper">
            <div class="container-fluid am-cf">
                <div class="row">
    	@section('content')
    	@show
                </div>
            </div>
        </div>
   </div>
    </div>
    @section('js')
    @show
    @include('public.teacher.jss')
</body>
</html>