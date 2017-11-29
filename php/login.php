<?php

// 连接数据库
$mysql_server_name='localhost'; //改成自己的mysql数据库服务器
 
$mysql_username='root'; //改成自己的mysql数据库用户名
 
$mysql_password='root'; //改成自己的mysql数据库密码
 
$mysql_database='fume-hood-monitor'; //改成自己的mysql数据库名

$conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password) or die("error connecting") ; //连接数据库
 
mysql_query("set names 'utf8'"); //数据库输出编码 
 
mysql_select_db($mysql_database); //打开数据库

$username = '1495';
$sql ="select * from admin where username = {$username}"; //SQL语句
 
$result = mysql_query($sql,$conn); //查询

$row = mysql_fetch_array($result);
var_dump($row);


private $auth = '';//存储当前登录账号信息

public function login(){
  if(empty($_POST['username']) || empty($_POST['password'])){
    return false;
  }
  // 处理字符，防止注入
  $username = addslashes($_POST['username']);
  $password = addslashes($_POST['password']);

  $this->auth = $this->checkuser($username,$password)
  if($this->auth){
    $_SESSION['auth'] = $this->auth;
    if($this->auth['type'] == 'admin'){
      return 1;
    }else{
      return 2;
    }
  }else{
    return false;
  }
}

// 找到则返回信息，否则返回false
private function checkuser($username, $password){
  $sql = 'select * from '.$this->_table.' where username = "'.$username.'"';
  $result = DB::findOne($sql);
  if((!empty($result))&&$result['password']==$password){
    return $result;
  }else{
    return false;
  }
}
?>