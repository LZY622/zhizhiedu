<!DOCTYPE html>
<html class="standard">
<head>
    <meta charset="utf-8">
    <title>慧盈英语教育</title>
    <link href="https://static.zhipin.com/zhipin/v92/web/geek/css/main.css" type="text/css" rel="stylesheet">
    <link href="/student/css/student.css" rel="stylesheet" type="text/css"/>
    <script>
        var positionList = [];
    </script>
    <link rel="canonical" href="https://www.zhipin.com/">
    <meta name="applicable-device" content="pc">
    <meta name="mobile-agent" content="format=html5;url=https://m.zhipin.com/">
    <style type="text/css">
        .navmenu li:hover .menuul{
            display:block;
        }

        .menuul{
            display:none;
        }

        .menuul li{
            float:none;
            width:100%;
            margin:0;
        }

        .menuul li a:hover{
            background:#ffffff;
        }
    </style>
</head>

<!--头部header-->
<body class="home-body">
<div id="header">
    <div class="inner home-inner">
        <div class="nav">
            <ul class="navmenu">
                <li class="cur"><a ka="header-home"  href="/" >首页</a></li>

                <li>
                    <a href="javascript:check()">口语预约</a>
                    <ul class="menuul">
                        <li><a href="">口语课预约</a></li><br>
                        <li><a href="">口语模考预约</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:check()" >作文批改预约</a>
                    <ul class="menuul">
                        <li><a href="">大作文批改预约</a></li><br>
                        <li><a href="">小作文批改预约</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        
        <div class="user-nav">
	        <div class="btns" style="margin-top: 5px">
                <a href="/setuser" class="btn btn-outline">欢迎你, <span>{{$rs->phone}}</span> </a>
	            <a href="/loginout" class="btn btn-outline">退出</a>
	        </div>
        </div>
    </div>
</div>
<div class="bd1">
    <ul>
        <li><img src="/student/images/banner.jpg" /></li>
    </ul>
</div>