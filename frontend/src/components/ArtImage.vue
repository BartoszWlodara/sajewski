<template>
    <div class="art_image_container">
            <div v-if="((ifAuth)&&(GET_ROLE.role==='Administrator'))" class="admin_options">
                <div class="admin_options_container">
                    <div class="admin_options_row">
                        <Trash2Icon @click="retrunImageID" class="category_delete_icon"></Trash2Icon>
                    </div>
                </div>
            </div>
             <div v-if="ifAuth" class="admin_options" v-bind:style="[GET_ROLE.role==='Administrator' ? {'top': '65px'} : {'top': '0px'}]">
                <div class="admin_options_container">
                    <div class="admin_options_row">
                        <Edit3Icon @click="returnImageIDtoEdit" class="category_delete_icon"></Edit3Icon>
                    </div>
                </div>
            </div>
            
        <div @click="click" class="art_image">

            <transition name="fade">
                <div v-show="loader" class="loader_container">
                    <img class="image_Loader" src="@/assets/images/loading.svg" v-bind:alt="'andrzej_sajewski_loader_picture'+DataArrayPicture.Title"/>
                </div>
            </transition>
            <transition name="fade">
                 <img loading="lazy" @load="imageLoader" v-bind:src="img+'/pictures/'+DataArrayPicture.PhotoImg_min" v-bind:alt="'andrzej_sajewski_picture_'+DataArrayPicture.Title"/>
            </transition>
        </div>
         <transition name="fade">
            <div v-if="(this.GET_LANG === 'pl')" class="art_image_title">{{ DataArrayPicture.Title }}</div>
            <div v-if="(this.GET_LANG === 'en')" class="art_image_title">{{ DataArrayPicture.TitleANG }}</div>
            <div v-if="(this.GET_LANG === 'it')" class="art_image_title">{{ DataArrayPicture.TitleIT }}</div>
         </transition>
    </div>
</template>

<script>
//import { defineComponent } from '@vue/composition-api'
import globalURL from "../globalURL"
import { mapGetters } from 'vuex'
import { Trash2Icon, Edit3Icon } from '../utils/libs/Icons'

export default ({
    components:{
        Trash2Icon,
        Edit3Icon
    },
    props:{
        DataArrayPicture: [],
        showIMG: {
            type: Boolean,
            default: false
        }
    },
    data(){
        return{
            img: globalURL,
            ifAuth: false,
            styleImageContainer: {
                display: 'flex'
            },
            loader:{
                type: Boolean,
                default: true
            }
        }
    },
    methods:{
        click(){
            this.$emit('clickFromImageGallery');
        },
        retrunImageID(){
            this.$emit('retrunImageID');
        },
        returnImageIDtoEdit(){
            this.$emit('returnImageIDtoEdit');
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
    },
    computed: {
       ...mapGetters([
        'GET_ROLE',
        'GET_AUTH_STATUS',
        'GET_LANG',
        'GET_IMAGE_PAGE_NO',
        'GET_FILTER'
        // ...
        ])
    }
})
</script>

<style scoped>
.art_image_container{
    width: 28%;
    height: 65vh;
    margin: 15px 2%;
    max-height: 550px;
    transition: .5s;
    position: relative;
}
.art_image{
    width: 100%;
    height: 85%;
    box-shadow: 0 0 10px black;
    overflow: hidden;
    display: flex;
    position: relative;
}
.art_image img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: .1s;
    margin: auto;
}
.art_image img:hover{
    transform:scale(1.15);
    cursor: pointer;
}
.art_image_title{
    width: 100%;
    text-align: center;
    margin-top: 20px;
    color: #E2E2E2;
}
@media(max-width:1100px){
    .art_image_container{
        height: 55vh;
    }
}
@media(max-width:899px){
    .art_image_container{
        width: 45%;
    }
}
@media(max-width:688px){
    .art_image_container{
        height: 45vh;
    }
}
@media(max-width:499px){
    .art_image_container{
        width: 80%;
        height: 50vh;
    }
}
@media(max-width:400px){
    .art_image_container{
        width: 90%;
        height: 55vh;
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