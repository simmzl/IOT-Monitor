<?php
  function findAll_by_uid($uid,$date){
    $date_min = strtotime(date("Y-m-d",$date));
    $date_max = strtotime(date("Y-m-d",$date+24*60*60));
    $sql = 'select * from XXX where xxx = "'.$uid.'" and xx>='.$date_min.' and xx<='.$date_max.' order by xx asc';
    $data = check($sql);
    return $data;
  }

  function check($sql){

    $mysql_server_name='XXX';
     
    $mysql_username='XXX';
     
    $mysql_password='XXX'; 
     
    $mysql_database='XXX'; 

    $conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password) or die("error connecting") ; //连接数据库
     
    mysql_query("set names 'utf8'"); //数据库输出编码 
     
    mysql_select_db($mysql_database); //打开数据库

    $row = mysql_query($sql,$conn);

    while($result[] = mysql_fetch_assoc($row)){};
    array_pop($result);
    return json_encode($result);
  }

  $uid = addslashes($_POST['xx']);
  $date = addslashes($_POST['xx']);

  echo(findAll_by_uid($uid,$date));
?>