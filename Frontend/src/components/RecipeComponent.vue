<script lang="ts">
import { Recipe } from "@/model/recipeModel";
import router from "@/router/index";

export default {
    name: "RecipeComponent",
    props: {
        // This component will have a props named recipe, which will be of type a single Recipe, and is mandatory.
        recipe: {
            type: Recipe,
            required: true
        },
    },
    methods: {
        editRecipe(){
            console.log("Pushing to edit page " + this.recipe.id);
            router.push({name: "editRecipe", params: {id: this.recipe.id} });
        }
    },
};
</script>

<template>
    <div class="RecipeComponent">
        <div class="containerText">
            <h3>{{ recipe.title }}</h3>
            <p>{{ recipe.description }}</p>
        </div>

        <div class="flexFill"></div>

        <!-- On clicking on the button, we want to delete the recipe,-->
        <!-- Since we are in the component file, we can't touch the API, we are allowed to do so only in Page files, -->
        <!-- Hence, we will emit a signal to the parent component saying that we want to delete the recipe,  -->
        <!-- and we don't forget to attach the id of the recipe we want to delete. -->
        <button @click="$emit('delete-recipe', recipe.id)">
            Delete Recipe
        </button>

        <button @click="editRecipe()">
            Edit recipe 
        </button>

    </div>
</template>

<style scoped>
.RecipeComponent {
    background-color: var(--color-accent);
    width: 300px;
    display: flex;
    padding: 30px;
    margin: 20px;
    flex-direction: row;
}

.containerText {
    display: flex;
    flex-direction: column;
}
</style>