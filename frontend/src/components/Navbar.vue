<template>
  <div class="nav">
      <div class="navbar">
        <div class="navbar-logo_div"><router-link class="navbar-logo" :to="{hash: '#home'}">Andrzej Andrea Sajewski</router-link></div>
        <div class="navbar-navigation">
            <router-link class="navbar-link" :to="{hash: '#biografia'}">{{ $t("message.bio") }}</router-link> 
            <router-link class="navbar-link" :to="{hash: '#prace'}">{{ $t("message.work") }}</router-link> 
            <router-link class="navbar-link" :to="{hash: '#wystawy'}">{{ $t("message.exhb") }}</router-link> 
            <router-link class="navbar-link" :to="{hash: '#aukcje'}">{{ $t("message.auctions") }}</router-link> 
            <router-link class="navbar-link" :to="{hash: '#kontakt'}">{{ $t("message.contact") }}</router-link> 
            
            <select class="language-select" @change="onChangeLanguage($event)" v-model="$i18n.locale">
                <option v-for="(lang , i) in langs"
                :key="`lang-${i}`"
                :value="lang">
                    {{ lang }}
                </option>

            </select>
            <UserIcon size="1x" v-if="ifAuth" @click="showUserModal" class="navbar_user_icon"></UserIcon>
               
        </div>
            <div @click="mobile_menu" class="navbar-mobile-menu">
                <MenuIcon size="2x" style="cursor: pointer;"></MenuIcon>
            </div>
      </div>

  <transition name="show">   
      <div v-show="side_menu" class="side_menu_mask"></div>
  </transition>

 <transition name="fade">
      <div v-show="side_menu" class="side_menu">
        <div class="side_menu_container">
          <router-link class="navbar-link" @click.native="hide_menu" :to="{hash: '#biografia'}">{{ $t("message.bio") }}</router-link> 
          <router-link class="navbar-link" @click.native="hide_menu" :to="{hash: '#prace'}">{{ $t("message.work") }}</router-link> 
          <router-link class="navbar-link" @click.native="hide_menu" :to="{hash: '#wystawy'}">{{ $t("message.exhb") }}</router-link> 
          <router-link class="navbar-link" @click.native="hide_menu" :to="{hash: '#aukcje'}">{{ $t("message.auctions") }}</router-link> 
          <router-link class="navbar-link" @click.native="hide_menu" :to="{hash: '#kontakt'}">{{ $t("message.contact") }}</router-link> 
          <div class="navbar-link" style="display:flex; justify-content:center;">
            <select class="language-select mobile" @change="onChangeLanguageSide_menu($event)" v-model="$i18n.locale">
                <option v-for="(lang , i) in langs"
                :key="`lang-${i}`"
                :value="lang">
                    {{ lang }}
                </option>

            </select>
          </div>
           <router-link v-if="(ifAuth && (GET_ROLE.role === 'Administrator'))" class="navbar-link" to="/paneladministracyjny">{{ $t("message.adminPanel") }}</router-link> 
           <router-link v-if="ifAuth" class="navbar-link" to="/account">Zmiana hasła</router-link> 
           <a v-if="ifAuth" class="navbar-link" @click="logout">Wyloguj</a>
        </div>
      </div>
 </transition>

<div v-if="ifAuth" id="modal_user_pop" v-on:click.self="closeUserModal" v-show="isUserModalVisible">

 <transition  name="modal-fade">

      <div class="modal_user_navbar"
        role="dialog"
        aria-labelledby="modalTitle"
        aria-describedby="modalDescription"
      >
        <header
          class="modal-header"
          id="modalTitle"
        >
          <slot name="header">
            Witaj, {{GET_ROLE.name}}
          </slot>
           <button
            type="button"
            class="btn-close"
            @click="closeUserModal"
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
            
            <router-link v-if="(GET_ROLE.role === 'Administrator')" class="navbar-link_popup" to="/paneladministracyjny">{{ $t("message.adminPanel") }}</router-link> 
            <router-link v-if="ifAuth" class="navbar-link_popup" to="/account">Zmiana hasła</router-link> 
            <a class="navbar-link_popup" @click="logout">Wyloguj</a> 
            
            </div>
          </slot>
        </section>
      </div>

  </transition>
  </div>
  </div>


</template>

<script>
import * as actionTypes from '../store/action-types'
/*import * as getterTypes from '../store/getter-types' */
import {mapGetters} from 'vuex' 
import { MenuIcon, UserIcon } from '../utils/libs/Icons'

