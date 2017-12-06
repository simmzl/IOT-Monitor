<?php 
header("content-type:text/html;charset=utf-8");

// $_FILES

$myFile = $_FILES['myFile']['name'];
$myname = $_POST['name'];
echo($myFile);