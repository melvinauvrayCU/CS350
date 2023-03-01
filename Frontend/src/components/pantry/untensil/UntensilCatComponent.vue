<script lang="ts">
import { UntensilCat } from "@/model/CatagoryModel";

export default {
    name: "UntensilCatComponent",
    props: {
        untensilcat: {
            type: UntensilCat,
            required: true
        },
    }
};
</script>

<template>
    <div class="UntensilCatComponent">
        <div class="containerText">
            <h5>{{ untensilcat.name }}</h5>
        </div>

        <div class="flexFill"></div>
        <button @click="$emit('delete-untensilcat', untensilcat.id)">
            X
        </button>

    </div>
</template>

<style scoped>
.UntensilCatComponent {
    background-color: white;
    width: 100px;
    display: flex;
    padding: 5px;
    margin: 10px;
    flex-direction: row;
}

.containerText {
    display: flex;
    flex-direction: row;
}
</style>