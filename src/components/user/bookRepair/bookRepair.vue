<template>
  <div class="bookRepair">
    <div class="col-lg-1 col-md-1"></div>
    <div class="col-lg-10  col-md-10 auto-padding">
      <div class="input_group equip_input">
        <form>
          <div class="info">
            <span>报修人:</span>
            <input type="text" v-model="person">
          </div >
          <div class="info">
            <span>手机号码:</span>
            <input type="text" v-model="tel">
          </div >
          <div class="info">
            <span>设备编号:</span>
            <input type="text" v-model="id">
          </div>
          <div class="textarea info" >
            <span>故障描述:</span>
            <textarea cols="30" rows="10" v-model="desc" placeholder="150字以内"></textarea>
          </div>
          <div class="info err_info" v-show="errShow">
            <span></span>
            <div id="error" :class="{'submitSuccess': isSubmitSuccess}" class="error_reg">{{err}}</div>
          </div>
          <div class="info">
            <span></span>
            <input type="submit" class='submit' value="提交" @click.stop.prevent="canSubmit()">
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script type="text/ecmascript-6">
  export default {
    data() {
      return {
        person: '',
        id: '',
        tel: '',
        desc: '',
        err: '',
        errShow: false,
        isSubmitSuccess: false
      }
    },
    methods: {
      isTel(num) {
        if (!this.isNumber(num)) {
          return false;
        }else {
          let tel = num.trim();
          return tel.length === 11;
        }
      },
      canSubmit() {
//        console.log(this.isTel(this.tel));
//        console.log('id是不是数字'+this.isNumber(this.id));
        if (!this.id || !this.tel || !this.desc || !this.person) {
          this.errShow = true;
          this.isSubmitSuccess = false;
          this.err = '请完成输入';
        }else if ( !this.isNumber(this.id) ) {
          this.errShow = true;
          this.isSubmitSuccess = false;
          this.err = '请输入正确的设备编号';
        }else if ( !this.isTel(this.tel) ) {
          this.errShow = true;
          this.isSubmitSuccess = false;
          this.err = '请输入正确的手机号码';
        }else if (this.desc.length > 150) {
          this.errShow = true;
          this.isSubmitSuccess = false;
          this.err = '故障描述限150字以内';
        }else{
//          this.errShow = true;
//          this.isSubmitSuccess = true;
//          this.err = '提交成功';

          let data = { 'operation': 'insert','id': this.id, 'tel': this.tel, 'person': this.person, 'desc': this.desc };
          this.$http.post('./php/book/book.php', data, {emulateJSON: true}).then((res) => {
            console.log(res);
            if(res.body === "报修成功"){
              this.errShow = true;
              this.isSubmitSuccess = true;
              this.err = '报修成功';

              this.id = '';
              this.tel = '';
              this.person = '';
              this.desc = '';
            }else if(res.body === "未找到编号为"+ this.id +"的设备"){
              this.errShow = true;
              this.isSubmitSuccess = false;
              this.err = "未找到编号为"+ this.id +"的设备";
            }else {
              this.errShow = true;
              this.isSubmitSuccess = false;
              this.err = '提交失败';
            }
          });
        }
      }
    }
  }
</script>
<style lang="stylus" scoped>
  .bookRepair
    .input_group
      .info
        input
          /*border 1px solid #949494*/
        .submitSuccess
          border none!important
          color #fff!important
          background #5cb85c!important
    .textarea
      span
        vertical-align top
      textarea
        background transparent
        width 60%
        min-width 240px
        border-radius 4px 4px
        margin 0 0 0 10px
        outline none
        padding-left 8px
        /*border 1px solid #949494*/
        height 200px
        font-size 14px
</style>
