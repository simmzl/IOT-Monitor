<?php

function handleDB($db,$sql){
  $conn=mysql_connect('xx','xx','xx') or die("error connecting");
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

// $username = $_POST['name'];
// $pwd = $_POST['pwd'];
$username = $_COOKIE['username'];
$pwd = $_COOKIE['info'];

$row = handleDB("fume-hood-monitor","select * from admin where username = '{$username}'");
$result = mysql_fetch_array($row);
if($result['password'] == $pwd){
  if($result['type'] == 'member') {
    $sql = "select id,rtmp from equip_data where owner = '{$username}'";
    if ($row = handleDB('fume-hood-monitor',$sql)) {
      while($tmp[] = mysql_fetch_assoc($row)){};
      array_pop($tmp);
      $response =  decodeUnicode(json_encode($tmp));
      echo $response;
    }
  }elseif ($result['type'] == 'admin') {
    $sql = "select id,rtmp from equip_data";
    if ($row = handleDB('fume-hood-monitor',$sql)) {
      while($tmp[] = mysql_fetch_assoc($row)){};
      array_pop($tmp);
      $response =  decodeUnicode(json_encode($tmp));
      echo $response;
    }
  }
}
