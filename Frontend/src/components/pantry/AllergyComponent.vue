<script lang="ts">
export default {
    name: "AllergyComponent",
    props: {
        allergy: {
            type: String,
            required: true
        },
    },
};



</script>

<template>
    <div class="IngredientCatComponent">
        <div class="containerText">
            <h5>{{ allergy }}</h5>
        </div>

        <div class="flexFill"></div>

        <button @click="$emit('delete-allergy', allergy)">
            X
        </button>

</div>
</template>

<style scoped>
.IngredientCatComponent {
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