<?php

header('Content-Type:text/plain;charset=utf-8');

$a=rand(0,30);
$b=rand(0,70);
$c=rand(0,10);
$x=rand(0,10);
$z=2;

$id=1;
$date=time();
$ws=($c/10);
$temp=$a+($x/10);
$hum=$b;

$con = mysql_connect("XXX","XXX","XXX");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

// mysql_query("set names utf-8");


// Create table in my_db database

mysql_select_db("XXX", $con);

	$sql = "INSERT INTO `xx` 
	(`xx`,`xx`,`xx`,`xx`,`xx`,`xx`)
	VALUES
	(NULL,'$date','$ws','$temp','$hum','$z')";
	mysql_query($sql,$con);


	mysql_close($con);
?>
