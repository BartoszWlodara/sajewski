<template>
<div>
   <div class="arrangement_card">

            <div class="arrangement_card_mask"></div>

            <transition name="fade">
                <div v-show="loader" class="loader_container">
                    <img loading="lazy" class="image_Loader" src="@/assets/images/loading.svg" alt="andrzej_sajewski_loader_arrangement"/>   
                </div>
            </transition>
            <transition name="fade">
                 <img loading="lazy" @load="imageLoader" class="arrangement_card_img" v-bind:src="img+'/arrangements/'+DataArrayArrangement.ImagePathMin" v-bind:alt="'andrzej_sajewski_arrangement_'+DataArrayArrangement.ImagePathMin"/>
            </transition>

  </div>

</div>
     
 </template>

<script>
import globalURL from "../globalURL"
import { mapGetters } from 'vuex'

export default ({
  props:{
      DataArrayArrangement: [],
      ShowArrangementIMG:{
          type: Boolean,
          default: false

      }
  },
  data(){
      return{
          img: globalURL,
          ifAuth: false,
          loader:{
            type: Boolean,
            default: true
          }
      }
  },
  methods:{
        imageLoader(){
            setTimeout(()=>{
                this.loader = false;
            }, 1000)
        }
  },
    created(){
        if(this.GET_AUTH_STATUS === "logged"){
            this.ifAuth = true;
        }else{
            this.ifAuth = false;
        }
    },
    computed: {
       ...mapGetters([
        'GET_ROLE',
        'GET_AUTH_STATUS'
        // ...
        ])
    }
})

</script>

<style scoped>
.arrangement_card{
    width: 27vw;
    height: 45vh;
    margin: 1%;
    max-height: 430px;
    max-width: 430px;
    min-height: 350px;
    position: relative;
    border-radius: 5px;
    transition: .5s;
    border-radius: 15px;
    padding-left: 5px;
    display: flex;
}
.arrangement_card:hover{
    transform: scale(1.05);
    cursor: pointer;
}
.arrangement_card_img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    border-radius: 15px;
}
.arrangement_card_mask{
    position: absolute;
    height: 100%;
    width: 100%;
    top: 0;
    left: 0;
    z-index: 4;
}
@media(max-width:1040px){
    .arrangement_card{
        height: 35vh;
        min-height: 250px;
    }
}
@media(max-width:766px){
    .arrangement_card{
        width: 30vw;
        height: 30vh;
        min-height: 200px;
    }
}
@media(max-width:644px){
    .arrangement_card{
        height: 40vh;
        width: 45vw;
    }
}
@media(max-width:476px){
    .arrangement_card{
        height: 30vh;
        width: 60vw;
    }
}
@media(max-width:766px){

}
.fade-enter-active,
.fade-leave-active {
    transition: opacity .5s
}

.fade-enter,
.fade-leave-to {
    opacity: 0
}
</style>
