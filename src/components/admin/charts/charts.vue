<template>
  <div class="charts">
    <!--左侧导航区-->
    <div class="col-lg-3 col-md-3 auto-padding">
      <div class="dataChoose paddingWrapper" >
        <div class="btn-group">
          <a class="dropdown-toggle a_title" data-toggle="dropdown"><span><i class='glyphicon glyphicon-cog selectById'></i></span>选择设备</a>
          <ul class="dropdown-menu" role="menu">
            <li @click.stop="">
              <a class="historyActive">请选择设备：</a>
              <div class="dropSelectsId">
                <select v-model="selectedId" v-if="allUids">
                  <option v-for="id in allUids" :value="id">{{id}}</option>
                </select>
                <button type="button" class="btn btn-primary btn-xs button-font" @click="getDataByDateAndEquip">确定</button>
              </div>
            </li>
          </ul>
        </div>
        <div class="btn-group">
          <a  class="dropdown-toggle a_title" data-toggle="dropdown" style='width: 100%'>
            <span><i class='glyphicon glyphicon-calendar history'></i></span>
            历史数据 </a>
          <ul class="dropdown-menu" role="menu" style="min-width: 300px">
            <li id="today" class="today" @click="today"><a class="pointer" :class="{'historyActive': isToday}">今天</a></li>
            <li id="oneDay" @click="stop">
              <a href="javascript:;">历史日期：</a>
              <div class="dropSelects">
                <select id="year" v-model="selectYear">
                  <option v-for="year in setYear" :value="year">{{year}}</option>
                </select>
                <span class="dropLabel">年</span>
                <select id="moth" v-model="selectMonth">
                  <option v-for="month in 12" :value="month">{{month}}</option>
                </select>
                <span class="dropLabel">月</span>
                <select id="day" v-model="selectDay">
                  <option v-for="day in setDay" :value="day">{{day}}</option>
                </select>
                <span class="dropLabel">日</span>
                <button type="button" id="query" class="btn btn-primary btn-xs button-font" @click="pastDay">确定</button>
              </div>
            </li>
          </ul>
        </div>
        <a class="realTimeBtn a_title btn-group" :class="{'im':im}" @click="turnIm" title="每三分钟自动刷新">
          <span><i class='glyphicon glyphicon-time' ></i></span>实时数据</a>
        <div class="btn-group chart_type">
          <a class="dropdown-toggle a_title" data-toggle="dropdown"><span><i class='glyphicon glyphicon-stats'></i></span>图表类型</a>
          <ul class="dropdown-menu" role="menu" >
            <li><a class="pointer series0" @click="turnSeriesType('line',$event)" :class="{aActive: this.chartData.seriesType === 'line'}">折线图</a></li>
            <li><a class="pointer series1" @click="turnSeriesType('bar',$event)" :class="{'aActive': this.chartData.seriesType === 'bar'}">柱形图</a></li>
          </ul>
        </div>
      </div>

    </div>
    <!--数据展示区-->
    <div class="col-lg-9 col-md-9 no-padding">
      <div class="no-data paddingWrapper" v-show="noEquipment">您当前账号尚无设备绑定，请联系管理员绑定设备。</div>
      <div class="no-data paddingWrapper" v-show="!noEquipment && noData">
        暂无数据...
        <div class='text-center pre_next'>
           <span @click="nextOrPastDay('past')">
             <span class='pre_day'>上一天</span>
             <span><i class='glyphicon glyphicon-chevron-left'></i></span>
           </span>
          <span @click="nextOrPastDay('next')">
              <span><i class='glyphicon glyphicon-chevron-right'></i></span>
              <span class='next_day'>下一天</span>
            </span>
        </div>
      </div>
      <!--数据展示-->
      <div id="showData" v-show="!noData">
        <!--温度数据-->
        <div class="chart-wrapper paddingWrapper">
          <div id="temperature" class="temperature"></div>
          <div class='text-center pre_next'>
           <span @click="nextOrPastDay('past')">
             <span class='pre_day'  >上一天</span>
             <span><i class='glyphicon glyphicon-chevron-left'></i></span>
           </span>
           <span @click="nextOrPastDay('next')">
              <span><i class='glyphicon glyphicon-chevron-right'></i></span>
              <span class='next_day' >下一天</span>
            </span>
          </div>
        </div>
        <hr>
        <!--湿度数据-->
        <div class="chart-wrapper paddingWrapper">
          <div id="humidity" class="humidity"></div>
          <div class='text-center pre_next'>
            <span @click="nextOrPastDay('past')">
             <span class='pre_day'>上一天</span>
             <span><i class='glyphicon glyphicon-chevron-left'></i></span>
            </span>
            <span @click="nextOrPastDay('next')">
              <span><i class='glyphicon glyphicon-chevron-right'></i></span>
              <span class='next_day' >下一天</span>
            </span>
          </div>
        </div>
        <hr>
        <!--风速数据-->
        <div class="chart-wrapper paddingWrapper">
          <div id="wind" class="wind"></div>
          <div class='text-center pre_next'>
            <span @click="nextOrPastDay('past')">
             <span class='pre_day'  >上一天</span>
             <span><i class='glyphicon glyphicon-chevron-left'></i></span>
            </span>
            <span @click="nextOrPastDay('next')">
              <span><i class='glyphicon glyphicon-chevron-right'></i></span>
              <span class='next_day'>下一天</span>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script type="text/ecmascript-6">
  import echarts from 'echarts';

  export default {
    data() {
      return {
        selectedId: '',
        allUids: [],
        demoData: {
          type: Array
        },
        isToday: true,
//        实时状态
        im: false,
//        定时器
        timer: null,
//        下一天上一天选择状态(1/-1)
        nextOrPast: 0,
//        图标属性
        chartData: {
          name: '',
          subText: '',
          myStartValue: '',
          seriesType: 'line'
        },
//        所选日期
        selectYear: '',
        selectMonth: '',
        selectDay: '',
        noData: false,
        noEquipment: false
      }
    },
    computed: {
      temperature() {
        return {
          title: {
            text: "温度(℃)",
            subtext: this.chartData.subText
          },
          tooltip: {
            trigger: 'axis'
          },
          xAxis: {
//                获取json中第二个数据作为横坐标
            data: this.demoData.map(function (item) {
              return new Date(item.date * 1000).toLocaleString();
            })
          },
          yAxis: {
            splitLine: {
              show: true
            }
          },
          toolbox: {
            left: 'center',
            feature: {
              dataZoom: {
                yAxisIndex: 'none'
              },
              restore: {},
              saveAsImage: {}
            }
          },
          dataZoom: [{
            startValue: this.chartData.myStartValue
          }, {
            type: 'inside'
          }, {
            handleIcon: 'M10.7,11.9v-1.3H9.3v1.3c-4.9,0.3-8.8,4.4-8.8,9.4c0,5,3.9,9.1,8.8,9.4v1.3h1.3v-1.3c4.9-0.3,8.8-4.4,8.8-9.4C19.5,16.3,15.6,12.2,10.7,11.9z M13.3,24.4H6.7V23h6.6V24.4z M13.3,19.6H6.7v-1.4h6.6V19.6z',
            handleSize: '80%',
            handleStyle: {
              color: '#fff',
              shadowBlur: 3,
              shadowColor: 'rgba(0, 0, 0, 0.6)',
              shadowOffsetX: 2,
              shadowOffsetY: 2
            }
          }],
          visualMap: {
            top: 10,
            right: 10,
            pieces: [
              {
                lte: 0,
                color: '#3FC221'
              },
              {
                gt: 0,
                lte: 10,
                color: '#096'
              }, {
                gt: 10,
                lte: 25,
                color: '#ffde33'
              }, {
                gt: 25,
                lte: 28,
                color: '#ff9933'
              }, {
                gte: 28,
                color: 'red'
              }
            ]
          },
          series: {
            type: this.chartData.seriesType,
            data: this.demoData.map(function (item) {
              return item.temperature;
            })
          }
        }
      },
      wind() {
        return {
          title: {
            text: "风速(m/s)",
            subtext: this.chartData.subText
          },
          tooltip: {
            trigger: 'axis'
          },
          xAxis: {
//                获取json中第二个数据作为横坐标
            data: this.demoData.map(function (item) {
              return new Date(item.date * 1000).toLocaleString();
            })
          },
          yAxis: {
            splitLine: {
              show: true
            }
          },
          toolbox: {
            left: 'center',
            feature: {
              dataZoom: {
                yAxisIndex: 'none'
              },
              restore: {},
              saveAsImage: {}
            }
          },
          dataZoom: [{
            startValue: this.chartData.myStartValue
          }, {
            type: 'inside'
          }, {
            handleIcon: 'M10.7,11.9v-1.3H9.3v1.3c-4.9,0.3-8.8,4.4-8.8,9.4c0,5,3.9,9.1,8.8,9.4v1.3h1.3v-1.3c4.9-0.3,8.8-4.4,8.8-9.4C19.5,16.3,15.6,12.2,10.7,11.9z M13.3,24.4H6.7V23h6.6V24.4z M13.3,19.6H6.7v-1.4h6.6V19.6z',
            handleSize: '80%',
            handleStyle: {
              color: '#fff',
              shadowBlur: 3,
              shadowColor: 'rgba(0, 0, 0, 0.6)',
              shadowOffsetX: 2,
              shadowOffsetY: 2
            }
          }],
          visualMap: {
            top: 10,
            right: 10,
            pieces: [
              {
                gt: 0,
                lte: 4,
                color: '#096'
              }, {
                gt: 4,
                lte: 8,
                color: '#ffde33'
              }, {
                gt: 8,
                lte: 12,
                color: '#ff9933'
              }, {
                gte: 12,
                color: 'red'
              }
            ]
          },
          series: {
            type: this.chartData.seriesType,
            data: this.demoData.map(function (item) {
              return item.wind_speed;
            })
          }
        }
      },
      humidity() {
        return {
          title: {
            text: "湿度(%)",
            subtext: this.chartData.subText
          },
          tooltip: {
            trigger: 'axis'
          },
          xAxis: {
//                获取json中第二个数据作为横坐标
            data: this.demoData.map(function (item) {
              return new Date(item.date * 1000).toLocaleString();
            })
          },
          yAxis: {
            splitLine: {
              show: true
            }
          },
          toolbox: {
            left: 'center',
            feature: {
              dataZoom: {
                yAxisIndex: 'none'
              },
              restore: {},
              saveAsImage: {}
            }
          },
          dataZoom: [{
            startValue: this.chartData.myStartValue
          }, {
            type: 'inside'
          }, {
            handleIcon: 'M10.7,11.9v-1.3H9.3v1.3c-4.9,0.3-8.8,4.4-8.8,9.4c0,5,3.9,9.1,8.8,9.4v1.3h1.3v-1.3c4.9-0.3,8.8-4.4,8.8-9.4C19.5,16.3,15.6,12.2,10.7,11.9z M13.3,24.4H6.7V23h6.6V24.4z M13.3,19.6H6.7v-1.4h6.6V19.6z',
            handleSize: '80%',
            handleStyle: {
              color: '#fff',
              shadowBlur: 3,
              shadowColor: 'rgba(0, 0, 0, 0.6)',
              shadowOffsetX: 2,
              shadowOffsetY: 2
            }
          }],
          visualMap: {
            top: 10,
            right: 10,
            pieces: [
              {
                lte: 10,
                color: '#3FC221'
              },
              {
                gt: 10,
                lte: 30,
                color: '#096'
              }, {
                gt: 30,
                lte: 50,
                color: '#ffde33'
              }, {
                gt: 50,
                lte: 70,
                color: '#ff9933'
              }, {
                gte: 70,
                color: 'red'
              }
            ]
          },
          series: {
            type: this.chartData.seriesType,
            data: this.demoData.map(function (item) {
              return item.humidity;
            })
          }
        }
      },
//      设置年月日选择器表单
      setYear() {
        let myDate = new Date;
        let result=[];
        let nowYear = myDate.getFullYear();
        for (let i=2017;i<=nowYear;i++){
          result.push(i);
        }
        this.selectYear = nowYear;
        return result;
      },
      setDay: {
        get() {
          let specDay,result=[],secMon = this.selectMonth;
          let specVal = [1, 3, 5, 7, 8, 10, 12];
          let isSpecDay = !!specVal.find(function (item) {
            return item === secMon;
          });
          if (isSpecDay) {
            specDay = 31;
          } else if (secMon === 2) {
            !this.checkYear(this.selectYear)?specDay = 28:specDay = 29;
          } else {
            specDay = 30;
          }
          for (let i=1;i<=specDay;i++){
            result.push(i);
          }
          return result;
        }
      }
    },
    created() {
      this.getUidList();
    },
    activated() {
      this.loadScriptOnce('http://lab.simmzl.cn/player/cyberplayer.js');
    },
    deactivated() {
      this.im = false;
      this.clearAllTimer();
    },
    methods: {
//      初始化图表
      myInit() {
        let temperature = echarts.init(document.getElementById('temperature'));
        let humidity = echarts.init(document.getElementById('humidity'));
        let wind = echarts.init(document.getElementById('wind'));
        temperature.setOption(this.temperature);
        humidity.setOption(this.humidity);
        wind.setOption(this.wind);
      },
      addZero(num) {
        if (num < 10) {
          return num = "0" + num;
        } else {
          return num;
        }
      },
      stop(e) {
        e.stopPropagation();
      },
//      是否为闰年
      checkYear(val) {
        let yearVal = parseInt(val);
        return (yearVal % 100 === 0 && yearVal % 400 === 0)||(yearVal % 4 === 0);
      },
//      改变图标类型
      turnSeriesType(type,e) {
        if(type === this.chartData.seriesType){
          return e.stopPropagation();
        }else {
          if (this.chartData.seriesType === 'line') {
            this.chartData.seriesType = 'bar';
            this.myInit();
          } else {
            this.chartData.seriesType = 'line';
            this.myInit();
          }
        }
      },
//      获取所有设备id列表
      getUidList() {
//        this.$http.post('https://www.easy-mock.com/mock/5a475a5da1af5e2dfae2c8d3/alluids/uids').then((res) => {
//          console.log(res.body);
////          res.body.map( (item) => {
////            this.allUids.push(item);
////          });
//          this.allUids = res.body;
//          console.log(this.allUids);
//          this.selectedId = this.allUids[2];
//        });

        this.$http.post('./php/charts/allUid.php').then((res) => {
//          console.log(res.body);
//          res.body.map( (item) => {
//            this.allUids.push(item.table_name);
//          });
          if(res.body[0]){
            this.allUids = res.body;
//            console.log(this.allUids);
            this.selectedId = this.allUids[0];

            this.updateDemoData();
            this.noData = false;
            this.noEquipment = false;
            this.im = false;
            this.initSelectDate();
          }else {
            this.noData = true;
            this.noEquipment = true;
          }
        })
      },
//      请求并更新数据
      updateDemoData() {
        this.nextOrPast = 0;
        this.isToday = true;
        let myDate = new Date();
        let sqlDate = Math.floor(myDate.getTime()/1000);
        let data = { 'date': sqlDate, 'uid': this.selectedId };
        this.$http.post('./php/charts/echoDemoData.php', data,{emulateJSON:true}).then((res)=>{
//          console.log(res);
          this.demoData = res.data;
          if(!this.demoData[0]){
            if(!this.noData) this.noData=true;
          }else {
            if(this.noData) this.noData=false;
            if(!this.im){
              this.chartData.subText = this.selectedId + " " + myDate.getFullYear() + '/' + this.addZero(myDate.getMonth()+1) + '/' + this.addZero(myDate.getDate());
            }
            this.chartData.myStartValue = (this.demoData[0].date * 1000).toLocaleString();
            this.myInit();
          }
        });
      },
//      切换实时显示数据状态
      turnIm() {
        this.initSelectDate();
        this.isToday = !this.isToday;
        this.im = !this.im;
        let self = this;
        let myDate = new Date();
        if(this.im){
          this.clearAllTimer();
          this.chartData.subText = this.selectedId + " " + myDate.getFullYear() + '/' + this.addZero(myDate.getMonth()+1) + '/' + this.addZero(myDate.getDate()) +  '（每三分钟自动更新数据）';
          this.myInit();
          if(!this.timer){
            this.timer = setInterval(function () {
              if(self.im) {
                self.updateDemoData();
              }
            },2000);
          }
        }else {
          this.clearAllTimer();
          this.im = false;
          this.chartData.subText = this.selectedId + " " + myDate.getFullYear() + '/' + this.addZero(myDate.getMonth()+1) + '/' + this.addZero(myDate.getDate());
          this.myInit();
        }
      },
//      根据所选日期及设备编号获取数据
      getDataByDateAndEquip() {
        let dateStr = `${this.selectYear}-${this.selectMonth}-${this.selectDay} 01:00:00`;
        let selectDate = new Date(dateStr).getTime();
        selectDate = Math.floor(selectDate/1000);
        let data = { 'date': selectDate, 'uid': this.selectedId };
        this.$http.post('./php/charts/echoDemoData.php', data,{emulateJSON:true}).then((res)=>{
//          console.log(res);
          this.demoData = res.data;
          if(!this.demoData[0]){
            if(!this.noData) this.noData=true;
          }else {
            if(this.noData) this.noData=false;
            this.chartData.subText = this.selectedId + " " + this.selectYear + '/' + this.addZero(this.selectMonth) + '/' + this.addZero(this.selectDay);
            this.chartData.myStartValue = (this.demoData[0].date * 1000).toLocaleString();
            this.myInit();
          }
        });
      },
      clearAllTimer() {
        if(!!this.timer){
          for(let i=1; i<this.timer;i++){
            clearInterval(i);
          }
        }
      },
      pastDay() {
        this.isToday = false;
        this.im = false;
        this.getDataByDateAndEquip();
      },
      nextOrPastDay(str) {
        this.isToday = false;
        this.im = false;
        if (str === 'next') {
          this.nextOrPast = 1;
        }else {
          this.nextOrPast = -1;
        }
//        将当前所在日期转成毫秒
        let dateStr = `${this.selectYear}-${this.selectMonth}-${this.selectDay} 01:00:00`;
        let selectDate = new Date(dateStr).getTime();
        let selectDay = selectDate + 86400000 * this.nextOrPast;

        this.selectYear = new Date(selectDay).getFullYear();
        this.selectMonth = new Date(selectDay).getMonth() + 1;
        this.selectDay = new Date(selectDay).getDate();

        selectDay = Math.floor(selectDay/1000);
        let data = { 'date': selectDay, 'uid': this.selectedId };
        this.$http.post('./php/charts/echoDemoData.php', data,{emulateJSON:true}).then((res)=>{
//          console.log(res);
          this.demoData = res.data;
          if(!this.demoData[0]){
            if(!this.noData) this.noData=true;
          }else {
            if(this.noData) this.noData=false;
            this.chartData.subText = this.selectedId + " " + new Date(selectDay*1000).getFullYear() + '/' + this.addZero(new Date(selectDay*1000).getMonth()+1) + '/' + this.addZero(new Date(selectDay*1000).getDate());
            this.chartData.myStartValue = (this.demoData[0].date * 1000).toLocaleString();
            this.myInit();
          }
        });
      },
//      将日期设为今天
      today() {
        this.im = false;
        this.updateDemoData();
        this.initSelectDate();
      },
//      初始化当前所在日期
      initSelectDate() {
        let myDate = new Date();
        this.selectYear = myDate.getFullYear();
        this.selectMonth = myDate.getMonth() + 1;
        this.selectDay = myDate.getDate();
      },
      loadScriptOnce(src) {
        let scripts = document.getElementsByTagName('script');
        let res = 0;
        for (let i = 0; i < scripts.length; i++) {
          if (scripts[i].src === src) {
            res = 1;
            break;
          }
        }
        if (res === 0) {
          let script = document.createElement("script");
          script.src = src;
          document.body.appendChild(script);
          console.log('script loading');
        }
      }
    }
  }
