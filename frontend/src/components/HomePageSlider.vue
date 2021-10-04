<template>
  <div id="home" class="home_page_slider">
      <div class="home_page_slider_text_container">
          <div class="home_page_slider_text">
              <div class="row vw_85 break_row">
                <span id="me_span">{{$t('message.HomePageSlider_Par1')}}</span>
                <h1 id="slider_author_name">Andrzej Andrea Sajewski</h1>
              </div>
       
                <p id="slider_text">
                    {{$t('message.HomePageSlider_Par2')}}
                </p>
          </div>
       
      </div>

    <splide v-if="showDesktop" class="desktop" :options="options" style="width: 100vw;">
        <splide-slide>
             <img class="splide_img" src="@/assets/images/home_slider/slide1.jpeg" alt="AndrzejAndreaSajewski_obraz1">
        </splide-slide>
        <splide-slide>
             <img class="splide_img" src="@/assets/images/home_slider/slide3.jpg" alt="AndrzejAndreaSajewski_obraz3">
        </splide-slide>
        <splide-slide>
             <img class="splide_img" src="@/assets/images/home_slider/slide4.jpeg" alt="AndrzejAndreaSajewski_obraz4">
        </splide-slide>
    </splide>

    <splide class="mobile" :options="options" style="width: 100vw;">
        <splide-slide>
             <img class="splide_img" src="@/assets/images/home_slider/mobile/slide1_min.jpeg" alt="AndrzejAndreaSajewski_obraz1">
        </splide-slide>
        <splide-slide>
             <img class="splide_img" src="@/assets/images/home_slider/mobile/slide3_min.jpeg" alt="AndrzejAndreaSajewski_obraz3">
        </splide-slide>
        <splide-slide>
             <img class="splide_img" src="@/assets/images/home_slider/mobile/slide4_min.jpeg" alt="AndrzejAndreaSajewski_obraz4">
        </splide-slide>
    </splide>
    

  </div>
</template>

<script>
import { Splide, SplideSlide } from '@splidejs/vue-splide'
import '@splidejs/splide/dist/css/themes/splide-default.min.css'

export default {
  name: 'HomePageSlider',
  components: {
    Splide,
    SplideSlide,
  },
  data(){
      return{
          options: {
            rewind : true,
            autoplay: true,
            perPage: 1,
            pauseOnHover: false,
            arrows: false,
          },
          windowSize: 0,
          showDesktop: true,
      }
  },
  created() {
        window.addEventListener('resize', this.handleResize);
        this.handleResize();
  },
  destroyed() {
        window.removeEventListener('resize', this.handleResize);
  },
  methods:{
      handleResize() {
            this.windowSize = window.innerWidth;

            if(this.windowSize<=889){
                return this.showDesktop = false;
               // console.log(this.showDesktop);
            }else{
                return this.showDesktop = true;
               // console.log(this.showDesktop);
            }
       }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style  lang="scss">
.home_page_slider{
    height: 100vh;
    width: 100vw;
    position: relative;
  /*  z-index: 2; */
  z-index: 3;
}
.home_page_slider_text_container{
    position: absolute;
    width: 60%;
    height: 100%;
    max-width: 1000px;
    top: 0;
    left: 0;
    background: rgb(12, 12, 12, .4);
    z-index: 3;
    display: flex;
}
.home_page_slider_text{
    position: absolute;
    z-index: 5;
    color: white;
    top: 50%;
    transform: translate(0%, -50%);
    padding: 6%;
}
#slider_text{
    width: 50%;
    max-width: 1000px;
    padding: 10px 10px 10px 30px;
    text-align: left;
    font-weight: 600;
    line-height: 30px;
}
@media(max-width:830px){
    .home_page_slider_text_container, #slider_text{
        width: 100%;
        border-radius: 0 65% 40% 0%;
    }
}
.splide{
    height: 100%;
}
.splide__track, .splide__list{
    height: 100%!important;
}
.splide_img{
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.splide__pagination{
    z-index: 7;
    margin-bottom: 20px;
}
.splide__pagination__page {
    width: 20px;
    height: 8px;
    border-radius: 20px;
    margin: 0 10px 20px 10px;
    opacity: .9;
}
#me_span{
    font-size: 55px;
    font-weight: 700;
    position: relative;
}
#me_span::after{
    content: '';
    position: absolute;
    top: 10px;
    right: -20px;
    width: 4px;
    height: 60px;
    background: white;
    transition: 1s;
}
#slider_author_name{
    margin: auto auto 4px 40px;
    font-size: 42px;
    letter-spacing: 3px;
}
@media(max-width:975px){
    .break_row{
        display: block!important;
    }
    #me_span, #slider_author_name, #slider_text{
        float: left;
    }
}
@media(max-width:830px){
    .break_row{
        width: auto;
    }
}
@media(max-width:760px){
    #slider_author_name{
        font-size: 30px;
        width: calc(100% - 10px);
        text-align: center;
        margin: 15px 0 0 0;
    }
    #me_span{
        font-size: 45px;
    }
    .home_page_slider_text{
        padding: 5%;
    }
    #slider_text{
        padding: 0;
    }
    #me_span::after{
        height: 45px;
        transform: rotate(90deg);
    top: -35px;
    right: 0px;
    height: 200px;
    transition: 1s;
    width: 3px;
    }
}
@media(max-width:450px){
    #slider_author_name{
        font-size: 25px;
        margin: 35px 0 0 0;
        width: 100%;
        text-align: center;
    }
    #me_span{
        font-size: 35px;
    }
    #me_span::after{
        right: 35px;
        top: -37px;
        transition: 1s;
        width: 2px;
    }
    #slider_text{
        font-size: 15px;
        margin-top: 35px;
    }
}
@media(max-width:400px){
    #slider_author_name{
        font-size: 18px;
    }
    #me_span{
        font-size: 25px;
    }
    #me_span::after{
        right: 3px;
        top: -45px;
    }
    #slider_text{
        font-size: 14px;
        line-height: 25px;
        margin-top: 20px;
    }
}
</style>
