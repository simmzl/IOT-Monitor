<?php
function handleDB($sql){
  $conn=mysql_connect('xx','xx','xx') or die("error connecting") ; //连接数据库
  mysql_query("set names 'utf8'"); //数据库输出编码
  mysql_select_db('fume-hood-monitor'); //打开数据库
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

  $detail = $_POST['detail'];

  // 设备数据录入
  $id = addslashes($_POST['id']);
  $type = addslashes($_POST['type']);
  $version = addslashes($_POST['version']);
  $install_date = addslashes($_POST['install_date']);
  $rtmp = $_POST['rtmp'];
  $company = addslashes($_POST['company']);
  $co_addr = addslashes($_POST['co_addr']);
  $lng = addslashes($_POST['lng']);
  $lat = addslashes($_POST['lat']);
  $co_linkman = addslashes($_POST['co_linkman']);
  $co_tel = addslashes($_POST['co_tel']);

  if(empty($id) || empty($type) || empty($version) || empty($install_date) || empty($rtmp)|| empty($company) || empty($co_addr)
 || empty($lng) || empty($lat) || empty($co_linkman) || empty($co_tel)){
    $response = 0;
  }

  if($detail == 'changeInfo'){
    // $old_id = $_POST['old_id'];
        $old_id = '00000003';
    $sql = "update equip_data set id='{$id}',type='{$type}',version='{$version}',install_date='{$install_date}',rtmp='{$rtmp}',company='{$company}',co_addr='{$co_addr}',co_lng='{$lng}',co_lat='{$lat}',co_linkman='{$co_linkman}',co_tel='{$co_tel}' where id='{$old_id}'";
  }elseif ($detail == 'input') {
    $sql = "insert into equip_data (id,type,version,install_date,rtmp,company,co_addr,co_lng,co_lat,co_linkman,co_tel,status) values ('{$id}','{$type}','{$version}','{$install_date}','{$rtmp}','{$company}','{$co_addr}','{$lng}','{$lat}','{$co_linkman}','{$co_tel}','正常')";
  }

  if(handleDB($sql)){
    $response = 1;
  }else{
    $response = 0;
  }
  echo $response;
}elseif ($operation == 'query'){

  // 设备数据查询

  $queryid = addslashes($_POST['queryid']);

  if(empty($queryid)){
    $response = 0;
  }

  $sql = "select * from equip_data where id = '{$queryid}'";
  if($row = handleDB($sql)){
    $tmp = mysql_fetch_assoc($row);
    $response =  decodeUnicode(json_encode($tmp));
  }else{
    $response = 0;
  }
  echo $response;
}elseif ($operation == 'queryAll') {

  // 查询所有数据

  $sql = "select * from equip_data ORDER BY `equip_data`.`id` ASC";
  if($row = handleDB($sql)){
    while($tmp[] = mysql_fetch_assoc($row)){};
    array_pop($tmp);
    $response =  decodeUnicode(json_encode($tmp));
  }else{
    $response = 0;
  }
  echo $response;
}elseif ($operation == 'repair') {
  
  // 输出待维修和正常状态的设备数据

  $detail = $_POST['detail'];
  if($detail == 'wrong'){
    $res = '待维修';
  }elseif ($detail == 'normal') {
    $res = '正常';
  }

  $sql = "select * from equip_data where status = '{$res}' ORDER BY `equip_data`.`id` ASC";
  if($row = handleDB($sql)){
    while($tmp[] = mysql_fetch_assoc($row)){};
    array_pop($tmp);
    $response =  decodeUnicode(json_encode($tmp));
  }else{
    $response = 0;
  }
  echo $response;
}elseif ($operation == 'delete') {

  // 删除指定ID的设备

  $delete_id = $_POST['deleteEquipId'];
  if(handleDB("delete from equip_data where id = '{$delete_id}'")){
    echo "删除成功";
  }else{
    echo '删除失败';
  }
}elseif ($operation == 'changeStatus') {

  // 更改指定ID的设备的状态
  $change_status = $_POST['detail'];
  $change_id = $_POST['removeEquipId'];
  if(handleDB("update equip_data set status = '{$change_status}' where id = '{$change_id}'")){
    echo "更改成功";
  }else{
    echo '更改失败';
  }
}