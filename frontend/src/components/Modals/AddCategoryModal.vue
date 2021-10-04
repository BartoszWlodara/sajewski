<template>
  <transition name="modal-fade">
    <div class="modal-backdrop">
          <Loader v-if="Translate"></Loader>
      <div class="modal"
        role="dialog"
        aria-labelledby="modalTitle"
        aria-describedby="modalDescription"
      >
        <header
          class="modal-header"
          id="modalTitle"
        >
          <slot name="header">
            Definiowanie kategorii
          </slot>
          <button
            type="button"
            class="btn-close"
            @click="close"
            aria-label="Close modal"
          >
            x
          </button>
        </header>

        <section
          class="modal-body"
          id="modalDescription"
        >
          <slot name="body">
            <div class="modal_body_container">
                <div class="modal_body_input_container">
                  <div class="modal_input_row">
                        <label class="modal_body_input_label"> Nazwa kategorii - polski</label>
                        <input v-model="categoryNamePL" class="modal_input_user_edit" @change="TranslateTitleUnlock" />
                  </div>
                  <div class="modal_input_row">
                        <label class="modal_body_input_label"> Nazwa kategorii - angielski</label>
                         <button v-bind:class="{ disabled: disabled_ENG }" class="translate_button modal_input_user_edit" @click="TranslateFunctionTitleENG">Tłumacz</button>
                        <input v-model="categoryNameENG" class="modal_input_user_edit" />
                  </div>
                  <div class="modal_input_row">
                        <label class="modal_body_input_label"> Nazwa kategorii - włoski</label>
                         <button v-bind:class="{ disabled: disabled_IT }" class="translate_button modal_input_user_edit" @click="TranslateFunctionTitleIT">Tłumacz</button>
                        <input v-model="categoryNameIT" class="modal_input_user_edit" />
                  </div>
                </div>

                <div class="modal_body_input_container modal_add_image_horizontal">
                    <label class="modal_body_input_label"> Dodaj zdjęcie</label>
                    <input style="visibility:hidden;" type="file" ref="file" accept="image/png, image/gif, image/jpeg" @change="selectFile" />
                
                    <div style="width:100%;" @click="selectFileClick">
                          <AddNewItemHorizontal v-bind:class="{ disabled: DisabledFileUpload }"></AddNewItemHorizontal>
                          <span class="filename" v-if="DisabledFileUpload"><p class="filenameInfo">Załączony plik:</p>{{FileName}}
                          <XCircleIcon @click="removeFile"></XCircleIcon>
                          </span>
                    </div>
        
                </div>

            </div>
          </slot>
        </section>

        <footer class="modal-footer">

          <h4 style="margin:0;" class="text-danger" v-if="message">{{message}}</h4>

          <div class="modal_footer_btn_row">

          <button
            type="button"
            @click="close"
            aria-label="Close modal"
          >
            Anuluj
          </button>
          <button @click="upload" class="btn-yellow">Dodaj kategorię</button>

          </div>

        </footer>
      </div>
    </div>
  </transition>
</template>
<script>
import AddNewItemHorizontal from '@/components/AddNewItemHorizontal.vue'
import {XCircleIcon} from '@/utils/libs/Icons'
//import UploadService from "@/services/uploadFileService";
import API from '@/http.js'

