<script lang="ts">
import type { IngredientCat } from "@/model/PantryModels";
import IngredientCatComponent from "@/components/pantry/ingredient/IngredientCatComponent.vue";
export default {
    name: "IngredientCatListComponent",
    emits: ["open-ingredientmodal","delete-ingredientcat"],
    props: {
        ingredientcats: Array<IngredientCat>,
    },
    components: {
        IngredientCatComponent,
    }
};
</script>
<template>
    <div class="list">
        <IngredientCatComponent @delete-ingredientcat="(id) => $emit('delete-ingredientcat', id)"
            @open-ingredientmodal="(id) => $emit('open-ingredientmodal', id)" 
            v-for="ingredientcat in ingredientcats" :key="ingredientcat.id"
            :ingredientcat="ingredientcat" />
    </div>
</template>

<style scoped>

.list {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
}

</style>