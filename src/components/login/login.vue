<template>
  <div class="index">
    <img class='fl index_l' src="../../../static/img/art.png">
    <div class="fr index_r">
      <div class='content'>
        <div class="login" v-show="!isSignUp">
          <h4 class='content_title'>智能实验室管理系统</h4>
          <form class="from">
            <input  placeholder='学号' type="text" v-model="username" maxlength="10" required="required">
            <input type="password" class="password" placeholder='密码' v-model="password" maxlength="16" required="required">
            <div class="loginError" :class="{'loginSuccess': isLoginSuccess}" v-show="errShow">{{err}}</div>
            <div class='content_footer'>
              <button type="submit" class='login_btn fr' @click.stop.prevent="_login">登录</button>
              <a class='fl forget' href='#'>忘记密码？</a>
            </div>
          </form>
          <div class="border"></div>
          <div class="text_center">
            <a class='reg' @click="showSignUp">没有账号？点我注册</a>
          </div>
          <div style="font-size: 12px; color:#aaaaaabd;margin-top: 10px">
            测试：管理员账号：1495 密码：abcd 普通用户可以自行注册
          </div>
        </div>
        <div class="signup" v-show="isSignUp">
          <h4 class='content_title'>智能实验室管理系统</h4>
          <form class="from">
            <input  placeholder='学号' type="text" v-model="signUp.username" maxlength="10" required="required">
            <input  placeholder='邮箱' type="email" v-model="signUp.email" maxlength="16" required="required">
            <input type="password" class="password" placeholder='密码' v-model="signUp.pwd" maxlength="16" required="required">
            <input type="password" class="password" placeholder='确认密码' v-model="signUp.pwdConf" maxlength="16" required="required">
            <div class="loginError" :class="{'signUpSuccess': signUp.isSignUpSuccess}" v-show="signUp.errShow">{{signUp.err}}</div>
            <div class='content_footer'>
              <button type="submit" class='login_btn fr' @click.stop.prevent="_signUp">注册</button>
              <a class='fl forget back' @click="hideSignUp">&#8592 返回登录</a>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div style="clear: both"></div>
  </div>
</template>
<script type="text/ecmascript-6">
  import {setCookie, getCookie} from '../../common/js/cookie.js'

  export default {
    data() {
      return {
        isSignUp: false,
        username: '',
        password: '',
        err: '',
        errShow: false,
        isLoginSuccess: false,
        signUp: {
          username: '',
          email: '',
          pwd: '',
          pwdConf: '',
          err: '',
          errShow: false,
          isSignUpSuccess: false
        }
      }
    },
    mounted() {
      if(getCookie('username')){
        this.$router.push('/admin');
      }
    },
    methods: {
      showSignUp() {
        this.isSignUp = true;
      },
      hideSignUp() {
        this.isSignUp = false;
      },
      _login() {
        if(!this.username || !this.password){
          this.err = ("请输入学号或密码");
          this.errShow = true;
        }else if (!this.isNumber(this.username)){
          this.err = ("请输入正确的学号（数字）");
          if(this.errShow !== true)  this.errShow = true;
        }else {
//            测试
          this.isLoginSuccess = true;
          this.err = "登录成功";
          this.errShow = true;
          setCookie('username',this.username,1000*60);
          setTimeout(function(){
            this.$router.push('/admin')
          }.bind(this),500);

          let data = {'username':this.username,'password':this.password};
//          /*接口请求*/
          this.$http.post('/url',data).then((res)=>{
            console.log(res);
            /*接口的传值是(-1,该用户不存在),(0,密码错误)，同时还会检测管理员账号的值*/
            if(res.data === -1){
              this.err = "该用户不存在";
              this.errShow = true;
            }else if(res.data === 0){
              this.err = "密码输入错误";
              this.errShow = true;
            }else if(res.data === 'admin'){
              this.$router.push('/admin');
            }else{
              this.isLoginSuccess = true;
              this.err = "登录成功";
              this.errShow = true;
              setCookie('username',this.username,1000*60);
              setTimeout(function(){
                this.$router.push('/admin')
              }.bind(this),500);
            }
          })

        }
      },
      _signUp() {
        if(!this.signUp.username || !this.signUp.email || !this.signUp.pwd || !this.signUp.pwdConf){
          this.signUp.err = ("请完成输入");
          if(this.signUp.errShow === false )this.signUp.errShow = true;
        }else if(!this.isNumber(this.signUp.username)){
          this.signUp.err = ("请输入正确的学号（纯数字）");
          if(this.signUp.errShow === false )this.signUp.errShow = true;
        }else if(!this.isEmail(this.signUp.email)){
          this.signUp.err = ("邮箱格式错误");
          if(this.signUp.errShow === false )this.signUp.errShow = true;
        }else if(this.signUp.pwd !== this.signUp.pwdConf){
          this.signUp.err = ("两次输入的密码不同");
          if(this.signUp.errShow === false )this.signUp.errShow = true;
        }else if(this.signUp.pwd.length < 6){
          this.signUp.err = ("密码不能少于6位");
          if(this.signUp.errShow === false )this.signUp.errShow = true;
        }else{
          this.signUp.err = "注册成功";
          this.signUp.isSignUpSuccess = true;
          this.signUp.errShow = true;
          this.username = this.signUp.username;
          this.password = '';
//          /*注册成功之后再跳回登录页*/
//          setTimeout(function(){
//            this.isSignUp = false;
//            this.errShow = false;
//            this.err = false;
//            this.signUp.isSignUpSuccess = false;
//            this.signUp.errShow = false;
//          }.bind(this),1000);

          let data = {'username':this.sign.username, 'email':this.sign.email, 'password':this.sign.pwd};
          this.$http.post('/url',data).then((res)=>{
            console.log(res);
            if(res.data === "ok"){
              this.signUp.err = "注册成功";
              this.signUp.isSignUpSuccess = true;
              this.signUp.errShow = true;
              this.username = this.signUp.username;
              this.password = '';
//          /*注册成功之后再跳回登录页*/
              setTimeout(function(){
                this.isSignUp = false;
                this.errShow = false;
                this.err = false;
                this.signUp.isSignUpSuccess = false;
                this.signUp.errShow = false;
              }.bind(this),1000);
            }
          })

        }
      }
    }
  }
