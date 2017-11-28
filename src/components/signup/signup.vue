<template>
  <div class="main_center">
    <img class='fl mask_l' src="../../../static/img/art.png">
    <div class="fr mask_r">
      <div class='mask_center reg_mask'>
        <h4 class='mask_title'>智能实验室管理系统</h4>
        <form action="../admin.php?controller=index&method=register" method="post">
          <span>学号:</span>
          <input class='reg_input' type="text" id="username" name="username" maxlength="10" required="required">
          <span>邮箱:</span>
          <input class='reg_input' type="email" id="email" name="email" maxlength="100" required="required">
          <span>密码:</span>
          <input class='reg_input' type="password" name="password" id="password" maxlength="16" required="required">
          <span>确认密码:</span>
          <input class='reg_input' type="password" id="password_conf" maxlength="16" required="required">
          <div id="error" class="error_reg"></div>
          <div class='reg_mask_footer'>
            <button type="submit" class='fr reg_btn' id='reg_btn'>注册</button>
            <a class='fl back_Login' href='../index.php'>&#8592 返回登录</a>
          </div>
        </form>
      </div>
    </div>
    <div style="clear: both"></div>
  </div>
</template>
<script type="text/ecmascript-6">
  export default {}
</script>
<style scoped>
  @import "../../common/css/signinUp.css";
</style>
