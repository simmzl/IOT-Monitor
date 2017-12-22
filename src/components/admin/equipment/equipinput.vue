<template>
  <div class="input_group equip_input" id="equip_input">
    <form action="">
      <div class="info">
        <span>设备名称:</span>
        <input type="text" v-model="edit.name">
      </div>
      <div class="info">
        <span>设备编号:</span>
        <input type="text" v-model="edit.id">
      </div>
      <div class="info">
        <span>生产日期:</span>
        <input type="text" placeholder="格式：19700101" v-model="edit.date">
      </div>
      <div class="info">
        <span>供应商:</span>
        <input type="text" v-model="edit.vendor">
      </div>
      <div class="info">
        <span>负责人:</span>
        <input type="text" v-model="edit.person">
      </div>
      <div class="info err_info" v-show="edit.errShow">
        <span></span>
        <div id="error" :class="{'submitSuccess': edit.isSubmitSuccess}" class="error_reg">{{edit.err}}</div>
      </div>
      <div class="info">
        <span style="font-size: 0"></span>
        <input type="submit" class='submit' id="submit" @click.stop.prevent="canSubmit" value="提交">
      </div>
    </form>
  </div>
</template>
<script type="text/ecmascript-6">
  export default {
    data() {
      return {
        edit: {
          name: '',
          id: '',
          date: '',
          vendor: '',
          person: '',
          err: '',
          errShow: false,
          isSubmitSuccess: false
        }
      }
    },
    computed: {},
    methods: {
      canSubmit() {
        if (!this.edit.id || !this.edit.name || !this.edit.date || !this.edit.vendor || !this.edit.person) {
          this.edit.errShow = true;
          this.edit.isSubmitSuccess = false;
          this.edit.err = "请完成输入";
          return false;
        } else if (!this.isNumber(this.edit.id)) {
          this.edit.isSubmitSuccess = false;
          this.edit.errShow = true;
          this.edit.err = "请输入正确的编号（纯数字）";
          return false;
        } else if (!this.isDate(this.edit.date)) {
          this.edit.isSubmitSuccess = false;
          this.edit.errShow = true;
          let myDate = new Date;
          let rightFormat = myDate.getFullYear() + '' + (myDate.getMonth() + 1) + '' + myDate.addZero(myDate.getDate());
          this.edit.err = `请输入正确的日期（如：${rightFormat}）`;
          return false;
        } else {
          let data = {'operation': 'inputs', 'name': this.edit.name, 'id': this.edit.id, 'date': this.edit.date, 'vendor': this.edit.vendor, 'admin': 'person'};
          this.$http.post('./php/equipments/equipments.php', data, {emulateJSON: true}).then((res) => {
            if (res.body == 1) {
              this.edit.isSubmitSuccess = true;
              this.edit.errShow = true;
//              清空输入
//              this.edit.id = '';
//              this.edit.name = '';
//              this.edit.date = '';
//              this.edit.vendor = '';
//              this.edit.person = '';

              this.edit.err = '提交成功';
            } else if (res.body == 0) {
              this.edit.isSubmitSuccess = false;
              this.edit.errShow = true;
              this.edit.err = '提交失败，设备编号已存在';
            }
          });
          return true;
        }
      }
    }
  }
</script>
<style>
  .equip_input {
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
  }

  .input_group .info {
    margin: 20px;
    font-size: 0;
  }

  .input_group span.edit_desc {
    width: auto;
    font-weight: normal;
  }

  .input_group input {
    border-radius: 4px 4px;
    margin: 0 0 0 10px;
    height: 36px;
    width: 240px;
    border: 1px solid #e6e6e6;
    outline: none;
    padding-left: 8px;
    font-size: 14px;
  }

  textarea {
    width: 60%;
    min-width: 240px;
    border-radius: 4px 4px;
    margin: 0 0 0 10px;
    outline: none;
    padding-left: 8px;
    border: 1px solid #e6e6e6;
  }

  .input_group span {
    display: inline-block;
    width: 65px;
    font-weight: bold;
    font-size: 14px;
  }

  #error.error_reg {
    display: inline-block;
    box-sizing: border-box;
    width: 240px;
    height: 24px;
    border: 1px solid #faccc6;
    padding: 3px 10px;
    margin-left: 10px;
    font-size: 12px;
    line-height: 18px;
    color: #e4393c;
    background: #ffebeb;
    border-radius: 2px 2px;
  }

  .err_info.info {
    margin-top: -15px;
    margin-bottom: -15px;
  }

  .submitSuccess {
    border: none!important;
    color: #fff!important;
    background: #5cb85c!important;
  }
</style>
