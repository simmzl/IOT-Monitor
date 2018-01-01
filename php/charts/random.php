<?php

header('Content-Type:text/plain;charset=utf-8');

// $table_name = '00000001';
function creat_random($table_name){
  $a=rand(0,30);
  $b=rand(0,70);
  $c=rand(0,10);
  $x=rand(0,10);
  $z=2;

  $date=time();
  $ws=($c/10);
  $temp=$a+($x/10);
  $hum=$b;

  $con = mysql_connect("xx","ss","ss");
  if (!$con){
    die('Could not connect:' . mysql_error());
  }

  mysql_select_db("ss", $con);

  $sql = "INSERT INTO `{$table_name}` 
  (`id`,`date`,`wind_speed`,`temperature`,`humidity`)
  VALUES
  (NULL,'$date','$ws','$temp','$hum')";
  mysql_query($sql,$con);
  mysql_close($con);
}

creat_random("00000001");
creat_random("00000002");
creat_random("00000003");

?>
