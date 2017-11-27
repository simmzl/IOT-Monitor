<template>
  <div class='equip_repair'>
    <div class="panel panel-success">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">维修中<small>（点击关闭/开启）</small></a>
        </h4>
      </div>
      <div id="collapseOne" class="panel-collapse collapse in">
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
                <th>维修记录</th>
                <th>操作</th>
              </tr>
              </thead>
              <tbody>
              <tr  v-if="!!repairing[0]" v-for="item in repairing">
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
      </div>
    </div>
    <div class="panel panel-warning">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">未维修<small>（点击关闭/开启）</small></a>
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
                <th>维修记录</th>
                <th>操作</th>
              </tr>
              </thead>
              <tbody>
              <tr  v-if="!!repaired[0]" v-for="item in repaired">
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
  created() {
    this.$http.get('static/data/equipData/repairing.json').then((res) => {
      this.repairing = res.body;
      console.log(this.repairing);
    });
    this.$http.get('static/data/equipData/repaired.json').then((res) => {
      this.repaired = res.body;
      console.log(this.repaired);
    });
  }
}
</script>
<style>
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
