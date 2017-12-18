<template>
  <div class='equip_repair'>
    <!--<div class="panel panel-success">-->
      <!--<div class="panel-heading">-->
        <!--<h4 class="panel-title">-->
          <!--<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">维修中<small>（点击关闭/开启）</small></a>-->
        <!--</h4>-->
      <!--</div>-->
      <!--<div id="collapseOne" class="panel-collapse collapse in">-->
        <!--<div class="panel-body">-->
          <!--<div class='table-responsive'>-->
            <!--<table class='table table-striped table-bordered table-hover '>-->
              <!--<thead>-->
              <!--<tr>-->
                <!--<th>设备名称</th>-->
                <!--<th>设备编号</th>-->
                <!--<th>生产日期</th>-->
                <!--<th>供应商</th>-->
                <!--<th>负责人</th>-->
                <!--<th>维修记录</th>-->
                <!--<th>操作</th>-->
              <!--</tr>-->
              <!--</thead>-->
              <!--<tbody>-->
              <!--<tr  v-if="!!repairing[0]" v-for="item in repairing">-->
                <!--<td>{{item.name}}</td>-->
                <!--<td>{{item.id}}</td>-->
                <!--<td>{{item.date}}</td>-->
                <!--<td>{{item.vendor}}</td>-->
                <!--<td>{{item.manager}}</td>-->
                <!--<td class=''><span class='pointer'>查看</span></td>-->
                <!--<td><span class='pointer' @click="removeItem(item)">删除</span></td>-->
              <!--</tr>-->
              <!--</tbody>-->
            <!--</table>-->
          <!--</div>-->
        <!--</div>-->
      <!--</div>-->
    <!--</div>-->
    <div class="panel panel-warning">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">待维修<small>（点击关闭/开启）</small></a>
        </h4>
      </div>
      <div id="collapseTwo" class="panel-collapse collapse in">
        <div class="panel-body">
          <div class='table-responsive'>
            <table class='table table-striped table-bordered table-hover '>
              <thead>
              <tr>
                <th>设备名称</th>
                <th>设备编号</th>
                <th>生产日期</th>
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
                <td>{{equip.date}}</td>
                <td>{{equip.vendor}}</td>
                <td>{{equip.admin}}</td>
                <td class=''><span>{{equip.status}}</span></td>
                <td><span class='pointer deleteWarn' @click="removeItem(equip)">移除</span></td>
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
      repairing: {
        type: Object
      },
      repaired: {
        type: Object
      }
    }
  },
  computed: {
  },
  created() {
    this.$http.post('./php/equipments/equipments.php',{'operation': 'repair'},{emulateJSON: true}).then((res) => {
      if(res.body != 0){
        this.repaired = res.body;
      }else {
        this.repaired = '';
      }
    });
  },
  methods:{
    removeItem(item) {
      if(confirm('是否将设备状态更改为“正常”')){
        let index = this.repaired.indexOf(item);
        this.repaired.splice(index,1);
        let data = { 'operation':'changeStatus', 'removeEquipId': item.id };
        this.$http.post('./php/files/deleteOrEcho.php',data,{emulateJSON:true}).then((res) => {
          if(res.body == '更改成功'){
            alert('已将设备状态更改为“正常”');
          }else {
            alert('移除失败');
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
