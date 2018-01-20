<?php

function handleDB($db,$sql){
  $conn=mysql_connect('xx','xx','xx') or die("error connecting") ;
  mysql_query("set names 'utf8'");
  mysql_select_db($db);
  $row = mysql_query($sql,$conn);
  mysql_close($conn);
  return $row;
}

function decodeUnicode($str){
  return preg_replace_callback('/\\\\u([0-9a-f]{4})/i',
  create_function('$matches','return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'),$str);
}

// $sql = "select co_addr from equip_data where id=00000005";
$sql = "select id,co_addr,co_lng,co_lat from equip_data";
if ($row = handleDB('fume-hood-monitor',$sql)) {
  while($tmp[] = mysql_fetch_assoc($row)){};
  array_pop($tmp);
  $response = json_encode($tmp);
  echo $response;
}