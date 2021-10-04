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
            Edytowanie aukcji z {{EditData.Date}}
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
                        <label class="modal_body_input_label"> Nazwa obrazu - polski</label>
                        <input id="input_name_auction_PL" v-model="auctionNamePL" class="modal_input_user_edit" />
                  </div>
                  <div class="modal_input_row">
                        <label class="modal_body_input_label"> Nazwa obrazu - angielski</label>
                        <input id="input_name_auction_ENG" v-model="auctionNameENG" class="modal_input_user_edit" />
                  </div>
                  <div class="modal_input_row">
                        <label class="modal_body_input_label"> Nazwa obrazu - włoski</label>
                        <input id="input_name_auction_IT" v-model="auctionNameIT" class="modal_input_user_edit" />
                  </div>
                  <div class="modal_input_row">
                        <label class="modal_body_input_label"> Link do aukcji</label>
                        <input id="input_auction_link" v-model="auctionLink" class="modal_input_user_edit" />
                  </div>

                </div>

                <div class="modal_body_input_container">
                    <label class="modal_body_input_label"> Data aukcji</label>
                   
                    <div class="date_container">
                      
                      <select id="input_picture_auction_DateDay" class="date_selector">
                          <option value="" disabled selected>Dzień</option>
                          <option  v-for="i in 31"
                          :key="i"
                          :value="i">
                              {{ i }}
                          </option>
                      </select>

                      <select id="input_picture_auction_DateMonth" class="date_selector">
                          <option value="" disabled selected>Miesiąc</option>
                          <option  v-for="i in 12"
                          :key="i"
                          :value="i">
                              {{ i }}
                          </option>
                      </select>

                      <select id="input_picture_auction_DateYear" class="date_selector" >
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
                    <label class="modal_body_input_label"> Zastąp obecne zdjęcie</label>
                    <input style="visibility:hidden;" type="file" ref="file" accept="image/png, image/gif, image/jpeg" @change="selectFile" />
                
                    <div style="width:100%;" @click="selectFileClick">
                          <AddNewItemHorizontal style="background-position: center;background-size: contain; background-repeat: no-repeat" 
                              v-bind:style="{ 'background-image': 'url(' + img +'/auctions/'+ EditData.ImagePathMin + ')' }" 
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
          <button @click="upload" class="btn-yellow">Aktualizuj aukcję</button>

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
import globalURL from '@/globalURL.js'

export default ({
    name: "AuctionEditModal",
    components:{
        AddNewItemHorizontal,
        XCircleIcon,
        Loader: () => import(/* webpackPrefetch: true */ '@/components/SmallLoader.vue')
    },
    props:{
      EditData: []
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
          auctionNamePL: this.EditData.Title,
          auctionNameENG: this.EditData.TitleANG,
          auctionNameIT: this.EditData.Title,
          auctionLink: this.EditData.Link,
          auctionDateDay: '',
          auctionDateMonth: '',
          auctionDateYear: '',
         // categoryImage: null,
          DisabledFileUpload: false,
          FileName: '',
          img: globalURL,
          currentYear: new Date().getFullYear(),
          show_loader: false
      };
    },
    methods:{
        close(){
            this.$emit('closeEditModal');
            this.auctionNamePL = '';
            this.auctionNameENG = '';
            this.auctionNameIT = '';
            this.auctionLink = '';
            this.auctionDateDay = '';
            this.auctionDateMonth = '';
            this.auctionDateYear = '';
            this.selectedFiles= undefined;
            this.DisabledFileUpload = false;
            this.FileName = '';
            this.message = '';
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
        upload() {

          this.auctionNamePL = document.getElementById('input_name_auction_PL').value;
          this.auctionNameENG = document.getElementById('input_name_auction_ENG').value;
          this.auctionNameIT = document.getElementById('input_name_auction_IT').value;
          this.auctionLink = document.getElementById('input_auction_link').value;
          this.auctionDateDay = document.getElementById('input_picture_auction_DateDay').value;
          this.auctionDateMonth = document.getElementById('input_picture_auction_DateMonth').value;
          this.auctionDateYear = document.getElementById('input_picture_auction_DateYear').value;


          let file;

          if(this.auctionNamePL===''){
            this.message = "Nazwa w j. polskim musi być wprowadzona."
          }
          else if(this.auctionLink===''){
            this.message = "Link do aukcji musi zostać wprowadzony."
          }
          else if(this.auctionDateDay==='' || this.auctionDateMonth === '' || this.auctionDateYear ===''){
            this.message = "Nie wprowadzono poprawnej daty wystawy."
          }
          else if(this.FileName===''){
            this.message = ""
            file = null;
          }
          else{
            file = this.selectedFiles[0];
            this.message = '';
          }

          if(this.auctionNameENG===''){
            this.auctionNameENG = this.auctionNamePL;
          }

          if(this.auctionNameIT===''){
            this.auctionNameIT = this.auctionNamePL;
          }

          if(this.message===''){
            this.show_loader = true;
            const formData = new FormData();
            formData.append('Title', this.auctionNamePL);
            formData.append('TitleANG', this.auctionNameENG);
            formData.append('TitleIT', this.auctionNameIT);
            formData.append('Link', this.auctionLink);
            formData.append('Date', (this.auctionDateYear+'-'+this.auctionDateMonth+'-'+this.auctionDateDay));
            formData.append('sendimage', file);

              API.post(`/auctions/auction_update.php?auction=${this.EditData.ID}`,formData, {
                  headers: {
                      'Authorization': 'Bearer ' + localStorage.getItem('user-token'),
                      'Content-Type': 'multipart/form-data'
                  }
              }).then(() => {

                  this.$router.go();
                  
              }).catch((e) => {
                  this.message = e.response.data.message;
                  this.show_loader = false;
      
              }); 

            }
          

        },
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
  }
  .modal_input_row{
    width: 100%;
    position: relative;
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
          width: calc(100% - 20px);
      }
  }
</style>
