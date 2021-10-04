<template>
    <div class="category_card">

        <div class="horizontal_style_border"></div>
           <img class="category_card_paraf" src="@/assets/images/paraf.png" alt="andrzej_andrea_sajewski_smalllogo">
        <div class="vertical_style_border"></div>

           <div class="category_card_mask"></div> 



            <transition name="fade">
                <div v-show="loader" class="loader_container">
                    <img class="image_Loader" src="@/assets/images/loading.svg" alt="andrzej_sajewski_loader"/>   
                </div>
            </transition>
            <transition name="fade">
                 <img loading="lazy" @load="imageLoader" class="category_card_img" v-bind:src="img+'/categories/'+DataArray.CategoryImagePath" v-bind:alt="'andrzej_sajewski_'+DataArray.CategoryName"/>
            </transition>

            <div v-if="showCategoryIMG" class="category_card_text_div">
                <div class="category_card_text">
                    <h3 class="category_card_text_title">{{ category_title }}</h3>
                    <hr class="category_card_text_hr" />
                </div>
            </div>
           

        <div class="horizontal_style_border_bottom"></div>
         <img class="category_card_paraf_bottom" src="@/assets/images/paraf.png" alt="andrzej_andrea_sajewski_smalllogo">
        <div class="vertical_style_border_bottom"></div>
    </div>
</template>

<script>
import globalURL from "../globalURL"
import { mapGetters } from 'vuex'

export default ({
    props:{
        DataArray: [],
        showCategoryIMG: {
            type: Boolean,
            default: false
        }
    },
    data(){
        return{
            img: globalURL,
            ifAuth: false,
            category_title: '',
            loader:{
                type: Boolean,
                default: true
            }
        }
    },
    created(){
        //console.log(this.DataArray);
        this.reloadTitle();
    },
    methods:{
        async reloadTitle(){
            if(this.GET_LANG === 'en'){
                this.category_title = this.DataArray.CategoryNameENG;
            }else if(this.GET_LANG === 'it'){
                this.category_title = this.DataArray.CategoryNameIT;
            }else{
                this.category_title = this.DataArray.CategoryName;
            }
        },
        imageLoader(){
            setTimeout(()=>{
                this.loader = false;
            }, 1000)
        }
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
.category_card{
    width: 23vw;
    height: 65vh;
   /* margin: 1%; */
    max-height: 470px;
    max-width: 330px;
    min-height: 350px;
    position: relative;
    border-radius: 5px;
    transition: .5s;
    display: flex;
    background: #2B2B2B;
}
.category_card:hover{
    transform: scale(1.05);
    cursor: pointer;
}
.category_card_paraf, .category_card_paraf_bottom{
    position: absolute;
    left: 10px;
    top: 15px;
    width: 35px;
}
.category_card_paraf_bottom{
    bottom: 15px;
    right: 10px;
    top: unset;
    left: unset;
}
.category_card_img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    transition: .1s;
    margin: auto;
}
.category_card_mask{
    position: absolute;
    height: 100%;
    width: 100%;
    top: 0;
    left: 0;
    z-index: 4;
}
.category_card_text_div{
    position: absolute;
    top: 50%;
    left:0;
    transform: translate(0, -50%);
    width: 100%;
    background: rgba(0, 0, 0, .5);
    color: white;
}
.category_card_text_title{
    font-weight: 900;
    font-size: 22px;
}
.category_card_text_hr{
    margin: -15px auto 25px auto;
    width: 65%;
    height: 3px;
    border: none;
    background: white;
}
@media(max-width:1040px){
    .category_card{
        height: 45vh;
    }
    .category_card_paraf, .category_card_paraf_bottom{
        width: 30px;
    }
}
@media(max-width:766px){
    .category_card{
        width: 30vw;
        height: 35vh;
    }
    .category_card_paraf, .category_card_paraf_bottom{
        width: 20px;
    }
    .category_card_paraf{
        left: 5px;
        top: 10px;
    }
    .category_card_paraf_bottom{
        right: 5px;
        bottom: 10px;
    }
}
@media(max-width:644px){
    .category_card{
        height: 40vh;
        width: 35vw;
    }
    .category_card_text_title{
        font-weight: 500;
    }
}
@media(max-width:476px){
    .category_card{
        width: 50vw;
        min-height: 320px;
    }
}
.horizontal_style_border, .vertical_style_border, .horizontal_style_border_bottom, .vertical_style_border_bottom{
    background: white;
    position: absolute;
    z-index: 2;

}
.horizontal_style_border, .horizontal_style_border_bottom{
    width: 40%;
    top: 20px;
    left: 50px;
    height: 2px;
}
.horizontal_style_border_bottom{
    top: unset;
    left: unset;
    bottom: 20px;
    right: 50px;
}
.vertical_style_border, .vertical_style_border_bottom{
    height: 30%;
    width: 2px;
    top: 50px;
    left: 20px;
}
.vertical_style_border_bottom{
    top: unset;
    left: unset;
    bottom: 50px;
    right: 20px;
}
@media(max-width:766px){
    .horizontal_style_border, .horizontal_style_border_bottom{
        width: 40%;
        top: 15px;
        left: 30px;
        height: 2px;
    }
    .horizontal_style_border_bottom{
        top: unset;
        left: unset;
        bottom: 15px;
        right: 30px;
    }
    .vertical_style_border, .vertical_style_border_bottom{
        height: 30%;
        width: 2px;
        top: 35px;
        left: 15px;
    }
    .vertical_style_border_bottom{
        top: unset;
        left: unset;
        bottom: 35px;
        right: 15px;
    }
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
