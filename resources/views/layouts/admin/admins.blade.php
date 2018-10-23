@include('public.admin.head')
<body data-type="widgets">
	<script src="/assets/js/theme.js"></script>
    <div class="am-g tpl-g">
    	@include('public.admin.header')
    	@include('public.admin.stylechange')
    	@include('public.admin.sidebar')
        <div class="tpl-content-wrapper">
            <div class="container-fluid am-cf">
                <div class="row">
            	@section('content')
            	@show
                </div>
            </div>
            @section('chart')
            @show
        </div>
   </div>
    </div>
    @section('js')
    @show
    @include('public.admin.jss')
</body>
</html>