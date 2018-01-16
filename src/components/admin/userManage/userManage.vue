<template>
<div class="user-manage">
  <div class="panel panel-success">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">维修人员</a>
        <button type="button" class="pull-right btn btn-success btn-xs" @click="resetChangeInfo()" data-toggle="modal" data-target="#changeInfo">+ 添加账号</button>
      </h4>
    </div>
    <div id="collapse1" class="panel-collapse collapse in">
      <div class="panel-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover'>
            <thead>
            <tr>
              <th>序号</th>
              <th>手机号码</th>
              <th>姓名</th>
              <th>邮箱</th>
              <th>注册时间</th>
              <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <tr  v-if="!!serviceman[0]" v-for="(person, index) in serviceman">
              <td>{{index+1}}</td>
              <td>{{person.username}}</td>
              <td>{{person.name}}</td>
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
              <th>手机号码</th>
              <th>姓名</th>
              <th>单位</th>
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
              <td>{{user.company}}</td>
              <td>{{user.email}}</td>
              <td>{{user.date}}</td>
              <td><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#showDetail" @click="showEquipList(user.username)">查看</button></td>
              <td><button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#addEquip" @click="addEquip(user.username)">添加设备</button></td>
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
            <li class="list-group-item" v-for="equipID in equipList">
              <span>{{equipID}}</span>
              <button type="button" class="pull-right btn btn-danger btn-xs" data-toggle="modal" @click="deleteEquipForUser(equipID)">删除</button>
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
          <form class="bs-example bs-example-form" role="form">
            <div class="input-group">
              <span class="input-group-addon">手机</span>
              <input type="text" class="form-control" v-model="changeInfo.username" maxlength="11">
            </div>
            <div class="input-group">
              <span class="input-group-addon">姓名</span>
              <input type="text" class="form-control"  v-model="changeInfo.name" maxlength="10">
            </div>
            <div class="input-group">
              <span class="input-group-addon">密码</span>
              <input type="password" class="form-control" v-model="changeInfo.pwd" minlength="6" maxlength="16">
            </div>
            <div class="input-group input-email">
              <span class="input-group-addon">邮箱</span>
              <input type="email" class="form-control" v-model="changeInfo.email">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <span class="err-warning pull-left">{{changeInfoWarning}}</span>
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" ref="closeChangeInfo">关闭</button>
          <button type="button" class="btn btn-primary btn-sm" @click="canSubmitInfo()">提交</button>
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
          <span class="err-warning pull-left">{{addEquipWarning}}</span>
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" ref="closeAddEquip">关闭</button>
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
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" ref="closeConformDelete">关闭</button>
          <button type="button" class="btn btn-primary btn-sm" @click="canDelete">确认</button>
        </div>
      </div>
    </div>
  </div>

</div>
</template>
<script type="text/ecmascript-6">
import md from 'md5'

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
      changeInfoWarning: '',
      addEquipOwner: '',
      addEquipWarning: '',
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
//      this.$http.post('https://www.easy-mock.com/mock/5a475a5da1af5e2dfae2c8d3/alluids/echousers').then(res =>{
      this.$http.post('./php/usermanage/usersOrEquipList.php',data,{emulateJSON:true}).then(res => {

//        console.log(res);
        this.users = res.body;
      });
    },
    getServicemanData() {
      let data = {'operation': 'getServiceman'};
//      this.$http.post('https://www.easy-mock.com/mock/5a475a5da1af5e2dfae2c8d3/alluids/serviceman').then(res =>{
      this.$http.post('./php/usermanage/usersOrEquipList.php',data,{emulateJSON:true}).then(res => {
//        console.log(res);
        this.serviceman = res.body;
      });
    },

