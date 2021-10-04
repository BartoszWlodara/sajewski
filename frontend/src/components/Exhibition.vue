<template>
    <div class="exhibition_row" :class="{ exhb_reverse: revert_display }">

        <div class="exhibition_text">
            <div class="exhibition_date_row">
                <hr class="exhibition_hr"/>
                <div class="exhibiotion_date"><p>{{ DataArrayExhibition.Date }}</p></div>
            </div>
            <div class="exhibition_title">{{ exhibition_title }}</div>
            <div class="exhibition_desc">
                <p>
                    {{ exhibition_description }}
                </p>
            </div>
        </div>
        <div class="exhibition_image_container">
            <div class="exhibition_image">

                <img v-if="!showExhibitionIMG" loading="lazy" class="image_Loader" src="@/assets/images/loading.svg" alt="andrzej_sajewski_loader"/>
                <transition name="fade">
                  <img v-if="showExhibitionIMG" loading="lazy" v-bind:src="img+'/exhibitions/'+DataArrayExhibition.ImagePath" v-bind:alt="'andrzej_sajewski_wystawa'+DataArrayExhibition.Title"/>
                </transition>

            </div>
        </div>
        
    </div>
</template>
<script>
//import { defineComponent } from '@vue/composition-api'
import globalURL from "../globalURL"
import { mapGetters } from 'vuex'
import moment from 'moment'


export default ({
    props:{
        DataArrayExhibition: [],
        showExhibitionIMG:{
            type: Boolean,
            default: false
        },
        index_no: null
    },
    data(){
        return{
            img: globalURL,
            ifAuth: false,
            exhibition_title: '',
            exhibition_description: '',
            revert_display: false
        }
    },
    methods:{
         async reloadText(){
            if(this.GET_LANG === 'en'){
                this.exhibition_title = this.DataArrayExhibition.TitleANG;
                this.exhibition_description = this.DataArrayExhibition.DescriptionANG;
            }else if(this.GET_LANG === 'it'){
                this.exhibition_title = this.DataArrayExhibition.TitleIT;
                this.exhibition_description = this.DataArrayExhibition.DescriptionIT;
            }else{
                this.exhibition_title = this.DataArrayExhibition.Title;
                this.exhibition_description = this.DataArrayExhibition.Description;
            }
        },
        checkRevert(){
            let index = this.index_no;
            index = index + 1;
            if((index % 2) === 0){
                this.revert_display = true;
            }else{
                this.revert_display = false;
            }
        }
    },
    mounted(){
        this.DataArrayExhibition.Date = moment(this.DataArrayExhibition.Date).format('DD-MM-YYYY');
    },
    created(){
        if(this.GET_AUTH_STATUS === "logged"){
            this.ifAuth = true;
        }else{
            this.ifAuth = false;
        }

        this.reloadText();
        this.checkRevert();
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
                this.reloadText();
            }
        }
    }
})
</script>
<style scoped>
.exhibition_row, .exhibition_date_row{
    width: calc(100% - 40px);
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    padding: 20px;
    position: relative;
}
.exhibition_date_row{
    padding-left: 10px;
    width: calc(100% - 10px);
}
.exhibition_hr{
    width: calc(100% - 110px);
    border: none;
    height: 2px;
    background: #E4A255;
    margin: 20px 0 0 -10px;
}
.exhibiotion_date{
    color: #E4A255;
    font-weight: 700;
    margin-top: -5px;
}
.exhibition_text{
    width: calc(55% - 40px);
    padding: 0 20px 0 20px;
}
.exhibition_image_container{
    width: 45%;
    display: flex;
    height: 40vh;
    min-height: unset;
}
.exhibition_image{
    width: 100%;
    margin: auto;
    height: 100%;
    display: flex;
}
.exhibition_image img{
    width: 100%;
    border-radius: 5px;
    height: 100%;
    object-fit: cover;
}
.exhibition_title{
    width: 100%;
    text-align: left;
    font-size: 18px;
    color: white;
    font-weight: 700;
}
.exhibition_desc{
    width: 100%;
    margin-top: 30px;
    text-align: center;
    font-size: 16px;
    color: white;
    font-weight: 600;
}
@media(min-width:992px){
    .exhibition_row{
        margin-top: 50px;
    }
    .exhb_reverse{
        flex-direction: row-reverse;
    }
    .exhibition_image_container{
        min-height: 40vh;
        height: unset;
    }
}
@media(max-width:991px){
    .exhibition_row, .exhibition_date_row{
        padding: 0;
        width: 100%;
    }
    .exhibition_image_container, .exhibition_text{
        width: 100%;
        padding: 20px;
    }
    .exhibition_image_container{
        padding-top: 0;
    }
    .exhibition_image{
        width: 95%;
    }
}
.admin_options{
    width: 60px;
    border-radius: 50%;
    top: -25px;
    right: 2%;
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
