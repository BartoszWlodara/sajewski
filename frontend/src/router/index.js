import Vue from 'vue'
import VueRouter from 'vue-router'
//import HomeView from '../views/HomeView.vue'
import store from '../store'
import Home from '../views/HomeView.vue'

Vue.use(VueRouter)


const routes = [
  {
    path: '/',
    name: 'HomeView',
    component: Home
  },/*
  {
    path: '/biografia',
    name: 'Biography',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import('../views/BiographyView.vue')
  },
  {
    path: '/galeria',
    name: 'Gallery',
    component: () => import( '../views/WorksGalleryView.vue')
  },
  {
    path: '/wystawy',
    name: 'Exhibitions',
    component: () => import('../views/ExhibitionView.vue')
  },
  {
    path: '/aukcje',
    name: 'Auctions',
    component: () => import('../views/AuctionsView.vue')
  },
  {
    path: '/kontakt',
    name: 'Contact',
    component: () => import('../views/ContactView.vue')
  }, */
  {
    path: '/paneladministracyjny/login',
    name: 'AdminLogin',
    component: () => import(/* webpackChunkName: "adminLogin" */ '../views/LoginView.vue')
  },
  {
    path: '/paneladministracyjny',
    name: 'AdminPanel',
    component: () => import(/* webpackChunkName: "adminPanel" */ '../views/AdminView.vue'),
    meta:{ 
      requiresAuth: true 
    }
  },
  {
    path: '/account',
    name: 'PasswordChange',
    component: () => import(/* webpackChunkName: "passwordView" */ '../views/PasswordView.vue'),
    meta:{ 
      requiresAuth: true 
    }
  },
  { 
    path: "*", 
    redirect: "/" 
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,/*
  scrollBehavior(to, from, savedPosition){
    if(savedPosition){
      return savedPosition;
    }else{
      const position = {};
      if(to.hash){
        position.selector = to.hash;
        return false;
      }
    }
  },*/
  routes,
  scrollBehavior(to, from, savedPosition){

    //document.querySelector('.side_menu').style.display='none';
   // document.querySelector('.side_menu_mask').style.display='none';
    document.documentElement.style.overflow = 'auto';
    
    let correctOffsetTop;
    if(to.hash === '#prace'){
      correctOffsetTop = 80;
    }else if(to.hash === '#aukcje'){
      correctOffsetTop = 20;
    }else if(to.hash === '#kontakt'){
      correctOffsetTop = 60;
    }else if(to.hash === '#biografia'){
      correctOffsetTop = 10;
    }else if(to.hash === '#home'){
      correctOffsetTop = 0;
    }else{
      correctOffsetTop = 0;
    }

    if(to.hash){
      const options = {
        top: document.querySelector(to.hash).offsetTop-correctOffsetTop,
        behavior: 'smooth'
      }
      window.scrollTo(options);
    //window.scrollBy(options);
      /*return{
        selector: to.hash,
        behavior: 'smooth'
      }*/
     
    }else if(savedPosition){
     /* return{
        selector: to.hash
      }*/
    //xs  console.log(to);
    return savedPosition
       

   }else{
      return {x:0, y:0};
    }
  }
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {

 //   let authenticated = this.$store.getters['auth/getAuthenticated'];

    let authenticated = store.getters['GET_AUTH_STATUS'];

    let IsAuthorize;

    if(authenticated === "logged"){
      IsAuthorize = true;
    }else{
      IsAuthorize = false;
    }

    if (IsAuthorize === false) {
      next({
        path: '/paneladministracyjny/login',
        query: { redirect: to.fullPath }
      })
    } else {
      next()
    }
  } else {
    next()
  }
})

export default router