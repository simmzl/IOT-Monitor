<?php
function handleDB($sql){
  $conn=mysql_connect('xxx','xx','xx') or die("error connecting") ; //连接数据库
  mysql_query("set names 'utf8'"); //数据库输出编码
  mysql_select_db('xx'); //打开数据库
  $result = mysql_query($sql,$conn); //执行
  mysql_close($conn);
  return $result;
}

function decodeUnicode($str){
  return preg_replace_callback('/\\\\u([0-9a-f]{4})/i',
  create_function('$matches','return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'),$str);
}

$operation = $_POST['operation'];
$response = 0;

if($operation == 'inputs'){

  // 设备数据录入
  $xx = addslashes($_POST['xx']);
  $xx = addslashes($_POST['xx']);
  $xx = addslashes($_POST['xx']);
  $xx = addslashes($_POST['xx']);
  $xx = addslashes($_POST['xx']);

  if(empty($x) || empty($xx) || empty($xx) || empty($xx) || empty($xx)){
    $response = 0;
  }

  $sql = "insert into xx (xx) values (xx)";
  if(handleDB($sql)){
    $response = 1;
  }else{
    $response = 0;
  }
  echo $response;
}elseif ($xx == 'query'){

  // 设备数据查询

  $x = addslashes($_POST['x']);

  if(empty($x)){
    $response = 0;
  }

  $sql = "select * from xx where id = '{$x}'";
  if($row = handleDB($sql)){
    $tmp = mysql_fetch_assoc($row);
    $response =  decodeUnicode(json_encode($tmp));
  }else{
    $response = 0;
  }
  echo $response;
}elseif ($xx == 'xx') {

  // 查询所有数据

  $sql = "select * from xx";
  if($row = handleDB($sql)){
    while($tmp[] = mysql_fetch_assoc($row)){};
    array_pop($tmp);
    $response =  decodeUnicode(json_encode($tmp));
  }else{
    $response = 0;
  }
  echo $response;
}elseif ($xx == 'xx') {
  
  // 输出待维修状态的设备数据

  $sql = "select * from xx where xx = 'xx'";
  if($row = handleDB($sql)){
    while($tmp[] = mysql_fetch_assoc($row)){};
    array_pop($tmp);
    $response =  decodeUnicode(json_encode($tmp));
  }else{
    $response = 0;
  }
  echo $response;
}elseif ($xx == 'xx') {

  // 删除指定ID的设备

  $xx = $_POST['xx'];
  if(handleDB("delete from xx where xx = '{$xx}'")){
    echo "删除成功";
  }else{
    echo '删除失败';
  }
}
// elseif ($xx == 'xx') {

//   // 更改指定ID的设备维修状态

//   $xx = $_POST['xx'];
//   $sql = "update xx set xx = xx where xx = '{$xx}'";
//   if(handleDB($sql){
//     echo "更改成功";
//   }else{
//     echo '更改失败';
//   } 
// }