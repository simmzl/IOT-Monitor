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
$operation = $_POST['operation'];
$now_username = $_COOKIE['username'];
$now_pwd = $_COOKIE['info'];
$mes = '';

$row = handleDB("fume-hood-monitor","select * from admin where username = '{$now_username}'");
$result = mysql_fetch_array($row);


if($result['password'] == $now_pwd){
  // 改变维修人员信息
  if($operation == 'changeInfo') {

    $username = $_POST['username'];
    $password = $_POST['pwd'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    $sql = "update admin set username = '{$username}', email = '{$email}', name = '{$name}', password = '{$password}' where username = '{$username}'";
    if (handleDB('fume-hood-monitor',$sql)) {
      $mes = 'success';
    }else{
      $mes = 'fail';
    }  
  }elseif ($operation == 'addServiceman') {

    $username = $_POST['username'];
    $password = $_POST['pwd'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $type = 'serviceman';

    $sql = "insert into admin (username,password,email,name,type) values ('{$username}','{$password}','{$email}','{$name}','{$type}')";
    if (handleDB('fume-hood-monitor',$sql)) {
      $mes = 'success';
    }else{
      $mes = 'fail';
    }  
  }elseif ($operation == 'deleteServiceman') {

    $username = $_POST["username"];

    $sql = "delete from admin where username='{$username}'";
    if (handleDB('fume-hood-monitor',$sql)) {
      $mes = '删除成功';
    }else{
      $mes = '删除失败';
    }  
  }elseif ($operation == 'addEquipForUser') {
    $owner = $_POST["owner"];
    $equipID = $_POST["equipID"];

    $select_sql = "select * from equip_data where id='{$equipID}'";
    $select_row = handleDB('fume-hood-monitor',$select_sql);
    $select_result = mysql_fetch_array($select_row);
    if(!$select_result){
      $mes = '没有该设备';
      echo $mes;
      return;
    }

    $sql = "update equip_data set owner='{$owner}' where id='{$equipID}'";
    if (handleDB('fume-hood-monitor',$sql)) {
      $mes = '添加设备成功';
    }else{
      $mes = '添加设备失败';
    }  
  }elseif ($operation == 'deleteEquipForUser') {
    // $owner = $_POST["owner"];
    $equipID = $_POST["equipID"];

    $sql = "update equip_data set owner='' where id='{$equipID}'";
    if (handleDB('fume-hood-monitor',$sql)) {
      $mes = '删除设备成功';
    }else{
      $mes = '删除设备失败';
    }  
  }
}
echo $mes;