<template>
  <div class="input_group equip_input" id="equip_input">
    <form>
      <div class="info">
        <span>设备编号:</span>
        <input type="text" v-model="edit.id">
      </div>
      <div class="info">
        <span>设备类型:</span>
        <input type="text" v-model="edit.type">
      </div>
      <div class="info">
        <span>设备型号:</span>
        <input type="text" placeholder="" v-model="edit.version">
      </div>
      <div class="info">
        <span>安装日期:</span>
        <input type="text" v-model="edit.install_date" placeholder="格式：2018-01-01">
      </div>
      <div class="info">
        <span>监控链接:</span>
        <input type="text" v-model="edit.rtmp">
      </div>
      <div class="info">
        <span>使用单位:</span>
        <input type="text" v-model="edit.company">
      </div>
      <div class="info addr-select">
        <span>单位地址:</span>
        <div data-toggle="distpicker" class="select-group">
          <select data-province="---- 选择省 ----" v-model="edit.co_addr.province" class="addr-province"></select>
          <select data-city="---- 选择市 ----" v-model="edit.co_addr.city" class="addr-city"></select>
          <select data-district="---- 选择区 ----" v-model="edit.co_addr.district" class="addr-district"></select>
        </div>
        <div class="addr-detail">
          <input type="text" placeholder="详细地址" v-model="edit.co_addr.detail">
        </div>
      </div>
      <div class="info">
        <span>单位联系人:</span>
        <input type="text" v-model="edit.co_linkman">
      </div>
      <div class="info">
        <span>联系人电话:</span>
        <input type="text" v-model="edit.co_tel">
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
          id: '',
          type: '',
          version: '',
          install_date: '',
          company: '',
          co_addr: {
            str: '',
            lng: '',
            lat: '',
            province: '',
            city: '',
            district: '',
            detail: ''
          },
          co_linkman: '',
          co_tel: '',
          rtmp: '',
          err: '',
          errShow: false,
          isSubmitSuccess: false
        }
      }
    },
    activated() {
      let scripts = document.getElementsByTagName('script');
      let src = 'https://cdn.staticfile.org/distpicker/2.0.0-rc/distpicker.min.js';
      for (let i=0;i<scripts.length;i++){
        if(scripts[i].src === src){
          document.body.removeChild(scripts[i]);
          break;
        }
      }
      let script = document.createElement("script");
      script.src = src;
      document.body.appendChild(script);
    },
    methods: {
      canSubmit() {
        this.edit.co_addr.str = this.edit.co_addr.province + this.edit.co_addr.city + this.edit.co_addr.district + this.edit.co_addr.detail;
        let myGeo = new BMap.Geocoder();
        myGeo.getPoint(this.edit.co_addr.str, point =>{
            if (point) {
              this.edit.co_addr.lng = point.lng;
              this.edit.co_addr.lat = point.lat;
            }
          },
          this.edit.co_addr.city);

        if (!this.edit.id || !this.edit.type || !this.edit.version || !this.edit.install_date || !this.edit.rtmp || !this.edit.company
          || !this.edit.co_addr.str || !this.edit.co_linkman || !this.edit.co_tel) {
          this.edit.errShow = true;
          this.edit.isSubmitSuccess = false;
          this.edit.err = "请完成输入";
        } else if (!this.isNumber(this.edit.id)) {
          this.edit.isSubmitSuccess = false;
          this.edit.errShow = true;
          this.edit.err = "请输入正确的编号（纯数字）";
        } else if (!this.isDate(this.edit.install_date)) {
          this.edit.isSubmitSuccess = false;
          this.edit.errShow = true;
          let myDate = new Date;
          let rightFormat = myDate.getFullYear() + '-' + myDate.addZero(myDate.getMonth() + 1) + '-' + myDate.addZero(myDate.getDate());
          this.edit.err = `请输入正确的日期（如：${rightFormat}）`;
        } else {
          let data = {
            'operation': 'inputs',
            'detail': 'input',
            'id': this.edit.id,
            'type': this.edit.type,
            'version': this.edit.version,
            'install_date': this.edit.install_date,
            'rtmp': this.edit.rtmp,
            'company': this.edit.company,
            'co_addr': this.edit.co_addr.str,
            'lng': this.edit.co_addr.lng,
            'lat': this.edit.co_addr.lat,
            'co_linkman': this.edit.co_linkman,
            'co_tel': this.edit.co_tel
          };
//            'admin': 'person'
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
              setTimeout( () => {
                this.edit.isSubmitSuccess = false;
                this.edit.errShow = false;
                this.edit.err = '';
              },2000)
            } else if (res.body == 0) {
              this.edit.isSubmitSuccess = false;
              this.edit.errShow = true;
              this.edit.err = '提交失败，设备编号已存在';
            }
          });
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
    margin: 0!important;
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

  .equip_input .info span{
    width: 80px!important;
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

  .equip_input #error.error_reg {
    margin-left: 0!important;
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
  .info.addr-select select{
    height: 36px;
    border-radius: 4px;
    margin-right: 5px;
    border: solid 1px #e6e6e6!important;
  }
  .info.addr-select .select-group,.info.addr-select .addr-detail{
    display: inline;
  }

  @media screen and (max-width: 991px) and (min-width: 550px){
    .info.addr-select .addr-detail{
      display: block;
    }
    .info.addr-select .addr-detail input{
      margin-left: 80px!important;
      margin-top: 10px!important;
    }
  }
  @media screen and (max-width: 550px) {
    .info.addr-select .addr-detail{
      display: block;
    }
    .info.addr-select .addr-detail input , .addr-city , .addr-district{
      display: block;
      margin-left: 80px!important;
      margin-top: 10px!important;
    }
  }
  @media screen and (max-width: 437px) {
    .info.addr-select .addr-detail{
      display: block;
    }
    .info.addr-select .addr-detail input , .addr-province, .addr-city, .addr-district{
      display: block;
      margin-left: 0!important;
      margin-top: 10px!important;
    }
  }
</style>
