<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="icon" type="image/png" href="/assets/i/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="/assets/i/app-icon72x72@2x.png">
    <meta name="apple-mobile-web-app-title" content="Amaze UI" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    @include('public.admin.css')
    @include('public.admin.js')
</head>
<script language="JavaScript">
 step=0
 function flash_title(n)
 {
    step++;
    m = $('#changenum').html();
    if (n != m) {
        step = 4;
    }
    if (step==3) {step=1}        
    if (step==1) {document.title='【你有'+n+'条未处理消息】'}
    if (step==2) {document.title='【　　　　　　】'}
    if (step != 4) {setTimeout("flash_title("+n+")",380);}
    if (step == 4) {
        setTimeout("flash_title("+m+")",380);
        step = 1;
    }
 }
 $(function(){
    var init = setInterval(function(){
        n = $('#changenum').html();
        // console.log(n);
        if (n > 0) {
            clearInterval(init);
            init = flash_title(n);
        }
    },5000);
    
 })
 // 
</script>