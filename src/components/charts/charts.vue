<template>
  <div class="charts">
    <!--左侧导航区-->
    <div class="col-lg-2 col-md-2">
      <div class="dataChoose">
        <div class="btn-group">
          <a  class="dropdown-toggle a_title" data-toggle="dropdown" style='width: 100%'>
            <span><i class='fa fa-calendar-check-o history'></i></span>
            历史数据 </a>
          <ul class="dropdown-menu"role="menu" style="min-width: 300px">
            <li id="today" class="today"><a class="pointer historyActive">今天</a></li>
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
                <button type="button" id="query" class="btn btn-primary btn-xs button-font" >确定</button>
              </div>
            </li>
          </ul>
        </div>
        <a class="realTimeBtn a_title btn-group" id='realTimeBtn' style="outline: none" onclick="turn()" title="每三分钟自动刷新">
          <span><i class='fa fa-clock-o'></i></span>实时数据</a>
        <div class="btn-group chart_type">
          <a class="dropdown-toggle a_title" data-toggle="dropdown"><span><i class='fa fa-bar-chart-o'></i></span>图表类型</a>
          <ul class="dropdown-menu" role="menu" >
            <li><a class="pointer series0" @click="turnSeriesType('line',$event)" :class="{aActive: this.chartData.seriesType === 'line'}">折线图</a></li>
            <li><a class="pointer series1" @click="turnSeriesType('bar',$event)" :class="{'aActive': this.chartData.seriesType === 'bar'}">柱形图</a></li>
          </ul>
        </div>
      </div>
    </div>
    <!--数据展示区-->
    <div class="col-lg-10  col-md-10 ">
      <!--<hr>-->
      <!--按钮设置区-->
      <div id="noData"><p>暂无数据...</p></div>
      <!--数据展示-->
      <div id="showData">
        <!--温度数据-->
        <div class="">
          <div id="temperature" style="width: 100%;height:400px;"></div>
          <div class='text-center pre_next'>
            <span class='pre_day' >上一天</span>
            <span><i class='fa fa-chevron-circle-left fa-lg'></i></span>
            <span><i class='fa fa-chevron-circle-right fa-lg'></i></span>
            <span class='next_day' >下一天</span>
          </div>
        </div>
        <hr>
        <!--湿度数据-->
        <div class="">
          <div id="humidity" style="width: 100%;height:400px;"></div>
          <div class='text-center pre_next'>
            <span class='pre_day' >上一天</span>
            <span><i class='fa fa-chevron-circle-left fa-lg'></i></span>
            <span><i class='fa fa-chevron-circle-right fa-lg'></i></span>
            <span class='next_day' id="">下一天</span>
          </div>
        </div>
        <hr>
        <!--风速数据-->
        <div class="">
          <div id="wind" style="width: 100%;height:400px;"></div>
          <div class='text-center pre_next'>
            <span class='pre_day' id="pre">上一天</span>
            <span><i class='fa fa-chevron-circle-left fa-lg'></i></span>
            <span><i class='fa fa-chevron-circle-right fa-lg'></i></span>
            <span class='next_day' id="next">下一天</span>
          </div>
        </div>
      </div>
      <hr>
    </div>
  </div>
</template>
<script type="text/ecmascript-6">
  import echarts from 'echarts';

  export default {
    data() {
      return {
        demoData: {
          type: Object
        },
        chartData: {
          name: '',
          subText: '测试',
          myStartValue: '',
          seriesType: 'line'
        },
        selectYear: '',
        selectMonth: '1',
        selectDay: '1'
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
        for (let i=2017;i<=2090;i++){
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
      this.$http.get('static/data/demo.json').then((res) => {
        this.demoData = res.body;
        this.$nextTick(() => {
          this.myInit();
        });
      });
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
          e.stopPropagation();
          return;
        }else {
          if (this.chartData.seriesType === 'line') {
            this.chartData.seriesType = 'bar';
            this.myInit();
          } else {
            this.chartData.seriesType = 'line';
            this.myInit();
          }
        }
      }
    }
  }
</script>
<style>
  @import "../../common/css/reset.css";
  .dropSelects{
    padding-bottom: 8px;
    margin-bottom: 0;
  }
</style>
