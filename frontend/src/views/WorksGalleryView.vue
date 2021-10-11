<template>
  <div v-if="CategoryArrayLoaded" id="prace" class="gallery">
        <div class="gallery_background"> </div>

            <div class="row chapter_title">{{ $t("message.worksTitle") }}</div>
            <ChapterHeader></ChapterHeader>

            <div class="row max-width" ref="category_images">

                    <splide :options="options" style="width: 100vw;">
                    <splide-slide v-if="ifAuth">
                        <div @click="showCategoryModal" class="add_category">
                            <div class="gallery_add_picture_container">
                                <PlusCircleIcon size="2.5x" class="anticon-plus-circle"></PlusCircleIcon>
                                <p>Dodaj kategorię</p>
                            </div>
                        </div>
                    </splide-slide>
                    <splide-slide>
                        <div @click="filteredImagesAll()">
                            <CategoryCard  :DataArray="propsCategoryFilterAll" :showCategoryIMG="ShowCategoryImage"></CategoryCard>
                        </div>
                    </splide-slide>
                    <splide-slide v-for="category in CategoriesArray" :key="category.id">
                        <div>

                            <div v-if="ifAuth" class="admin_options">
                                <div class="admin_options_container">
                            <!--  <div class="admin_options_row border_bottom">
                                        <a-icon type="edit" />
                                    </div> -->
                                    <div class="admin_options_row">
                                    <!--   <a-icon type="delete" /> -->
                                    <Trash2Icon @click="SelectCategoryToDelete(category.ID)" class="category_delete_icon"></Trash2Icon>
                                    </div>
                                </div>
                            </div>
                            <div v-if="ifAuth" class="admin_options" style="top:65px;">
                                <div class="admin_options_container">
                                    <div class="admin_options_row">
                                    <!--   <a-icon type="delete" /> -->
                                    <Edit3Icon @click="SelectCategoryToEdit(category)" class="category_delete_icon"></Edit3Icon>
                                    </div>
                                </div>
                            </div>
                            
                            <div @click="filteredImages(category)">
                                <CategoryCard :DataArray="category" :showCategoryIMG="ShowCategoryImage"></CategoryCard>
                            </div>
                            
                        </div>
                    </splide-slide>
                </splide>
            </div>

            
            <div v-if="ifAuth" style="z-index:2; position:relative;" @click="showAddPictureModal">
            <AddNewItemHorizontal></AddNewItemHorizontal>
            </div>


            <div v-if="this.GET_LANG === 'pl'" id="gallery_images_container" class="gallery_category_info_filter" ref="gallery_images">{{this.GET_FILTER.CategoryName}}</div>
            <div v-if="this.GET_LANG === 'en'" id="gallery_images_container" class="gallery_category_info_filter" ref="gallery_images">{{this.GET_FILTER.CategoryNameENG}}</div>
            <div v-if="this.GET_LANG === 'it'" id="gallery_images_container" class="gallery_category_info_filter" ref="gallery_images">{{this.GET_FILTER.CategoryNameIT}}</div>

            <div v-if="ShowGallery" class="gallery_container">

                <Loader v-if="loader" :galleryLoader="true"></Loader>

                <ArtImage 
                    v-for="picture in PicturesArray"
                    :key="picture.id"
                    :DataArrayPicture="picture"
                    :showIMG="ShowGalleryImage"
                    @clickFromImageGallery="showGalleryPictureModal(picture)"
                    @retrunImageID="SelectPictureToDelete(picture.ID)"
                    @returnImageIDtoEdit="SelectPictureToEdit(picture)" >
                </ArtImage>

                <div class="pagination">
                    <div class="pictures_pagination">
                        <div :class="{ arrow_actived: isArrowPrevActived }" @click="ImagePrevPage" class="pagination_arrows">
                            <ChevronLeftIcon size="1.7x" class="pagination_arrows_i"></ChevronLeftIcon>
                        </div>
                        <div class="display_pageNUM">{{GET_IMAGE_PAGE_NO}}</div>
                        <div :class="{ arrow_actived: isArrowNextActived }"  @click="ImageNextPage" class="pagination_arrows ">
                            <ChevronRightIcon size="1.7x" class="pagination_arrows_i"></ChevronRightIcon>
                        </div>
                    </div>
                </div>
                
                                
            </div>

            <CategoryModal v-if="isCategoryModal" @closeCategoryModal="closeCategoryModal"></CategoryModal>
           <transition name="fade">
            <GalleryPictureModal v-if="isGalleryModalVisible" @GalleryModalClose="closeGalleryPictureModal" :DataModal="PictureModal_ID_ToOpen"></GalleryPictureModal>
           </transition>
            <AddNewPictureModal v-if="isAddPictureModal" @closePictureModal="closeAddPictureModal"></AddNewPictureModal>

            <DeleteModal v-if="isDeleteModalVisible" @close="closeDeleteModal" @deleteElement='DeleteElement'></DeleteModal>

            <EditCategoryModal v-if="isEditCategoryModal" @closeCategoryModal="closeCategoryModal" :CategoryToEdit="EditCategoryModal_ID"></EditCategoryModal>
           
            <EditPictureModal v-if="isEditPictureModal" @closeCategoryModal="closeCategoryModal" :PictureToEdit="EditPictureModal_ID"></EditPictureModal>

  </div>
    <!--
 <router-link :to="{hash: '#me'}">ME</router-link> 

    <img alt="Vue logo" src="../assets/logo.png">
    <HelloWorld msg="Welcome to Your Vue.js App"/>
    <div id="me">jhjhj</div>

