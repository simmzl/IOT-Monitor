<template>
<div class="labinfo">
  <div class='col-lg-1 col-md-1'></div>
  <!--我的信息-->
  <div class="col-lg-10 col-md-10 no-padding">
    <div class="basicInfo" v-show="!isShowEdit">
      <div class="myInfoData">
        <a class="pull-right editInfo" id='edit' href="javascript:;" title="编辑" @click="showEdit"><i class="fa fa-pencil"></i>编辑</a>
        <h3 class="title">基础资料</h3>
      </div>
      <div class="myInfoData">
        <span>手机号：</span>
        <span>{{info.username}}</span>
      </div>
      <div class="myInfoData">
        <span>姓名：</span>
        <span>{{info.name}}</span>
      </div>
      <div class="myInfoData">
        <span>注册邮箱:</span>
        <span>{{info.email}}</span>
      </div>
      <div class="myInfoData">
        <span>注册日期：</span>
        <span>{{info.date}}</span>
      </div>
      <div class="myInfoData">
        <span>账号类别:</span>
        <span>{{userType}}</span>
      </div>
    </div>
    <div id='edit_info' v-show="isShowEdit">
      <div class="editInfoWrapper input_group">
        <div class="myInfoData">
          <a class="pull-right editInfo" id='back' href="javascript:;" title='返回' @click="showEdit"><i class="fa fa-reply"></i>返回</a>
          <h3 class="title">编辑资料</h3>
        </div>
        <form action="">
          <div class="info">
            <span>手机号:</span>
            <input type="text" v-model="edit.id">
          </div>
          <div class="info">
            <span>姓名:</span>
            <input type="text" v-model="edit.name">
          </div>
          <div class="info">
            <span>注册邮箱:</span>
            <input type="text" id="edit_email" v-model="edit.email">
          </div>
          <div class="info err_info" v-show="edit.errShow">
            <span></span>
            <div id="error" class="error_reg" :class="{'submitSuccess': edit.isSubmitSuccess}">{{edit.err}}</div>
          </div>
          <div class="info">
            <span></span>
            <input type="submit" class='submit' id="submit_info" @click.stop.prevent="canSubmit" value="提交">
          </div>
        </form>
      </div>
      <div class="input_group">
        <div class="edit_pwd">
          <div class="myInfoData">
            <a class="pull-right editInfo" id='edit_pwd' href="javascript:;" title='' @click="showPwd"><i id="edit_pwd_turn" class="fa fa-pencil"></i><span class="edit_desc">{{editPwd.content}}</span></a>
            <h3 class="title">更改密码</h3>
          </div>
          <div class="edit_pwd_wrapper" v-show="isShowPwd">
            <form action="">
              <div class="info">
                <span>原密码:</span>
                <input type="password" id="ori_pwd" v-model="editPwd.oriPwd">
              </div>
              <div class="info">
                <span>新密码:</span>
                <input type="password" id="password" v-model="editPwd.pwd">
              </div>
              <div class="info">
                <span>确认密码:</span>
                <input type="password" id="password_conf" v-model='editPwd.pwdConf'>
              </div>
              <div class="info err_info" v-show="editPwd.errShow">
                <span></span>
                <div id="error_pwd" class="error_reg" :class="{'submitSuccess': editPwd.isSubmitSuccess}">{{editPwd.err}}</div>
              </div>
              <div class="info">
                <span></span>
                <input type="submit" class='submit' id="submit_pwd" @click.stop.prevent="canPwdSubmit" value="提交">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</template>
<script type="text/ecmascript-6">
import {setCookie, getCookie} from '../../common/js/cookie.js'
import md from 'md5'

