<script lang="ts">
import { Recipe } from "@/model/recipeModel";
import RatingComponent from "./RatingComponent.vue";

//import { RatingComponent } from "@/components/RatingComponent.vue"

export default {
    name: "RecipeComponent",
    components: {
        RatingComponent,
    },
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
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
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
            <RatingComponent class="star" :rating="recipe.rating" />
        </div>
    </div>
</template>

<style scoped>
.RecipeComponent {
    background-color: white;
    border: 3px solid lightgrey;
    border-color: lightgrey;
    border-radius: 5px;
    width: 300px;
    display: flex;
    padding: 40px;
    margin: 20px;
    flex-direction: row;
}

.containerText {
    text-decoration-color: white;
    flex-direction: column;
    margin-left: -30px;
}

.recipe-title {
    margin-top: -30px;
}

.recipe-descrip {
    margin-top: 10px;
}

.delete-button {
    display: flex;
    cursor: pointer;
    width: 40px;
    height: 30px;
    margin-right: -20px;
    margin-top: -30px;
}

.delete-button__button {
    background-color: red;
    border: 1px solid red;
    border-radius: 3px;

    font-size: 10px;
    color: white;
}

.delete-button__button:hover {
    background-color: darkred;
    border: 1px solid darkred;
    border-radius: 3px;
}

.star {
    background-color: lightgray;
    display: flex;
    margin-left: -80px;
    margin-top: 70px;
}
</style>

