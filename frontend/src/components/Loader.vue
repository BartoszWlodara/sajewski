<template>

    <div class="loader">
        
        <div v-if="!samsungBrowserLoader" class="middle">
            <div class="bar bar1"></div>
            <div class="bar bar2"></div>
            <div class="bar bar3"></div>
            <div class="bar bar4"></div>
            <div class="bar bar5"></div>
            <div class="bar bar6"></div>
            <div class="bar bar7"></div>
            <div class="bar bar8"></div>
            <div class="bar bar9"></div>
        </div>

        <div v-if="samsungBrowserLoader" class="middle">
            <div class="bar_samsung bar1"></div>
            <div class="bar_samsung bar2"></div>
            <div class="bar_samsung bar3"></div>
            <div class="bar_samsung bar4"></div>
            <div class="bar_samsung bar5"></div>
            <div class="bar_samsung bar6"></div>
            <div class="bar_samsung bar7"></div>
            <div class="bar_samsung bar8"></div>
            <div class="bar_samsung bar9"></div>
        </div>
       
    </div>

</template>
<script>

export default {
    name: "Loader",
    props:{
        samsungBrowserLoader:{
            default: false,
            type: Boolean
        }
    },
}
</script>

<style scoped>

.loader{
    position: fixed;
    height: 100vh;
    width: 100vw;
    background: #2B2B2B;
    top: 0;
    left: 0;
    z-index: 40;
    transition: 1s;
}
.middle {
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  position: absolute;
}
.bar, .bar_samsung {
  width: 10px;
  height: 70px;
  display: inline-block;
  transform-origin: bottom center;
  border-radius: 20px;
  /*   box-shadow:5px 10px 20px inset rgba(255,23,25.2); */
  animation: loader 1.2s linear infinite;
  margin-left: 2px;
}
.bar_samsung{
    animation: loaderSamsung 1.2s linear infinite;
}
.bar1 {
  animation-delay: 0.1s;
}
.bar2 {
  animation-delay: 0.2s;
}
.bar3 {
  animation-delay: 0.3s;
}
.bar4 {
  animation-delay: 0.4s;
}
.bar5 {
  animation-delay: 0.5s;
}
.bar6 {
  animation-delay: 0.6s;
}
.bar7 {
  animation-delay: 0.7s;
}
.bar8 {
  animation-delay: 0.8s;
}
.bar9 {
  animation-delay: 0.9s;
}

@keyframes loader {
  0% {
    transform: scaleY(0.1);
    background: white;
  }
  50% {
    transform: scaleY(1);
    background: #E4A255;
  }
  100% {
    transform: scaleY(0.1);
    background: transparent;
  }
}
@keyframes loaderSamsung {
  0% {
    transform: scaleY(0.1);
    background: white;
  }
  50% {
    transform: scaleY(1);
    background: white;
  }
  100% {
    transform: scaleY(0.1);
    background: transparent;
  }
}

</style>