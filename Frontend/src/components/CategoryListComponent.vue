<script lang="ts">
import type { Category } from "@/model/categoryModel";
import type { Recipe } from "@/model/recipeModel";
import CategoryComponent from "./CategoryComponent.vue";
import RecipeListComponent from "./RecipeListComponent.vue";

export default {
    name: "CategoryListComponent",
    // This component will include an array of Category since we want to display the full list of categories available
    props: {
        categories: Array<Category>,
        recipes: Array<Recipe>,
    },
    components: {
        CategoryComponent,
        RecipeListComponent,
    },
    methods: {
        getRecipesForCategory(category: Category) {
            return this.recipes?.filter((recipe) =>
            category.linkedRecipeList.some((linkedRecipe) => linkedRecipe.id === recipe.id)
            );
        },
     },
};

</script>

<template>
    <div class="categoryRecipeList">
        <div v-for="category in categories" :key="category.id">
            <CategoryComponent :category="category"/>

            <RecipeListComponent  
                :recipes="getRecipesForCategory(category)"
                @delete-recipe="(id) => $emit('delete-recipe',id)" />
        </div> 
    </div>
</template>
