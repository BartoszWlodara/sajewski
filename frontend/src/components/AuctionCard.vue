<template>
<div>
   <div class="auction_card">
       
            <div class="auction_card_mask"></div>

            <transition name="fade">
                <div v-show="loader" class="loader_container">
                    <img loading="lazy" class="image_Loader" src="@/assets/images/loading.svg" alt="andrzej_sajewski_loader"/>   
                </div>
            </transition>
            <transition name="fade">
                 <img loading="lazy" @load="imageLoader" class="auction_card_img" v-bind:src="img+'/auctions/'+DataArrayAuction.ImagePathMin" v-bind:alt="'andrzej_sajewski_auction_'+DataArrayAuction.Title"/>
            </transition>
  </div>

     <div class="auction_card_text">
                <div class="auction_card_title">{{ auction_title }}</div>
                <div class="auction_card_date">{{ DataArrayAuction.Date }}</div>
     </div>

</div>
     
 </template>

<script>
import globalURL from "../globalURL"
import { mapGetters } from 'vuex'
import moment from 'moment'

export default ({
  props:{
      DataArrayAuction: [],
      ShowAuctionIMG:{
          type: Boolean,
          default: false

      }
  },
  data(){
      return{
          img: globalURL,
          ifAuth: false,
          auction_title: '',
          loader:{
                type: Boolean,
                default: true
          }
      }
  },
  methods:{
        async reloadTitle(){
            if(this.GET_LANG === 'en'){
                this.auction_title = this.DataArrayAuction.TitleANG;
            }else if(this.GET_LANG === 'it'){
                this.auction_title = this.DataArrayAuction.TitleIT;
            }else{
                this.auction_title = this.DataArrayAuction.Title;
            }
        },
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

        this.reloadTitle();
    },
    mounted(){
        this.DataArrayAuction.Date = moment(this.DataArrayAuction.Date).format('DD-MM-YYYY');
    },
    computed: {
       ...mapGetters([
        'GET_ROLE',
        'GET_AUTH_STATUS',
        'GET_LANG'
        // ...
        ])
    },
    watch: {
        GET_LANG: {
            deep: true,
            handler() {
                this.reloadTitle();
            }
        }
    }
})

</script>

<style scoped>
.auction_card{
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
.auction_card:hover{
    transform: scale(1.05);
    cursor: pointer;
}
.auction_card_img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    border-radius: 15px;
}
.auction_card_mask{
    position: absolute;
    height: 100%;
    width: 100%;
    top: 0;
    left: 0;
    z-index: 4;
}
@media(max-width:1040px){
    .auction_card{
        height: 35vh;
        min-height: 250px;
    }
}
@media(max-width:766px){
    .auction_card{
        width: 30vw;
        height: 30vh;
        min-height: 200px;
    }
}
@media(max-width:644px){
    .auction_card{
        height: 40vh;
        width: 45vw;
    }
}
@media(max-width:476px){
    .auction_card{
        height: 30vh;
        width: 60vw;
    }
}
.auction_card_text{
    width: 100%;
    z-index: 4;
    height: 20%;
    margin-top: 15px;;
    position: absolute;
    bottom: -22%;
    left: 0;
}
.auction_card_title{
    padding-top: 5px;
    color: white;
    font-weight: 500;
}
.auction_card_date{
    margin-top: 10px;
    font-size: 14px;
    color: #E4A255;
    font-weight: 600;
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
