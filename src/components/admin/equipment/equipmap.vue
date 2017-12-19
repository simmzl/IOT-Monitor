<template>
    <div class="map-container">
      <div id="baiduMap"></div>
    </div>
</template>
<script type="text/ecmascript-6">
  export default  {
    data() {
      return {}
    },
    activated() {
      this.initMap();
    },
    methods: {
      initMap() {
        let map = new BMap.Map("baiduMap", {
          enableMapClick: false
        });
        let point = new BMap.Point(118.652182, 24.938167);
        map.centerAndZoom(point, 18); //初始化地图，设置中心点坐标和地图级别
        map.enableScrollWheelZoom(true); //可缩放
        this.$http.get('https://www.easy-mock.com/mock/598c46ffa1d30433d85d21b6/map/map').then((res) => {
          let data = res.body;
          for (let i in data) {
            let marker = new BMap.Marker(new BMap.Point(data[i].mapLocal[0], data[i].mapLocal[1])); // 创建标注
            map.addOverlay(marker); //将标注添加到地图中
//            marker.setAnimation(BMAP_ANIMATION_BOUNCE); //动画

            (function (i) {
              let title = {
                title: '<span style="font-size:14px;color:#0A8021">' + data[i].mapName + '</span>'
              };
              let body = "<table class='map-table'><tr><td> " +
                "<span class='table-temp' id='tableTemp'>温度<br>" + data[i].mapTemp + "℃</span></td>" +
                "<td><span class='table-humi' id='tableHumi'>湿度<br>" + data[i].mapHumi + "%</span></td>" +
                "<td><span class='table-wind' id='tableWind'>风速<br>" + data[i].mapSpeed + "m/s</span></td></tr></table>" +
                "<span style='float: right;'><a href='javascript:;'>详情>></a></span>";

              let infoWindow0 = new BMap.InfoWindow(body, title);
              marker.addEventListener("click", function () {
                this.openInfoWindow(infoWindow0);
              });
            })(i)
          }
        })
      }
    }
  }
</script>
<style lang="stylus" rel="stylesheet/stylus">
  .map-container
    width 100%
    padding 20px
    background-color #f0f8f6
    box-shadow 0 15px 30px rgba(0, 0, 0, 0.1)
    border-radius 10px
    #baiduMap
      height 600px
      width 100%
      border-radius 10px

  .BMap_bubble_title {
    text-align: center;
    padding: 4px 0;
  }

  .map-table {
    width: 100%;
    height: 90px;
  }

  .map-table td {
    text-align: center;
    color: #fff;
    font-size: 20px;
    width: 33%;
  }

  .map-table td span {
    height: 100%;
    width: 90%;
    line-height: 34px;
    font-size: 16px;
    font-weight: 700;
    display: inline-block;
    padding-top: 10px;
    background: #1163b9;
  }

  @media screen and (max-width: 449px) {
    #baiduMap {
      height: 500px;
    }
  }
</style>
