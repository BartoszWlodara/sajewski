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
            <div class="users_section_title">Użytkownicy
                <button id="show-modal" @click="showUsersModal" class="add_user_btn">Dodaj użytkownika</button>
            </div>

            <div class="users_section_content">
                <div class="user_record" v-for="user in userArray"
                    :key="user.id">
                    <div class="user_record_cell">{{user.name}}</div>
                    <div class="user_record_cell">{{user.e_mail}}</div>
                    <div class="user_record_cell">{{user.role}}</div>
                    <div style="width:50px;" class="user_record_cell">
                        <button v-if="user.role!=='Administrator'" @click="SelectUserToDelete(user.id, user.role)" class="delete_btn">Usuń</button>
                    </div>
                </div>
            </div>
        </div>
        

        <UsersModal v-if="isUsersModalVisible" @close="closeUsersModal"></UsersModal>
        <DeleteModal v-if="isDeleteModalVisible" @close="closeDeleteModal" @deleteElement='DeleteElement'></DeleteModal>

    </div>
</template>

<script>
import UsersModal from '@/components/Modals/AdminUsersModal.vue'
import DeleteModal from '@/components/Modals/DeleteModal.vue'
import * as actionTypes from '../store/action-types'
import API from '../http.js'
import { mapGetters } from 'vuex'

export default {
    name: 'AdminView',
    components:{
        UsersModal,
        DeleteModal
    },
    data(){
        return{
            isUsersModalVisible: false,
            isDeleteModalVisible: false,
            userArray: [],
            itemToDelete: null,
            UserRoleToDelete: ''
        }
    },
    methods:{
        showUsersModal(){
            this.isUsersModalVisible = true;
        },
        closeUsersModal(){
            this.isUsersModalVisible = false;
        },
        closeDeleteModal(){
            this.isDeleteModalVisible = false;
            this.itemToDelete = null;
            this.UserRoleToDelete = '';
        },
        logout() {
            this.$store.dispatch(actionTypes.AUTH_LOGOUT)
            .then(() => {
            this.$router.push('/paneladministracyjny/login')
            })
        },
        SelectUserToDelete(id, role){
            this.itemToDelete = id;
            this.UserRoleToDelete = role;
            this.isDeleteModalVisible = true;
        },
        DeleteElement(){

            API.post(`/admin/delete_user.php?user=${this.itemToDelete}`, {
                role: this.UserRoleToDelete
            }, {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('user-token')
                }
            }).then(() => {

                this.$router.go();
                
            }).catch(() => {
                 
                alert("Nie można usunąć użytkownika.");
    
            }); 
            this.itemToDelete = null;
            this.UserRoleToDelete = '';
            this.isDeleteModalVisible = false;
        }
        
    },
    mounted() {

        if(this.GET_ROLE.role === 'Administrator'){

            API.get(`admin/get_users.php`, {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('user-token')
                }
            }).then(response => {
               this.userArray = response.data.Users;
                
                
            }).catch(() => {
                 
                this.$store.dispatch(actionTypes.AUTH_LOGOUT)
                    .then(() => {
                    this.$router.push('/paneladministracyjny/login')
                })
    
            }); 
        }else{
            
            this.$router.push('/')

        }

            
    },
      computed: {
       ...mapGetters([
        'GET_ROLE'
        // ...
        ]),
    },
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
.user_record{
    width: calc(100% - 40px);
    min-height: 25px;
    background: #c3c3c3;
    border-radius: 10px;
    display: flex;
    justify-content: space-between;
    padding: 0 20px;
    margin-top: 20px;
    flex-wrap: wrap;
}
.user_record_cell{
    padding: 20px;
    color: rgb(32, 32, 32);
    font-weight: 500;
    width: calc(25% - 40px);
    overflow: hidden;
}
@media(max-width:650px){
    .user_record_cell{
        width: unset;
    }
}
.delete_btn{
    margin-top: -10px;
    color: white;
    font-weight: 600;
    width: 70px;
    height: 25px;
    border: none;
    outline: none;
    border-radius: 7px;
    background: rgb(163, 20, 20);
}
.return{
    color: white;
    text-decoration: none;
}
.logout{
    cursor: pointer;
}
</style>