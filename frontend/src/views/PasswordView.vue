<template>
    <div id="admin_panel">
        <div class="admin_header">
            <div class="return_div">
                 <router-link class="return" to="/">Strona główna</router-link>
            </div>
            <div @click="logout" class="logout">
                Wyloguj
            </div>
        </div>

        <div class="users_section">
            <div class="users_section_title">Zmiana hasła
               
            </div>

            <div class="users_section_content">
                <form class="container" @submit.prevent="changePassword">
                    <div class="input_container">
                        <div class="modal_input_row">
                                <label class="input_label">Stare hasło</label>
                                <input v-model="password_old" value="" type="password" class="input_user_edit" />
                        </div>
                        <div class="modal_input_row">
                                <label class="input_label">Nowe hasło</label>
                                <input v-model="password" type="password" class="input_user_edit" />
                        </div>
                        <div class="modal_input_row">
                                <label class="input_label">Potwierdź hasło</label>
                                <input v-model="password_confirm" type="password" class="input_user_edit" />
                        </div>
                    </div>

                <h4 style="margin:0px 0px 15px 0px;" class="text-danger" v-if="message">{{message}}</h4>

                    <div>
                        <button type="submit" class="btn-yellow">Zmień hasło</button>
                    </div>

                </form>
            </div>
        </div>
            <ConfirmModal v-if="displayConfirmModal" @ConfirmModal="ConfirmModalAction"></ConfirmModal>
    </div>
</template>

<script>

import * as actionTypes from '../store/action-types'
import { mapGetters } from 'vuex'
import API from '../http.js'

export default {
    name: 'PasswordView',
    components:{
        ConfirmModal: () => import(/* webpackPrefetch: true */ '@/components/Modals/PasswordConfirmModal.vue'),
    },
    data(){
        return{
            email: '',
            password_old: '',
            password: '',
            password_confirm: '',
            message: '',
            displayConfirmModal: false
        }
    },
    methods:{
        logout() {
            this.$store.dispatch(actionTypes.AUTH_LOGOUT)
            .then(() => {
            this.$router.push('/paneladministracyjny/login')
            })
        },
        changePassword(){

            if(this.password_old === '' || this.password === '' || this.password_confirm === ''){
                this.message = 'Nie uzupełniono wszystkich pól.';
            }else{
                this.message = '';

                if(this.password === this.password_confirm){

                    this.email = this.GET_ROLE.email;
                    
                    API.post('/admin/passwordChange.php', {
                        email: this.email,
                        password: this.password_old,
                        newPassword: this.password
                    },{
                        headers: {
                            'Authorization': 'Bearer ' + localStorage.getItem('user-token')
                        }
                    }).then((response) => {

                        if(response.data.status !== 200){
                            this.message = response.data.message;
                        }else{
                            this.message = '';
                            this.displayConfirmModal = true;
                        }
                    })

                }else{
                    this.message = 'Hasła nie są identyczne.'
                    this.displayConfirmModal = false;
                }
            }
        },
        ConfirmModalAction(){
            this.$store.dispatch(actionTypes.AUTH_LOGOUT)
                .then(() => {
                this.$router.push('/paneladministracyjny/login')
            })
        }
    },
    mounted(){

    },
    computed: {
       ...mapGetters([
        'GET_ROLE'
        ]),
    }
}
</script>

<style scoped>
#admin_panel{
    width: 100%;
    height: 100%;
    display: flex;
    padding-top: 100px
}
.admin_header{
    width: calc(100% - 40px);
    position: fixed;
    top: 0;
    left: 0;
    background: rgb(20, 20, 20);
    display: flex;
    justify-content: space-between;
    padding: 20px;
    color: white;
    font-weight: 500;
}
.users_section{
    width: 80%;
    max-width: 1200px;
  /*  border: 2px solid white;*/
    min-height: calc(100vh - 200px);
    margin: auto auto 50px auto;
    border-radius: 10px;
    padding-bottom: 20px;
    background: #333;
}
@media(max-width: 700px){
    .users_section{
        width: 95%;
    }
}
.users_section_title{
    width: 90%;
    text-align: left;
    color: white;
    padding: 20px 0 20px 0;
    font-size: 18px;
    font-weight: 600;
    line-height: 30px;
    border-bottom: 1px solid white;
    margin: auto;
    display: flex;
    justify-content: space-between;
}
.add_user_btn{
    border-radius: 7px;
    outline: none;
    border: none;
    padding: 7px 10px 7px 10px;
    height: 30px;
}
.users_section_content{
    width: 90%;
    height: 100%;
    margin: 30px auto;
}
.return{
    color: white;
    text-decoration: none;
}
.logout{
    cursor: pointer;
}
.row{
    width: 100%;
    display: flex;
    flex-wrap: wrap;
}
.modal_input_row{
    width: 100%;
    position: relative;
}
.input_container{
      width: 90%;
      margin: auto;
      display: flex;
      position: relative;
      flex-wrap: wrap;
  }
  .input_user_edit{
      width: 49%;
      height: 40px;
      border: none;
      outline: none;
      margin: 30px auto; 
      border-radius: 7px;
      padding: 0 10px 0 10px;
  }
  /*:hoverselect.modal_input_user_edit{
      width: 51%; 
  }*/
  .input_label{
      position: absolute;
      top:0;
      left:0;
      width: 100%;
      color: white;
  }
@media(max-width: 900px){
      .input_user_edit{
          width: 80%;
      }
  }
@media(max-width: 500px){
      .input_user_edit{
          width: calc(100% - 20px);
      }
  }
.btn-yellow {
    color: rgb(255, 255, 255);
    background: #E4A255;
    font-weight: 600;
    width: 150px;
    padding: 5px;
    margin: 10px;
    border-radius: 7px;
    min-height: 35px;
    border: none;
}
</style>