<template>
  <div class='equip_repair'>
    <div class="panel panel-info">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseFir">学生报修设备<small>（点击关闭/开启）</small></a>
        </h4>
      </div>
      <div id="collapseFir" class="panel-collapse collapse in">
        <div class="panel-body">
          <div class='table-responsive'>
            <table class='table table-striped table-bordered table-hover'>
              <thead>
              <tr>
                <th>设备名称</th>
                <th>设备编号</th>
                <th>生产日期</th>
                <th>录入日期</th>
                <th>供应商</th>
                <th>负责人</th>
                <th>维修状态</th>
                <th>操作</th>
              </tr>
              </thead>
              <!--<tbody>-->
              <!--&lt;!&ndash;<tr  v-if="!!normal[0]" v-for="equip in normal">&ndash;&gt;-->
                <!--&lt;!&ndash;<td>{{equip.name}}</td>&ndash;&gt;-->
                <!--&lt;!&ndash;<td>{{equip.id}}</td>&ndash;&gt;-->
                <!--&lt;!&ndash;<td>{{equip.date}}</td>&ndash;&gt;-->
                <!--&lt;!&ndash;<td>{{equip.vendor}}</td>&ndash;&gt;-->
                <!--&lt;!&ndash;<td>{{equip.admin}}</td>&ndash;&gt;-->
                <!--&lt;!&ndash;<td class=''><span>{{equip.status}}</span></td>&ndash;&gt;-->
                <!--&lt;!&ndash;<td><span class='pointer deleteWarn' @click="removeItem(equip,'待维修')">设为待维修</span></td>&ndash;&gt;-->
              <!--&lt;!&ndash;</tr>&ndash;&gt;-->
              <!--</tbody>-->
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="panel panel-danger">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseSec">待维修设备</a>
        </h4>
      </div>
      <div id="collapseSec" class="panel-collapse collapse in">
        <div class="panel-body">
          <div class='table-responsive'>
            <table class='table table-striped table-bordered table-hover '>
              <thead>
              <tr>
                <th>设备名称</th>
                <th>设备编号</th>
                <th>生产日期</th>
                <th>录入日期</th>
                <th>供应商</th>
                <th>负责人</th>
                <th>维修状态</th>
                <th>操作</th>
              </tr>
              </thead>
              <tbody>
              <tr  v-if="!!repaired[0]" v-for="equip in repaired">
                <td>{{equip.name}}</td>
                <td>{{equip.id}}</td>
                <td>{{equip.production_date}}</td>
                <td>{{equip.date}}</td>
                <td>{{equip.vendor}}</td>
                <td>{{equip.admin}}</td>
                <td class=''><span>{{equip.status}}</span></td>
                <td><span class='pointer alertSuccess' @click="removeItem(equip,'正常')">设为正常</span></td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="panel panel-success">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseThi">正常设备</a>
        </h4>
      </div>
      <div id="collapseThi" class="panel-collapse collapse in">
        <div class="panel-body">
          <div class='table-responsive'>
            <table class='table table-striped table-bordered table-hover '>
              <thead>
              <tr>
                <th>设备名称</th>
                <th>设备编号</th>
                <th>生产日期</th>
                <th>录入日期</th>
                <th>供应商</th>
                <th>负责人</th>
                <th>维修状态</th>
                <th>操作</th>
              </tr>
              </thead>
              <tbody>
              <tr  v-if="!!normal[0]" v-for="equip in normal">
                <td>{{equip.name}}</td>
                <td>{{equip.id}}</td>
                <td>{{equip.production_date}}</td>
                <td>{{equip.date}}</td>
                <td>{{equip.vendor}}</td>
                <td>{{equip.admin}}</td>
                <td class=''><span>{{equip.status}}</span></td>
                <td><span class='pointer deleteWarn' @click="removeItem(equip,'待维修')">设为待维修</span></td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script type="text/ecmascript-6">
export default {
  data() {
    return {
      normal: {
        type: Object
      },
      repaired: {
        type: Object
      }
    }
  },
  computed: {
  },
  activated() {
    this.initAllList();
  },
  methods:{
    initAllList() {
      this.getRepairList();
      this.getNormalList();
    },
    removeItem(item,str) {
      if(confirm('是否将设备状态更改为' + str + '?')){
        let data = { 'operation':'changeStatus', 'removeEquipId': item.id, 'detail': str};
        this.$http.post('./php/equipments/equipments.php',data,{emulateJSON:true}).then((res) => {
          if(res.body == '更改成功'){
            this.initAllList();
//            alert('已将设备状态更改为' + str);
          }else {
            alert('更改失败');
          }
        });
      }
    },
    getRepairList() {
      this.$http.post('./php/equipments/equipments.php',{'operation': 'repair', 'detail': 'wrong'},{emulateJSON: true}).then((res) => {
        if(res.body != 0){
          this.repaired = res.body;
        }else {
          this.repaired = '';
        }
      });
    },
    getNormalList() {
      this.$http.post('./php/equipments/equipments.php',{'operation': 'repair', 'detail': 'normal'},{emulateJSON: true}).then((res) => {
        if(res.body != 0){
          this.normal = res.body;
        }else {
          this.normal = '';
        }
      });
    }
  }
}
</script>
<style>
.deleteWarn{
  color: #e4393c;
}
.alertSuccess{
  color: #5cb85c;
}
.equip_repair .table-responsive .table{
  margin-bottom: 0!important;
}
.panel-body{
  padding: 0;
}
.table-responsive{
  border-bottom-left-radius: 4px;
  border-bottom-right-radius: 4px;
}
@media screen and (max-width: 767px){
  .table-responsive{
    margin-bottom: 0;
  }
}
</style>
