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
            Definiowanie nowej wystawy
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
                    <label class="modal_body_input_label"> Nazwa wystawy j. polski</label>
                        <input v-model="ExhibitionNamePL" class="modal_input_user_edit" @change="TranslateTitleUnlock" />
                </div>
                <div class="modal_body_input_container">
                    <label class="modal_body_input_label"> Nazwa wystawy j. angielski</label>
                          <button v-bind:class="{ disabled: disabled_ENG_title }" class="translate_button modal_input_user_edit" @click="TranslateFunctionTITLE_ENG">Tłumacz</button>
                        <input v-model="ExhibitionNameENG" class="modal_input_user_edit" />
                </div>
                <div class="modal_body_input_container">
                    <label class="modal_body_input_label"> Nazwa wystawy j. włoski</label>
                          <button v-bind:class="{ disabled: disabled_IT_title }" class="translate_button modal_input_user_edit" @click="TranslateFunctionTITLE_IT">Tłumacz</button>
                        <input v-model="ExhibitionNameIT" class="modal_input_user_edit" />
                </div>
                <div class="modal_body_input_container">
                    <label class="modal_body_input_label">Opis wystawy j. polski</label>
                        <textarea v-model="ExhibitionDescriptionPL" class="modal_input_user_edit modal_input_textarea" @change="TranslateDescUnlock"></textarea>
                </div>
                <div class="modal_body_input_container">
                    <label class="modal_body_input_label">Opis wystawy j. angielski</label>

                        <button v-bind:class="{ disabled: disabled_ENG_desc }" class="translate_button modal_input_user_edit" @click="TranslateFunctionDESC_ENG">Tłumacz</button>
                        <textarea v-model="ExhibitionDescriptionENG" class="modal_input_user_edit modal_input_textarea"></textarea>
                </div>
                <div class="modal_body_input_container">
                    <label class="modal_body_input_label">Opis wystawy j. włoski</label>
                       
                         <button v-bind:class="{ disabled: disabled_IT_desc }" class="translate_button modal_input_user_edit" @click="TranslateFunctionDESC_IT">Tłumacz</button>
                        <textarea v-model="ExhibitionDescriptionIT" class="modal_input_user_edit modal_input_textarea">
                        </textarea>
                     
                </div>
                <div class="modal_body_input_container">
                    <label class="modal_body_input_label"> Data wystawy</label>
                   
                    <div class="date_container">
                      
                      <select v-model="ExhibitionDateDay" class="date_selector">
                          <option value="" disabled selected>Dzień</option>
                          <option  v-for="i in 31"
                          :key="i"
                          :value="i">
                              {{ i }}
                          </option>
                      </select>

                      <select v-model="ExhibitionDateMonth" class="date_selector">
                          <option value="" disabled selected>Miesiąc</option>
                          <option  v-for="i in 12"
                          :key="i"
                          :value="i">
                              {{ i }}
                          </option>
                      </select>

                      <select v-model="ExhibitionDateYear" class="date_selector" >
                            <option value="" disabled selected>Rok</option>
                            <option  v-for="i in 20"
                            :key="i"
                            :value="(currentYear-5)+i">
                                {{ (currentYear-5)+i }}
                            </option>
                      </select>

                    </div>
                        <!-- <input v-model="ExhibitionDate" type="date" class="modal_input_user_edit" style="z-index:2;" /> -->
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
          <button @click="upload" class="btn-yellow">Dodaj wystawę</button>

          </div>

        </footer>
      </div>
    </div>
  </transition>
</template>
<script>
import AddNewItemHorizontal from '@/components/AddNewItemHorizontal.vue'
import {XCircleIcon} from '@/utils/libs/Icons'
import API from '@/http.js'

