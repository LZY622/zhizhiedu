<!DOCTYPE HTML>
<html lang="en">
<head>
<title>慧盈英语教育注册</title>
<!-- Meta tag Keywords -->
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
function hideURLbar(){ window.scrollTo(0,1); } </script>
<script src="/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/bootstrap-theme.min.css">
<script src="/assets/js/jquery.min.js"></script>
<!-- Meta tag Keywords -->

<!-- css files -->
<link rel="stylesheet" href="/student/dong/css/style.css" type="text/css" media="all" /> <!-- Style-CSS --> 
<link rel="stylesheet" href="/student/dong/css/font-awesome.css"> <!-- Font-Awesome-Icons-CSS -->
<!-- //css files -->

<!-- js -->
<!-- <script type="text/javascript" src="/student/dong/js/jquery-2.1.4.min.js"></script> -->
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
                <h1></h1>
            </div>
            <!--//header-->
            <div class="main-content-agile">
                <div class="sub-main-w3">   
                    <div class="wthree-pro">
                        <h2>注册用户</h2>
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
                    <form action="/zhuce" method="post">
                        {{csrf_field()}}
                        <input placeholder="请输入手机号" name="phone" type="text" required=""><br><br>
                        <input  placeholder="请输入密码" name="password" type="password" required=""><br><br>
                        <input  placeholder="请再次输入密码" name="repass" type="password" required=""><br><br>
                        <input  placeholder="请输入qq号" name="qq" type="text" required=""><br><br>
                        <input  placeholder="请输入手机验证码" name="code" type="text"  style="width: 50%;padding-right: 0px;" required="">
                        <button type="button" class="btn btn-info" style="width: 30%;display: inline;height: 50px;padding-left:2px" onclick="sendCode();" id="yzm">获取手机验证码</button>
                        <label style="color:red;">* 如您不在国内请联系助教领取验证码</label>
                        <br><br>
                        <div class="sub-w3l">
                            <div class="right-w3l">
                                <input type="submit" value="提交">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--//main-->

            <!--footer-->
            <div class="footer">
                <p></p>
            </div>
            <!--//footer-->
        </div>
    </div>

</body>
</html>

<script>

    $('.alert-success').delay(2000).fadeOut(1000);
    $('.alert-warning').delay(2000).fadeOut(1000);
    // 倒计时60s
    var countdown = 60;
    function settime(){
        if(countdown == 0){
            $('#yzm').attr('onclick','sendCode();');
            $('#yzm').text('发送验证码');
            countdown = 60;
        }else{
            $('#yzm').removeAttr('onclick','sendCode');
            $('#yzm').text('重新发送（'+countdown+'s)');
            countdown--;
            setTimeout(function () {
                settime();
            },1000);
        }
    }
    function sendCode(){
        //获取手机号
        var phone = $('input[name=phone]').val();
        //判断手机号是否为空
        if(!phone){
            var div = '<div class="alert alert-warning" role="alert">手机号不能为空</div>';
            $('.sub-main-w3').prepend(div);
            $('.alert-warning').delay(2000).fadeOut(1000);
            return;
        }
        settime();
        //触发ajax，请求验证码，根据是否成功给出提示信息
        $.ajax({
            type:'GET',
            url:'/sendcode',
            dataType:'json',
            data:{'phone':phone},
            success:function(data){
                if(data.status == 0){
                    $('.sub-main-w3 div[role="alert"]').remove();
                    var div = '<div class="alert alert-success" role="alert">'+data.message+'</div>';
                    $('.sub-main-w3').prepend(div);
                    $('.alert-success').delay(2000).fadeOut(1000);
                }else{
                    $('.sub-main-w3 div[role="alert"]').remove();
                    var div = '<div class="alert alert-warning" role="alert">'+data.message+'</div>';
                    $('.sub-main-w3').prepend(div);
                    $('.alert-warning').delay(2000).fadeOut(1000);
                }
            },
            error:function(data){
                //错误信息
            }
        });
    }
</script>
