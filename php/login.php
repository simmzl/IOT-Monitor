<?php

function checkuser($username, $password){

  $mysql_server_name='localhost'; 
   
  $mysql_username='保密'; 
   
  $mysql_password='保密'; 
   
  $mysql_database='保密'; 

  $conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password) or die("error connecting") ; //连接数据库
   
  mysql_query("set names 'utf8'"); //数据库输出编码 
   
  mysql_select_db($mysql_database); //打开数据库

  $sql ="select * from admin where username = {$username}"; 
   
  $row = mysql_query($sql,$conn); //查询

  $result = mysql_fetch_array($row);

  if((!empty($result))&&$result['password']==$password){
    return $result;
  }else{
    return false;
  }
}

$auth = '';//存储当前登录账号信息
$response = 0;

if(empty($_POST['username']) || empty($_POST['password'])){
  $response = 0;
}
// 处理字符，防止注入
$username = addslashes($_POST['username']);
$password = addslashes($_POST['password']);

// echo $response;
if($auth = checkuser($username,$password)){
  $_SESSION['auth'] = $auth;
  if($auth['type'] == 'admin'){
    $response = 1;
  }else{
    $response = 2;
  }
}else{
  $response = 0;
}

echo $response;
?>