//    添加、更改维修人员账号
    resetChangeInfo() {
      this.changeInfoWarning = '';
      for(let key in this.changeInfo) {
        if(this.changeInfo.hasOwnProperty(key)){
          this.changeInfo[key] = '';
        }
      }
      this.changeInfo.pwd = '';
      this.changeInfo.operation = 'addServiceman';
    },
    canSubmitInfo() {
      if(!this.changeInfo.username || !this.changeInfo.company || !this.changeInfo.email || !this.changeInfo.pwd){
        this.changeInfoWarning = '尚有未填项';
        return;
      }else if(!this.isNumber(this.changeInfo.username) && this.changeInfo.username.length !== 11){
        this.changeInfoWarning = '手机号格式不正确';
        return;
      }else if (this.changeInfo.pwd.length < 6 || this.changeInfo.pwd.length > 16) {
        this.changeInfoWarning = '密码长度为6-16位';
        return;
      }else if(!this.isEmail(this.changeInfo.email)) {
        this.changeInfoWarning = '邮箱格式不正确';
        return;
      }else {
        this.changeInfoWarning = '';
      }

      let operation = this.changeInfo.operation;
      let data = {
        'operation': operation,
        'username': this.changeInfo.username,
        'pwd': md(this.changeInfo.pwd),
        'company': this.changeInfo.company,
        'email': this.changeInfo.email
      };
      this.$http.post('./php/usermanage/moreOperation.php',data,{emulateJSON:true}).then(res => {
//        console.log(res.body);
        if(res.body === 'success'){
          this.getServicemanData();
          this.$refs.closeChangeInfo.click();
        }
      });
    },
    showChangeModal(person) {
      this.changeInfoWarning = '';
      let tmp = {};
      for(let key in person) {
        if(person.hasOwnProperty(key)){
          tmp[key] = person[key] ;
        }
      }
      this.changeInfo = tmp;
      this.changeInfo.pwd = '';
      this.changeInfo.operation = 'changeInfo';
//      console.log(this.changeInfo);
    },

//    删除维修人员账号
    deleteItem(person) {
      for(let key in person) {
        if(person.hasOwnProperty(key)){
          this.changeInfo[key] = person[key] ;
        }
      }
    },
    canDelete() {
//      console.log(this.changeInfo);
      let data = {'operation': 'deleteServiceman', 'username': this.changeInfo.username};
      this.$http.post('./php/usermanage/moreOperation.php',data,{emulateJSON:true}).then(res => {
//        console.log(res.body);
        if(res.body === '删除成功'){
          let index = this.serviceman.indexOf(this.changeInfo);
          this.serviceman.splice(index, 1);
          this.resetChangeInfo();
          this.changeInfo.operation = '';
          this.$refs.closeConformDelete.click();
        }
      });
    },

//    显示普通用户拥有的设备ID
    showEquipList(username) {
      let data = {'operation': 'getEquipList','username': username};
//      this.$http.post('https://www.easy-mock.com/mock/5a475a5da1af5e2dfae2c8d3/alluids/list').then(res =>{
      this.$http.post('./php/usermanage/usersOrEquipList.php',data,{emulateJSON:true}).then(res => {

//        console.log(res);
        this.equipList = res.body;
      });
    },

//    为用户添加拥有设备
    addEquip(username) {
      this.addEquipWarning = '';
      this.numOfAddEquip = '';
      this.addEquipOwner = username;
    },
    canAddEquip() {
      if(!this.numOfAddEquip || !this.isNumber(this.numOfAddEquip)){
        this.addEquipWarning = '请输入正确编号';
        return;
      }
      let data = {'operation': 'addEquipForUser', 'equipID': this.numOfAddEquip, 'owner': this.addEquipOwner};
      this.$http.post('./php/usermanage/moreOperation.php',data,{emulateJSON:true}).then(res => {
//        console.log(res.body);
        if(res.body === '没有该设备'){
          this.addEquipWarning = '没有该设备';
        }else if(res.body === '添加设备失败') {
          this.addEquipWarning = '添加设备失败';
        }else {
//          console.log(this.$refs.closeAddEquip);
          this.$refs.closeAddEquip.click();
          this.addEquipWarning = '';
        }
      });
    },

//    删除普通用户所拥有的一台设备
    deleteEquipForUser(equipID) {
      let data = {'operation': 'deleteEquipForUser', 'equipID': equipID};
      this.$http.post('./php/usermanage/moreOperation.php',data,{emulateJSON:true}).then(res => {
//        console.log(res.body);
        if(res.body === '删除设备成功'){
          let index = this.equipList.indexOf(equipID);
          this.equipList.splice(index, 1);
        }
      });
    }
  }
}
</script>
<style lang="stylus" rel="stylesheet/stylus">
  .user-manage
    .table
      margin-bottom 0
    .panel-success
      .panel-title
        button
          margin-top -2px!important
    .modal-body
      .input-group-addon
        background-color #ffffff!important
      .form-control
        box-shadow none!important
      .list-group
        margin-bottom 0
    .modal-footer
      .err-warning
        color #e4393c
        line-height 30px
    #changeInfo
      .input-group
        margin-bottom 15px
      .input-email
        margin-bottom 0
    #addEquip
      .form-group
        margin-bottom 0
</style>
