<template>
  <div id="app">

     <transition name="fade">
        <CookiesComponent v-if="this.GET_COOKIES_STATUS"></CookiesComponent>
     </transition>

 <router-view>
  <Login></Login>
  <AdminView></AdminView>
  <PasswordView></PasswordView>
  </router-view> 

  
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  components: {
    Login: () => import(/* webpackPrefetch: true */ '@/views/LoginView.vue'),
    AdminView: () => import(/* webpackPrefetch: true */ '@/views/AdminView.vue'),
    PasswordView: () => import(/* webpackPrefetch: true */ '@/views/PasswordView.vue'),
    CookiesComponent: () => import(/* webpackPrefetch: true */ '@/components/CookiesMessage.vue')
  },
  mounted(){
    if(localStorage.Lang!=null) this.$i18n.locale=localStorage.Lang;
    
  },
  computed: {
    ...mapGetters([
        'GET_COOKIES_STATUS'
    ]),
  },
}
</script>

<style lang="scss">
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
html{
  overflow-x: hidden;
}
body{
  margin: 0 0 -1000px 0;
  background: #2B2B2B;
  overflow: hidden;
}
#nav {
  padding: 30px;

  a {
    font-weight: bold;
    color: #2c3e50;

    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
.row{
  display: flex;
}
.vw_85{
  width: 85vw;
}
.splide__arrow{
    width: 3em;
    height: 3em;
    opacity: 1;
    color: white;
}
.splide__arrow--prev{
    left: -1.2em;
}
.splide__arrow--next{
    right: -1.4em;
}
@media(max-width:450px){
  .splide__arrow--prev{
    left: -1.5rem!important;
  }
  .splide__arrow--next{
    right: -1.5rem!important;
  }
}
.chapter_title{
    width: 100%;
    justify-content: center;
    font-size: 24px;
    color: white;
    font-weight: 900;
    letter-spacing: 1px;
    margin-top: 20px;
}
.auction_slide .splide__track{
  overflow: unset;
  overflow-x: clip;
}
button{
  cursor: pointer;
}
.admin_options{
    position: absolute;
    top: 0;
    right: 0;
    height: 60px;
    width: 60px;
    background: rgba(255, 255, 255, .7);
    z-index: 5;
    border-radius: 50%;
}
.admin_options_container{
    width: 100%;
    height: 100%;
}
.admin_options_row{
    width: 100%;
    /*height: 50%;*/
    height: 100%;
    display: flex;
    position: relative;
}
.admin_options_row.border_bottom:after{
    content: '';
    height: 1px;
    width: 35px;
    background: black;
    position: absolute;
    bottom: 0;
    left: 7.5px;
}
.anticon-delete, .anticon-edit{
    margin: auto;
    font-size: 20px;
    padding: 15px 10px 10px 10px;
}
.anticon-delete:hover, .anticon-edit:hover{
    transform: scale(1.3);
    transition: .5s;
    cursor: pointer;
}
.image_Loader{
  height: 50px!important;
  width: 50px!important;
  margin: auto;
  transition: 0;
}
.grecaptcha-badge{
  z-index: 25;
}
.desktop{
  display: block;
}
.mobile{
  display: none;
}
@media(max-width:889px){
    .desktop{
        display: none;
    }
    .mobile{
        display: block;
    }
}
.text-danger{
    color: wheat;
    font-weight: 600;
}
.category_delete_icon{
    margin: auto;
    transition: .3s;
}
.category_delete_icon:hover{
    transform: scale(1.1);
    cursor: pointer;
}
   .disabled{
    opacity: .5;
    pointer-events: none;
  }
  .filename{
    color: white;
  }
  .filenameInfo{
    font-weight: 600;
    margin-bottom: 5px;
  }
  .modal-header {
    min-height: 25px;
  }
  .modal-footer{
    min-height: 100px;
  }
.fade-enter-active,
.fade-leave-active {
    transition: opacity .2s;
}
[v-cloak] { display: none; }
.fade-enter,
.fade-leave-to {
    opacity: 0
}
.feather-x-circle{
  cursor: pointer;
}
textarea{
  font-family: arial;
  font-size: 14px;
}
.loader_container{
    display: flex;
    width: 100%;
    height: 100%;
    position: absolute;
    background: #2B2B2B;
}
</style>
