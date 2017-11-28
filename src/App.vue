<template>
<div id="app">
  <router-link to="/">登录</router-link>
  <router-link to="/signUp">注册</router-link>
  <router-link to="/admin">admin</router-link>
  <router-link to="/user">user</router-link>
  <router-view></router-view>
</div>
</template>

<script>
  export default {
    data() {
      return {}
    },
    components: {
    }
  }
</script>
<style>
  @import "./common/css/main.css";
  @import "./common/css/reset.css";
  .router-link-exact-active.active {
    color: #5cb85c!important;
  }
</style>
