<script lang="ts">
import type { IngredientCat } from "@/model/CatagoryModel";
import IngredientCatComponent from "@/components/pantry/ingredient/IngredientCatComponent.vue";
export default {
    name: "IngredientCatListComponent",
    props: {
        ingredientcats: Array<IngredientCat>,
    },
    components: {
        IngredientCatComponent,
    }
};
</script>
<template>
        <IngredientCatComponent @delete-ingredientcat="(id) => $emit('delete-ingredientcat', id)" v-for="ingredientcat in ingredientcats" :key="ingredientcat.id"
            :ingredientcat="ingredientcat" />
</template>
