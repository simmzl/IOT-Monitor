<template>
  <div class="input_group equip_input" id="equip_input">
    <form action="">
      <div class="info">
        <span>设备编号:</span>
        <input type="text" id="equip_id" v-model="edit.id">
      </div>
      <div class="info">
        <span>生产日期:</span>
        <input type="text" placeholder="19700101" v-model="edit.date">
      </div>
      <div class="info">
        <span>供应商:</span>
        <input type="text" v-model="edit.vendor">
      </div>
      <div class="info">
        <span>负责人:</span>
        <input type="text" v-model="edit.person">
      </div>
      <div class="info err_info" v-show="edit.errShow">
        <span></span>
        <div id="error" class="error_reg">{{edit.err}}</div>
      </div>
      <div class="info">
        <span style="font-size: 0"></span>
        <input type="submit" class='submit' id="submit">
      </div>
    </form>
  </div>
</template>
<script type="text/ecmascript-6">
  export default {
    data() {
      return {
        edit: {
          id: '',
          date: '',
          vendor: '',
          person: '',
          err: '',
          errShow: false
        }
      }
    },
    computed: {

    }
  }
</script>
<style>
  .equip_input{
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
  }

  .input_group .info{
    margin: 20px ;
    font-size: 0;
  }
  .input_group span.edit_desc{
    width: auto;
    font-weight: normal;
  }
  .input_group input{
    border-radius: 4px 4px;
    margin: 0 0 0 10px;
    height: 36px;
    width: 240px;
    border: 1px solid #e6e6e6;
    outline: none;
    padding-left: 8px;
    font-size: 14px;
  }
  textarea{
    width: 60%;
    min-width: 240px;
    border-radius: 4px 4px;
    margin: 0 0 0 10px;
    outline: none;
    padding-left: 8px;
    border: 1px solid #e6e6e6;
  }
  .input_group span{
    display: inline-block;
    width: 65px;
    font-weight: bold;
    font-size: 14px;
  }

</style>
