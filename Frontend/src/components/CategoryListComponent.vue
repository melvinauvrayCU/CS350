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
        isUserAuthenticated: {
            type: Boolean,
            required: true
        }
    },
    components: {
        CategoryComponent,
        RecipeListComponent,
    }
};

</script>

<template>
    <div class="categoryRecipeList">
        <div v-for="category in categories" :key="category.id">
            <CategoryComponent :category="category" />

            <RecipeListComponent :recipes="category.linkedRecipeList"
                @delete-recipe="(id) => $emit('delete-recipe', id)" :isUserAuthenticated="isUserAuthenticated" />
        </div>
    </div>
</template>
