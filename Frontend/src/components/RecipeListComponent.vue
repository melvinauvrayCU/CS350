<script lang="ts">
import type { Recipe } from "@/model/recipeModel";
import RecipeComponent from "@/components/RecipeComponent.vue";
export default {
    name: "RecipeListComponent",
    // This component will require an array of Recipe, since we want to display a full recipe list.
    props: {
        recipes: Array<Recipe>,
    },
    // We will use smaller components in this list, such as the RecipeComponent.
    components: {
        RecipeComponent,
    }
};
</script>
<template>
    <div>
        <!-- 4 different properties are passed to this component here: -->
        <!-- First, when we receive the signal "delete-recipe" (see component RecipeComponent), we want to delete a recipe. -->
        <!-- However we can't delete a recipe here since we are in a component file and not a page file. -->
        <!-- So we just want to let the signal pass through and emit it again for the parent. -->
        <!-- We make sure to get the recipe id that was in the signal to re-emit it. -->

        <!-- Then we have the v-for property, it means that we will loop through the "recipes" array, and for each element, -->
        <!-- We will create a RecipeComponent. So even though we are writing here only one<RecipeComponent />, -->
        <!-- in fact multiple components will be displayed. -->

        <!-- When using v-for, vueJS forces us to add a key attribute for each component we will create. -->
        <!-- This key attribute must absolutely be unique. Hence, here we are using the recipe id, which should be unique. -->

        <!-- Lastly, we have the ":recipe" field, which is the props we will pass to the child. -->
        <!-- Each RecipeComponent requires a recipe props (see the component's file), so we are giving it through this property. -->
        <RecipeComponent @delete-recipe="(id) => $emit('delete-recipe', id)" v-for="recipe in recipes" :key="recipe.id"
            :recipe="recipe" />


        login page
    </div>
</template>