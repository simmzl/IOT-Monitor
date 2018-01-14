<template>
<div class="labvideo">
  <div class='col-lg-3 col-md-3 auto-padding video-info'>
    <div class="video-title">监控信息</div>
    <div class="video-info-wrapper">
      <p class="video-info-wrapper-title">选择设备：</p>
      <div class="dropSelectsId">
        <select v-model="selectedId" v-if="allUids">
          <option v-for="id in allUids" :value="id">{{id}}</option>
        </select>
        <button type="button" class="btn btn-primary btn-xs button-font" @click="initPlayer()" ref="playById">确定</button>
      </div>
    </div>
  </div>
  <div class="col-lg-9 col-md-9 auto-padding">
    <div class="video-wrapper" style="width: 100%">
      <div class="video-title">视频监控</div>
      <div id="playercontainer"></div>
      <div class="video-footer">
        地点：工学院；时间：2017/11/24
      </div>
    </div>
  </div>
</div>
</template>

<script type="text/ecmascript-6">
export default {
  data() {
    return {
      allUids: {
        type: Object
      },
      selectedId: '',
      player: null,
      playerOptions: {
        width : 500,
        height : 433,
        backcolor : "#FFFFFF",
        stretching : "uniform",
        file : "rtmp://live.hkstv.hk.lxdns.com/live/hks",
        ak : "116bdbd482b147928a542c053aae4eb7",
        autoStart : true,
        repeat : false,
        volume : 100,
        controls : "over"
      }
    }
  },
  created() {
    this.getUidList();
//    this.initPlayer();
  },
//  mounted
  activated () {
//    this.getUidList();
//    let player = cyberplayer("playercontainer").setup(this.playerOptions);
    this.initPlayer();
  },
  methods: {
    initPlayer() {
      let player = cyberplayer("playercontainer").setup(this.playerOptions);
    },
    getUidList() {
        this.$http.post('https://www.easy-mock.com/mock/5a475a5da1af5e2dfae2c8d3/alluids/uids').then((res) => {
//          console.log(res.body);
          this.allUids = res.body;
//          console.log(this.allUids);
          this.selectedId = this.allUids[0];
//          this.$refs.playById.click();
        });

//      this.$http.post('./php/charts/allUid.php').then((res) => {
//        console.log(res.body);
//        if(res.body[0]){
//          this.allUids = res.body;
//          console.log(this.allUids);
//          this.selectedId = this.allUids[0];
//        }
//      })
    },
  }
}
</script>
<style>
  #playercontainer{
    width: 100% !important;
  }
  .jwplayer .jw-icon-barlogo-new{
    display: none;
  }
  .video-info{
    margin-bottom: 20px;
  }
  .video-wrapper{
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    background: #fff;
    border-radius: 10px;
    margin-bottom: 20px;
  }
  .video-title{
    font-size: 14px;
    height: 40px;
    line-height: 40px;
    padding-left: 10px;
    border-bottom: 1px solid #f0f0f0;
    background-color: #fff;
    border-top-right-radius: 10px;
    border-top-left-radius: 10px;
  }
  .video-footer{
    border-top: 1px solid #f0f0f0;
    border-bottom-right-radius: 10px;
    border-bottom-left-radius: 10px;
    height: 40px;
    font-size: 14px;
    line-height: 40px;
    padding-left: 10px;
  }
  .video-info-wrapper{
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    padding: 10px;
    width: 100%;
    height: auto;
    border-bottom-right-radius: 10px;
    border-bottom-left-radius: 10px;
    background-color: #ffffff;
  }
  .vjs-big-play-button{
    width: 2em!important;
    border-radius: 1em!important;
    background: rgba(0,0,0,0.1)!important;
    transition: background .2s;
  }
  .video-js:hover .vjs-big-play-button, .vjs-custom-skin > .video-js .vjs-big-play-button:focus, .vjs-custom-skin > .video-js .vjs-big-play-button:active{
    background: rgba(0,0,0,0.4)!important;
  }
  .vjs-custom-skin>.video-js .vjs-big-play-button{
    margin-left: -1em!important;
  }
  @media  screen and ( max-width: 991px) {
    .labvideo .auto-padding{
      padding: 0;
    }
    .video-info-wrapper{
      height: auto;
    }
    .video-info-wrapper .video-info-wrapper-title,.video-info-wrapper .dropSelectsId{
      display: inline;
    }
    .video-info-wrapper .dropSelectsId{
      margin-left: 0;
    }
  }
</style>