-->
</template>

<script>
import ChapterHeader from '@/components/ChapterHeader.vue'
import CategoryCard from '@/components/CategoryCard.vue'
import { Splide, SplideSlide } from '@splidejs/vue-splide'
import '@splidejs/splide/dist/css/themes/splide-default.min.css'
import ArtImage from '@/components/ArtImage.vue'
//import AddNewItemHorizontal from '@/components/AddNewItemHorizontal.vue'
import CategoryModal from '@/components/Modals/AddCategoryModal.vue'
import GalleryPictureModal from '@/components/Modals/GalleryPictureModal.vue'
import AddNewPictureModal from '@/components/Modals/AddNewPictureModal.vue'
import API from '../http.js'
import { mapGetters } from 'vuex'
import * as actionTypes from '../store/action-types'
import { ChevronRightIcon, ChevronLeftIcon, PlusCircleIcon, Trash2Icon, Edit3Icon } from '../utils/libs/Icons'
//import DeleteModal from '@/components/Modals/DeleteModal.vue'

export default {
  name: 'WorksGalleryView',
  components: {
    ChapterHeader,
    CategoryCard,
    Splide,
    SplideSlide,
    ArtImage,
    AddNewItemHorizontal: () => import('@/components/AddNewItemHorizontal.vue'),
    GalleryPictureModal,
    CategoryModal,
    AddNewPictureModal,
    ChevronRightIcon,
    ChevronLeftIcon,
    PlusCircleIcon,
    Trash2Icon,
    DeleteModal: () => import('@/components/Modals/DeleteModal.vue'),
    Edit3Icon,
    EditCategoryModal: () => import('@/components/Modals/EditCategoryModal.vue'),
    EditPictureModal: () => import('@/components/Modals/EditPictureModal.vue'),
    Loader: () => import('@/components/SmallLoader.vue')
  },
  data(){
    return{
        options: {
            rewind : true,
           // fixedWidth: '30%',
           autoWidth: true,
            gap: 30,
            width: '100%',
            pagination: false,
            preloadPages: 0,
        },
        isGalleryModalVisible: false,
        isCategoryModal: false,
        isAddPictureModal: false,
        CategoriesArray: [],
        ShowCategory: false,
        PicturesArray: [],
        PictureModal_ID_ToOpen: [],
        ifAuth: false,
        CategoryArrayLoaded: false,
        ShowGallery: false,
        ShowCategoryImage: false,
        ShowGalleryImage: false,
        propsCategoryFilterAll: 
            {
                CategoryName: "Wszystkie",
                CategoryNameENG: "All",
                CategoryNameIT: "Tutti",
                CategoryImagePath: "upload/category_all.png",
                ID: '00'
            },
        selectedCategory: null,
        PageNumber: '1',
        isArrowNextActived: true,
        isArrowPrevActived: false,
        totalPages: null,
        category_title: '',
        categoryItemToDelete: null,
        isDeleteModalVisible: false,
        pictureItemToDelete: null,
        elementTypeToDelete: '',
        isEditCategoryModal: false,
        EditCategoryModal_ID: [],
        isEditPictureModal: false,
        EditPictureModal_ID: [],
        loader: false
    }
  },
  methods: {
      showGalleryPictureModal(picture){
          this.isGalleryModalVisible = true;
          this.PictureModal_ID_ToOpen = picture;

          document.documentElement.style.overflow = 'hidden'
      },
      closeGalleryPictureModal(){
          this.isGalleryModalVisible = false;
          document.documentElement.style.overflow = 'auto'
      },
      showCategoryModal(){
          this.isCategoryModal = true;
           document.documentElement.style.overflow = 'hidden'
      },
      closeCategoryModal(){
          this.isCategoryModal = false;
          this.isEditCategoryModal = false;
          this.isEditPictureModal = false;
          document.documentElement.style.overflow = 'auto'
      },
      showAddPictureModal(){
          this.isAddPictureModal = true;
           document.documentElement.style.overflow = 'hidden'
      },
      closeAddPictureModal(){
          this.isAddPictureModal = false;
          document.documentElement.style.overflow = 'auto'
      },
      onScroll() {
        var CategoryPosition = this.$refs["category_images"];
        var GalleryPosition = this.$refs["gallery_images"];

        if (CategoryPosition) {
            var marginTopUsersCategory = CategoryPosition.getBoundingClientRect().top;
            var innerHeightCategory = window.innerHeight;
                    
            if (((marginTopUsersCategory - innerHeightCategory) < -50)) {                 
                setTimeout(()=>{

                    this.ShowCategoryImage = true;
          
                }, 1000)
               
            }                               
        }  
        if (GalleryPosition) {
            var marginTopUsersGallery = GalleryPosition.getBoundingClientRect().top;
            var innerHeightGallery = window.innerHeight;
                    
            if (((marginTopUsersGallery - innerHeightGallery) < -50)) {                 
                setTimeout(()=>{

                    this.ShowGalleryImage = true;
          
                }, 1000)
               
            }                               
        } 
      },  
      getCategories(){
            API.get(`categories/category_get.php`).then(response => {
               this.CategoriesArray = response.data.Categories;

                if(this.GET_AUTH_STATUS === "logged"){
                    this.ifAuth = true;
                }else{
                    this.ifAuth = false;
                }
                this.CategoryArrayLoaded = true;
                this.ShowCategory = true;

            }).catch(() => {
                    if(this.GET_AUTH_STATUS === "logged"){
                    this.ifAuth = true;
                    }else{
                        this.ifAuth = false;
                    }
                    this.CategoryArrayLoaded = false;
                this.ShowCategory = true;
            }); 
      },
      getImages(){
            API.get(`pictures/picture_get.php?category=${this.GET_FILTER.ID}&page=${this.GET_IMAGE_PAGE_NO}`).then(response => {
                this.PicturesArray = response.data.data.Pictures;
                this.totalPages = response.data.pages;
                this.ShowGallery = true;
              
              this.startStatusPagination();
                //return response.data.Pictures;
                //this.ShowCategory = true;
            }).catch(()=> {
                this.showGallery = false;
                // this.ShowCategory = true;
            }); 
      },
        filteredImages(category) {
        this.loader = true;
        this.$store.dispatch(actionTypes.FILTER, category).then((response) => {
        this.PicturesArray = [];
        this.PicturesArray = response.data.Pictures;

        this.totalPages = response.pages;
        this.startStatusPagination();
        
        }).catch(()=>{
            console.log("Błąd filtrowania.");
        })
            setTimeout(()=>{
                this.loader = false;
            }, 1500)
        },
        filteredImagesAll(){
            this.loader = true;
            this.$store.dispatch(actionTypes.FILTER_ALL).then((response) => {
                this.PicturesArray = [];
                this.PicturesArray = response.data.Pictures;
                this.totalPages = response.pages;
                this.startStatusPagination();
            }).catch(()=>{
                console.log("Błąd filtrowania all.");
            })
             setTimeout(()=>{
                this.loader = false;
            }, 1500)
        },
        startStatusPagination(){
            if(this.totalPages <= 1){
                this.isArrowNextActived = false;
            }else{
                if(this.GET_IMAGE_PAGE_NO < this.totalPages){
                    this.isArrowNextActived = true;
                }else{
                    this.isArrowNextActived = false;
                }
                 
            }

            if(this.GET_IMAGE_PAGE_NO > 1){
                this.isArrowPrevActived = true;
            }else{
                this.isArrowPrevActived = false;
            }
           
        },
        ImageNextPage(){
            this.loader = true;
            this.PicturesArray = [];
            if(this.GET_IMAGE_PAGE_NO < this.totalPages)
            this.$store.dispatch(actionTypes.PICTURE_NEXT_PAGE, {category :this.GET_FILTER.ID, page: this.GET_IMAGE_PAGE_NO}).then((response) => {
                this.PicturesArray = response;
                this.scroll_pagination();

                if(this.GET_IMAGE_PAGE_NO >= this.totalPages){
                    this.isArrowNextActived = false;
                }else{
                    this.isArrowNextActived = true;
                }
                this.isArrowPrevActived= true;

            }).catch(()=>{
                console.log("Błąd paginacji.");
            })
            else{
                this.isArrowNextActived = false;
                this.isArrowPrevActived= true;
            }
        },
        ImagePrevPage(){
            this.loader = true;
            this.PicturesArray = [];
            if(this.GET_IMAGE_PAGE_NO >= 2){
                    this.$store.dispatch(actionTypes.PICTURE_PREV_PAGE, {category :this.GET_FILTER.ID, page: this.GET_IMAGE_PAGE_NO}).then((response) => {
                        this.PicturesArray = response;
                        this.scroll_pagination();

                        if(this.GET_IMAGE_PAGE_NO < 2){
                            this.isArrowPrevActived = false;
                         
                        }else{
                            this.isArrowPrevActived = true;
                        }
                
                        this.isArrowNextActived = true;

                    }).catch(()=>{
                        console.log("Błąd paginacji.");
                    })
            }else{
                this.isArrowPrevActived = false;
            }
        },
        scroll_pagination(){
            let window_heigth = window.innerHeight;
            window_heigth = window_heigth/2;

            const scroll_options = {
                top: document.querySelector('#prace').offsetTop+window_heigth,
                behavior: 'smooth'
            }

            setTimeout(()=>{
                this.loader = false;
            }, 1500)
            window.scrollTo(scroll_options);
            
        },
        SelectCategoryToDelete(id){
            this.elementTypeToDelete = 'category';
            this.categoryItemToDelete = id;
            this.isDeleteModalVisible = true;
        },
        DeleteElement(){

            if(this.elementTypeToDelete==='category'){
                
                API.post(`/categories/delete_category.php?category=${this.categoryItemToDelete}`, {
                    role: this.GET_ROLE.role
                }, {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('user-token')
                    }
                }).then(() => {

                    this.$router.go();
                    
                }).catch(() => {
                    
                    alert("Nie można usunąć kategorii.");
        
                });

            }else if(this.elementTypeToDelete==='picture'){
                
                API.post(`/pictures/delete_picture.php?picture=${this.pictureItemToDelete}`, {
                    role: this.GET_ROLE.role
                }, {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('user-token')
                    }
                }).then(() => {

                    this.$router.go();
                    
                }).catch(() => {
                    
                    alert("Nie można usunąć kategorii.");
        
                });

            }

            this.categoryItemToDelete = null;
            this.isDeleteModalVisible = false;
            this.elementTypeToDelete = '';
        },
        closeDeleteModal(){
            this.isDeleteModalVisible = false;
            this.categoryItemToDelete = null;
            this.elementTypeToDelete = '';
        },
        SelectPictureToDelete(id){
            this.pictureItemToDelete = id;
            this.isDeleteModalVisible = true;
            this.elementTypeToDelete = 'picture';
        },
        SelectCategoryToEdit(item){
            this.EditCategoryModal_ID = item;
            this.isEditCategoryModal = true;
        },
        SelectPictureToEdit(item){
            this.EditPictureModal_ID = item;
            this.isEditPictureModal = true;
        }
 
  },
  async created() {
       await this.getCategories();
       await this.getImages();
       this.startStatusPagination();
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
        'GET_AUTH_STATUS',
        'GET_FILTER',
        'GET_LANG',
        'GET_IMAGE_PAGE_NO',
        'GET_IMAGE_NEXT_BUTTON_ACTIVE',
        'GET_IMAGE_PREV_BUTTON_ACTIVE'
        // ...
        ]),
    },
    watch: {
        GET_IMAGE_NEXT_BUTTON_ACTIVE: {
            deep: true,
            handler() {
                this.paginationButtons();
            }
        }

    }
}
</script>
<style scoped>
.gallery{
    margin-top: -330px;
  /*  z-index: 2; */
    position: relative;
    padding-bottom: 20px;
    overflow: hidden;

}
.gallery_background{
    background: #2B2B2B;
    position: absolute;
    top:  230px;
    height: calc(100% - 230px);
    width: 100%;
    box-shadow: inset 0px 5px 20px rgb(26, 26, 26);
}
.max-width{
    max-width: 1500px;
    margin: 20px auto;
    padding: 20px 30px;
    overflow: hidden;
}
.gallery_category_info_filter{
    width: 100%;
    display: flex;
    justify-content: center;
    color: #E2E2E2;
    font-weight: 500;
    letter-spacing: 1px;
    z-index: 2;
    position: relative;
}
.gallery_container{
    width: 90%;
    margin: 30px auto 0px auto;
    max-width: 1400px;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.add_category:hover{
    transform: scale(1.05);
    cursor: pointer;
    background: rgb(66, 66, 66);
    transform: none;
}
.gallery_add_picture_container{
    margin: auto;
}
.gallery_add_picture_container p{
    margin-top: -10px;
    color: white;
    font-weight: 500;
}
.add_category{
    width: 23vw;
    height: 65vh;
    margin: 1%;
    background: #2B2B2B;
    border: 2px solid white;
    max-height: 470px;
    max-width: 330px;
    min-height: 350px;
    position: relative;
    border-radius: 5px;
    transition: .5s;
    display: flex;
}
@media(max-width:1040px){
    .add_category{
        height: 45vh;
    }
}
@media(max-width:766px){
    .add_category{
        width: 30vw;
        height: 35vh;
    }
}
@media(max-width:644px){
    .add_category{
        height: 40vh;
        width: 35vw;
    }
}
@media(max-width:476px){
    .add_category{
        width: 50vw;
        min-height: 320px;
    }
}
.pagination{
    width: 100%;
    display: flex;
    justify-content: center;
    margin-top: 20px;
}
.pictures_pagination{
    width: 180px;
    height: 50px;
    z-index: 1;
    margin-bottom: 40px;
    display: flex;
    justify-content: space-between;
}
.pagination_arrows{
    height: 50px;
    width: 50px;
    background: gray;
    border-radius: 50%;
    display: flex;
    box-shadow: 0px 1px 6px black;
 
}
.pagination_arrows_i{
    margin: auto;
}
.arrow_actived{
    height: 60px;
    width: 60px;
    background: white;
    cursor: pointer;
    margin-top: -5px;
    transition: .5s;
    pointer-events: all;
}
.arrow_actived:hover{
    transform: scale(1.1);
}
.display_pageNUM{
    font-size: 20px;
    font-weight: 700;
    line-height: 50px;
    color: white;
}
.display_pageNUM::selection{
    background: none;
}
.anticon-plus-circle{
    color: white;
    margin-bottom: 10px;
}
</style>
