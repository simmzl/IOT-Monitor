<template>
  <div class="main_center">
    <img class='fl mask_l' src="../../../static/img/art.png">
    <div class="fr mask_r">
      <div class='mask_center'>
        <h4 class='mask_title'>智能实验室管理系统</h4>
        <form action="http://movie.simmzl.cn/monitor/admin.php?controller=admin&method=login" method="post" class="from">
          <input  placeholder='学号' type="text" id="username" name="username" maxlength="10" required="required">
          <input type="password" placeholder='密码' id='password' name="password" maxlength="16" required="required">
          <div></div>
          <div class='mask_footer'>
            <button type="submit" class='login_btn fr' id="loginButton">登录</button>
            <a class='fl forget' href='#'>忘记密码？</a>
          </div>
        </form>
        <div class="border"></div>
        <div class="text_center">
          <a class='reg' href="./tpl/register.html">没有账号？点我注册</a>
        </div>
        <div style="font-size: 12px; color:#aaaaaabd;margin-top: 10px">
          测试：管理员账号：1495 密码：abcd 普通用户可以自行注册
        </div>
      </div>
    </div>
    <div style="clear: both"></div>
  </div>
</template>
<script type="text/ecmascript-6">
  import {setCookie, getCookie} from '../../common/js/cookie.js'

  export default {
    mounted() {
      if(getCookie('username')){
        this.$router.push('/home');
      }
    },
    methods() {

    }
  }
</script>
<style>
 @import "../../common/css/signinUp.css";
</style>
