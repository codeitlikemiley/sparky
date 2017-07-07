<template>
<div class="progress-container">
    <div class="progress-bar inner" :style="{ 'width': progress+'%' }" :progress="progress" :name="name">
        <div class="inner">
            <strong class="fg-darkCobalt place-left">{{ name }}</strong>
        </div>
    </div>
    <div class="align-right place-right">
        <strong class="fg-darkCobalt progress-percent">{{ progress }}%</strong>
    </div>
</div>
</template>

<script>
export default {
    name: 'progressBar',
    props: ['name','progress'],
}
</script>

<style scoped>
.progress-container{
    width:100%;
    position:relative;
}
.progress-bar {
  height: 20px;
  border: 1px solid #3cba54;
  border-radius: 3px;
  background-image: 
    repeating-linear-gradient(
      -45deg,
      #3cba54,
      #3cba54 11px,
      #f4c20d 10px,
      #f4c20d 20px /* determines size */
    );
  background-size: 28px 28px;
  animation: move .5s linear infinite;
  padding:0;
  margin: 0;
}
.inner {
    position: absolute;
}
.progress-percent{
    z-index:999 !important;
}


@keyframes move {
  0% {
    background-position: 0 0;
  }
  100% {
    background-position: 28px 0;
  }
}
</style>
