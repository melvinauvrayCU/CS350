<script lang="ts">
import type { Ingredient } from "@/model/recipeModel";
import ViewIngredient from "@/components/view/ViewIngredientComponent.vue";
import { Conversion, Unit } from "@/model/PantryModels";

export default {
    name: "ViewIngredientList",
    props: {
        ingredients: {
            type: Array<Ingredient>,
            required: true
        },
        conversion: {
            type: Conversion,
            required: true
        },
        units: {
            type: Array<Unit>,
            required: true
        },
        feeding: {
            type: Number,
            required: true,
            default: 1
        }
    },
    components: {
        ViewIngredient
    },
    methods: {
        
    },
};
</script>

<template>
    <ViewIngredient v-for="ingredient in ingredients" 
    :key="ingredient.name" 
    :ingredient="ingredient" 
    :conversion="conversion"
    :units="units"
    :feeding="feeding"
    />
</template>