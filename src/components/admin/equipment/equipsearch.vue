<template>
  <div class='equip_search_all'>
    <div class='equip_search'>
      <input type="text" id='equip_search' placeholder='设备编号'><span class=""><i class="fa fa-search fa-lg"></i></span>
    </div>
    <div class="equip_all">
      <input type="checkbox" class="showAllInput" v-model="isShowAll" @click.once="loadAllData"><span>显示所有设备</span>
    </div>
    <div class='table-responsive' v-show="isShowAll">
      <table class='table table-striped table-bordered table-hover'>
        <thead>
        <tr>
          <th>设备名称</th>
          <th>设备编号</th>
          <th>生产日期</th>
          <th>供应商</th>
          <th>负责人</th>
          <th>维修记录</th>
          <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <tr  v-if="!!equipData[0]" v-for="item in equipData">
          <td>{{item.name}}</td>
          <td>{{item.id}}</td>
          <td>{{item.date}}</td>
          <td>{{item.vendor}}</td>
          <td>{{item.manager}}</td>
          <td class=''><span class='pointer'>查看</span></td>
          <td><span class='pointer' @click="removeItem(item)">删除</span></td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script type="text/ecmascript-6">
  export default {
    data() {
      return {
        equipData:{
          type: Object
        },
        isShowAll: false
      }
    },
    computed: {

    },
    methods: {
      loadAllData() {
        this.$http.get('static/data/equipData/all.json').then((res) => {
          this.equipData = res.body;
        });
      },
      removeItem(item) {
        let conf = confirm("确认删除？");
        if(conf) {
          let index = this.equipData.indexOf(item);
          this.equipData.splice(index, 1);
        }
      }
    },
//    watch: {
//      isShowAll: function (val) {
//        if(val && !this.equipData[0]){
//          this.$http.get('static/data/equipData/all.json').then((res) => {
//            this.equipData = res.body;
//          });
//        }
//      }
//    }
  }
</script>
<style>
  .equip_search_all {
    padding: 30px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
  }
  .equip_search input{
    max-width: 720px;
    width: calc(100% - 30px);
    height: 40px;
    border: 1px solid #e6e6e6;
    outline: none;
    padding-left: 8px;
    border-radius: 4px 4px;
    display: inline!important;
    margin-bottom: 20px;
  }
  .equip_search span{
    display: inline-block;
    width: 20px;
    margin-left: 10px;
    cursor: pointer;
  }
  .equip_all{
    margin-bottom: 20px;
  }
  table a{
    color: #2277da;
  }
  #collapseOne table,#collapseTwo table{
    border: none;
    margin-bottom: 0;
  }
  .showAllInput{
    -webkit-appearance: checkbox;
    vertical-align: top;
  }
  @media  screen and ( max-width: 991px) {
    .equip_search_all{
      padding: 20px;
    }
  }
</style>
