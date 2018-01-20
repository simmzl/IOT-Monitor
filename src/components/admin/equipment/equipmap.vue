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
        let point = new BMap.Point(104.388611,37.993911);
        map.centerAndZoom(point,5); //初始化地图，设置中心点坐标和地图级别
//        map.setCenter("全国");
        map.enableScrollWheelZoom(true); //可缩放
//        切换城市
        var size = new BMap.Size(10, 20);
        map.addControl(new BMap.CityListControl({
          anchor: BMAP_ANCHOR_TOP_LEFT,
          offset: size,
        }));

//        this.$http.get('https://www.easy-mock.com/mock/598c46ffa1d30433d85d21b6/map/map').then((res) => {
        this.$http.get('./php/map/map.php').then((res) => {
//        this.$http.get('../../../static/mao.json').then((res) => {
          let data = res.body;
//          let data = [{"id":"00000001","co_addr":" xx\u7701xx\u5e02xx\u533axx","co_lng":"","co_lat":""},{"id":"00000002","co_addr":"xx\u7701xx\u5e02xx\u533axx","co_lng":"","co_lat":""},{"id":"00000003","co_addr":"xx\u7701xx\u5e02xx\u533axx","co_lng":"","co_lat":""},{"id":"00000005","co_addr":"\u798f\u5efa\u7701\u6cc9\u5dde\u5e02\u4e30\u6cfd\u533a\u534e\u4fa8\u5927\u5b66","co_lng":"118.651759","co_lat":"24.940229"},{"id":"00000004","co_addr":"\u798f\u5efa\u7701\u6cc9\u5dde\u5e02\u4e30\u6cfd\u533a\u534e\u4fa8\u5927\u5b66\u5de5\u5b66\u9662","co_lng":"118.991759","co_lat":"24.940229"}];
          for (let i in data) {
            let marker = new BMap.Marker(new BMap.Point(data[i].co_lng, data[i].co_lat)); // 创建标注
            map.addOverlay(marker); //将标注添加到地图中
            marker.disableDragging(); //不可拖拽
//            marker.setAnimation(BMAP_ANIMATION_BOUNCE); //动画

            (function (i) {
              let body = '<div>设备ID：' + data[i]['id'] + '</div>' + '<div>所在地址：'+ data[i]['co_addr'] +'</div>';
              let infoWindow0 = new BMap.InfoWindow(body);
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
      height 700px
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
  .citylist_popup_main .city_content_top{
    height: 46px!important;
  }
  #selCityWd{
    height: 23px!important;
    padding-top: 1px!important;
    padding-bottom: 1px!important;

  }
</style>
