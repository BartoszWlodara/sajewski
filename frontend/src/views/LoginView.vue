<template>
  <div id="login_page">
    <Loader v-if="show_loader"></Loader>
      <form class="login_container" @submit.prevent="login">
          <h2 style="margin-bottom:0;padding-bottom:10px;">Panel Administracyjny</h2>
          <h3>Logowanie</h3>
          <h6 class="error_msg" v-if="error">{{error}}</h6>
          <div class="login_input_container">
              <div class="input_row">
                 <input required v-model="email" @focus="runCaptcha" type="email" class="login_input" placeholder="Login (e-mail)"/>
              </div>
               <div class="input_row">
                 <input required v-model="password" type="password" class="login_input" placeholder="Hasło"/>
              </div>

                <vue-recaptcha
                    ref="recaptcha"
                    @verify="onCaptchaVerified"
                    @expired="onCaptchaExpired"
                    size="invisible"
                    sitekey="6Lcvh7wbAAAAAGrHKO8eHhPRphw3w1PAM5daqCLc"> <!-- PROD -->
                                   
                </vue-recaptcha>
              
              <button :disabled="disabled_button" type="submit" class="login_btn">Zaloguj</button>
              
             <div style="margin:-30px 0 30px 0;">
                 <router-link class="return_link" to="/">Powrót do strony głównej</router-link>
             </div>
          </div>
           
      </form>

  </div>
</template>

<script>
// @ is an alias to /src
import * as actionTypes from '../store/action-types'
import VueRecaptcha from 'vue-recaptcha';

export default {
  name: 'LoginView',
  components:{
      VueRecaptcha,
      Loader: () => import(/* webpackPrefetch: true */ '@/components/SmallLoader.vue')
  },
  data(){
      return{
          email: '',
          password: '',
          loading: false,
          error: '',
          status: '',
          disabled_button: true,
          show_loader: false
      }
  },
  methods: {
    login() {

         this.$refs.recaptcha.execute();
         this.show_loader = true;

    },
    reCaptchaOnFocus() {
        this.disabled_button = false;
        let head = document.getElementsByTagName('head')[0];
        const script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = 'https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit';
        head.appendChild(script);

    },
    onCaptchaVerified: function (recaptchaToken) {

            const self = this;
            self.status = "submitting";
            self.$refs.recaptcha.reset();

            let email = this.email;
            let password = this.password;
            let captcha = recaptchaToken;
            this.$store.dispatch(actionTypes.AUTH_REQUEST, { email, password, captcha }).then(() => {
                this.$router.push('/');
                self.status = "";
            }).catch((e)=>{
                this.error = e.response.data.message;
                self.status = "";
                self.show_loader = false;
            })
            

    },
    onCaptchaExpired: function () {
        this.$refs.recaptcha.reset();
    },
    runCaptcha(){
        this.reCaptchaOnFocus();
    }
  }
}

</script>
<style scoped>
.login_input_container{
    color: wheat;
}
#login_page{
    min-height: 100vh;
    display: flex;
    background-image: url('~@/assets/images/home_slider/slide1.jpeg');
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
}
.login_container{
    width: 50%;
    margin: auto;
    background: rgba(33, 33, 33, .8);
    box-shadow: 0 0 20px gray;
    border-radius: 20px;
    max-width: 800px;
}
.login_container > h2, .login_container > h3 {
    width: 100%;
    color: white;
    padding: 30px 10px;
}
.login_container > h3{
    padding: 0;
}
.input_row{
    width: 100%;
}
.login_input{
    width: 80%;
    max-width: 500px;
    height: 40px;
    margin-top: 30px;
    border-radius: 10px;
    border: none;
    outline: none;
    padding: 4px 10px 4px 10px;
    background: rgba(255, 255, 255, .9);
}
.login_btn{
    padding: 10px;
    width: 150px;
    border-radius: 10px;
    margin: 40px auto 50px auto;
    border: none;
    background: white;
}
@media(max-width:799px){
    .login_container{
        width: 70%;
    }
}
@media(max-width:520px){
    .login_container{
        width: 90%;
    }
}
.error_msg{
    font-size: 16px;
    color: #cc3636;
    margin: 0;
}
.return_link{
    color: white;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
}
</style>
