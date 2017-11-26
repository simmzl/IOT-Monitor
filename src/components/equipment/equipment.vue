<template>
  <div class="equipment">
    <div class="col-lg-2 col-md-2 auto-padding">
      <div class="dataChoose equip">
        <a class="a_title" id='entering'><router-link to="/equipinput">设备录入</router-link></a>
        <a class="a_title" id='search'><router-link to="/equipsearch">设备查询</router-link></a>
        <a class="a_title" id='repair'><router-link to="/equiprepair">设备维修</router-link></a>
        <a class='a_title'><router-link to="/equiprepair">设备地图</router-link></a>
      </div>
    </div>
    <div class="col-lg-10 col-md-10 no-padding">
      <router-view name="equip"></router-view>
    </div>
  </div>
</template>
<script type="text/ecmascript-6">
  export default {
  }
</script>
<style>
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
  }


</style>
