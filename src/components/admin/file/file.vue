<template>
<div class="fileManage">
  <div class='col-lg-1 col-md-1'></div>
  <div class="col-lg-10 col-md-10 no-padding">
    <div class="upload clearfix">
      <h3>上传文件</h3>
      <hr class="hr">
      <div class="uploadSelect">
        <label for="file" class="uploadLabel pull-right">选择文件</label>
        <div>所选文件：{{fileSelect}}</div>
      </div>
      <hr>
      <div class="uploadSubmit">
        <form id="uploadForm" enctype="multipart/form-data">
          　　<input id="file" class="fileInput" type="file" name="myFile" ref="upload" @change="getFileSelect" accept="application/pdf,application/msword,text/plain,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation">
              <input type="hidden" name="MAX_FILE_SIZE" value="10455040">
          　　<input type="submit" name="submit" class="uploadBtn pull-right" value="上传" @click.stop.prevent="canSubmit">
        </form>
        <div class="fileWarn" :class="{'fileSuccess': isSuccess}">{{err}}</div>
      </div>
    </div>
    <div class="fileList">
      <h3>文件列表</h3>
      <hr>
      <ul>
        <li v-if="!!fileList" v-for="file in fileList"><a :href="file.path">{{file.name}}</a></li>
      </ul>
    </div>
  </div>
</div>
</template>
<script type="text/ecmascript-6">
  export default {
    data() {
      return {
        fileSelect: '',
        err: '',
        isSuccess: false,
        fileList: []
      }
    },
    computed: {
    },
    created() {
      this.$http.get('static/data/file.json').then((res) => {
        this.fileList = res.body;
      });
    },
    methods: {
      getFileSelect() {
        this.fileSelect = this.$refs.upload.files[0].name;
        if (this.fileSelect) {
          this.err = '';
        }
      },
      canSubmit() {
        if (!this.fileSelect) {
          if(this.isSuccess) this.isSuccess = false;
          this.err = '警告：未选择任何文件。';
        }else {
          let myData = new FormData();
          console.log(this.$refs.upload.files[0]);
          let selectFile = this.$refs.upload.files[0];
          myData.append('myFile',selectFile);
          let allowArray = ['text/plain','application/pdf',
            'application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel','application/vnd.ms-powerpoint',
            ' application/vnd.openxmlformats-officedocument.presentationml.presentation'];
          if(selectFile.size > 10455040){
            if(this.isSuccess) this.isSuccess = false;
            this.err = '请选择小于10M的文件';
            return;
          }else if (allowArray.indexOf(selectFile.type) === -1 ) {
            if(this.isSuccess) this.isSuccess = false;
            this.err = '文件类型不合法,允许类型：pdf、doc、docx、txt、xls、ppt、pptx';
            return;
          }
          this.$http.post('./php/files/uploadFile.php', myData).then(function(res) {
            console.log(res);
            if(res.data === '文件上传成功'){
              this.isSuccess = true;
              this.err = '上传成功!';
            }else {
              if(this.isSuccess) this.isSuccess = false;
              this.err = res.data;
            }
          }, function(error) {
            if(this.isSuccess) this.isSuccess = false;
            this.err = '上传失败';
          });
        }
      }
    }
  }
</script>
<style>
  .upload {
    margin-bottom: 30px;
  }
  .upload,.fileManage .fileList{
    padding: 30px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.05);
  }
  .fileList ul li {
    color: #337ab7;
    cursor: pointer;
    margin-bottom: 8px;
  }
  .uploadSelect,.uploadSubmit{
    line-height: 35px;
  }
  .uploadLabel,.uploadBtn{
    font-weight: normal;
    text-align: center;
    width: 65px;
    height: 35px;
    line-height: 25px;
    background-color: #fff;
    padding: 5px;
    border-radius: 8px;
    color: #000;
    font-size: 12px;
    border: 1px solid #adadad;
    transition: all 0.2s;
    cursor: pointer;
  }
  .uploadLabel:hover,.uploadBtn:hover{
    background-color: #000;
    color: #fff;
  }
  .fileInput{
    display: none!important;
  }
  .fileWarn{
    color: #e4393c;
  }
  .hr{
    opacity: 0;
  }
  .fileSuccess{
    color: #5cb85c;
  }
</style>
