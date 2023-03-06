<script lang="ts">
export default {
    name: "BackgroundIcons"
};
</script>
<template>
    <div>
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
    position: absolute;
    -webkit-user-drag: none;
    user-select: none;
    -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
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