<template>
  <div class="serviceman">
    <service-nav></service-nav>
    <div class='container main clearfix'>
      <div class="containter-main clearfix">
        <keep-alive>
          <router-view></router-view>
        </keep-alive>
      </div>
    </div>
    <lab-footer></lab-footer>
  </div>
</template>
<script type="text/ecmascript-6">
  import serviceNav from './nav/serviceNav'
  import labFooter from '../footer/labfooter'
//  import userFiles from './userFiles/userFiles'
//  import bookRepair from './bookRepair/bookRepair'
  import { getCookie } from '../../common/js/cookie.js'

  export default {
    data() {
      return {
      }
    },
    activated() {
      let uName = getCookie('username');
      let uPwd = getCookie('info');
      this.name = uName;
      this.pwd = uPwd;
      /*如果cookie不存在，则跳转到登录页*/
      if(uName === "") return this.$router.push('/');
      this.$http.post('./php/login.php', data,{emulateJSON:true}).then((res)=>{
        if(res.data !== '3') this.$router.push('/404');
      });
    },
    methods: {},
    components: {
      serviceNav,
      labFooter,
//      userFiles,
//      bookRepair
    }
  }
</script>
<style scoped>
  th{
    white-space: nowrap;
  }
  .container{
    padding-left: 10px;
    padding-right: 10px;
  }
  .main {
    padding-top: 80px;
  }
  .serviceman {
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
  @media  screen and ( max-width: 991px) {
    .main{
      padding-top: 70px;
    }
  }
</style>