export default ({
    name: "AddExhibitionModal",
    data(){
        return{
          ExhibitionNamePL: '',
          ExhibitionNameENG: '',
          ExhibitionNameIT: '',
          ExhibitionDescriptionPL: '',
          ExhibitionDescriptionENG: '',
          ExhibitionDescriptionIT: '',
          ExhibitionDateDay: '',
          ExhibitionDateMonth: '',
          ExhibitionDateYear: '',
          selectedFile: null,
          DisabledFileUpload: false,
          FileName: '',
          message: '',
          currentYear: new Date().getFullYear(), // 2020,
          Translate: false,
          disabled_ENG_title: true,
          disabled_IT_title: true,
          disabled_ENG_desc: true,
          disabled_IT_desc: true
        }
    },
    components:{
        AddNewItemHorizontal,
        Loader: () => import(/* webpackPrefetch: true */ '@/components/SmallLoader.vue'),
        XCircleIcon
    },
    methods:{
        close(){
            this.$emit('closeExhibitionModal');
            this.ExhibitionNamePL = '';
            this.ExhibitionNameENG = '';
            this.ExhibitionNameIT = '';
            this.ExhibitionDescriptionPL = '';
            this.ExhibitionDescriptionENG = '';
            this.ExhibitionDescriptionIT = '';
            this.ExhibitionDateDay = '',
            this.ExhibitionDateMonth = '',
            this.ExhibitionDateYear = '',
            this.selectedFile = null;
            this.DisabledFileUpload = false;
            this.FileName = '';
            this.message = '';
            this.disabled_ENG_title = true;
            this.disabled_IT_title = true;
            this.disabled_ENG_desc = true;
            this.disabled_IT_desc = true;
            this.Translate = false;
        },
        selectFile() {
            this.selectedFile = this.$refs.file.files;
            this.DisabledFileUpload = true;
            this.FileName = this.selectedFile[0].name;
        },
        removeFile(){
          this.selectedFile = null;
          this.FileName = '';
          this.DisabledFileUpload = false;
        },
        selectFileClick(){
          if(this.DisabledFileUpload === false){
              this.$refs.file.click();
          }
        },
        TranslateTitleUnlock(){
          this.disabled_ENG_title = false;
          this.disabled_IT_title = false;
        },
        TranslateDescUnlock(){
          this.disabled_ENG_desc = false;
          this.disabled_IT_desc = false;
        },
        TranslateFunctionTITLE_ENG(){
          const url = 'https://libretranslate.de/translate';

            this.Translate = true;

            fetch(url, {
              method: "POST",
              body: JSON.stringify({
                q: this.ExhibitionNamePL+'.',
                source: "pl",
                target: "en",
              }),
              headers: { "Content-Type": "application/json" }
            }).then((response) => {
              const self = this; 
              response.json().then(function(result) {
                self.ExhibitionNameENG = result.translatedText;
                self.Translate = false;
                self.disabled_ENG_title = true;
              });
            }).catch(() =>{
              this.message = 'Błąd podczas tłumaczenia tytułu na j. angielski.'
            });
        },
        TranslateFunctionTITLE_IT(){
          const url = 'https://libretranslate.de/translate';

            this.Translate = true;

            fetch(url, {
              method: "POST",
              body: JSON.stringify({
                q: this.ExhibitionNamePL+'.',
                source: "pl",
                target: "it",
              }),
              headers: { "Content-Type": "application/json" }
            }).then((response) => {
              const self = this; 
              response.json().then(function(result) {
                self.ExhibitionNameIT = result.translatedText;
                self.Translate = false;
                self.disabled_IT_title = true;
              });
            }).catch(() =>{
              this.message = 'Błąd podczas tłumaczenia tytułu na j. włoski.'
            });
        },
        TranslateFunctionDESC_ENG(){
          const url = 'https://libretranslate.de/translate';

            this.Translate = true;

            fetch(url, {
              method: "POST",
              body: JSON.stringify({
                q: this.ExhibitionDescriptionPL+'.',
                source: "pl",
                target: "en",
              }),
              headers: { "Content-Type": "application/json" }
            }).then((response) => {
              const self = this; 
              response.json().then(function(result) {
                self.ExhibitionDescriptionENG = result.translatedText;
                self.Translate = false;
                self.disabled_ENG_desc = true;
              });
            }).catch(() =>{
              this.message = 'Błąd podczas tłumaczenia opisu na j. angielski.'
            });
        },
        TranslateFunctionDESC_IT(){
          const url = 'https://libretranslate.de/translate';

            this.Translate = true;

            fetch(url, {
              method: "POST",
              body: JSON.stringify({
                q: this.ExhibitionDescriptionPL,
                source: "pl",
                target: "it",
              }),
              headers: { "Content-Type": "application/json" }
            }).then((response) => {
              const self = this; 
              response.json().then(function(result) {
                self.ExhibitionDescriptionIT = result.translatedText;
                self.Translate = false;
                self.disabled_IT_desc = true;
              });
            }).catch(() =>{
              this.message = 'Błąd podczas tłumaczenia opisu na j. włoski.'
            });
        },
        upload() {

          if(this.ExhibitionNamePL===''){
            this.message = "Nazwa wystawy w j. polskim musi być wprowadzona."
          }
          else if(this.ExhibitionNameENG===''){
            this.message = "Nazwa wystawy w j. angielskim musi być wprowadzona."
          }
          else if(this.ExhibitionNameIT===''){
            this.message = "Nazwa wystawy w j. włoskim musi być wprowadzona."
          }
          else if(this.ExhibitionDescriptionPL===''){
            this.message = "Opis wystawy w j. polskim musi być wprowadzony."
          }
          else if(this.ExhibitionDescriptionENG===''){
            this.message = "Opis wystawy w j. angielskim musi być wprowadzony."
          }
          else if(this.ExhibitionDescriptionIT===''){
            this.message = "Opis wystawy w j. włoskim musi być wprowadzony."
          }
          else if(this.ExhibitionDateDay==='' || this.ExhibitionDateMonth === '' || this.ExhibitionDateYear ===''){
            this.message = "Nie wprowadzono poprawnej daty wystawy."
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
          formData.append('Title', this.ExhibitionNamePL);
          formData.append('TitleANG', this.ExhibitionNameENG);
          formData.append('TitleIT', this.ExhibitionNameIT);
          formData.append('Description', this.ExhibitionDescriptionPL);
          formData.append('DescriptionANG', this.ExhibitionDescriptionENG);
          formData.append('DescriptionIT', this.ExhibitionDescriptionIT);
          formData.append('Date', (this.ExhibitionDateYear+'-'+this.ExhibitionDateMonth+'-'+this.ExhibitionDateDay));
          formData.append('sendimage', this.selectedFile[0]);

            API.post(`/exhibitions/exhibition_add.php`,formData, {
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
    max-height: 90vh;
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
  .modal_input_user_edit, .date_selector{
      width: 49%;
      height: 40px;
      border: none;
      outline: none;
      margin: 30px auto; 
      border-radius: 7px;
      padding: 0 10px 0 10px;
  }
  .date_selector{
    width: 30%;
    cursor: pointer;
  }
  select.modal_input_user_edit{
      width: 51%;
  }
  .modal_body_input_label{
      position: absolute;
      top:0;
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
  .date_container{
  width: 51%;
  display: flex;
  justify-content: space-between;
  margin: auto;
}
  @media(max-width: 900px){
      .modal_input_user_edit, .date_container{
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
      .modal_input_user_edit, .modal_add_image_horizontal, .date_container{
          width: 100%;
      }
  }
  .modal_input_textarea{
  height: 150px;
  padding: 10px;
}
.translate_button{
  margin: 30px auto -20px auto;
  border: 1px solid white;
  color: white;
  height: 37px;
  background: rgba(255, 255, 255, .1);
}
</style>
