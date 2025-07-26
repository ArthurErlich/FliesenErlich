<?php
//  NOTE! It is better to do it in Node.js, but this is not usable in the webscpace right now
// check if its a get method $_REQUEST -> eg $_GET or $_POSTT
// check if request comes from correct ip e.g. server ip

function getUserIpAddr()
{
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    //ip from share internet
    $ip = $_SERVER['HTTP_CLIENT_IP'];
  } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    //ip pass from proxy
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  } else {
    $ip = $_SERVER['REMOTE_ADDR'];
  }
  return $ip;
}

echo getUserIpAddr();

?>
