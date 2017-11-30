<template>
  <div class="bookRepair">
    <div class="col-lg-1 col-md-1"></div>
    <div class="col-lg-10  col-md-10 auto-padding">
      <div class="input_group equip_input">
        <form>
          <div class="info">
            <span>设备编号:</span>
            <input type="text">
          </div>
          <div class="info">
            <span>日期:</span>
            <input type="text">
          </div >
          <div class="textarea info" >
            <span>故障描述:</span>
            <textarea cols="30" rows="10"></textarea>
          </div>
          <div class="info">
            <span></span>
            <input type="submit" class='submit'>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script type="text/ecmascript-6">
  export default {
  }
</script>
<style lang="stylus" scoped>
  .bookRepair
    .input_group
      .info
        input
          border 1px solid #949494
    .textarea
      span
        vertical-align top
      textarea
        background transparent
        width 60%
        min-width 240px
        border-radius 4px 4px
        margin 0 0 0 10px
        outline none
        padding-left 8px
        border 1px solid #949494
        height 200px
        font-size 14px
</style>
