<template>
  <div id="app">
    <labnav></labnav>
    <div class='container main clearfix'>
      <div class="containter-main">
        <!--<keep-alive>-->
          <router-view></router-view>
        <!--</keep-alive>-->
      </div>
    </div>
    <labfooter></labfooter>
  </div>
</template>

<script>
  import labnav from './components/nav/labnav'
  import labfooter from './components/footer/labfooter'

  export default {
    data() {
      return {}
    },
    components: {
      labnav,
      labfooter
    }
  }
</script>

<style>
  @import "common/css/main.css";
  @import "common/css/reset.css";

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
  #app {
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    height: 100%;
  }
  .container.main.clearfix{
    min-height: 100%;
  }
  .containter-main{
    padding-bottom: 180px;
  }
  .clearfix:after {
    display: block;
    content: '';
    clear: both;
    height: 0;
    visibility: hidden
  }
</style>