export default {
  name: 'Navbar',
  components:{
    MenuIcon,
    UserIcon
  },
  data(){
      return {
          langs : ['pl', 'en', 'it'],
          side_menu: false,
          isUserModalVisible: false,
          ifAuth: false
     }
  },
  methods:{
      mobile_menu(){
          let menu_handle = this.side_menu;
          if(menu_handle === false){
              this.side_menu = true;
              document.documentElement.style.overflow = 'hidden'
          }else if(menu_handle === true){
              this.side_menu = false;
              document.documentElement.style.overflow = 'auto'
          }
      },
      hide_menu(){
        this.side_menu = false;
      },
      showUserModal() {
        if(this.isUserModalVisible === false){
            this.isUserModalVisible = true;
        }else{
            this.isUserModalVisible = false;
        }
      },
      closeUserModal() {
        this.isUserModalVisible = false;
            document.querySelector('.side_menu').style.display='none';
    document.querySelector('.side_menu_mask').style.display='none';
    document.documentElement.style.overflow = 'auto';
      },
      logout() {
        this.$store.dispatch(actionTypes.AUTH_LOGOUT)
        .then(() => {
          this.$router.push('/paneladministracyjny/login')
      })
      },
      onChangeLanguage(event){
          //console.log(event.target.value);
          this.$store.dispatch(actionTypes.LANG, event.target.value);
      },
      onChangeLanguageSide_menu(event){
          this.$store.dispatch(actionTypes.LANG, event.target.value);
          this.mobile_menu();
      }
  },
  async created(){
        if(this.GET_AUTH_STATUS === "logged"){
            this.ifAuth = true;
        }else{
        this.ifAuth = false;
        }
  },
  computed: {
      ...mapGetters([
          'GET_ROLE',
          'GET_AUTH_STATUS',
          'GET_LANG'
                // ...
      ])
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
.navbar{
    width: 100%;
    background: rgba(26, 26, 26, .94);
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    justify-content: space-between;
    z-index: 20;
}
.navbar-logo_div{
   padding: 20px;
}
.navbar-logo{
   color: white;
   font-weight: 600;
   letter-spacing: 1px;
   font-size: 18px;
   text-decoration: none;
}
@media(max-width:500px){
  .navbar-logo{
    font-size: 16px;
  }
}
@media(max-width:350px){
  .navbar-logo{
    font-size: 14px;
  }
}
.navbar-navigation{
    display: flex;
    margin-right: 3%;
}
.navbar-mobile-menu{
    display: none;
    color: white;
}
@media(max-width:889px){
    .navbar-navigation{
        display: none;
    }
    .navbar-mobile-menu{
        display: block;
        padding: 15px 25px 0 25px;
        height: 20px;
    }
}
.navbar-link{
    padding: 20px;
    text-decoration: none;
    color: white;
    font-weight: 500;
}
.navbar-link:hover{
    transition: .7s;
    background: rgb(70, 70, 70);
}
.language-select{
    width: 48px;
    height: 30px;
    border-radius: 10px;
    background: #1c1c1c;
    outline: none;
    margin: 16px 0 0 10px;
    padding: 4px;
    border: none;
    border: 2px solid rgb(245, 245, 245);
    color: white;
    font-weight: 600;
    cursor: pointer;
}
.language-select.mobile{
    width: 60px;
    height: 50px;
    margin: 0;
    padding-left: 15px;
    font-size: 16px;
}
#hamburger_menu{
    font-size: 32px;
    cursor: pointer;
}
.side_menu{
    width: 100%;
    max-width: 500px;
   /* height: calc(100vh - 62px); */
    height: calc(100vh - 55px);
    position: fixed;
    background: rgba(26, 26, 26, .8);
    right: 0;
    top: 59px; 
    z-index: 19;
    overflow: scroll;
}
.side_menu_container{
    display: grid;
}
@media(min-width: 890px){
    .side_menu, .side_menu_mask{
        display: none;
    }
}
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
.side_menu_mask{
    height: 100%;
    width: 100vw;
    z-index: 18;
    position: fixed;
    top:0;
    left: 0;
    background: black;
    opacity: 70%;
    overflow: hidden;
}
.navbar_user_icon{
    color: white;
    margin: 16px 0 20px 20px;
    padding: 5px;
    border-radius: 50%;
    border: 2px solid white;
    cursor: pointer;
    transition: .4s;
}
.navbar_user_icon:hover{
    background: #E4A255;
    color: white;
}


@media(max-width:889px){
    #modal_user_pop{
        display: none;
    }
}
  .modal_user_navbar {
    background: #464646;
    box-shadow: 2px 2px 20px 1px rgb(22, 22, 22);
    overflow-x: auto;
    display: flex;
    flex-direction: column;
    position: fixed;
    top:55px;
    right:30px;
    width: 250px;
    z-index: 21;
    border-radius: 7px;
  }
  .modal-header {
    position: relative;
    border-bottom: 1px solid #eeeeee;
    color: white;
    justify-content: space-between;
    font-size: 14px;
    padding: 15px;
    display: flex;
    letter-spacing: .2px;
    font-weight: 600;
  }
  .modal-body {
    position: relative;
    margin: auto;
    display: flex;
    flex-wrap: wrap;
    width: 100%;
    justify-content: center;
  }
   .modal_body_container{
       display: flex;
       flex-wrap: wrap;
       width: 100%;
   } 
  .btn-close {
    position: absolute;
    top: 0;
    right: 0;
    border: none;
    font-size: 20px;
    padding: 10px;
    cursor: pointer;
    font-weight: bold;
    color: white;
    background: transparent;
  }

  .modal-fade-enter,
  .modal-fade-leave-to {
    opacity: 0;
  }

  .modal-fade-enter-active,
  .modal-fade-leave-active {
    transition: opacity .5s ease;
  }

  .navbar-link_popup{
      width: 100%;
      padding: 10px;
      color: white;
      text-decoration: none;
      font-weight: 500;
      font-size: 15px;
      cursor: pointer;
  }
  .navbar-link_popup:hover{
      background: #666666;
  }

</style>
