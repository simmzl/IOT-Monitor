<?php

function add_user($xx, $xx,$xx,$xx){

  $mysql_server_name='localhost';
   
  $mysql_username='保密'; 
   
  $mysql_password='保密'; 
   
  $mysql_database='保密'; 

  $conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password) or die("error connecting") ; //连接数据库
   
  mysql_query("set names 'utf8'"); //数据库输出编码 
   
  mysql_select_db($mysql_database); //打开数据库

  $sql = "insert into admin (xx,xx,xx,xx) values ('{$xx}','{$xx}','{$xx}','{$xx}')";
  // echo $sql;
  $result = mysql_query($sql,$conn); //执行
  return $result;
}

$response = 0;
$xx = addslashes($_POST['xx']);
$xx = addslashes($_POST['xx']);
$xx = addslashes($_POST['xx']);
$type = 'xx';


if(empty($xx) || empty($xx) || empty($xx)){
  $response = 0;
}

if(add_user($xx,$xx,$xx,$xx)){
  $response = 1;
}else{
  $response = 0;
}

echo $response;
?>