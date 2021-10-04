<template>
  <transition name="modal-fade">
    <div class="modal-backdrop">
      <div class="modal"
        role="dialog"
        aria-labelledby="modalTitle"
        aria-describedby="modalDescription"
      >
          <button
            type="button"
            class="btn-close"
            @click="close"
            aria-label="Close modal"
          >
            x
          </button>

        <section
          class="modal-body"
          id="modalDescription"
        >
          <slot name="body">
            <div class="modal_body_container">

              <transition name="fade">
                  <div v-show="loader" class="loader_container">
                      <img class="image_Loader" src="@/assets/images/loading.svg" v-bind:alt="'andrzej_sajewski_loader_picture_Detail_'+DataModal.Title"/>
                  </div>
              </transition>
              <transition name="fade">
                  <img loading="lazy" @load="imageLoader" v-bind:src="img+'/pictures/'+DataModal.PhotoImg" v-bind:alt="'andrzej_andrea_sajewski_picture_details_'+DataModal.Title"/>
              </transition>

            </div>
          </slot>
        </section>
      </div>
    </div>
  </transition>
</template>
<script>
import globalURL from "@/globalURL"

export default ({
    name: "GalleryPictureModal",
    props:{
        DataModal: [],
    },
    methods:{
        close(){
            this.$emit('GalleryModalClose');
        },
        imageLoader(){
            setTimeout(()=>{
                this.loader = false;
            }, 1000)
        }
    },
    data(){
        return{
            img: globalURL,
            loader:{
                type: Boolean,
                default: true
            }
        }
    },
})
</script>

<style scoped>
.modal-backdrop {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 1);
    display: flex;
    justify-content: center;
    align-items: center;
    overflow-y: scroll;
    z-index: 25;
  }

  .modal {
    background: #303030;
    box-shadow: 2px 2px 20px 1px rgb(22, 22, 22);
    display: flex;
    flex-direction: column;
    width: 85%;
    max-width: 1400px;
    height: 90vh;
    border-radius: 10px;
    position: absolute;
    top: 5vh;
    bottom: 5vh;
    left: 7.5%;
    right:7.5%;
  }

  .modal-body {
    position: relative;
   /* padding: 20px 5px; */
    height: 100%;
  }

  .btn-close {
    position: absolute;
    top: 0;
    right: 10px;
    border: none;
    font-size: 25px;
    padding: 10px;
    cursor: pointer;
    font-weight: bold;
    color: white;
    background: transparent;
    z-index: 16;
  }

  .modal-fade-enter,
  .modal-fade-leave-to {
    opacity: 0;
  }

  .modal-fade-enter-active,
  .modal-fade-leave-active {
    transition: opacity .5s ease;
  }

@media(max-width: 500px){
    .modal{
        width: 98%;
        left: 1%;
        right:1%;
    }
  }

  @media(max-width: 900px){
    .modal{
        width: 93%;
        left: 3.5%;
        right:3.5%;
    }
  }

.modal_body_container{
    height: 100%;
    display: flex;
}
.modal_body_container > img{
    width: 100%;
    margin: auto;
    max-height: 85vh;
    object-fit: contain;
    border-radius: 10px;
}
@media all and (-ms-high-contrast: none), (-ms-high-contrast: active) {
   .modal_body_container > img{
     width: auto;
   }
}
</style>
