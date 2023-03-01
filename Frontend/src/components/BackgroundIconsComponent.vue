<script lang="ts">
export default {
    name: "BackgroundIcons"
};
</script>
<template>
    <div>
        <img src="@/assets/foodIcons/banana.png">
        <img src="@/assets/foodIcons/cheese.png">
        <img src="@/assets/foodIcons/meat.png">
        <img src="@/assets/foodIcons/pepper.png">
        <img src="@/assets/foodIcons/lemon.png">
    </div>
</template>

<style scoped>
div {
    height: 100%;
    width: 100%;
    position: absolute;
    z-index: -1;
}

img {
    width: 80px;
    position: absolute
}

img:nth-child(1) {
    top: 20%;
    left: 4%;
    transform: rotate(-15deg);
}

img:nth-child(2) {
    top: 5%;
    right: 6%;
    transform: rotate(15deg);
}

img:nth-child(3) {
    top: 60%;
    left: 8%;
}

img:nth-child(4) {
    top: 45%;
    right: 2%;
}

img:nth-child(5) {
    top: 90%;
    right: 10%;
}
</style>