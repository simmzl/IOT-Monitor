<template>
  <div class="equipment">
    <div class="col-lg-2 col-md-2 auto-padding">
      <div class="dataChoose equip">
        <div class="link-wrapper flex-wrapper">
          <router-link to="/admin/equipment/equipInput">设备录入</router-link>
          <router-link to="/admin/equipment/equipSearch">设备查询</router-link>
          <router-link to="/admin/equipment/equipRepair">设备维修</router-link>
          <router-link to="/equipRepair">设备地图</router-link>
        </div>
      </div>
    </div>
    <div class="col-lg-10 col-md-10 no-padding">
      <keep-alive>
        <router-view name="equip"></router-view>
      </keep-alive>
    </div>
  </div>
</template>
<script type="text/ecmascript-6">
  export default {}
</script>
<style scoped>
  .equipment .dataChoose .link-wrapper a{
    font-size: 16px;
    display: inline-block;
    padding: 10px;
    cursor: pointer;
    border: none;
    border-radius: 8px 8px;
  }
  a.router-link-exact-active.active {
    color: #5cb85c!important;
  }
  .equipment .dataChoose{
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
  }
  @media  screen and ( min-width: 992px) {
    .equipment .no-padding{
      padding-left: 10px;
    }
  }
  @media  screen and ( max-width: 991px) {
    .auto-padding{
      padding: 0;
    }
    .equipment .dataChoose .link-wrapper a{
      padding: 5px!important;
    }
    .flex-wrapper{
      display: flex;
    }
    .flex-wrapper a{
      flex: 1;
      text-align: center;
    }
  }
</style>
