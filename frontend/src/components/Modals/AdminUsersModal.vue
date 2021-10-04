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
            Rejestracja użytkownika
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
      <form @submit.prevent="register">
        <section
          class="modal-body"
          id="modalDescription"
        >
          <slot name="body">
            <div class="modal_body_container">

                <div class="modal_body_input_container">
                    <label class="modal_body_input_label"> Imię i nazwisko</label>
                        <input required v-model="name" class="modal_input_user_edit" />
                </div>
                <div class="modal_body_input_container">
                    <label class="modal_body_input_label">Login (adres e-mail)</label>
                        <input required v-model="email" type="email" class="modal_input_user_edit" />
                </div>
                <div class="modal_body_input_container">
                    <label class="modal_body_input_label">Rola</label>
                        <select required v-model="role" class="modal_input_user_edit">
                            <option selected disabled>Wybierz rolę</option>
                            <option>Redaktor</option>
                            <option disabled>Administrator</option>
                        </select>
                </div>
                <div class="modal_body_input_container">
                    <label class="modal_body_input_label">Hasło</label>
                        <input required v-model="password" type="password" class="modal_input_user_edit" />
                </div>
                <div class="modal_body_input_container">
                    <label class="modal_body_input_label">Powtórz hasło</label>
                        <input required v-model="password_two" class="modal_input_user_edit" type="password" />
                </div>

                  <p v-if="error" class="text-danger">{{error}}</p>
            </div>
          </slot>
        </section>

        <footer class="modal-footer">
          <slot name="footer">
            <p>Redaktor - posiada mozliwość dodawania nowych elementów w aplikacji.</p>
            <p>Administrator - posiada pełny dostęp do aplikacji. Konta administratora nie mozna usunąć!</p>
          </slot>
          <div class="modal_footer_btn_row">

          <button
            type="button"
            @click="close"
            aria-label="Close modal"
          >
            Anuluj
          </button>
          <button type="submit" class="btn-yellow">Dodaj uzytkownika</button>

          </div>

        </footer>
      </form>

      </div>
    </div>
  </transition>
</template>
<script>
import API from '@/http.js'

export default ({
    name: "AdminUsersModal",
    data(){
      return{
        name: '',
        email: '',
        role: '',
        password: '',
        password_two: '',
        error: '',
        show_loader: false
      }
    },
    components:{
      Loader: () => import(/* webpackPrefetch: true */ '@/components/SmallLoader.vue'),
    },
    methods:{
        close(){
            this.$emit('close');
        },
        register(){

          if(this.password === this.password_two){
            this.show_loader = true;
            API.post('/admin/register.php', {
                name: this.name,
                email: this.email,
                role: this.role,
                password: this.password,
              },{
                headers: {
                      'Authorization': 'Bearer ' + localStorage.getItem('user-token')
                }
              })
              .then(() => {
                this.$router.go()
              })
              .catch((e) => {
                this.error = e.response.data.message;
                this.show_loader = false;
              });

            }else{

                this.error = "Hasła nie są identyczne!"

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
    background-color: rgba(0, 0, 0, 0.3);
    display: flex;
    justify-content: center;
    align-items: center;
    overflow-y: scroll;
  }

  .modal {
    background: #303030;
    box-shadow: 2px 2px 20px 1px rgb(22, 22, 22);
    overflow-x: auto;
    display: flex;
    flex-direction: column;
    width: 85%;
    max-width: 1400px;
    min-height: 70vh;
    border-radius: 10px;
    position: absolute;
    top: 40px;
    bottom: 40px;
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
  @media(max-width: 900px){
      .modal_input_user_edit{
          width: 80%;
      }
      select.modal_input_user_edit{
          width: 84%;
      }
  }
@media(max-width: 500px){
    .modal{
        width: 95%;
        left: 2.5%;
        right: 2.5%;
    }
      .modal_input_user_edit{
          width: 100%;
      }
      select.modal_input_user_edit{
          width: 110%;
      }
  }
</style>
