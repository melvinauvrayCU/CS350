<script lang="ts">
import type { IngredientCat } from "@/model/PantryModels";
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
        <IngredientCatComponent @delete-ingredientcat="(id) => $emit('delete-ingredientcat', id)"
            @open-ingredientmodal="(id) => $emit('open-ingredientmodal', id)" 
            v-for="ingredientcat in ingredientcats" :key="ingredientcat.id"
            :ingredientcat="ingredientcat" />
</template>
