<!DOCTYPE HTML>
<html lang="en">
<head>
<title>慧盈英语教育登录</title>
<!-- Meta tag Keywords -->
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Meta tag Keywords -->

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
                    <form action="/do_login" method="post">
                        {{csrf_field()}}
                        <input placeholder="请输入手机号" name="phone" type="text" required=""><br><br>

                        <input  placeholder="请输入密码" name="password" type="password"><br>
                        <div class="sub-w3l">
                            <h6><a href="/signup" style="color: red;">立即注册</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="">忘记密码?</a></h6>
                            <div class="right-w3l">
                                <input type="submit" value="登录">
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
    <script>

        $('.alert-success').delay(2000).fadeOut(1000);
        $('.alert-warning').delay(2000).fadeOut(1000);
        
    </script>
</body>
</html>




