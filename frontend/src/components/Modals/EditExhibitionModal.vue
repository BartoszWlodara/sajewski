<template>
  <transition name="modal-fade">
    <div class="modal-backdrop">
        <Loader v-if="show_loader"></Loader>
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
            Edycja wystawy z {{ExhibitionToEdit.Date}}
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
                        <input id="input_name_exhibition_PL" v-model="ExhibitionNamePL" class="modal_input_user_edit" />
                </div>
                <div class="modal_body_input_container">
                    <label class="modal_body_input_label"> Nazwa wystawy j. angielski</label>
                        <input id="input_name_exhibition_ENG" v-model="ExhibitionNameENG" class="modal_input_user_edit" />
                </div>
                <div class="modal_body_input_container">
                    <label class="modal_body_input_label"> Nazwa wystawy j. włoski</label>
                        <input id="input_name_exhibition_IT" v-model="ExhibitionNameIT" class="modal_input_user_edit" />
                </div>
                <div class="modal_body_input_container">
                    <label class="modal_body_input_label">Opis wystawy j. polski</label>
                        <textarea id="input_picture_exhibition_descPL" v-model="ExhibitionDescriptionPL" class="modal_input_user_edit modal_input_textarea"></textarea>
                </div>
                <div class="modal_body_input_container">
                    <label class="modal_body_input_label">Opis wystawy j. angielski</label>
                        <textarea id="input_picture_exhibition_descENG" v-model="ExhibitionDescriptionENG" class="modal_input_user_edit modal_input_textarea"></textarea>
                </div>
                <div class="modal_body_input_container">
                    <label class="modal_body_input_label">Opis wystawy j. włoski</label>
                        <textarea id="input_picture_exhibition_descIT" v-model="ExhibitionDescriptionIT" class="modal_input_user_edit modal_input_textarea"></textarea>
                </div>
                <div class="modal_body_input_container">
                    <label class="modal_body_input_label"> Data wystawy</label>
                   
                    <div class="date_container">
                      
                      <select id="input_picture_exhibition_DateDay" class="date_selector">
                          <option value="" disabled selected>Dzień</option>
                          <option  v-for="i in 31"
                          :key="i"
                          :value="i">
                              {{ i }}
                          </option>
                      </select>

                      <select id="input_picture_exhibition_DateMonth" class="date_selector">
                          <option value="" disabled selected>Miesiąc</option>
                          <option  v-for="i in 12"
                          :key="i"
                          :value="i">
                              {{ i }}
                          </option>
                      </select>

                      <select id="input_picture_exhibition_DateYear" class="date_selector" >
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
                          <AddNewItemHorizontal style="background-position: center;background-size: contain; background-repeat: no-repeat" 
                              v-bind:style="{ 'background-image': 'url(' + img +'/exhibitions/'+ ExhibitionToEdit.ImagePath + ')' }" 
                              v-bind:class="{ disabled: DisabledFileUpload }">
                          </AddNewItemHorizontal>
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
          <button @click="upload" class="btn-yellow">Aktualizuj wystawę</button>

          </div>

        </footer>
      </div>
    </div>
  </transition>
</template>
<script>
import AddNewItemHorizontal from '@/components/AddNewItemHorizontal.vue'
import API from '@/http.js'
import {XCircleIcon} from '@/utils/libs/Icons'
import globalURL from '@/globalURL.js'

export default ({
    name: "EditExhibitionModal",
    props:{
      ExhibitionToEdit: []
    },
    data(){
        return{
          ExhibitionNamePL: this.ExhibitionToEdit.Title,
          ExhibitionNameENG: this.ExhibitionToEdit.TitleANG,
          ExhibitionNameIT: this.ExhibitionToEdit.TitleIT,
          ExhibitionDescriptionPL: this.ExhibitionToEdit.Description,
          ExhibitionDescriptionENG: this.ExhibitionToEdit.DescriptionANG,
          ExhibitionDescriptionIT: this.ExhibitionToEdit.DescriptionIT,
          ExhibitionDateDay: '',
          ExhibitionDateMonth: '',
          ExhibitionDateYear: '',
          selectedFile: null,
          DisabledFileUpload: false,
          FileName: '',
          message: '',
          currentYear: new Date().getFullYear(), 
          img: globalURL,
          show_loader: false
        }
    },
    components:{
        AddNewItemHorizontal,
        XCircleIcon,
        Loader: () => import(/* webpackPrefetch: true */ '@/components/SmallLoader.vue'),
    },
    methods:{
        close(){
            this.$emit('closeEditExhibitionModal');
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
        upload() {
  
          this.ExhibitionNamePL = document.getElementById('input_name_exhibition_PL').value;
          this.ExhibitionNameENG = document.getElementById('input_name_exhibition_ENG').value;
          this.ExhibitionNameIT = document.getElementById('input_name_exhibition_IT').value;
          this.ExhibitionDescriptionPL = document.getElementById('input_picture_exhibition_descPL').value;
          this.ExhibitionDescriptionENG = document.getElementById('input_picture_exhibition_descENG').value;
          this.ExhibitionDescriptionIT= document.getElementById('input_picture_exhibition_descIT').value;
          this.ExhibitionDateDay = document.getElementById('input_picture_exhibition_DateDay').value;
          this.ExhibitionDateMonth = document.getElementById('input_picture_exhibition_DateMonth').value;
          this.ExhibitionDateYear = document.getElementById('input_picture_exhibition_DateYear').value;

          let file;
       
          if(this.ExhibitionNamePL===''){
            this.message = "Nazwa wystawy w j. polskim musi być wprowadzona."
          }
          else if(this.ExhibitionDescriptionPL===''){
            this.message = "Opis wystawy w j. polskim musi być wprowadzony."
          }
          else if(this.ExhibitionDateDay==='' || this.ExhibitionDateMonth === '' || this.ExhibitionDateYear ===''){
            this.message = "Nie wprowadzono poprawnej daty wystawy."
          }
          else if(this.FileName===''){
            this.message = "";
            file = null;
          }
          else{
            this.message = '';
            file = this.selectedFile[0];
          }

        if(this.message===''){
          this.show_loader = true;

          const formData = new FormData();
          formData.append('Title', this.ExhibitionNamePL);
          formData.append('TitleANG', this.ExhibitionNameENG);
          formData.append('TitleIT', this.ExhibitionNameIT);
          formData.append('Description', this.ExhibitionDescriptionPL);
          formData.append('DescriptionANG', this.ExhibitionDescriptionENG);
          formData.append('DescriptionIT', this.ExhibitionDescriptionIT);
          formData.append('Date', (this.ExhibitionDateYear+'-'+this.ExhibitionDateMonth+'-'+this.ExhibitionDateDay));
          formData.append('sendimage', file);

            API.post(`/exhibitions/exhibition_update.php?exhibition=${this.ExhibitionToEdit.ID}`,formData, {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('user-token'),
                    'Content-Type': 'multipart/form-data'
                }
            }).then(() => {

                this.$router.go();
                
            }).catch((error) => {
                 
                  this.message = error.response.data.message;
                  this.show_loader = false;
    
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

</style>
