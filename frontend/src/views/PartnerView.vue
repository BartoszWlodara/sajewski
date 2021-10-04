<template>
    <div id="pratners">
        <div class="row chapter_title">{{ $t("message.partnersTitle") }}</div>
        <ChapterHeader></ChapterHeader>

   <!-- <div class="auction_text">
        <p>
            Zapraszam do zapozniania się z wynikami sprzedazy moich obrazów. Zachęcam do śledzenia ofert aukcyjnych i licytacji wystawionych prac.
        </p>
    </div> -->

<div class="row max-width">
<div class="partners">
   <div class="partner_image">
       <a href="http://tadeo-art.pl/index.php?id=3&who=284" target="blank">
           <img src="@/assets/images/partners/tadeo.jpeg" alt="andrzejsajewski_tadeoart" loading="lazy">  
       </a> 
    </div>
     <div class="partner_image">
        <a href="http://wilart.pl" target="blank">
            <img src="@/assets/images/partners/willart.jpeg" alt="andrzejsajewski_willart" loading="lazy">
        </a> 
    </div> 
    <!--
    <ul class="partner_list">
        <li>Tadeo_Art</li>
        <li>WILART</li>
    </ul> -->
</div>
    
</div>
    </div>
</template>

<script>
import ChapterHeader from '@/components/ChapterHeader.vue'


export default ({
    components:{
        ChapterHeader,
    },
    data(){
      return{

      }
  }
})
</script>

<style scoped>
    #pratners{
        padding-bottom: 70px;
        background: #2B2B2B;
        position: relative;
        overflow: hidden;
    /*    z-index: 1; */
    }
    .max-width{
    max-width: 1500px;
    margin: 20px auto;
    padding: 20px 100px;
    display: flex;
    justify-content: center;
    
}
.partners{
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    justify-content: center;
    margin-top: -20px;
}
.partner_image:hover{
    transform: scale(1.1);
    cursor: pointer;
}
.partner_image{
    width: 200px;
    margin: 20px 20px auto 20px;
    height: 130px;
    transition: .5s;
}
.partner_image > a, .partner_image > a > img{
    width: 100%;
    height: 100%;
}
.auction_text{
    width: 90%;
    text-align: center;
    margin: auto;
    color: white;
    padding: 5px 0 5px 0;
}
@media(max-width:766px){
    .max-width{
        padding: 20px 40px;
    }
}
.partner_list{
    list-style-type: none;
    color: white;
    font-weight: 700;
    margin: 0;
    padding: 0;
}
.partner_list > li{
    margin-top: 30px;
}
.partner_list > li:first-child{
    margin-top: 0;
}
</style>