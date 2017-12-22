<?php
function handleDB($sql){
  $conn=mysql_connect('xx','xx','xx') or die("error connecting") ; //连接数据库
  mysql_query("set names 'utf8'"); //数据库输出编码
  mysql_select_db('xx'); //打开数据库
  $result = mysql_query($sql,$conn); //执行
  return $result;
}
$xx = $_POST['xx'];
$username = $_COOKIE['username'];
$pwd = $_COOKIE['info'];
$row = handleDB("select * from xx where username = '{$username}'");
$result = mysql_fetch_array($row);
if((empty($result)) && $result['password'] != $pwd) {
  $mes = 0;
  echo $mes;
  return;
}
if ($operation == 'echo') {

  $mes=array("date"=> $result['date'] ,"username"=> $result['username'] ,"email"=> $result['email'] ,"type"=> $result['type'] );
  $mes = json_encode($mes);
  echo $mes;
}elseif ($operation == 'editinfo') {
  $new_username = $_POST['new_username'];
  $new_email = $_POST['new_email'];

  $sql = "update xx set username = '{$new_username}', email = '{$new_email}' where username = '{$username}'";
  if (handleDB($sql)) {
    $mes = '修改成功';
  }else{
    $mes = '修改失败';
  }
  echo $mes;
}elseif ($operation == 'editpwd') {
  $new_pwd = $_POST['new_pwd'];

  $sql = "update xx set password = '{$new_pwd}' where username = '{$username}'";
  if (handleDB($sql)) {
    $mes = '修改成功';
  }else{
    $mes = '修改失败';
  }
  echo $mes;
}
?>