export default {
  data() {
    return {
      info: {
        type: Object
      },
      isShowEdit: false,
      isShowPwd: false,
      edit: {
        name: "",
        id: "",
        email: "",
        err: "",
        errShow: false,
        isSubmitSuccess: false
      },
      editPwd: {
        content: '展开',
        oriPwd: '',
        pwd: '',
        pwdConf: '',
        err: "",
        errShow: false,
        isSubmitSuccess: false
      }
    }
  },
  computed: {
    userType() {
      if(this.info.type === 'member'){
        return '学生用户';
      }else if(this.info.type === 'admin'){
        return '管理员';
      }else if(this.info.type === 'serviceman'){
        return '维修人员';
      }
    }
  },
  created() {
    let data = {'operation': 'echo'};
    this.$http.post('./php/info/info.php', data, {emulateJSON:true}).then((res) => {
      this.info = res.body;
      this.initEdit();
    });
  },
  methods: {
    showEdit() {
      this.initEdit();
      return this.isShowEdit = !this.isShowEdit;
    },
    showPwd() {
      if (this.editPwd.content === "展开") {
        this.editPwd.content = "关闭";
      }else {
        this.initPwdEdit();
        this.editPwd.content = "展开";
      }
      return this.isShowPwd = !this.isShowPwd;
    },
//    修改资料前验证
    canSubmit() {
      if(!this.edit.id || !this.edit.email || !this.edit.name){
        if(this.edit.isSubmitSuccess) this.edit.isSubmitSuccess = false;
        this.edit.errShow = true;
        this.edit.err = "请完成输入";
      }else {
        if(this.isNumber(this.edit.id) && this.edit.id.length === 11 && this.isEmail(this.edit.email)){
          let data = {'operation': 'editinfo', 'new_username': this.edit.id, 'new_email': this.edit.email, 'new_name': this.edit.name};
          this.$http.post('./php/info/info.php', data, {emulateJSON:true}).then( (res) => {
//            console.log(res.body);
            if(res.body === '修改成功'){
              this.edit.errShow = true;
              this.edit.isSubmitSuccess = true;
              this.edit.err = "修改成功";
              this.info.username = this.edit.id;
              this.info.email = this.edit.email;
              this.info.name = this.edit.name;
              setCookie('username',this.edit.id,1000*60);
            }else {
              if(this.edit.isSubmitSuccess) this.edit.isSubmitSuccess = false;
              this.edit.errShow = true;
              this.edit.err = "修改失败";
            }
          });
        }else {
          if(this.edit.isSubmitSuccess) this.edit.isSubmitSuccess = false;
          this.edit.errShow = true;
          this.edit.err = "请输入正确的手机号或邮箱";
        }
      }
    },
//    修改密码前验证
    canPwdSubmit() {
      if(!this.editPwd.oriPwd || !this.editPwd.pwd || !this.editPwd.pwdConf){
        if(this.editPwd.isSubmitSuccess) this.editPwd.isSubmitSuccess = false;
        this.editPwd.errShow = true;
        this.editPwd.err = "请完成输入";
      }else if(md(this.editPwd.oriPwd) !== getCookie('info')) {
        if(this.editPwd.isSubmitSuccess) this.editPwd.isSubmitSuccess = false;
        this.editPwd.errShow = true;
        this.editPwd.err = "原密码错误";
      }else if(this.editPwd.pwd === this.editPwd.pwdConf){
        if(this.editPwd.pwd.length<6){
          if(this.editPwd.isSubmitSuccess) this.editPwd.isSubmitSuccess = false;
          this.editPwd.errShow = true;
          this.editPwd.err = "密码不能少于6个字符";
        }else {
          let data = {'operation': 'editpwd', 'new_pwd': md(this.editPwd.pwd)};
          this.$http.post('./php/info/info.php', data, {emulateJSON:true}).then( (res) => {
            console.log(res.body);
            if(res.body === '修改成功'){
              this.editPwd.errShow = true;
              this.editPwd.isSubmitSuccess = true;
              this.editPwd.err = "修改成功";
              setCookie('info',md(this.editPwd.pwd),1000*60);
            }else {
              if(this.editPwd.isSubmitSuccess) this.editPwd.isSubmitSuccess = false;
              this.editPwd.errShow = true;
              this.editPwd.err = "修改失败";
            }
          });
        }
      }else {
        if(this.editPwd.isSubmitSuccess) this.editPwd.isSubmitSuccess = false;
        this.editPwd.errShow = true;
        this.editPwd.err = "两次输入的密码不同";
      }
    },
    initEdit() {
      this.edit.id = this.info.username;
      this.edit.email = this.info.email;
      this.edit.name = this.info.name;
      this.edit.errShow = false;
    },
    initPwdEdit() {
      this.editPwd.oriPwd = '';
      this.editPwd.pwdConf = '';
      this.editPwd.pwd = '';
      this.editPwd.errShow = false;
    }
  }
}
</script>
<style>
  .labinfo .title{
    line-height: 60px;
  }
  .basicInfo,.editInfoWrapper,.edit_pwd{
    padding: 30px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.05);
  }
  .editInfoWrapper{
    margin-bottom: 40px;
  }
  .myInfoData {
    padding-left: 20px;
    line-height: 40px;
    border-bottom: 1px solid #e6e6e6;
    overflow: hidden;
  }
  .editInfo {
    line-height: 40px;
    margin-top: 15px;
    margin-right: 20px;
  }
  .fa {
    margin-right: 10px;
    width: 16px;
    height: 14px;
  }
  .editInfo>i.fa{
    margin-right: 5px;
  }

  .input_group .info{
    margin: 20px ;
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
  }
  .input_group span{
    display: inline-block;
    width: 65px;
    font-weight: bold;
    font-size: 14px;
  }
  .submit{
    padding-left: 0!important;
    text-decoration: none;
    text-align: center;
    display: inline-block;
    font-size: 14px;
    /*margin-left: 99px!important;*/
    background-color: #000000;
    color: #fff;
    height: 40px!important;
  }
  #error.error_reg,#error_pwd{
    display: inline-block;
    box-sizing: border-box;
    width: 240px;
    height: 24px;
    border: 1px solid #faccc6;
    padding: 3px 10px;
    margin-left: 10px;
    font-size: 12px;
    line-height: 16px;
    color: #e4393c;
    background: #ffebeb;
    border-radius: 2px 2px;
  }
  .err_info.info{
    margin-top: -15px;
    margin-bottom: -15px;
  }
  /*.err_info.info error*/
  /*search*/
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
  .submitSuccess {
    border: none!important;
    color: #fff!important;
    background: #5cb85c!important;
  }
</style>
