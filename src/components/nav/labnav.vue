<template>
<div>
  <nav class="navbar navbar-default nav-justified" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="javascript:;">智能实验室管理系统</a>
      </div>
      <div class="collapse navbar-collapse" id="navbar">
        <ul class="nav navbar-nav navbar-right main-nav">
          <li><a href="manage.html">设备管理</a></li>
          <!--<li><a href="http://movie.simmzl.cn/monitor/admin.php?controller=admin&method=admin">数据监测</a></li>-->
          <li><router-link to="/charts">数据检测</router-link></li>
          <li><a href="">视频监控</a></li>
          <li><a href="">文档管理</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              个人中心
              <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
              <li><router-link to="/info">个人信息</router-link></li>
              <li><a href="javascript:;" id="loginOut">退出登录</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</div>
</template>
<script type="text/ecmascript-6">
export default {}
</script>
<style>
  nav{
    position: fixed!important;
    z-index: 999;
    top: 0;
    box-shadow: 0 0 1px rgba(0,0,0,0.25);
    padding: 10px;
  }
  .navbar-default{
    border: none;
    border-radius: 0;
    background-color: #fff;
  }
  .navbar-default a{
    color: #000!important;
  }
  .navbar-header button{
    border: none!important;
  }
</style>
