<script lang="ts">
import { IngredientCat } from "@/model/PantryModels";
import CustomButton from "@/components/formComponents/CustomButtonComponent.vue";
export default {
    name: "IngredientCatComponent",
    emits: ["open-ingredientmodal","delete-ingredientcat"],
    props: {
        ingredientcat: {
            type: IngredientCat,
            required: true
        },
    },
    components: {
        CustomButton
    }
};



</script>

<template>
    <div class="listItem">
        <div class="containerText">
            <h4 class="text">{{ ingredientcat.name }}</h4>
        </div>

        <CustomButton class="button" type="success" effect="inline" text="" titleText="Open ingredient category" 
        icon="add" @clicked="$emit('open-ingredientmodal', ingredientcat.id)" />

        <CustomButton class="button" type="danger" effect="inline" text="" titleText="Delete ingredient category" 
        icon="trash" @clicked="$emit('delete-ingredientcat', ingredientcat.id)" />

</div>
</template>

<style scoped>
.listItem {
    display: flex;
    flex-direction: row;
    border-radius: 25px;
    border-width: 1;
    border-style: solid;
    border-color: var(--color-background-light);
    background-color: var(--color-background-extra-light);
    padding: 10px;
    margin: 5px;
}

.text {
    padding-left: 7px;
    padding-top: 5px;
    display: flex;
    flex-direction: row;
}

.button {
    padding-left: 10px;
    padding-bottom: 5px;
}

</style>