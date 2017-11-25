<template>
<div>
  <div class="col-lg-9 col-md-9">
    <div class="video-wrapper" style="width: 100%">
      <div class="video-title">视频监控</div>
      <video-player class="vjs-custom-skin" ref="videoPlayer" :options="typeOptions">
      </video-player>
      <div class="video-footer">
        地点：工学院；时间：2017/11/24
      </div>
    </div>
  </div>
  <div class='col-lg-3 col-md-3'>
    <div class="video-title">监控信息</div>
    <div class="video-info-wrapper">
      <p>地点：工学院</p>
      <p>时间：2017/11/24</p>
    </div>
  </div>
</div>
</template>

<script type="text/ecmascript-6">
  import VideoPlayer from 'vue-video-player/src/player';
  require('videojs-flash/dist/videojs-flash');
  require('video.js/dist/video-js.css');
  require('vue-video-player/src/custom-theme.css');

  export default {
    components: {
      VideoPlayer
    },
    data () {
      return {
        typeOptions: {
          techOrder: ['flash', 'html5'],
          controls: true,
          sources: [{
            type: 'rtmp/mp4',
            src: 'rtmp://live.hkstv.hk.lxdns.com/live/hks'
          }],
          live: true,
          controlBar: {
            volumeMenuButton: {
              inline: false,
              vertical: true
            }
          }
        }
      }
    }
  }
</script>
<style>
  body{
    background: #f0f0f0;
  }
  .video-wrapper{
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    background: #fff;
    border-radius: 10px;
    margin-bottom: 20px;
  }
  .video-title{
    font-size: 14px;
    height: 48px;
    line-height: 48px;
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
    height: 48px;
    font-size: 14px;
    line-height: 48px;
    padding-left: 10px;
  }
  .video-info-wrapper{
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    padding: 10px;
    width: 100%;
    height: 408px;
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
</style>
