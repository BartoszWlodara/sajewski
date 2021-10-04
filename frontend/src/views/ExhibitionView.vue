<template>
    <div id="wystawy" ref="exhibition_images" v-if="showExhibitionView">
 
    <div class="exhibition_background_div">
            <div class="exhibition_background_div_fixed">
                <div class="exhibition_background_image"></div>
            </div>
    </div>

        <div class="row chapter_title">{{ $t("message.exhibiotonsTitle") }} </div>
        <ChapterHeader></ChapterHeader>
    
        <div @click="showExhibitionModal" v-if="ifAuth">
             <AddNewItemHorizontal></AddNewItemHorizontal>          
        </div>


    <transition-group name="fade">

           
        <div v-for="(exhibition, index) in ExhibitionArray"
            :key="exhibition.ID"
            class="exhibition_container">

                         <div v-if="((ifAuth)&&(GET_ROLE.role==='Administrator'))" class="admin_options">
                                <div class="admin_options_container">
                                    <div class="admin_options_row">
                                    <Trash2Icon @click="SelectExhibitionToDelete(exhibition.ID)" class="category_delete_icon"></Trash2Icon>
                                    </div>
                                </div>
                        </div>
                         <div v-if="ifAuth" class="admin_options" v-bind:style="[GET_ROLE.role==='Administrator' ? {'right': '65px'} : {'right': '0px'}]">
                                <div class="admin_options_container">
                                    <div class="admin_options_row">
                                    <Edit3Icon @click="SelectExhibitionToEdit(exhibition)" class="category_delete_icon"></Edit3Icon>
                                    </div>
                                </div>
                        </div>

                <Exhibition v-if="exhibition.ID" :index_no="index" :DataArrayExhibition="exhibition" :showExhibitionIMG="ShowExhibitionImage"></Exhibition>
        </div>
  
    </transition-group>

<button v-if="buttonActive" class="show_more_btn" @click="GetMoreExhibitions">{{$t('message.ShowMore')}}</button>

        <AddExhibitionModal v-if="isActiveModalExhibition" @closeExhibitionModal="closeExhibitionModal"></AddExhibitionModal>

            
        <DeleteModal v-if="isDeleteModalVisible" @close="closeDeleteModal" @deleteElement='DeleteElement'></DeleteModal>

        <EditExhibitionModal v-if="isEditModalVisible" @closeEditExhibitionModal="closeExhibitionModal" :ExhibitionToEdit="itemToEdit"></EditExhibitionModal>


    </div>
</template>

<script>
import ChapterHeader from '@/components/ChapterHeader.vue'
import Exhibition from '@/components/Exhibition.vue'
import AddNewItemHorizontal from '@/components/AddNewItemHorizontal.vue'
import AddExhibitionModal from '@/components/Modals/AddExhibitionModal'
import EditExhibitionModal from '@/components/Modals/EditExhibitionModal'
import API from '../http.js'
import {mapGetters} from 'vuex'
import { Trash2Icon, Edit3Icon } from '../utils/libs/Icons'
import DeleteModal from '@/components/Modals/DeleteModal.vue'

