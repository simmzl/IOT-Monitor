<template>
<div class="user-manage">
  <div class="panel panel-success">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">维修人员</a>
        <button type="button" class="pull-right btn btn-success btn-xs" @click="showChangeModal(person)" data-toggle="modal" data-target="#changeInfo">+ 添加账号</button>
      </h4>
    </div>
    <div id="collapse1" class="panel-collapse collapse in">
      <div class="panel-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover'>
            <thead>
            <tr>
              <th>序号</th>
              <th>用户名</th>
              <th>姓名</th>
              <th>手机号码</th>
              <th>邮箱</th>
              <th>注册时间</th>
              <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <tr  v-if="!!serviceman[0]" v-for="(person,index) in serviceman">
              <td>{{index+1}}</td>
              <td>{{person.username}}</td>
              <td>{{person.name}}</td>
              <td>{{person.tel}}</td>
              <td>{{person.email}}</td>
              <td>{{person.date}}</td>
              <td>
                <button type="button" class="btn btn-primary btn-xs" @click="showChangeModal(person)" data-toggle="modal" data-target="#changeInfo">更改</button>
                <button type="button" class="btn btn-danger btn-xs" @click="deleteItem(person)" data-toggle="modal" data-target="#conformDelete">删除</button>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="panel panel-info">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">普通用户</a>
      </h4>
    </div>
    <div id="collapse2" class="panel-collapse collapse in">
      <div class="panel-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover'>
            <thead>
            <tr>
              <th>序号</th>
              <th>用户名</th>
              <th>姓名</th>
              <th>手机号码</th>
              <th>邮箱</th>
              <th>注册时间</th>
              <th>设备信息</th>
              <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <tr  v-if="!!users[0]" v-for="(user,index) in users">
              <td>{{index+1}}</td>
              <td>{{user.username}}</td>
              <td>{{user.name}}</td>
              <td>{{user.tel}}</td>
              <td>{{user.email}}</td>
              <td>{{user.date}}</td>
              <td><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#showDetail" @click="showEquipList(users.username)">查看</button></td>
              <td><button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#addEquip" @click="addEquip(users.username)">添加设备</button></td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="showDetail" tabindex="-1" role="dialog" aria-labelledby="showDetailLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="showDetailLabel">设备编号：</h4>
        </div>
        <div class="modal-body">
          <ul class="list-group" v-if="!!equipList[0]">
            <li class="list-group-item" v-for="equip in equipList">
              <span>{{equip}}</span>
              <button type="button" class="pull-right btn btn-danger btn-xs" data-toggle="modal" data-target="#conformDelete">删除</button>
            </li>
          </ul>
          <span v-if="!equipList[0]">暂无设备</span>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">关闭</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="changeInfo" tabindex="-1" role="dialog" aria-labelledby="changeInfoLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="changeInfoLabel">维修人员信息：</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" role="form">
            <div class="form-group">
              <div class="col-sm-12">
                <input type="text" class="form-control" placeholder="用户名" v-model="changeInfo.username">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <input type="text" class="form-control" placeholder="密码" v-model="changeInfo.pwd">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <input type="text" class="form-control" placeholder="姓名" v-model="changeInfo.name">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <input type="text" class="form-control" placeholder="邮箱" v-model="changeInfo.email">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">关闭</button>
          <button type="button" class="btn btn-primary btn-sm">提交</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="addEquip" tabindex="-1" role="dialog" aria-labelledby="addEquipLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="addEquipLabel">添加设备：</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" role="form">
            <div class="form-group">
              <div class="col-sm-12">
                <input type="text" class="form-control" placeholder="设备编号" v-model="numOfAddEquip">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">关闭</button>
          <button type="button" class="btn btn-primary btn-sm" @click="canAddEquip()">确认提交</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="conformDelete" tabindex="-1" role="dialog" aria-labelledby="conformDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <form class="form-horizontal" role="form">
              <span>确认删除？</span>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">关闭</button>
          <button type="button" class="btn btn-primary btn-sm" @click="canDelete">确认</button>
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
      autoIndex: 0,
      users: {
        type: Object
      },
      serviceman: {
        type: Object
      },
      equipList: {
        type: Object
      },
      changeInfo: {
        pwd: ''
      },
      addEquipOwner: '',
      numOfAddEquip: ''
    }
  },
  activated(){
    this.getUsersData();
    this.getServicemanData();
  },
  computed: {
  },
  methods: {
    getUsersData() {
      let data = {'operation': 'getUsers'};
      this.$http.post('https://www.easy-mock.com/mock/5a475a5da1af5e2dfae2c8d3/alluids/echousers').then(res =>{
        console.log(res);
        this.users = res.body;
      });
    },
    getServicemanData() {
      let data = {'operation': 'getServiceman'};
      this.$http.post('https://www.easy-mock.com/mock/5a475a5da1af5e2dfae2c8d3/alluids/serviceman').then(res =>{
        console.log(res);
        this.serviceman = res.body;
      });
    },
    showEquipList(username) {
      let data = {'operation': 'getEquipList','username': username};
      this.$http.post('https://www.easy-mock.com/mock/5a475a5da1af5e2dfae2c8d3/alluids/list').then(res =>{
        console.log(res);
        this.equipList = res.body;
      });
    },
    showChangeModal(person) {
      this.changeInfo = person;
    },
    addEquip(username) {
      this.addEquipOwner = username;
    },
    canAddEquip() {
      if(!this.numOfAddEquip || !this.isNumber(this.numOfAddEquip)) return;
      let data = {'operation': 'addEquip', 'equipmentNum': this.numOfAddEquip, 'owner': this.addEquipOwner};
      this.$http.post('./php/usermanage/usermanage.php').then(res => {

      });
    },
    deleteItem(person) {
      this.changeInfo = person;
    },
    canDelete() {
      let data = {'operation': 'delete', 'username': this.changeInfo.username};
      this.$http.post('./php/usermanage/usermanage.php').then(res => {

      });
    }
  }
}
</script>
<style lang="stylus" rel="stylesheet/stylus">
  .user-manage
    .panel-success
      .panel-title
        btn
          margin-top -2px
</style>
