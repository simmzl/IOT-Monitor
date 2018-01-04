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

// $username = $_POST['name'];
// $pwd = $_POST['pwd'];
$operation = $_POST['operation'];
$username = $_COOKIE['username'];
$pwd = $_COOKIE['info'];

$row = handleDB("xx","select * from admin where username = '{$username}'");
$result = mysql_fetch_array($row);
if($result['password'] == $pwd){
  if($operation == 'getServiceman') {
    $sql = "select * from admin where type='serviceman' order by date asc";
    if ($row = handleDB('xx',$sql)) {
      while($tmp[] = mysql_fetch_assoc($row)){};
      array_pop($tmp);
      $arrlength=count($tmp);
      for($x=0;$x<$arrlength;$x++) {
        unset($tmp[$x]['password']);
      }
      $response =  decodeUnicode(json_encode($tmp));
      echo $response;
    }
  }elseif ($operation == 'getUsers') {
    $sql = "select * from xx where type='member' order by date asc";
    if ($row = handleDB('xx',$sql)) {
      while($tmp[] = mysql_fetch_assoc($row)){};
      array_pop($tmp);
      $arrlength=count($tmp);
      for($x=0;$x<$arrlength;$x++) {
        unset($tmp[$x]['password']);
      }
      $response =  decodeUnicode(json_encode($tmp));
      echo $response;
    }
  }elseif ($operation == 'getEquipList') {
    $name = $_POST['username'];
    $sql = "select * from xx where owner = '{$name}'";
    if ($row = handleDB('xx',$sql)) {
      $res = array();
      while($tmp = mysql_fetch_array($row)){
        array_push($res,$tmp['id']);
      };
      echo json_encode($res);
    }
  }
}

