<template>
<div class="user">
  <user-nav></user-nav>
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
  import userNav from './nav/userNav'
  import labFooter from '../footer/labfooter'
  import userFiles from './userFiles/userFiles'
  import bookRepair from './bookRepair/bookRepair'
  import { getCookie } from '../../common/js/cookie.js'

  export default {
    data() {
      return {
      }
    },
    created() {
      let uName = getCookie('username');
      let uPwd = getCookie('info');
      this.name = uName;
      this.pwd = uPwd;
      /*如果cookie不存在，则跳转到登录页*/
      if(uName === ""){
        this.$router.push('/');
      }else {
        let data = {'username':this.name,'password':this.pwd};
        this.$http.post('./php/login.php', data,{emulateJSON:true}).then((res)=>{
          if(res.data !== '2'){
            this.$router.push('/');
          }
        });
      }
    },
    methods: {
      check() {
        let data = {'username':this.name,'password':this.pwd};
        this.$http.post('./php/login.php', data,{emulateJSON:true}).then((res)=>{
          return res.data === '2';
        })
      }
    },
    components: {
      userNav,
      labFooter,
      userFiles,
      bookRepair
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
  .user {
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
