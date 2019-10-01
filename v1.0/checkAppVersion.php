<?php
/*********
 * |To check the verion of the app.
 *********/
function is_old_android($version = '5.12.300'){
  
  if(strstr($_SERVER['HTTP_USER_AGENT'], 'Android')){
    
    preg_match('/Android (\d+(?:\.\d+)+)[;)]/', $_SERVER['HTTP_USER_AGENT'], $matches);
    
    return version_compare($matches[1], $version, '<=');

  }

}
?>