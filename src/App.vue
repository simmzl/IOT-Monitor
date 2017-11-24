<template>
  <div id="app">
    <labnav></labnav>
    <div class='container main clearfix'>
      <div class="containter-main">
        <!--<info></info>-->
        <keep-alive>
          <router-view></router-view>
        </keep-alive>
      </div>
    </div>
    <labfooter></labfooter>
  </div>
</template>

<script>
  import labnav from './components/nav/labnav'
  import labfooter from './components/footer/labfooter'
  import info from './components/info/info'

  export default {
    components: {
      labnav,
      labfooter,
      info
    }
  }
</script>

<style>
  @import "common/css/main.css";

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
