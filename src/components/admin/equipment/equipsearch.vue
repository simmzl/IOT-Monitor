<template>
  <div class='equip_search_all'>
    <div class='equip_search'>
      <input type="text" id='equip_search' placeholder='设备编号' v-model="queryId" @keyup.enter="query"><span @click="query"><i class="fa fa-search fa-lg"></i></span>
    </div>
    <div class='table-responsive' v-show="!!queryRes.id">
      <table class='table table-striped table-bordered table-hover'>
        <thead>
        <tr>
          <th>设备编号</th>
          <th>设备类型</th>
          <th>设备型号</th>
          <th>安装日期</th>
          <th>使用单位</th>
          <th>单位地址</th>
          <th>单位联系人</th>
          <th>联系人电话</th>
          <th class="equip-status">设备状态</th>
          <th>监控链接</th>
          <th class="operation">操作</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td>{{queryRes.id}}</td>
          <td>{{queryRes.type}}</td>
          <td>{{queryRes.version}}</td>
          <td>{{queryRes.install_date}}</td>
          <td>{{queryRes.company}}</td>
          <td>{{queryRes.co_addr}}</td>
          <td>{{queryRes.co_linkman}}</td>
          <td>{{queryRes.co_tel}}</td>
          <td><span>{{queryRes.status}}</span></td>
          <td>
            <span v-if="!queryRes.rtmp">无</span>
            <button type="button" data-toggle="modal" data-target="#showRTMPDetail" class="btn btn-primary btn-xs" v-if="!!queryRes.rtmp" @click="showRTMPAddr(queryRes.rtmp)">查看</button>
          </td>
          <td class="operation-td">
            <button type="button" data-toggle="modal" data-target="#changeEquipInfo" class="btn btn-warning btn-xs operation-change" @click="changeEquipInfo(queryRes)">修改</button>
            <button type="button" class="btn btn-danger btn-xs" @click="deleteItem">删除</button>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
    <div v-show="!queryRes.id" class="deleteWarn">{{resWarn}}</div>
    <hr>
    <div class="equip_all">
      <input type="checkbox" class="showAllInput" v-model="isShowAll" @click="loadAllData"><span>显示所有设备</span>
    </div>
    <div class='table-responsive' v-show="isShowAll">
      <table class='table table-striped table-bordered table-hover'>
        <thead>
        <tr>
          <th>设备编号</th>
          <th>设备类型</th>
          <th>设备型号</th>
          <th>安装日期</th>
          <th>使用单位</th>
          <th>单位地址</th>
          <th>单位联系人</th>
          <th>联系人电话</th>
          <th class="equip-status">设备状态</th>
          <th>监控链接</th>
          <th class="operation-td nowrap">操作</th>
        </tr>
        </thead>
        <tbody>
        <tr  v-if="!!equipData[0]" v-for="equip in equipData">

          <td>{{equip.id}}</td>
          <td>{{equip.type}}</td>
          <td>{{equip.version}}</td>
          <td>{{equip.install_date}}</td>
          <td>{{equip.company}}</td>
          <td>{{equip.co_addr}}</td>
          <td>{{equip.co_linkman}}</td>
          <td>{{equip.co_tel}}</td>

          <td><span class='pointer'>{{equip.status}}</span></td>
          <td>
            <span v-if="!equip.rtmp">无</span>
            <button type="button" data-toggle="modal" data-target="#showRTMPDetail" class="btn btn-primary btn-xs" v-if="!!equip.rtmp" @click="showRTMPAddr(equip.rtmp)">查看</button>
          </td>
          <td class="operation-td nowrap">
            <button type="button" data-toggle="modal" data-target="#changeEquipInfo" class="btn btn-warning btn-xs operation-change" @click="changeEquipInfo(equip)">修改</button>
            <button type="button" class="btn btn-danger btn-xs" @click="removeItem(equip)">删除</button>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
    <div class="modal fade" id="showRTMPDetail" tabindex="-1" role="dialog" aria-labelledby="showRTMPDetail" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="showDetailLabel">监控链接：</h4>
          </div>
          <div class="modal-body">
            <span>{{selectedRtmp}}</span>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">关闭</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="changeEquipInfo" tabindex="-1" role="dialog" aria-labelledby="changeEquipInfo" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">修改设备信息：</h4>
          </div>
          <div class="modal-body">
            <form class="input_group">
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
                <span>原地址:</span>
                <input type="text" v-model="edit.co_addr.str" class="origin-addr" readonly="readonly">
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
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" ref="closeModal">关闭</button>
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
        queryId: '',
        queryRes: {
          type: Object
        },
        equipData:{
          type: Object
        },
        resWarn: '',
        isShowAll: false,
        selectedRtmp: '',
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
    methods: {
      loadAllData() {
        this.$http.post('./php/equipments/equipments.php', {'operation': 'queryAll'},{emulateJSON: true}).then((res) => {
          if (res.body != 0) {
            this.equipData = res.body;
          }
        });
      },
      query() {
        if(this.queryId === '') {
          this.resWarn = '请输入设备编号...';
          return;
        }
        let data = {'operation': 'query', 'queryid': this.queryId};
        this.$http.post('./php/equipments/equipments.php',data,{emulateJSON: true}).then((res) => {
          if (!!res.body.id) {
            this.queryRes = res.body;
          }else {
            this.queryRes = '';
            this.resWarn = '未找到设备...';
          }
        });
      },
      deleteItem() {
        let conf = confirm("确认删除？");
        if(conf) {
          let data = { 'operation':'delete', 'deleteEquipId': this.queryRes.id};
          this.$http.post('./php/equipments/equipments.php',data,{emulateJSON:true}).then((res) => {
            if(res.body === '删除成功'){
              this.queryRes = '';
            }else {
              alert('删除失败');
            }
          });
        }
      },
      removeItem(item) {
        let conf = confirm("确认删除？");
        if(conf) {
          let data = { 'operation':'delete', 'deleteEquipId': item.id};
          this.$http.post('./php/equipments/equipments.php',data,{emulateJSON:true}).then((res) => {
            if(res.body === '删除成功'){
              let index = this.equipData.indexOf(item);
              this.equipData.splice(index,1);
            }else {
              alert('删除失败');
            }
          });
        }
      },
      showRTMPAddr(item) {
        this.selectedRtmp = item;
      },
      changeEquipInfo(obj) {
        let scripts = document.getElementsByTagName('script');
        for (let i=0;i<scripts.length;i++){
          if(scripts[i].src === "https://cdn.staticfile.org/distpicker/2.0.0-rc/distpicker.min.js"){
            document.body.removeChild(scripts[i]);
            break;
          }
        }
        let script = document.createElement("script");
        script.src = "https://cdn.staticfile.org/distpicker/2.0.0-rc/distpicker.min.js";
        document.body.appendChild(script);

        for(let key in obj) {
          if(obj.hasOwnProperty(key)){
            this.edit[key] = obj[key] ;
          }
        }
        this.edit.old_id = obj.id;
        this.edit.co_addr = {};
        this.edit.co_addr.province = '';
        this.edit.co_addr.city = '';
        this.edit.co_addr.district = '';
        this.edit.co_addr.detail = '';

        this.edit.co_addr.str = obj.co_addr;
      },
      canSubmit() {
        let tmp = this.edit.co_addr.province + this.edit.co_addr.city + this.edit.co_addr.district + this.edit.co_addr.detail;
        if (!!tmp && !!this.edit.co_addr.province && !!this.edit.co_addr.city && !!this.edit.co_addr.district){
          this.edit.co_addr.str = tmp;
        }
        let myGeo = new BMap.Geocoder();
        myGeo.getPoint(this.edit.co_addr.str, point =>{
            if (point) {
              this.edit.co_addr.lng = point.lng;
              this.edit.co_addr.lat = point.lat;

              if (!this.edit.co_addr.lng || !this.edit.co_addr.lat) {
                this.edit.errShow = true;
                this.edit.isSubmitSuccess = false;
                this.edit.err = "获取坐标失败，请重试";
                return;
              }

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
                  'detail': 'changeInfo',
                  'old_id': this.edit.old_id,
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
                this.$http.post('./php/equipments/equipments.php', data, {emulateJSON: true}).then((res) => {
                  if (res.body == 1) {
                    this.edit.isSubmitSuccess = true;
                    this.edit.errShow = true;

                    this.edit.err = '提交成功';
                    this.loadAllData();
                    setTimeout( () => {
                      this.edit.isSubmitSuccess = false;
                      this.edit.errShow = false;
                      this.edit.err = '';
                      this.$refs.closeModal.click();
                    },1000)
                  } else if (res.body == 0) {
                    this.edit.isSubmitSuccess = false;
                    this.edit.errShow = true;
                    this.edit.err = '提交失败，设备编号已存在';
                  }
                });
              }
            }else{
              this.edit.isSubmitSuccess = false;
              this.edit.errShow = true;
              this.edit.err = '获取坐标失败，请重试';
            }
          },
          this.edit.co_addr.city);
      }
    }
  }
</script>
<style>
  .deleteWarn{
    color: #e4393c;
  }
  .equip_search_all {
    padding: 30px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
  }
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
  .equip_all{
    margin-bottom: 20px;
  }
  table a{
    color: #2277da;
  }
  #collapseOne table,#collapseTwo table{
    border: none;
    margin-bottom: 0;
  }
  .showAllInput{
    -webkit-appearance: checkbox;
    vertical-align: top;
  }
  .equip_search_all form .info span{
    width: 80px!important;
  }
  .equip_search_all form #error.error_reg{
    margin-left: 0!important;
  }

  @media  screen and ( min-width: 992px) {
    .equip_search_all form .addr-detail{
      margin-top: 10px;
      display: block!important;
      margin-left: 80px;
    }
  }
  @media  screen and ( max-width: 991px) {
    .equip_search_all{
      padding: 20px;
    }
  }
  /*.equip-status{*/
    /*width: 78px;*/
  /*}*/
  /*.operation{*/
    /*width: 98px;*/
  /*}*/
  .operation-td{
    font-size: 0;
  }
  .operation-change{
    margin-right: 5px;
  }
  table th,.nowrap{
    white-space: nowrap!important;
  }
  .origin-addr{
    border: none!important;
  }
</style>
