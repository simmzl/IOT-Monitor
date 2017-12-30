<template>
<div class="user-manage">
  <div class="panel panel-success">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThi">维修人员</a>
      </h4>
    </div>
    <div id="collapseThi" class="panel-collapse collapse in">
      <div class="panel-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover '>
            <thead>
            <tr>
              <th>用户名</th>
              <th>密码</th>
              <th>姓名</th>
              <th>手机号码</th>
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

</script>
<style lang="stylus" rel="stylesheet/stylus">

</style>
