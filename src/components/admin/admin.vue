<template>
  <div class="admin">
    <lab-nav></lab-nav>
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

<script>
  import labNav from '../../components/nav/labnav'
  import labFooter from '../../components/footer/labfooter'
  import { getCookie } from '../../common/js/cookie.js'

  export default {
    data() {
      return {
        name: '',
        pwd: ''
      }
    },
    // created() {
    //   this.init();
    // },
    activated() {
      this.init();
    },
    methods: {
      init() {
        let uName = getCookie('username');
        let uPwd = getCookie('info');
        this.name = uName;
        this.pwd = uPwd;
        if(uName === "") return this.$router.push('/');
        this.$http.post('./php/login.php', data,{emulateJSON:true}).then((res)=>{
          if(res.data !== '1') this.$router.push('/404');
        });
      }
    },
    components: {
      labNav,
      labFooter
    }
  }
</script>

<style>
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
  @media  screen and ( max-width: 991px) {
    .main{
      padding-top: 70px;
    }
  }
</style>

