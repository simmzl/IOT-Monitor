<template>
  <div class="admin">
    <lab-nav></lab-nav>
    <div class='container main clearfix'>
      <div class="containter-main clearfix">
        <router-view></router-view>
      </div>
    </div>
    <lab-footer></lab-footer>
  </div>
</template>

<script>
  import labNav from '../../components/nav/labnav'
  import labFooter from '../../components/footer/labfooter'
  import { setCookie,getCookie,delCookie } from '../../common/js/cookie.js'

  export default {
    data() {
      return {
        name: ''
      }
    },
    mounted() {
      let uName = getCookie('username');
      this.name = uName;
      /*如果cookie不存在，则跳转到登录页*/
      if(uName === ""){
        this.$router.push('/')
      }
    },
    components: {
      labNav,
      labFooter
    }
  }
</script>

<style>
  .container{
    padding-left: 10px;
    padding-right: 10px;
  }
  body{
    background: #f6f6f6;
  }
  .main {
    padding-top: 100px;
  }
  .admin {
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    height: 100%;
  }
  .container.main.clearfix{
    min-height: 100%;
  }
  .containter-main{
    padding-bottom: 140px;
  }
  .clearfix:after {
    display: block;
    content: '';
    clear: both;
    height: 0;
    visibility: hidden;
  }
</style>