</script>
<style>
  .im{
    color: #5cb85c;
  }
  .next_day, .pre_day{
    user-select: none;
  }
  .dataChoose i.selectById{
    margin-right: 6px;
  }
  .no-data{
    color: #e4393c;
  }
  .chart_type ul{
    padding: 0;
    min-width: 100%;
  }
  .chart_type ul li a{
    padding: 3px 0;
    text-align: center;
  }
  .pre_next span{
    cursor: pointer;
  }
  .pre_next .glyphicon{
    font-size: 14px;
    margin: 0 10px;
  }
  .dropSelects{
    padding-bottom: 8px;
    margin-bottom: 0;
  }
  .dropSelectsId{
    padding-bottom: 8px;
    padding-top: 8px;
    text-align: center;
  }
  .charts .auto-padding{
    padding-right: 30px;
  }
  .pre_next{
    font-size: 0;
  }
  .pre_next .pre_day, .pre_next .next_day {
    font-size: 14px;
  }
  .realTimeBtn.a_title.btn-group.im:hover{
    color: #5cb85c!important;
  }
  .humidity,.temperature,.wind{
    width: 100%!important;
    height:400px;
  }
  @media  screen and ( max-width: 991px) {
    .charts .auto-padding{
      padding: 0;
    }
  }
</style>
