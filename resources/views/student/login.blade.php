<!DOCTYPE HTML>
<html lang="en">
<head>
<title>慧盈英语教育登录</title>
<!-- Meta tag Keywords -->
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Meta tag Keywords -->
<script src="/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/bootstrap-theme.min.css">
<!-- <script src="/assets/js/jquery.min.js"></script> -->
<!-- <script src="/js/bootstrap.min.js"></script> -->
<!-- <script type="text/javascript" src="/student/function/js/jquery.js"></script> -->
<link rel="stylesheet" href="/student/function/css/bootstrap.css" type="text/css" />
<!-- css files -->
<link rel="stylesheet" href="/student/dong/css/style.css" type="text/css" media="all" /> <!-- Style-CSS --> 
<link rel="stylesheet" href="/student/dong/css/font-awesome.css"> <!-- Font-Awesome-Icons-CSS -->
<!-- //css files -->

<!-- js -->
<script type="text/javascript" src="/student/dong/js/jquery-2.1.4.min.js"></script>
<!-- //js -->

<!-- online-fonts -->
<link href="//fonts.googleapis.com/css?family=Oleo+Script:400,700&amp;subset=latin-ext" rel="stylesheet">
<!-- //online-fonts -->
</head>
<body>
<script src="/student/dong/js/jquery.vide.min.js"></script>
    <!-- main -->
    <div data-vide-bg="/student/dong/video/Ipad">
        <div class="center-container">
            <!--header-->
            <div class="header-w3l">
                <h1>课程从这里开始</h1>
            </div>
            <!--//header-->
            <div class="main-content-agile">
                <div class="sub-main-w3">   
                    <div class="wthree-pro">
                        <h2>欢迎登录</h2>
                    </div>
                    <div id="xinxi">
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
                    </div>
                    <form action="/do_login" method="post">
                        {{csrf_field()}}
                        <input placeholder="请输入注册手机号" name="phone" type="text" required=""><br><br>

                        <input  placeholder="请输入密码" name="password" type="password"><br>
                        <div class="sub-w3l">
                            <h6><a href="/signup" style="color: red;">立即注册</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" style="color: red;" id="model">忘记密码</a></h6>
                            <div class="right-w3l">
                                <input type="submit" value="登录">
                                <a href="/youke"><button type="button" style="background-color: #e7e7e7; color: black;height: 41px">游客模式登录</button></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--//main-->

            <!--footer-->
            <div class="footer">
                <!-- <p>&copy; 2017 Classic Login Form. All rights reserved | Design by</p> -->
            </div>
            <!--//footer-->
        </div>
    </div>
    <!-- <div class="modal fade notice" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none; padding-right: 17px;">
        <div class="modal-dialog modal-ml">
            <div class="modal-body">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">申请重置密码</h4>
                    </div>
                    <div class="modal-body">
                        <div id="notice_con" class="modal-body"></div>
                        <input placeholder="请输入注册手机号" name="phone_forget" type="text" required=""><br>
                        <button type="button" class="button button-3d button-small button-rounded button-blue" data-dismiss="modal" aria-hidden="true" id="notice_close">确定</button>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <script>

        $('.alert-success').delay(2000).fadeOut(1000);
        $('.alert-warning').delay(2000).fadeOut(1000);
        $(function(){
            $('#model').click(function(){
                if ($('input[name=phone]').val()) {
                    $.ajax({//参数形式见https://blog.csdn.net/qq_29569183/article/details/79194292
                        type:'GET',
                        url:'/forget',
                        dataType:'json',
                        data:{"phone":$('input[name=phone]').val()},//layui的表单submit监听
                        success:function(data){
                            if(data.status == 1){
                                $('#xinxi div').remove();
                                var div = '<div class="alert alert-success" role="alert">您的重置密码的申请已经提交，请等待助教联系您哦~</div>';
                                $('#xinxi').append(div);
                                $('.alert-success').delay(2000).fadeOut(1000);
                            }else{
                                $('#xinxi div').remove();
                                var div = '<div class="alert alert-warning" role="alert">您填写的手机号有误，无此用户</div>';
                                $('#xinxi').append(div);
                                $('.alert-warning').delay(2000).fadeOut(1000);
                            }
                        },
                        error:function(data){
                            //错误信息
                        }
                    });
                }else{
                    $('#xinxi div').remove();
                    var div = '<div class="alert alert-warning" role="alert">忘记密码不要紧，请您填写上注册手机号之后再点击“忘记密码”</div>';
                    $('#xinxi').append(div);
                    $('.alert-warning').delay(2000).fadeOut(1000);
                }
            });
        });
    </script>
</body>
</html>




