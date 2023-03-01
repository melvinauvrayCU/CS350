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
            <h3>{{ recipe.title }}</h3>
            <p>{{ recipe.description }}</p>
        </div>
        <div class="flexFill">
        </div>
        <div class="delete-button">
            <!-- On clicking on the button, we want to delete the recipe,-->
            <!-- Since we are in the component file, we can't touch the API, we are allowed to do so only in Page files, -->
            <!-- Hence, we will emit a signal to the parent component saying that we want to delete the recipe,  -->
            <!-- and we don't forget to attach the id of the recipe we want to delete. -->
            <button @click="$emit('delete-recipe', recipe.id)">
            Delete Recipe
        </button>
        </div>
        
        

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

.delete-button {
    background-color: red;
    border: none;
    color: red;
    padding: 15px 15px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 5px;

}
</style>