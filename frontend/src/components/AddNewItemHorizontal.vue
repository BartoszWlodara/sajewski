<template>
    <div class="add_item">
        <div class="add_item_container">
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
.add_item{
    width: 80%;
    height: 20vh;
    min-height: 100px;
    border: 2px solid white;
    margin: 30px auto 20px auto;
    border-radius: 15px;
    display: flex;
    transition: .5s;
    z-index: 5;
}
.add_item:hover{
    transform: scale(1.05);
    cursor: pointer;
    background: rgba(66, 66, 66, .5);
}
.add_item_container{
    margin: auto;
}
.add_item_container p{
    margin-top: -10px;
    color: white;
    font-weight: 500;
}
.anticon-plus-circle{
    color: white;
    margin-bottom: 10px;
}
</style>