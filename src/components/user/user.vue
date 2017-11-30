<template>
<div class="user">
  <user-nav></user-nav>
  <div class='container main clearfix'>
    <div class="containter-main clearfix">
      <router-view></router-view>
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
  import { setCookie,getCookie,delCookie } from '../../common/js/cookie.js'

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
        this.$http.post('./login.php', data,{emulateJSON:true}).then((res)=>{
          if(res.data !== '2'){
            this.$router.push('/');
          }
        });
      }
    },
    methods: {
      check() {
        let data = {'username':this.name,'password':this.pwd};
        this.$http.post('./login.php', data,{emulateJSON:true}).then((res)=>{
          console.log(res);
          console.log('res.data === \'2\ 之前'+ res.data === '2');
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
  .container{
    padding-left: 10px;
    padding-right: 10px;
  }
  .main {
    padding-top: 90px;
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
</style>
