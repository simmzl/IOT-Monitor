<template>
  <div class="admin">
    <labNav></labNav>
    <div class='container main clearfix'>
      <div class="containter-main clearfix">
        <router-view></router-view>
      </div>
    </div>
    <labFooter></labFooter>
  </div>
</template>

<script>
  import labNav from '../../components/nav/labnav'
  import labFooter from '../../components/footer/labfooter'

  export default {
    data() {
      return {}
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