</script>
<style scoped lang="stylus">
  input, button
    border-radius 4px 4px
    -webkit-appearance none
  input::-webkit-outer-spin-button,input::-webkit-inner-spin-button
    -webkit-appearance none !important
    margin: 0
  .fl
    float left
  .fr
    float right
  .index
    width 720px
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.05);
  .index, .content
    position absolute
    top 50%
    left 50%
    transform translate(-50%, -50%)
    .index_l
      border-top-left-radius 8px
      border-bottom-left-radius 8px
    .index_r
      position relative
      display inline-block
      background-color #fff
      border-top-right-radius 8px
      border-bottom-right-radius 8px
    .index_l,.index_r
      width 360px
      height 480px
      .content
       .content_title
        font-weight: bold
      .from
        margin 10px auto 40px auto
        input
          margin 10px 0
          height 36px
          width 250px
          border 1px solid #e6e6e6
          padding-left 8px
          outline none
          &:focus
            box-shadow 5px 6px 13px 0 rgba(0, 0, 0, 0.05)
        .password
          margin-bottom 10px
        .loginError
          display inline-block
          width 250px
          border 1px solid #faccc6
          padding 3px 0 3px 10px
          font-size 12px
          line-height 16px
          color #e4393c
          background #ffebeb
          border-radius 2px 2px
          &.loginSuccess,&.signUpSuccess
            border none
            color #fff
            background #5cb85c
      .content_footer
        width 250px
        height 36px
        line-height 36px
        margin-bottom 40px
        margin-top 10px
        .login_btn
          text-decoration none
          text-align center
          display inline-block
          width 100px
          height 36px
          font-size 14px
          line-height 36px
          background-color: #FF6154
          color #fff
        .forget
          color #aaa
          font-size 12px
          &.back
            cursor pointer
          &:hover
            color #565656
      .border
        border-top 1px dashed #aaa
      .text_center
        text-align center
        .reg
          margin-top 40px
          text-align center
          display inline-block
          color #aaa
          font-size 12px
          cursor pointer
          &:hover
            color #565656

  @media screen and (max-width: 767px) {
    img {
      display: none;
    }
    body {
     background-color: #fff;
    }

    .index {
     width: auto;
    }
 }
</style>
