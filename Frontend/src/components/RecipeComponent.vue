<script lang="ts">
import { Recipe } from "@/model/recipeModel";

export default {
    name: "RecipeComponent",
    props: {
        // This component will have a props named recipe, which will be of type a single Recipe, and is mandatory.
        recipe: {
            type: Recipe,
            required: true
        },
    }
};
</script>

<template>
    <div class="RecipeComponent">
        <div class="containerText">
            <h3 class="recipe-title">{{ recipe.title }}</h3>
            <p class="recipe-descrip">{{ recipe.description }}</p>
        </div>
        <div class="flexFill"> </div>
        <div class="delete-button">
            <!-- On clicking on the button, we want to delete the recipe,-->
            <!-- Since we are in the component file, we can't touch the API, we are allowed to do so only in Page files, -->
            <!-- Hence, we will emit a signal to the parent component saying that we want to delete the recipe,  -->
            <!-- and we don't forget to attach the id of the recipe we want to delete. -->
            <button class="delete-button__button" @click="$emit('delete-recipe', recipe.id)">
            Delete Recipe
            </button>
        </div>
    </div>
</template>

<style scoped>
.RecipeComponent {
    background-color: white;
    border: 3px solid black;
    border-color: black;
    width: 500px;
    display: flex;
    padding: 30px;
    margin: 20px;
    flex-direction: row;
}

.containerText {
    display: flex;
    text-decoration-color: white;
    flex-direction: column;
}

.delete-button {
    display: flex;
    cursor: pointer;
    font-size: 16px;
}

.delete-button__button {
    background-color: red;
    border: 1px solid red;
    border-radius: 3px;
    margin-left: auto;
    margin-top: -10px;
    font-size: 16px;
    color: white;
}

.recipe-title {
    font-size: 20px;

    margin-right: auto;
    margin-top: -10px;
}

.delete-button__button:hover {
    background-color: darkred;
    border: 1px solid darkred;
    border-radius: 3px;
}
</style>