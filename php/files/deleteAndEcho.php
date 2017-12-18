<?php 
header('content-type:text/json;charset=utf-8');
// 数据库操作
function handleDB($sql){
  $conn=mysql_connect('xxx','xxx','xxx') or die("error connecting") ; //连接数据库
  mysql_query("set names 'utf8'"); //数据库输出编码
  mysql_select_db('xxx'); //打开数据库
  $result = mysql_query($sql,$conn); //执行
  return $result;
}

// 解决json_encode将中文输出为unicode，且php版本低于5.4时无法添加json_encode()参数JSON_UNESCAPED_UNICODE
function decodeUnicode($str){
  return preg_replace_callback('/\\\\u([0-9a-f]{4})/i',
  create_function('$matches','return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'),$str);
}

$ss = $_POST['xx'];
$xx = $_POST['xx'];

// 输出所有文件名
if ($ss == 'ss') {
  $row = handleDB('select * from xxx');
  while($result[] = mysql_fetch_assoc($row)){};
  array_pop($result);
  $mes =  decodeUnicode(json_encode($result));
}else if ($xx == 'xx') {
  handleDB("delete from xxx where xxx = '{$xx}'");
  $mes = '删除成功';
}
echo $mes;