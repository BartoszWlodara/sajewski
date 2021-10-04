<template>
    <div class="footer">
        <div class="app_author">
            <p class="web_owner">Andrzej Andrea Sajewski © | {{currentYear}}</p>
            <hr class="footer_hr" />
            <p class="devMail" @click="DevMail">design & development - B. Włodara</p>
        </div>
    </div>
</template>
<script>

export default {
    data(){
        return{
            currentYear: new Date().getFullYear()
        }
    },
    methods:{
        DevMail(){
            window.location.href = "mailto:bartosz.wlodara@gmail.com?subject=Subject&body=message%20goes%20here";
        }
    }
}
</script>

<style scoped>
.footer{
  /*  width: 100%; */
    height: 105px;
    display: flex;
    justify-content: center;
    padding: 2px;
    position: relative;
    background: #2B2B2B;
    color: white;
    overflow: hidden;
   /* z-index: 1; */
   z-index: 1;
}
.app_author{
    min-width: 300px;
}
.footer_hr{
    border: none;
    width: 100%;
    background: white;
    height: 1px;
}
.devMail:hover{
    cursor: pointer;
    font-size: 16.5px;
    transition: .5s;
}
.web_owner{
    font-weight: 600;
}
.devMail{
    margin-top: 15px;
}
</style>