<template>
    <div class="small_loader" v-bind:class="{gallery_loader: galleryLoader}">
        <img src="@/assets/images/loading.svg">
    </div>
    
</template>
<script>
export default {
    props:{
        galleryLoader: {
            type: Boolean,
            default: false
        }
    }
}
</script>

<style scoped>
.small_loader{
    width: 100%;
    height: 100%;
    display: flex;
    background: rgba(0, 0, 0,.4);
    z-index: 10;

    position: fixed;
    top: 0;
}
.gallery_loader{
    background: #2B2B2B;
}
.small_loader > img{
    z-index: 20;
    width: 70px;
    height: 70px;
    margin: auto;
}
</style>