<template>
  <div class="chapter_header">
  
      <div class="row">
          <hr class="horizontal_hr" />
             <div class="chapter_logo">
                <img class="chapter_paraf" src="@/assets/images/paraf.png" alt="adrzej_adnrea_sajewski_logo" />    
             </div> 
          <hr class="horizontal_hr" />
    
      </div>
  </div>
</template>

<script>

export default {
  name: 'ChapterHeader',
  data(){
      return{
          options: {
            rewind : true,
            autoplay: true,
            perPage: 1,
            pauseOnHover: false,
            arrows: false
          }
      }
  },
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
.chapter_header{
    width: 100%;
    display: flex;
    justify-content: center;
}
.horizontal_hr{
    width: 25%;
    height: 1px;
    background: white;
    margin: 27px 0;
    border: none;
}
.row{
    width: 100%;
    justify-content: center;
}
.chapter_logo{
    padding: 10px 20px 10px 20px;
}
.chapter_paraf{
    width: 80%;
    height: 85%;
}
</style>