export default ({
    name: "CategoryModal",
    components:{
        AddNewItemHorizontal,
        Loader: () => import(/* webpackPrefetch: true */ '@/components/SmallLoader.vue'),
        XCircleIcon
    },
    data(){
        return {
          selectedFiles: undefined,
          currentFile: undefined,
          progress: 0,
          message: "",
          fileInfos: [],
          true:{
            type: Boolean,
            default: true
          },
          categoryNamePL: '',
          categoryNameENG: '',
          categoryNameIT: '',
         // categoryImage: null,
          DisabledFileUpload: false,
          FileName: '',
          disabled_ENG: true,
          disabled_IT: true,
          Translate: false
      };
    },
    methods:{
        close(){
            this.$emit('closeCategoryModal');
            this.categoryNamePL = '';
            this.categoryNameENG = '';
            this.categoryNameIT = '';
            this.selectedFiles= undefined;
            this.DisabledFileUpload = false;
            this.FileName = '';
            this.message = '';
            this.disabled_ENG = true;
            this.disabled_IT = true;
            this.Translate = false;
        },
        selectFile() {
            this.selectedFiles = this.$refs.file.files;
            this.DisabledFileUpload = true;
            this.FileName = this.selectedFiles[0].name;
        },
        removeFile(){
          this.selectedFiles = null;
          this.FileName = '';
          this.DisabledFileUpload = false;
        },
        selectFileClick(){
          if(this.DisabledFileUpload === false){
              this.$refs.file.click();
          }
        },
        TranslateTitleUnlock(){
          this.disabled_ENG = false;
          this.disabled_IT = false;
        },
        TranslateFunctionTitleENG(){
          const url = 'https://libretranslate.de/translate';

            this.Translate = true;

            fetch(url, {
              method: "POST",
              body: JSON.stringify({
                q: this.categoryNamePL+'.',
                source: "pl",
                target: "en",
              }),
              headers: { "Content-Type": "application/json" }
            }).then((response) => {
              const self = this; 
              response.json().then(function(result) {
                self.categoryNameENG = result.translatedText;
                self.Translate = false;
                self.disabled_ENG = true;
              });
            }).catch(() =>{
              this.message = 'Błąd podczas tłumaczenia kategorii na j. angielski.'
            });
        },
        TranslateFunctionTitleIT(){
          const url = 'https://libretranslate.de/translate';

            this.Translate = true;

            fetch(url, {
              method: "POST",
              body: JSON.stringify({
                q: this.categoryNamePL+'.',
                source: "pl",
                target: "it",
              }),
              headers: { "Content-Type": "application/json" }
            }).then((response) => {
              const self = this; 
              response.json().then(function(result) {
                self.categoryNameIT = result.translatedText;
                self.Translate = false;
                self.disabled_IT = true;
              });
            }).catch(() =>{
              this.message = 'Błąd podczas tłumaczenia kategorii na j. włoski.'
            });
        },
        upload() {

          if(this.categoryNamePL===''){
            this.message = "Nazwa w j. polskim musi być wprowadzona."
          }
          else if(this.categoryNameENG===''){
            this.message = "Nazwa w j. angielskim musi być wprowadzona."
          }
          else if(this.categoryNameIT===''){
            this.message = "Nazwa w j. włoskim musi być wprowadzona."
          }
          else if(this.FileName===''){
            this.message = "Nie załączono zdjęcia."
          }
          else{
            this.message = '';
          }

        if(this.message===''){
          this.Translate = true;

          const formData = new FormData();
          formData.append('CategoryName', this.categoryNamePL);
          formData.append('CategoryNameENG', this.categoryNameENG);
          formData.append('CategoryNameIT', this.categoryNameIT);
          formData.append('sendimage', this.selectedFiles[0]);

            API.post(`/categories/category_add.php`,formData, {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('user-token'),
                    'Content-Type': 'multipart/form-data'
                }
            }).then(() => {

                this.$router.go();
                
            }).catch((e) => {
              this.message = e.response.data.message;
              this.Translate = false;
            }); 

        }

        }
    }
})
</script>

<style scoped>
.modal-backdrop {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    overflow-y: scroll;
    z-index: 25;
  }

  .modal {
    background: #303030;
    box-shadow: 2px 2px 20px 1px rgb(22, 22, 22);
    overflow-x: auto;
    display: flex;
    flex-direction: column;
    width: 85%;
    max-width: 1400px;
    border-radius: 10px;
    position: absolute;
    margin: auto;
    top: 30px;
    bottom: 30px;
    left: 7.5%;
    right: 7.5%;
  }

  .modal-header,
  .modal-footer {
    padding: 15px;
    display: flex;
  }

  .modal-header {
    position: relative;
    border-bottom: 1px solid #eeeeee;
    color: white;
    font-weight: 600;
    letter-spacing: 1px;
    justify-content: space-between;
    padding-left: 20px;
  }

  .modal-footer {
    border-top: 1px solid #eeeeee;
    flex-direction: column;
  }

  .modal-body {
    position: relative;
    padding: 20px 10px;
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
  }

  .btn-yellow {
    color: rgb(255, 255, 255);
    background: #E4A255;
    font-weight: 600;
  }

  .modal-fade-enter,
  .modal-fade-leave-to {
    opacity: 0;
  }

  .modal-fade-enter-active,
  .modal-fade-leave-active {
    transition: opacity .5s ease;
  }
  .modal_body_input_container{
      width: 90%;
      margin: auto;
      display: flex;
      position: relative;
      flex-wrap: wrap;
      max-width: 920px;
  }
  .modal_input_row{
    width: 100%;
    position: relative;
  }
  .modal_input_user_edit{
      width: 49%;
      height: 40px;
      border: none;
      outline: none;
      margin: 30px auto; 
      border-radius: 7px;
      padding: 0 10px 0 10px;
  }
  select.modal_input_user_edit{
      width: 51%;
  }
  .modal_body_input_label{
      position: absolute;
      top:0;
      left: 0;
      width: 100%;
      color: white;
  }
  .modal-footer > p{
      color: white;
      margin: 8px;
      text-align: left;
  }
  .modal_footer_btn_row{
      width: 100%;
      display: flex;
      justify-content: center;
      margin-top: 20px;
  }
  .modal_footer_btn_row > button{
      width: 150px;
      padding: 5px;
      margin: 10px;
      border-radius: 7px;
      min-height: 35px;
      border: none;
  }
  .modal_add_image_horizontal{
      width: 58%;
  }
  @media(max-width: 900px){
      .modal_input_user_edit{
          width: 80%;
      }
      .modal_add_image_horizontal{
          width: 92%;
      }
  }
@media(max-width: 500px){
    .modal{
        width: 95%;
        left: 2.5%;
        right: 2.5%;
    }
      .modal_input_user_edit, .modal_add_image_horizontal{
          width: calc(100% - 20px);
      }
  }
.translate_button{
  margin: 30px auto -20px auto;
  border: 1px solid white;
  color: white;
  height: 37px;
  background: rgba(255, 255, 255, .1);
}
</style>
