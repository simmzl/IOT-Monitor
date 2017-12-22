<template>
<div class="userFiles">
  <div class='col-lg-1 col-md-1'></div>
  <div class="col-lg-10 col-md-10 fileList-container">
    <div class="fileList">
      <h3 class="fileList-title">文件列表</h3>
      <hr>
      <div class='table-responsive' v-show="!!fileList.length">
        <table class='table table-striped table-bordered table-hover'>
          <thead>
          <tr>
            <th>文件名</th>
            <th>上传日期</th>
            <th>操作</th>
          </tr>
          </thead>
          <tbody>
          <tr  v-if="!!fileList.length" v-for="file in fileList">
            <td>{{file.filename}}</td>
            <td>{{file.date}}</td>
            <td><a target="_blank" :href="'http://lab.simmzl.cn/php/files/uploads/'+ file.filename">打开</a></td>
          </tr>
          </tbody>
        </table>
      </div>
      <div class="fileWarn" v-show="!fileList.length">暂无文件...</div>
    </div>
  </div>
</div>
</template>
<script type="text/ecmascript-6">
  export default {
    data() {
      return {
        fileList: []
      }
    },
    created() {
      this.initFileList();
    },
    methods: {
      initFileList(){
        let data = {'operation': 'echoAllFiles'};
        this.$http.post('./php/files/deleteOrEcho.php',data,{emulateJSON:true}).then((res) => {
          if(res.status === 200){
            this.fileList = res.body;
          }
        })
      },
    }
  }
</script>
<style lang="stylus">
  .userFiles
    .fileList
      padding 30px 10px
      background-color #ffffff
      border-radius 10px
      box-shadow 0 15px 30px rgba(0, 0, 0, 0.05)
      .fileList-title,.fileWarn
        padding-left 20px

  @media screen and (max-width: 767px)
    .fileList-container
      padding-left 0
      padding-right 0
</style>
