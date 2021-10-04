<template>
  <div class="home">

<transition name="fade">
  <Loader v-if="loader" :samsungBrowserLoader="samsung_browser"></Loader>
</transition>

  <Navbar></Navbar>
  
  <HomePageSlider></HomePageSlider>
  <BiographyView></BiographyView>
  <WorksGalleryView v-if="showComponents"></WorksGalleryView>
  
  <ExhibitionView v-if="showComponents"></ExhibitionView>
  <AuctionsView v-if="showComponents"></AuctionsView>
  <ArrangementsView v-if="showComponents"></ArrangementsView>
  <PartnerView v-if="showComponents"></PartnerView>
  <ContactView v-if="showComponents" :samsungBrowser="samsung_browser"></ContactView>
  <Footer></Footer> 

  </div>
    <!--
 <router-link :to="{hash: '#me'}">ME</router-link> 

    <img alt="Vue logo" src="../assets/logo.png">
    <HelloWorld msg="Welcome to Your Vue.js App"/>
    <div id="me">jhjhj</div>

-->
</template>

<script>
import Loader from '@/components/Loader.vue'
import HomePageSlider from '@/components/HomePageSlider.vue'
import Navbar from '@/components/Navbar.vue'
import BiographyView from '@/views/BiographyView.vue'
import WorksGalleryView from '@/views/WorksGalleryView.vue'
import ExhibitionView from '@/views/ExhibitionView.vue'
import AuctionsView from '@/views/AuctionsView.vue'
import ArrangementsView from '@/views/ArrangementsView.vue'
import PartnerView from '@/views/PartnerView.vue'
import ContactView from '@/views/ContactView.vue'
import Footer from '@/components/Footer.vue'
import { mapGetters } from 'vuex'

export default {
  name: 'HomeView',
  components: {
    Loader,
    HomePageSlider,
    Navbar, 
    BiographyView,
    WorksGalleryView,
    ExhibitionView,
    AuctionsView,
    ArrangementsView,
    PartnerView,
    ContactView,
    Footer,
  },
  data(){
    return{
      loader: true,
      showComponents: false,
      samsung_browser: false
    }
  },
  methods:{
    hideLoader(){
/*
      if(this.GET_AUTH_STATUS === "logged"){
          setTimeout(()=>{
                this.loader = false;
          }, 1000)
      }else{

        document.onreadystatechange = () => { 
          if (document.readyState == "complete") { 
              setTimeout(()=>{
                this.loader = false;
              }, 800)
          } 
        }

      }
      */


      setTimeout(()=>{
          this.loader = false;
          this.showComponents = true;
      }, 1000)
    
    }
  },
  created(){
     this.hideLoader();

      let sUsrAg = navigator.userAgent;

            if (sUsrAg.indexOf("SamsungBrowser") > -1) {

              this.samsung_browser = true;
            
            }else{

                this.samsung_browser = false;
            }
  },
  computed: {
       ...mapGetters([
        'GET_AUTH_STATUS'
        ]),
    },
}
</script>

