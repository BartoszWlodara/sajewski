<template>
    <div id="kontakt" :style="[samsungBrowser ? {'background': image} : {'background': '#7D674D'}]" >
        <div class="contact_image">
            <Loader v-if="show_loader"></Loader>

            <div class="contact_image_content">
             <div class="row chapter_title">{{ $t("message.contactTitle") }}</div>
                <ChapterHeader></ChapterHeader>
                <div class="contact_details">
                    <p>
                        {{$t('message.Contact_Info_Par1')}}
                    </p>
                    <p>
                        {{$t('message.Contact_Info_Par2')}}
                    </p>

                    <div class="contact_email">
                        <div id="email_info">{{$t('message.Contact_Adress_Email')}}</div>
                        <div id="email_author">umberto770@op.pl</div>
                    </div>
                </div>
            </div>
          
        </div>

        
            <div class="contact_form_div">
                
                    <div class="contact_form">
                        <form class="login_container" @submit.prevent="sendEmail">
                            <input required class="contact_form_input" @change="runCaptcha" v-model="emailFrom" type="email" :placeholder="$t('message.placeholder_email')" />
                            <input required class="contact_form_input" v-model="topicValue" :placeholder="$t('message.placeholder_topic')" />
                            <textarea required class="contact_form_textarea" v-model="contentValue" :placeholder="$t('message.placeholder_content')"></textarea>
                            <p class="text-danger">{{this.message}}</p>
                            <div class="button_container">
                                <vue-recaptcha
                                    ref="recaptcha"
                                    @verify="onCaptchaVerified"
                                    @expired="onCaptchaExpired"
                                    size="invisible"
                                    sitekey="6Lcvh7wbAAAAAGrHKO8eHhPRphw3w1PAM5daqCLc"> <!-- PROD -->
                                   
                                </vue-recaptcha>
                                
                                <button :disabled="status==='submitting'" type="submit" class="contact_btn">{{$t('message.Send')}}</button>
                          
                            </div>
                        </form>
                    </div>
            
            </div>
     
    </div>
</template>

<script>
import ChapterHeader from '@/components/ChapterHeader.vue'
import API from '../http'
import VueRecaptcha from 'vue-recaptcha';
//import axios from 'axios'

export default ({
    components:{
        ChapterHeader,
        VueRecaptcha,
        Loader: () => import(/* webpackPrefetch: true */ '@/components/SmallLoader.vue'),
    },
    props:{
        samsungBrowser:{
            default: false,
            type: Boolean
        }
    },
    data(){
        return{
            emailFrom: '',
            topicValue: '',
            contentValue: '',
            message: '',
            status: '',
            image: `url(${require('@/assets/images/samsung_browser_contact.png')})`,
            show_loader: false
        }
    },
    methods:{
        sendEmail(){
      
             this.$refs.recaptcha.execute();

        },
        reCaptchaOnFocus() {
            let head = document.getElementsByTagName('head')[0];
            const script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = 'https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit';
            head.appendChild(script);

        },
        onCaptchaVerified: function (recaptchaToken) {

            const self = this;
            self.$refs.recaptcha.reset();
            

                if(self.emailFrom.length < 5){
                    self.message = self.$t('message.TooShortEmail');
                }else if(this.topicValue.length < 10){
                    self.message = self.$t('message.TooShortTopic');
                }
                else if(this.contentValue.length < 20){
                    self.message = self.$t('message.TooShortContent');
                }else{
                    self.show_loader = true;
                    self.status = "submitting";

                    API.post('mail.php', {
                        email_from: self.emailFrom,
                        topic: self.topicValue,
                        content: self.contentValue,
                        recaptcha: recaptchaToken

                    }).then(() => {

                        self.message = self.$t('message.EmailSuccess');

                        self.emailFrom = '';
                        self.topicValue = '';
                        self.contentValue = '';

                        self.show_loader = false;
                    
                    }).catch((e) => {
    
                        let error_code = e.response.data.error_code;

                        if(error_code === 'error_mail'){
                            self.message = self.$t('message.EmailFail');
                        }else{
                            self.message = self.$t('message.EmailFail_captcha');
                        }
                        self.status = "";
                        self.show_loader = false;
                    })
                }

        },
        onCaptchaExpired: function () {
             this.$refs.recaptcha.reset();
        },
        runCaptcha(){
            this.reCaptchaOnFocus();
        }
    }
})
</script>

<style scoped>
#kontakt{
    width: 100%;
    margin: auto;
    display: flex;
    min-height: 80vh;

    position: relative;
    overflow: hidden;
    flex-wrap: wrap;
    z-index: 3;
}
.contact_image{
    width: 50%;
    position: relative;
    z-index: 2;
    display: flex;
  /*  background-color: red;
    border-top-right-radius: 50%;
    border-bottom-right-radius: 50%;
    background-image: url('~@/assets/images/contact.jpg'); */
}
.contact_image::before{
    content: '';
    width: 100%;
    height: 120%;
    position: absolute;
    top: -10%;
    left: 0;
    z-index: -1;
    opacity: .65;
    border-top-right-radius: 50%;
    border-bottom-right-radius: 50%;
    background-image: url('~@/assets/images/contact.jpeg');
    filter: brightness(.5);
    background-repeat: no-repeat;
    background-position: 100% 50%;
}
.contact_form_div{
    width: 50%;
    display: flex;
}
.contact_form{
    width: 70%;
    margin: auto auto auto 7%;
}
.contact_form_input, .contact_form_textarea{
    width: calc(100% - 20px);
    margin-top: 10px;
    height: 45px;
    border: none;
    border-radius: 10px;
    background-color: #E8E8E8;
    outline: none;
    padding: 0 10px 0 10px;
}
.contact_form_textarea{
    height: 200px;
    padding: 10px;
}
.contact_details{
    width: 80%;
    margin: auto;
    text-align: left;
    color: white;
    font-weight: 500;
    font-size: 17px;
}
.contact_email, .email_info, .email_author{
    width: 100%;
    margin-top: 50px;
}
.contact_image_content{
    margin: auto;
    transform: translate(0, -20%)
}
.button_container{
    width: 100%;
    display: flex;
    justify-content: center;
}
.contact_btn{
    height: 35px;
    width: 110px;
    margin: 20px auto 0 auto;
    padding: 5px;
    border-radius: 10px;
    border: none;
    background: #E8E8E8;
}
@media(max-width:1199px){
    .contact_form{
        width: 85%;
    }
    .button_container{
        margin-bottom: 50px;
    }
}
@media(max-width:975px){
    .contact_image, .contact_form_div{
        width: 100%;
    }
    .contact_form{
        width: 60%;
        margin: auto;
    }
    .contact_image_content{
        transform: unset;
    }
    .contact_image::before{
        width: 80%;
        height: 330%;
        top: -180px;
    }
    .contact_form_div{
        z-index: 2;
    }
    .contact_details{
        margin-bottom: 50px;
    }
}
@media(max-width:750px){
    .contact_image::before{
        top: -200px;
    }
    .contact_form{
        width: 80%;
    }
}
@media(max-width:591px){
    .contact_image::before{
        top: -435px;
        height: 400%;
        background-position: center 60%;
    }
    .button_container{
        margin-bottom: 40px;
    }
}
@media(max-width:499px){
    .contact_image::before{
        width: 90%;
        background-position: 50% 40%;
        top: -5px;
        height: 180%;
    }
}

@media(max-width:415px){
    .button_container{
        margin-bottom: 35px;
        
    }
}
@media(max-width:395px){
    .contact_image::before{
        height: 160%;
        
    }
}
</style>