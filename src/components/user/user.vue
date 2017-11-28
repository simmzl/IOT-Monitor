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

  export default {
    data() {
      return {
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
<style>

</style>
