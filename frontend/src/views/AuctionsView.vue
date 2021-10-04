<template>
    <div id="aukcje" >
        <div class="row chapter_title">{{ $t("message.auctionsTitle") }}</div>
        <ChapterHeader></ChapterHeader>

    <div v-if="ShowAuctions" class="auction_text">
        <p>
            {{$t('message.Auctions_Info')}}
        </p>
    </div>

<div class="no_auctions" v-if="!ShowAuctions">{{$t('message.NoAuctions')}}</div>

<div class="row max-width" ref="auction_images" v-if="ShowAuctions">

        <splide class="auction_slide" :options="options" style="width: 100vw;" v-if="ShowAuctions">
        <splide-slide v-if="ifAuth">
            <div @click="showAddAuctionModal">
               <AddNewItemVertical></AddNewItemVertical>
            </div>
        </splide-slide>

        <splide-slide 
            v-for="auctions in AuctionArray" 
            :key="auctions.id"
        >
        <div>

            <div v-if="((ifAuth)&&(GET_ROLE.role==='Administrator'))" class="admin_options">
                <div class="admin_options_container">
                    <div class="admin_options_row">
                        <Trash2Icon @click="SelectAuctionToDelete(auctions.ID)" class="category_delete_icon"></Trash2Icon>
                    </div>
                </div>
            </div>
             <div v-if="ifAuth" class="admin_options" v-bind:style="[GET_ROLE.role==='Administrator' ? {'top': '65px'} : {'top': '0px'}]">
                <div class="admin_options_container">
                    <div class="admin_options_row">
                        <Edit3Icon @click="SelectAuctionToEdit(auctions)" class="category_delete_icon"></Edit3Icon>
                    </div>
                </div>
            </div>

            <div @click="showAuctionPictureModal(auctions)">
               <AucitonCard :DataArrayAuction="auctions" :ShowAuctionIMG="ShowAuctionImage"></AucitonCard>
            </div>

        </div>

        </splide-slide>

        
    </splide>
    
</div>

<AddAuctionModal v-if="isAddAuctionModal" @closeAddAuctionModal="closeAddAuctionModal"></AddAuctionModal>
<transition name="fade">
<AuctionPictureModal v-if="isAuctionPictureModal" @AuctionModalClose="closeAuctionPictureModal" :DataModalAuction="PictureAuctionModal_ID_ToOpen"></AuctionPictureModal>
</transition>
<DeleteModal v-if="isDeleteModalVisible" @close="closeDeleteModal" @deleteElement='DeleteElement'></DeleteModal>
<EditModal v-if="isEditAuctionModal" @closeEditModal="closeAddAuctionModal" :EditData="aucitonToEdit"></EditModal>

    </div>
</template>

<script>
import ChapterHeader from '@/components/ChapterHeader.vue'
import { Splide, SplideSlide } from '@splidejs/vue-splide'
import '@splidejs/splide/dist/css/themes/splide-default.min.css'
import AucitonCard from '@/components/AuctionCard.vue'
import AddNewItemVertical from '@/components/AddNewItemVertical.vue'
import AddAuctionModal from '@/components/Modals/AddAuctionModal.vue'
import EditModal from '@/components/Modals/EditAuctionModal.vue'
import AuctionPictureModal from '@/components/Modals/AuctionPictureModal.vue'
import API from '../http.js'
import {mapGetters} from 'vuex'
import {Trash2Icon, Edit3Icon } from '../utils/libs/Icons'
import DeleteModal from '@/components/Modals/DeleteModal.vue'

export default ({
    components:{
        ChapterHeader,
        Splide,
        SplideSlide,
        AucitonCard,
        AddNewItemVertical,
        AddAuctionModal,
        AuctionPictureModal,
        Trash2Icon,
        DeleteModal,
        Edit3Icon,
        EditModal
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
          isAddAuctionModal: false,
          isAuctionPictureModal: false,
          AuctionArray: [],
          ShowAuctions: false,
          PictureAuctionModal_ID_ToOpen: [],
          ShowAuctionImage: false,
          isDeleteModalVisible: false,
          auctionToDelete: null,
          isEditAuctionModal: false,
          aucitonToEdit: []
      }
  },
  methods:{
      showAddAuctionModal(){
          this.isAddAuctionModal = true;
          document.documentElement.style.overflow = 'hidden';
      },
      closeAddAuctionModal(){
          this.isAddAuctionModal = false;
          this.isEditAuctionModal = false;
          document.documentElement.style.overflow = 'auto';
      },
      showAuctionPictureModal(auctions){
          this.isAuctionPictureModal = true;
 
          this.PictureAuctionModal_ID_ToOpen = auctions;

          document.documentElement.style.overflow = 'hidden'
      },
      closeAuctionPictureModal(){
          this.isAuctionPictureModal = false;
          document.documentElement.style.overflow = 'auto'
      },
      getAuctions(){
          API.get(`auctions/auction_get.php`).then(response => {
                this.AuctionArray = response.data.Auctions;
                        
                if(this.GET_AUTH_STATUS === "logged"){
                    this.ifAuth = true;
                }else{
                this.ifAuth = false;
                }

                if(this.AuctionArray.length >= 1){
                    this.ShowAuctions = true;
                }else{
                    this.ShowAuctions = false;
                }
                
            }).catch(() => {

                if(this.GET_AUTH_STATUS === "logged"){
                    this.ifAuth = true;
                }else{
                this.ifAuth = false;
                }

                this.ShowAuctions = false;
            }); 
      },
      onScroll() {
            var AuctionsPosition = this.$refs["auction_images"];

            if (AuctionsPosition) {
                var marginTopUsersAuctions = AuctionsPosition.getBoundingClientRect().top;
                var innerHeightAuctions = window.innerHeight;
                        
                if (((marginTopUsersAuctions - innerHeightAuctions) < -50)) {                 
                    setTimeout(()=>{

                        this.ShowAuctionImage = true;
            
                    }, 1000)
                
                }                               
            }  
        },
        SelectAuctionToDelete(id){
            this.auctionToDelete = id;
            this.isDeleteModalVisible = true;
        },
        closeDeleteModal(){
            this.isDeleteModalVisible = false;
            this.auctionToDelete = null;
        },
        DeleteElement(){

            API.post(`/auctions/delete_auction.php?auction=${this.auctionToDelete}`, {
                    role: this.GET_ROLE.role
                }, {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('user-token')
                    }
                }).then(() => {

                    this.$router.go();
                    
                }).catch(() => {
                    
                    alert("Nie można usunąć aukcji.");
        
            });

            this.isDeleteModalVisible = false;
            this.auctionToDelete = null;
        },
        SelectAuctionToEdit(item){
          this.isEditAuctionModal = true;
          this.aucitonToEdit = item;
          document.documentElement.style.overflow = 'hidden';
      },
  },
  async created(){
    await this.getAuctions();
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
    #aukcje{
        padding-top: 50px;
        padding-bottom: 60px;
        background: #2B2B2B;
        position: relative;
        overflow: hidden;
    /*    z-index: 1; */
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
.no_auctions{
    color: white;
    margin-top: 50px;
    font-family: Brush Script MT;
    font-size: 30px;
}
</style>