<template>
  <div id="biografia" class="biography">
      <div class="container">
        <div class="row chapter_title">{{ $t("message.biographyTitle") }}</div>
            <ChapterHeader></ChapterHeader>

            <div class="fb_link"><a href="https://www.facebook.com/andrzejandrea.sajewski" target="blank"><FacebookIcon class="fb_icon"></FacebookIcon></a></div>

                <h2 class="author_description desc_1">
                    <b>Andrzej Andrea Sajewski </b>
                    {{$t("message.biographyPar_1")}}
                </h2>

                <div class="author_circle_image">
                    <img src="@/assets/images/biography/image0.jpeg" alt="AndrzejAndreaSajewski">
                    <div class="photographer_link">
                        <a href="https://sliwczynski.weebly.com/" target="blank">Foto: Jacek Śliwczyński</a>
                    </div>
                </div>

                <h2 class="author_description desc_2">
                    {{$t('message.biographyPar_2')}}
                </h2>
                <h2 class="author_description desc_3"> 
                    {{$t('message.biographyPar_3')}}
                </h2>

        <div style="clear:both;"></div>
                <h1 class="ZB_title">{{$t('message.Z_B_Title')}}</h1>
                <h2 class="author_description desc_4">
                    {{$t('message.Z_B_Description')}}
                </h2>

        <div class="image_row">
                <div class="author_last_left_image">
                    <img src="@/assets/images/biography/image.jpeg" alt="AndrzejAndreaSajewski_obraz_beksinski_1" loading="lazy">
                </div>

                <div class="author_last_right_image_div">
                    <div class="author_last_right_image">
                        <div class="author_image_section_row">
                            <div class="smaller_images_container">
                                <div class="smaller_images_container_inside">
                                     <img class="image" src="@/assets/images/biography/image1.jpeg" alt="AndrzejAndreaSajewski_obraz_beksinski_2" loading="lazy">  
                                </div>
                                <div class="smaller_images_container_inside">
                                   <img class="image" src="@/assets/images/biography/image3.jpeg" alt="AndrzejAndreaSajewski_obraz_beksinski_3" loading="lazy">  
                                </div>
                            </div>
                             <div class="large_images_container">
                                    <img class="image" src="@/assets/images/biography/image2.jpeg" alt="AndrzejAndreaSajewski_obraz_beksinski_4" loading="lazy">  
                             </div>

                        </div>
                      
                    </div>
                </div>
        </div>
            </div>

  </div>
</template>

<script>
import ChapterHeader from '@/components/ChapterHeader.vue'
import { FacebookIcon } from '../utils/libs/Icons'

export default {
  name: 'BiographyView',
  components:{
      ChapterHeader,
      FacebookIcon
  }
}
</script>
<style scoped>
.biography{
    width: 100%;
    margin: auto;
   /* box-shadow: 0px 5px 20px rgb(26, 26, 26); */
    margin-bottom: 100px;
    display: flex;
    background-image: url('~@/assets/images/background.png');
    background-repeat: no-repeat;
    background-size: cover;
   /* z-index: 1; */
    position: relative;
}
.container{
    max-width: 1400px;
    margin: auto;
    padding: 5%;
    width: 90%;
}
.author_section{
    margin-top: 40px;
    height: auto;
}
.author_circle_image{
    float: left;
    position: relative;
    border-radius: 50%;
    overflow: hidden;
    width: 45%;
    height: 100%;
    margin: auto;
 /*   margin: 3%; */
    margin-top: 40px;
    max-height: 80vh;
}
.photographer_link{
    position: absolute;
    width: 100%;
    height: 50px;
    background: rgba(255, 255, 255, .4);
    bottom: 0;
    line-height: 40px;
    font-size: 14px;
    border-radius: 50%;
   
}
.photographer_link > a{
    color: white;
    text-decoration: none;
    font-weight: 600;
    transition: .5s;
}
.photographer_link > a:hover{
    font-size: 14.7px;
}
.author_circle_image img{
    width: 120%;
    height: 100%;
}
.author_work_image img{
    width: 90%;
    margin-top: 30px;
}
.about_author{
    width: 50%;

}
.author_description{
    font-size: 16px;
    color: white;
    text-align: left;
    font-weight: 500;
    width: 50%;
    float: right;
    text-align: justify;
    line-height: 25px;
}
.desc_1{
   margin-top: 45px;
}
.desc_4{
    width: 100%;
    float: left;
    margin-top: 50px;
    z-index: 3;
    text-align: center;
    position: relative;
}
.author_work_image{
    float: left;
    width: 60%;
    max-height: 200px;
}
.author_last_left_image{
    width: 40%;
    position: relative;
    z-index: 1;
}

.author_last_left_image img, .author_last_right_image_div img{
    width: 100%;
}
.author_last_left_image img{
    border-radius: 20px;
    max-height: 70vh;
    object-fit: fill;
    width: 80%;
    height: 100%;
}
.author_last_right_image_div{
    width: 55%;
    margin-right: 0;
    margin: -11% 0 0 auto;
    background: rgb(78, 78, 78);
    display: flex;
    position: relative;
    z-index: 0;
    border-top-left-radius: 80px;
    border-bottom-left-radius: 30px;
}
.author_last_right_image{
    width: 80%;
    margin: 17% auto 30px auto;
    display: flex;
}
.author_image_section_row{
    display: flex;
    max-height: 70vh;
    position: relative;
    margin: auto;
    width: 100%;
}
.smaller_images_container, .large_images_container{
    width: 50%;
}
.large_images_container > .image{
    height: 100%;
}
.smaller_images_container{
    position: relative;
    display: flex;
    flex-wrap: wrap;
}
.smaller_images_container_inside{
    width: 90%;
    height: 50%;
    margin: auto;
    display: flex;
}
.smaller_images_container_inside > .image{
    margin: auto;
}
@media(max-width:1217px){
    .desc_3{
        width:100%;
    }
}
@media(max-width:968px){
    .desc_2{
        width:100%;
        margin-top: 40px;
    }
    .chapter_title{
        margin-top: 50px;
    }
}
@media(max-width:786px){
    .desc_1{
        width:100%;
        margin-top: 15px;
    }
    .author_circle_image{
        width: 100%;
    }
}
.image_row{
    width: 95vw;
    display: flex;
    padding-top: 40px;
    margin-bottom: 250px;
    max-width: 1500px;
}
.image{
    width: 90%;
    height: 90%;
    border-radius: 7px;
    transition: .5s;
}
.image:hover{
    transform: scale(1.05);
    overflow: hidden;
}
@media(max-width:622px){
    .image_row{
        display: block;
        margin-top: 20px;
    }
    .author_last_right_image_div{
       /* margin-top: -70px auto 30px auto; */
        width: 100%;
    }
    .author_last_left_image{
        width: 90%;
        margin: 0px auto 20px auto;
    }
    .author_last_left_image img{
        margin-top: 20px;
    }
    .author_last_left_image{
        margin-top: 30px;
    }
    .desc_4{
        margin-top: 30px;
    }
}
.ZB_title{
    font-size: 26px;
    color: white;
    margin-bottom: 6px;
}
.fb_link{
    position: fixed;
    top: 50%;
    left: 0;
    background: #184b8c;
    z-index: 2;
    width: 35px;
    padding-top: 12px;
    height: 35px;
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
    cursor: pointer;
    transition: .4s;
}
.fb_link:hover{
    transform: scale(1.3);
}
.fb_icon{
    font-size: 22px;
    color: white;
}
</style>
