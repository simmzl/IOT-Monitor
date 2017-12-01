<?php

function add_user($username, $password,$email,$type){

  $mysql_server_name='localhost';
   
  $mysql_username='保密'; 
   
  $mysql_password='保密'; 
   
  $mysql_database='保密'; 

  $conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password) or die("error connecting") ; //连接数据库
   
  mysql_query("set names 'utf8'"); //数据库输出编码 
   
  mysql_select_db($mysql_database); //打开数据库

  $sql = "insert into admin (username,password,email,type) values ('{$username}','{$password}','{$email}','{$type}')";
  // echo $sql;
  $result = mysql_query($sql,$conn); //执行
  return $result;
}

$response = 0;
$username = addslashes($_POST['username']);
$password = addslashes($_POST['password']);
$email = addslashes($_POST['email']);
$type = 'member';

$test = $username + $password + $email + $type;

if(empty($username) || empty($password) || empty($email)){
  $response = 0;
}

if(add_user($username,$password,$email,$type)){
  $response = 1;
}else{
  $response = 0;
}

echo $response;
?>