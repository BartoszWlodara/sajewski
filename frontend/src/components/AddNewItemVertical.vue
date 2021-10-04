<template>
    <div class="add_item_vertical">
        <div class="add_item_vertical_container">
            <PlusCircleIcon size="2.5x" class="anticon-plus-circle"></PlusCircleIcon>
            <p>Dodaj</p>
        </div>
    </div>
</template>

<script>
//import { defineComponent } from '@vue/composition-api'
import { PlusCircleIcon } from '../utils/libs/Icons'

export default ({
    components:{
        PlusCircleIcon
    }
})
</script>

<style scoped>
.add_item_vertical{
    border: 2px solid white;
    z-index: 5;
    width: 27vw;
    height: 45vh;
    margin: 1% 1% 1% 3%;
    max-height: 430px;
    max-width: 430px;
    min-height: 350px;
    position: relative;
    border-radius: 5px;
    transition: .5s;
    border-radius: 15px;
    padding-left: 5px;
    display: flex;
}
.add_item_vertical:hover{
    transform: scale(1.05);
    cursor: pointer;
    background: rgba(66, 66, 66, .5);
}
.add_item_vertical_container{
    margin: auto;
}
.add_item_vertical_container p{
    margin-top: -10px;
    color: white;
    font-weight: 500;
}
.anticon-plus-circle{
    color: white;
    height: 50px;
    font-size: 50px;
}
@media(max-width:1040px){
    .add_item_vertical{
        height: 35vh;
        min-height: 250px;
    }
}
@media(max-width:766px){
    .add_item_vertical{
        width: 30vw;
        height: 30vh;
        min-height: 200px;
    }
}
@media(max-width:644px){
    .add_item_vertical{
        height: 40vh;
        width: 45vw;
    }
}
@media(max-width:476px){
    .add_item_vertical{
        height: 30vh;
        width: 60vw;
    }
}
.anticon-plus-circle{
    color: white;
    margin-bottom: 10px;
}
</style>