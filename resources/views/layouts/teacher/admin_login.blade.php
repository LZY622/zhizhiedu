@include('public.teacher.head')

<body data-type="login">
    <script src="/assets/js/theme.js"></script>
    <div class="am-g tpl-g">
        <!-- 风格切换 -->
        @include('public.teacher.stylechange')
        @section('content')
        
        @show
    </div>
@include('public.teacher.jss')
@section('js')
        
@show
</body>

</html>