export default ({
    components: {
        ChapterHeader, 
        Exhibition,
        AddNewItemHorizontal,
        AddExhibitionModal,
        Trash2Icon,
        DeleteModal,
        Edit3Icon,
        EditExhibitionModal
    },
    data(){
        return{
            isActiveModalExhibition: false,
            ExhibitionArray: [],
            active_page: 1,
            first_load: false,
            loadmore: false,
            ifAuth: false,
            scrollPosition: null,
            ExhibitionTopPosition: null,
            ExhibitionBottomPosition: null,
            windowHeight: window.innerHeight,
            ShowExhibitionImage: false,
            showExhibitionView: true,
            buttonClicks: 0,
            buttonActive: true,
            isDeleteModalVisible: false,
            ItemToDelete: null,
            isEditModalVisible: false,
            itemToEdit: []
        }
    },
    methods:{
        showExhibitionModal(){
            this.isActiveModalExhibition = true;
            document.documentElement.style.overflow = 'hidden'
        },
        closeExhibitionModal(){
            this.isActiveModalExhibition = false;
            this.isEditModalVisible = false;
            document.documentElement.style.overflow = 'auto'
        },
        loadDefaultExhibitions(){
           
            if(this.first_load !== true){
                API.get(`exhibitions/exhibition_get.php?page=1`).then(response => {
                    this.ExhibitionArray = response.data.data.Exhibitions;
                    let Pages = response.data.pages;

                    if(Pages <= 1){
                        this.buttonActive = false;
                    }

                    if(this.GET_AUTH_STATUS === "logged"){
                        this.ifAuth = true;
                    }else{
                        this.ifAuth = false;
                    }

                }).catch(e => {
                    console.log(e);
                    this.showExhibitionView = false;
                }); 

                 this.first_load = true;
            }
           
        },
        GetMoreExhibitions(){
          

            this.active_page += 1;
            
            API.get(`exhibitions/exhibition_get.php?page=${this.active_page}`).then(response => {
                    
                response.data.data.Exhibitions.forEach((x, index) => {
        
                    this.ExhibitionArray.push(response.data.data.Exhibitions[index]);

                    if(this.GET_AUTH_STATUS === "logged"){
                        this.ifAuth = true;
                    }else{
                        this.ifAuth = false;
                    }
                }); 

                this.buttonClicks += 1;

                if(this.buttonClicks === response.data.pages-1){
                    this.buttonActive = false;
                }
                
               // this.ExhibitionArray = this.ExhibitionArray.push.apply(subArray);
               
            }).catch(e => {
                console.log(e);
            }); 

        },
     /*   updateScroll() {
          this.scrollPosition = window.scrollY;

          this.ExhibitionTopPosition= document.querySelector('#wystawy').offsetTop-this.windowHeight;
          this.ExhibitionBottomPosition = document.querySelector('#wystawy').offsetHeight+(this.ExhibitionTopPosition+this.windowHeight);

          if((this.scrollPosition >= this.ExhibitionTopPosition)&&(this.scrollPosition <= this.ExhibitionBottomPosition)){
              document.getElementById('wystawy').style.visibility = 'visible';
          }else{
              document.getElementById('wystawy').style.visibility = 'hidden';
          }

        }, */
        onScroll() {
            var ExhibitionPosition = this.$refs["exhibition_images"];

            if (ExhibitionPosition) {
                var marginTopUsersExhibitions = ExhibitionPosition.getBoundingClientRect().top;
                var innerHeightExhibitions= window.innerHeight;
                        
                if (((marginTopUsersExhibitions - innerHeightExhibitions) < -50)) {                 
                    setTimeout(()=>{

                        this.ShowExhibitionImage = true;
                        this.$emit('showExhibitionView');
            
                    }, 1000)
                
                }                               
            }  
        },
        SelectExhibitionToDelete(id){
            this.ItemToDelete = id;
            this.isDeleteModalVisible= true;
        },
        closeDeleteModal(){
            this.ItemToDelete = null;
            this.isDeleteModalVisible = false;
        },
        DeleteElement(){

                API.post(`/exhibitions/delete_exhibition.php?exhibition=${this.ItemToDelete}`, {
                    role: this.GET_ROLE.role
                }, {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('user-token')
                    }
                }).then(() => {

                    this.$router.go();
                    
                }).catch(() => {
                    
                    alert("Nie można usunąć wystawy.");
        
                });

            this.ItemToDelete = null;
            this.isDeleteModalVisible = false;
        },
        SelectExhibitionToEdit(item){
            this.itemToEdit = item;
            this.isEditModalVisible = true;
        }
    },
    async created(){
        await this.loadDefaultExhibitions();
    },
    mounted() {
        this.$nextTick(function() {
            window.addEventListener('scroll', this.onScroll);
            this.onScroll(); // needed for initial loading on page
        });        
    },
    beforeDestroy() {
        window.removeEventListener('scroll', this.onScroll);
    },
    computed: {
        ...mapGetters([
            'GET_ROLE',
            'GET_AUTH_STATUS'
            // ...
            ])
    },
    /*mounted(){
        window.addEventListener('scroll', this.updateScroll);
        
    }*/
})
</script>

<style scoped>
#wystawy{
    margin-top: 0;
    padding: 60px 0 120px 0;
    width: 100%;
    min-height: 100vh;
    position: relative;
  /*  z-index: 1; */         
    transition: .5s;
    overflow: hidden;
}
.exhibition_background_div{
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    position: absolute;
    z-index: -1;
}
.exhibition_background_div_fixed{
    width: 100%;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    z-index: -5;
}
.exhibition_background_image{
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background-image: url('~@/assets/images/exhb.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
}
.exhibition_mask{
    position: absolute;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, .3);
    top: 0;
    left: 0;
    z-index: -2;
}
.exhibition_container{
    width: 80%;
    margin: 30px auto 0px auto;
    max-width: 1400px;
    background: rgba(0, 0, 0, .4);
    border-radius: 10px;
    position: relative;
}
@media(max-width:676px){
    .exhibition_container{
        width: 95%;
    }
}
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
.show_more_btn{
    background: #7D674D;
    width: 190px;
    height: 45px;
    margin-top: 50px;
    border: none;
    border-radius: 8px;
    color: white;
    font-weight: 600;
    font-size: 15px;
    transition: .4s;
}
.show_more_btn:hover{
    background: #4b3d2c;
    color: rgb(219, 219, 219);
}
.admin_options{
    top: -30px;
}
</style>