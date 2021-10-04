<template>

    <div class="cookies_message">
        <div @click="accept_cookies" class="cookies_close">
            +
        </div>
        <div class="message_content">
            {{ $t("message.cookieMessage") }}
        </div>
        <div class="cookies_agree">
            <button @click="accept_cookies">Ok</button>
        </div>
    </div>

</template>
<script>
import * as actionTypes from '../store/action-types'

export default {
    name: "CookiesMessage",
    methods:{
        accept_cookies(){
            this.$store.dispatch(actionTypes.COOKIE_MESSAGE);
        }
    }
}
</script>

<style scoped>
.cookies_message{
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100vw;
    min-height: 100px;
    background: #1a1919;
    z-index: 20;
    display: flex;
    flex-wrap: wrap;
}
.message_content{
    margin: auto;
    color: white;
    padding: 20px;
}
.cookies_agree{
    width: 100%;
    padding-bottom: 20px;
}
.cookies_close{
    width: 40px;
    height: 40px;
    background: #fff;
    position: absolute;
    right: 5px;
    top: -20px;
    border-radius: 50%;
    z-index: 21;
    font-weight: 900;
    font-size: 28px;
    cursor: pointer;
    transform: rotate(45deg);
    line-height: 40px;
}
.cookies_agree button{
    width: 70px;
    padding: 5px;
    border-radius: 5px;
    border: none;
    background: #7D674D;
    font-weight: 600;
    color: white;
}

</style>