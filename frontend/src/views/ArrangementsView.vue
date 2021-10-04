<template>
<div id="aranzacje" v-if="ShowArrangements">
            
    <div class="row chapter_title">{{ $t("message.arrangementsTitle") }}</div>
        <ChapterHeader></ChapterHeader>

    <div class="auction_text">
        <p>
            {{$t('message.Arrangement_Info')}}
        </p>
    </div>

    <div class="row max-width" ref="arrangement_images">

            <splide class="auction_slide" :options="options" style="width: 100vw;" v-if="ShowArrangements">
                <splide-slide v-if="ifAuth">
                    <div @click="showAddArrangementnModal">
                        <AddNewItemVertical></AddNewItemVertical>
                    </div>
                </splide-slide>
            
                <splide-slide    
                v-for="arrangement in ArrangementArray" 
                :key="arrangement.id"
                >

                <div>

                    <div v-if="((ifAuth)&&(GET_ROLE.role==='Administrator'))" class="admin_options">
                        <div class="admin_options_container">
                            <div class="admin_options_row">
                                <Trash2Icon @click="SelectArrangementToDelete(arrangement.ID)" class="category_delete_icon"></Trash2Icon>
                            </div>
                        </div>
                    </div>

                    <div @click="showArrangementPictureModal(arrangement)">
                            <ArrangementCard :DataArrayArrangement="arrangement" :ShowArrangementIMG="ShowArrangementImage"></ArrangementCard>
                    </div>

                </div>
                
            </splide-slide>
            
        </splide>
        
    </div>

<AddArrangementsModal v-if="isAddArrangementsModal" @closeAddArrangementModal="closeAddArrangementsModal"></AddArrangementsModal>
<transition name="fade">
<ArrangementPictureModal v-if="isAurrangementPictureModal" @ArrangementModalClose="closeArrangementPictureModal" :DataModalArrangement="PictureArrangementModal_ID_ToOpen"></ArrangementPictureModal>
</transition>
<DeleteModal v-if="isDeleteModalVisible" @close="closeDeleteModal" @deleteElement='DeleteElement'></DeleteModal>

</div>
</template>

<script>
import ChapterHeader from '@/components/ChapterHeader.vue'
import { Splide, SplideSlide } from '@splidejs/vue-splide';
import '@splidejs/splide/dist/css/themes/splide-default.min.css'
import ArrangementCard from '@/components/ArrangementCard.vue'
import AddNewItemVertical from '@/components/AddNewItemVertical.vue'
import AddArrangementsModal from '@/components/Modals/AddNewPictureModal.vue'
import ArrangementPictureModal from '@/components/Modals/ArrangementPictureModal.vue'
import API from '../http.js'
import {mapGetters} from 'vuex'
import {Trash2Icon } from '../utils/libs/Icons'
import DeleteModal from '@/components/Modals/DeleteModal.vue'

export default ({
      components:{
        ChapterHeader,
        Splide,
        SplideSlide,
        ArrangementCard,
        AddNewItemVertical,
        AddArrangementsModal,
        ArrangementPictureModal,
        Trash2Icon,
        DeleteModal
    },
    data(){
      return{
          options: {
            rewind : true,
            autoWidth: true,
            gap: 30,
            width: '100%',
            pagination: false
          },
          isAddArrangementsModal: false,
          isAurrangementPictureModal: false,
          ArrangementArray: [],
          ShowArrangements: false,
          PictureArrangementModal_ID_ToOpen: [],
          ifAuth: false,
          ShowArrangementImage: false,
          isDeleteModalVisible: false,
          arrangementToDelete: null
      }
  },
    methods:{
      showAddArrangementnModal(){
          this.isAddArrangementsModal = true;
          document.documentElement.style.overflow = 'hidden'
      },
      closeAddArrangementsModal(){
          this.isAddArrangementsModal = false;
          document.documentElement.style.overflow = 'auto'
      },
      showArrangementPictureModal(arrangement){
          this.isAurrangementPictureModal = true;

            this.PictureArrangementModal_ID_ToOpen = arrangement;
            this.isAuctionPictureModal = true;
 
          document.documentElement.style.overflow = 'hidden'
      },
      closeArrangementPictureModal(){
          this.isAurrangementPictureModal = false;
          document.documentElement.style.overflow = 'auto'
      },
      getArrangementImages(){
            API.get(`arrangements/arrangement_get.php`).then(response => {
                this.ArrangementArray = response.data.Arrangements;
                
                if(this.GET_AUTH_STATUS === "logged"){
                    this.ifAuth = true;
                }else{
                this.ifAuth = false;
                }
                this.ShowArrangements = true;
            }).catch(e => {
                console.log(e);
                
                if(this.GET_AUTH_STATUS === "logged"){
                    this.ifAuth = true;
                }else{
                this.ifAuth = false;
                }
                this.ShowArrangements = false;
            }); 
      },
       onScroll() {
            var ArrangementPosition = this.$refs["arrangement_images"];

            if (ArrangementPosition) {
                var marginTopUsersArrangement = ArrangementPosition.getBoundingClientRect().top;
                var innerHeightArrangement = window.innerHeight;
                        
                if (((marginTopUsersArrangement - innerHeightArrangement) < -50)) {                 
                    setTimeout(()=>{

                        this.ShowArrangementImage = true;
            
                    }, 1000)
                
                }                               
            }  
        },
        SelectArrangementToDelete(id){
            this.arrangementToDelete = id;
            this.isDeleteModalVisible = true;
        },
        closeDeleteModal(){
            this.isDeleteModalVisible = false;
            this.arrangementToDelete = null;
        },
        DeleteElement(){

            API.post(`/arrangements/delete_arrangement.php?arrangement=${this.arrangementToDelete}`, {
                    role: this.GET_ROLE.role
                }, {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('user-token')
                    }
                }).then(() => {

                    this.$router.go();
                    
                }).catch(() => {
                    
                    alert("Nie można usunąć aranżacji.");
        
            });

            this.isDeleteModalVisible = false;
            this.arrangementToDelete = null;
        }
  },
    async created(){
        await this.getArrangementImages();
    },
    mounted() {
        this.$nextTick(function() {
            window.addEventListener('scroll', this.onScroll);
            this.onScroll(); // needed for initial loading on page
        });        
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
    #aranzacje{
        padding-top: 50px;
        padding-bottom: 40px;
        background: #2B2B2B;
        position: relative;
        overflow: hidden;
      /*  z-index: 1; */
    }
    .max-width{
    max-width: 1500px;
    margin: 20px auto;
    padding: 20px 100px;
    
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
</style>