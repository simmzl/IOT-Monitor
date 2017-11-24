_init() {
  let checkMe;
  let seriesType, seriesData, subText = "", myStartValue;

  let myDate = new Date();
  let seriesDate = myDate.getTime();
  let myCharttemperature = echarts.init(document.getElementById('temperature'));
  let myCharthumidity = echarts.init(document.getElementById('humidity'));
  let myChartwind_speed = echarts.init(document.getElementById('wind'));

  Date.prototype.toLocaleString = function () {
    return this.getFullYear() + "/" + addZero((this.getMonth() + 1)) + "/" + addZero(this.getDate()) + "/ " + addZero(this.getHours()) + ":" + addZero(this.getMinutes());
  };
// 将毫秒数转化成时分秒
  function turnTime(num) {
    let t = new Date(num * 1000);
    return t.toLocaleString();
  }

//展示所有数据
  function showAllData() {
    let myStartValue = turnTime(demoData[0]['date']);
    function showItem(index, name) {
      seriesData = demoData.map(function (item) {
        return item[index];
      });
      let optiontemperature = {
        title: {
          text: name,
          subtext: subText
        },
        tooltip: {
          trigger: 'axis'
        },
        xAxis: {
//                获取json中第二个数据作为横坐标
          data: demoData.map(function (item) {
            return turnTime(item.date);
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
          startValue: myStartValue
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
          name: name,
          type: seriesType,
          data: demoData.map(function (item) {
            return item[index]
          })
        }
      };
      let optionhumidity = {
        title: {
          text: name,
          subtext: subText
        },
        tooltip: {
          trigger: 'axis'
        },
        xAxis: {
//                获取json中第一个数据作为横坐标
          data: data.map(function (item) {
            return turnTime(item.date);
          })
        },
        yAxis: {
          //name:yName,
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
          startValue: myStartValue
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
        }
        ],
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
          name: name,
          type: seriesType,
          data: data.map(function (item) {
            return item[index];
          })
        }
      };
      let optionwind_speed = {
        title: {
          text: name,
          subtext: subText
        },
        tooltip: {
          trigger: 'axis'
        },
        xAxis: {
//                获取json中第一个数据作为横坐标
          data: data.map(function (item) {
            return turnTime(item.date);
          })
        },
        yAxis: {
          //name:yName,
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
          startValue: myStartValue
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
        }
        ],
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
          name: name,
          type: seriesType,
          data: data.map(function (item) {
            return item[index];
          })
        }
      };
      let myChart = eval("myChart" + index);
      myChart.setOption(eval("option" + index));
    }

    showItem('temperature', '温度(℃)');
    showItem('humidity', '湿度(%)');
    showItem('wind_speed', '风速(m/s)');
    $('#noData').css('display', 'none');
    $('#showData').css('display', 'inherit');
  }

//时间不齐两位补零
  function addZero(obj) {
    if (obj < 10) {
      return obj = "0" + obj;
    } else {
      return obj;
    }
  }

//实时切换按钮
  function turn() {
    let btn = $('#realTimeBtn');
    let btnStatus = btn.attr("class") == "realTimeBtn a_title btn-group";
    if (btnStatus) {
      btn.addClass('btn-success');
      checkMe = true;
      subText = "（最近3小时内,每三分钟自动更新）";
      realTime();
    } else {
      checkMe = false;
      // subText = tempsubText;
      subText = "";
      showAllData();
      btn.removeClass('btn-success');
    }
  }

//实时显示数据
  function realTime() {

    let myDate = new Date();
    let nowYear = myDate.getFullYear();
    let nowMoth = addZero(myDate.getMonth() + 1);
    let nowDate = addZero(myDate.getDate());
    let nowHour = addZero(myDate.getHours());
    let nowMinute = addZero(myDate.getMinutes());
    //每天03：00前显示从00：00开始
    if (nowHour - 3 < 0) {
      myStartValue = nowYear + "-" + nowMoth + "-" + nowDate + " " + "00:00";
    } else {
      myStartValue = nowYear + "-" + nowMoth + "-" + nowDate + " " + nowHour + ":" + nowMinute;
    }
    // getPhp("constantly");
    showAllData();
    //alert(checkMe);
    if (checkMe) {
      setTimeout(function () {
        realTime();
      }, 58000);
    }
  }

