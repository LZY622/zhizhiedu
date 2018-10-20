<?php

$ip = getenv("REMOTE_ADDR");

$file = fopen("visit.txt","a");

fwrite($file,$ip." || ".gmdate ("Y-n-d")." ----> ".gmdate ("H:i:s")."\n");

header("Location: index/index.php");

?>