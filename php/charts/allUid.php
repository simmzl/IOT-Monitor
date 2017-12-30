<?php

function handleDB($db,$sql){
  $conn=mysql_connect('xx','xx','xx') or die("error connecting") ;
  mysql_query("set names 'utf8'");
  mysql_select_db($db);
  $row = mysql_query($sql,$conn);
  mysql_close($conn);
  return $row;
}

// $username = $_POST['name'];
// $pwd = $_POST['pwd'];
$username = $_COOKIE['username'];
$pwd = $_COOKIE['info'];
$row = handleDB("xx","select * from xx where username = '{$username}'");
$result = mysql_fetch_array($row);
if($result['password'] == $pwd){
  if($result['type'] == 'admin') {
    $sql = "SELECT table_name FROM INFORMATION_SCHEMA.TABLES WHERE table_schema = 'machine_data'";
    if ($row = handleDB('xx',$sql)) {
      $res = array();
      while($tmp = mysql_fetch_array($row)){
        array_push($res,$tmp['table_name']);
      };
      // array_pop($res);
      echo json_encode($res);
    }
  }elseif ($result['type'] == 'member') {
    $sql = "select * from equip_data where owner = '{$username}'";
    if ($row = handleDB('xx',$sql)) {
      $res = array();
      while($tmp = mysql_fetch_array($row)){
        array_push($res,$tmp['id']);
      };
      echo json_encode($res);
    }
  }
}