//切换图表类型
  function turnSeriesType() {
    let first = $('.series0');
    let last = $('.series1');
    if (seriesType == 'line') {
      seriesType = 'bar';
      showAllData();
      first.removeClass('aActive').attr("onclick", "turnSeriesType()");
      last.addClass('aActive').attr("onclick", " ");
    } else {
      seriesType = 'line';
      showAllData();
      first.addClass('aActive').attr("onclick", " ");
      last.removeClass('aActive').attr("onclick", "turnSeriesType()");
    }
  }

//切换历史数据   修改json路径和显示的值
  function turnHistory(obj) {
    let myThis = $('#' + obj);
    myThis.children().addClass("historyActive");
    myThis.siblings().children().removeClass("historyActive");

    myThis.attr("onclick", " ");
    myThis.siblings().attr("onclick", "turnHistory(this.id)");
  }

// 终止事件冒泡
  document.getElementById("oneDay").addEventListener('click', function (e) {
    e.stopPropagation();//终止事件冒泡
  }, false);

// 写入历史时间的年月日
  function writeYMD()  {
    let years = document.getElementById("year");
    let moths = document.getElementById("moth");
    let days = document.getElementById("day");
    let myDate = new Date();
    let nowYear = myDate.getFullYear();
    let specVal = [1, 3, 5, 7, 8, 10, 12];
    let specDay;

    // 写入月
    for (let i = 0; i < 12; i++) {
      let temp = addZero(i + 1);
      moths.options[i] = new Option(temp, i + 1);
    }

    //写入年份
    for (let y = 0; y < nowYear - 2016; y++) {
      years.options[y] = new Option(2017 + y, 2017 + y);
    }

    // 写入天数
    function changeDay(val) {
      days.options.length = 0;
      let mothsVal = parseInt(val);

      let result = !!specVal.find(function (item) {
        return item === mothsVal;
      });
      // console.log(mothsVal);
      //为什么要去掉return
      if (result) {
        specDay = 31;
      } else if (mothsVal === 2) {
        !checkYear(years.value)?specDay = 28:specDay = 29;
      } else {
        specDay = 30;
      }
      for (let j = 0; j < specDay; j++) {
        let temp1 = addZero(j + 1);
        days.options[j] = new Option(temp1, j + 1);
      }
    }

    // 检查是否为闰年
    function checkYear(val) {
      let yearVal = parseInt(val);
      return (yearVal % 100 === 0 && yearVal % 400 === 0)||(yearVal % 4 === 0);
    }
    changeDay(moths.value);

    moths.onchange = function () {
      changeDay(moths.value);
      // console.log(moths.value);
    };
    years.onchange = function () {
      if (moths.value === "2") {
        changeDay(moths.value);
      }
    };

    document.getElementById("query").addEventListener('click', function () {
      let changeDate =years.value + "/" + addZero(parseInt(moths.value)) + "/" + addZero(parseInt(days.value));
      let date = new Date(changeDate);
      seriesData = date.getTime();
      subText = years.value + "/" + addZero(parseInt(moths.value)) + "/" + addZero(parseInt(days.value));
      getPhp();
    });
  }

// alert("为了方便展示，默认显示2017/08/12的数据；可提供选择的数据日期为2017/08/10-2017/08/12");
  function getPhp(str) {

    checkMe = false;
    $('.realTimeBtn').removeClass('btn-success');

    let myDate = new Date();
    let isTrue =false;
    switch (str) {
      case 'today':
        seriesDate = myDate.getTime();
        console.log('today');
        break;
      case 'pre':
        seriesDate = seriesDate - 86400000;
        break;
      case 'next':
        if (seriesDate === myDate.getTime()) return;
        seriesDate = seriesDate + 86400000;
        break;
      case 'constantly':
        seriesDate = myDate.getTime();
        break;
      case 'query':

        break;
      default:
        break;
    }
    let t = new Date(seriesDate * 1000);
    if(str !== "constantly"){
      subText = t.toLocaleDateString();
    }
    let xmlhttp;
    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp = new XMLHttpRequest();
    }
    else {
      // code for IE6, IE5
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        // console.log(phpData);
        showAllData();
      } else {
        $('#showData').css('display', 'none');
        $('#noData').css('display', 'inherit');
        // $('.footer').css({"position": "fixed", "bottom": "0"});
      }
    };
    //请求指令加上输入框的值q
    xmlhttp.open("GET", "register2.php?date=" + seriesDate + "&seven="+ isTrue , true);
    //发送请求指令
    xmlhttp.send();
  }

  $('.today,.pre_day,.next_day').attr("onclick", "getPhp(this.className)");
  $('#today,#seven,#oneDay').attr("onclick", "turnHistory(this.id)");
  $('.series1').attr("onclick", "turnSeriesType()");

}
