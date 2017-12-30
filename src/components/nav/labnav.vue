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
          <li><router-link to="/admin/equipment" class="router-link-exact-active">设备管理</router-link></li>
          <li><router-link to="/admin/charts">数据监测</router-link></li>
          <li><router-link to="/admin/video">视频监控</router-link></li>
          <li><router-link to="/admin/file">文档管理</router-link></li>
          <li><router-link to="/admin/userManage">用户管理</router-link></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">个人中心<b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
              <li><router-link to="/admin/info">个人信息</router-link></li>
              <li><a href="javascript:;" @click="quit">退出登录</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
<script type="text/ecmascript-6">
  import { delCookie } from '../../common/js/cookie.js'

  export default {
    data(){
      return {

      }
    },
    computed: {
    },
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
  .navbar.navbar-default.nav-justified{
    background-color: rgba(255,255,255,.95);
  }
</style>
