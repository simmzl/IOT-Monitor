<template>
  <div class='equip_search_all'>
    <div class='equip_search'>
      <input type="text" id='equip_search' placeholder='设备编号' v-model="queryId" @keyup.enter="query"><span @click="query"><i class="fa fa-search fa-lg"></i></span>
    </div>
    <div class='table-responsive' v-show="!!queryRes.id">
      <table class='table table-striped table-bordered table-hover'>
        <thead>
        <tr>
          <th>设备名称</th>
          <th>设备编号</th>
          <th>生产日期</th>
          <th>录入日期</th>
          <th>供应商</th>
          <th>负责人</th>
          <th>设备状态</th>
          <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td>{{queryRes.name}}</td>
          <td>{{queryRes.id}}</td>
          <td>{{queryRes.production_date}}</td>
          <td>{{queryRes.date}}</td>
          <td>{{queryRes.vendor}}</td>
          <td>{{queryRes.admin}}</td>
          <td><span>{{queryRes.status}}</span></td>
          <td><span class='pointer deleteWarn' @click="deleteItem">删除</span></td>
        </tr>
        </tbody>
      </table>
    </div>
    <div v-show="!queryRes.id" class="deleteWarn">{{resWarn}}</div>

    <hr>

    <div class="equip_all">
      <input type="checkbox" class="showAllInput" v-model="isShowAll" @click="loadAllData"><span>显示所有设备</span>
    </div>
    <div class='table-responsive' v-show="isShowAll">
      <table class='table table-striped table-bordered table-hover'>
        <thead>
        <tr>
          <th>设备名称</th>
          <th>设备编号</th>
          <th>生产日期</th>
          <th>录入日期</th>
          <th>供应商</th>
          <th>负责人</th>
          <th>设备状态</th>
          <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <tr  v-if="!!equipData[0]" v-for="equip in equipData">
          <td>{{equip.name}}</td>
          <td>{{equip.id}}</td>
          <td>{{equip.production_date}}</td>
          <td>{{equip.date}}</td>
          <td>{{equip.vendor}}</td>
          <td>{{equip.admin}}</td>
          <td><span class='pointer'>{{equip.status}}</span></td>
          <td>
            <button type="button" class="btn btn-danger btn-xs" @click="removeItem(equip)">删除</button>
            <!--<span class='pointer deleteWarn' @click="removeItem(equip)">删除</span>-->
          </td>
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
        queryId: '',
        queryRes: {
          type: Object
        },
        equipData:{
          type: Object
        },
        resWarn: '',
        isShowAll: false
      }
    },
    computed: {

    },
    methods: {
      loadAllData() {
//        if(this.isShowAll === false) return;
        this.$http.post('./php/equipments/equipments.php', {'operation': 'queryAll'},{emulateJSON: true}).then((res) => {
          if (res.body != 0) {
            this.equipData = res.body;
          }
        });
      },
      query() {
        if(this.queryId === '') {
          this.resWarn = '请输入设备编号...';
          return;
        }
        let data = {'operation': 'query', 'queryid': this.queryId};
        this.$http.post('./php/equipments/equipments.php',data,{emulateJSON: true}).then((res) => {
//          console.log(res);
          if (!!res.body.id) {
            this.queryRes = res.body;
          }else {
            this.queryRes = '';
            this.resWarn = '未找到设备...';
//            console.log(this.resWarn);
          }
        });
      },
      deleteItem() {
        let conf = confirm("确认删除？");
        if(conf) {
          let data = { 'operation':'delete', 'deleteEquipId': this.queryRes.id};
          this.$http.post('./php/equipments/equipments.php',data,{emulateJSON:true}).then((res) => {
            if(res.body === '删除成功'){
              this.queryRes = '';
//              alert('删除成功');
            }else {
              alert('删除失败');
            }
          });
        }
      },
      removeItem(item) {
        let conf = confirm("确认删除？");
        if(conf) {
          let data = { 'operation':'delete', 'deleteEquipId': item.id};
          this.$http.post('./php/equipments/equipments.php',data,{emulateJSON:true}).then((res) => {
            if(res.body === '删除成功'){
              let index = this.equipData.indexOf(item);
              this.equipData.splice(index,1);
//              alert('删除成功');
            }else {
              alert('删除失败');
            }
          });
        }
      }
    }
  }
</script>
<style>
  .deleteWarn{
    color: #e4393c;
  }
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
