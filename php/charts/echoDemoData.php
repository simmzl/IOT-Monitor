<?php
  function findAll_by_uid($uid,$date){
    $date_min = strtotime(date("Y-m-d",$date));
    $date_max = strtotime(date("Y-m-d",$date+24*60*60));
    $sql = "select * from `{$uid}` where date>= '{$date_min}' and date<= '{$date_max}' order by date asc";
    // $sql = "select * from `00000001` where date>= 1506512260 and date<= 1516512260 order by date asc";
    $data = handleDB($sql);
    return $data;
  }

  function handleDB($sql){
    $conn=mysql_connect('xx','xx','xx') or die("error connecting") ; //连接数据库
    mysql_query("set names 'utf8'"); //数据库输出编码
    mysql_select_db('xx'); //打开数据库
    $row = mysql_query($sql,$conn); //执行

    while($result[] = mysql_fetch_assoc($row)){};
    array_pop($result);
    return json_encode($result);
  }

  $uid = addslashes($_POST['uid']);
  $date = addslashes($_POST['date']);

  // $date = 1506512260;

  echo(findAll_by_uid($uid,$date));
?>