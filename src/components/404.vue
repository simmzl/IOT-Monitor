<template>
<div class="error">
  <div class="error_404">404 NOT FOUND</div>
</div>
</template>

<script>
  export default {
    data() {
      return {}
    }
  }
</script>
<style lang="stylus">
    .error {
        position: relative;
        width: 100%;
        height: 100%;
        font-size: 24px;
        text-align: center;
        .error_404 {
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -100%);
            transform: translate(-50%, -100%);
        }
    }
</style>
