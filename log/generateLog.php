<?php
 /********************************
  * File to log the API for debugging the response.
  **********************************/
global $log_path;
$log_path = 'C:\xampp\tmp\apiLogs.txt';



function outputLog($str){
  global $log_path;
  $now = date('Y-m-d H:i:s');
  error_log("\r\n ".$now . "" . $str."\n","3",$log_path);
}
?>