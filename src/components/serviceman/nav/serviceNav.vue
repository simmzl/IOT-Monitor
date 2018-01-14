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
          <li><router-link to="/serviceman/bookRepair">设备报修</router-link></li>
          <li><router-link to="/serviceman/repair">设备管理</router-link></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              个人中心
              <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
              <li><router-link to="/serviceman/info">个人信息</router-link></li>
              <li><a href="javascript:;" @click="quit">退出登录</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
<script type="text/ecmascript-6">
  import { delCookie } from '../../../common/js/cookie.js'

  export default {
    methods: {
      quit() {
        delCookie('username');
        delCookie('info');
        this.$router.push('/');
      }
    }
  }
</script>
<style>
</style>
