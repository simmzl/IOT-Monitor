<template>
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
          <li><a href="./tpl/member/repair.html">设备报修</a></li>
          <li><a href="">文档中心</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              个人中心
              <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
              <li><a href=" ./tpl/member/information.html">个人信息</a></li>
              <li><a href="javascript:;" id="loginOut">退出登录</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
<script type="text/ecmascript-6">
  export default {}
</script>
<style >

</style>
