<?php
function handleDB($sql){
  $conn=mysql_connect('xx','xx','xx') or die("error connecting") ; //连接数据库
  mysql_query("set names 'utf8'"); //数据库输出编码
  mysql_select_db('xx'); //打开数据库
  $result = mysql_query($sql,$conn); //执行
  return $result;
}
function decodeUnicode($str){
  return preg_replace_callback('/\\\\u([0-9a-f]{4})/i',
  create_function('$matches','return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'),$str);
}


$operation = $_POST['operation'];
$mes = '';

if($operation == 'insert') {
  $id = $_POST['id'];
  $tel = $_POST['tel'];
  $desc = $_POST['desc'];
  $person = $_POST['person'];

  $sql = "select * from equip_data where id = '{$id}'";
  $row = handleDB($sql);
  $result = mysql_fetch_array($row);
  if((empty($result))) {
    $mes = "未找到编号为'{$id}'的设备";
    echo $mes;
    return;
  }
  $status = $result['status'];
  $insert_sql = "insert into xx (id,description,person,tel,status) values ('{$id}','{$desc}','{$person}','{$tel}','{$status}')";

  if(handleDB($insert_sql)){
    $mes = "报修成功";
  }else{
    $mes = "报修失败";
  }
}elseif ($operation == 'echo') {
  $echo_sql = "select * from xx ORDER BY  `xx`.`index` ASC ";
  if($row = handleDB($echo_sql)){
    while($tmp[] = mysql_fetch_assoc($row)){};
    array_pop($tmp);
    $mes = decodeUnicode(json_encode($tmp));
  }else{
    $mes = '获取失败';
  }
}elseif ($operation == 'removeBookItem') {
  $bookItemIndex = $_POST['bookItemIndex'];
  
  $sql = "delete from xx where `index` = '{$bookItemIndex}'";
  if(handleDB($sql)) {
    $mes = '删除成功';
  }else{
    $mes = '删除失败';
  }
}

echo $mes;


