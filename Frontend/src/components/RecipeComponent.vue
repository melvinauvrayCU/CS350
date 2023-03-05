<script lang="ts">
import { API } from "@/model/apiCalls";
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
    },
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
            <button class="delete-button__button" @click="$emit('delete-recipe', recipe.id)"> Delete </button> 
        </div>

        <div class="stars">
            <RatingComponent class="stars__star" :rating="recipe.rating" :recipeId="recipe.id"/>
        </div>
        
    </div>
</template>

<style scoped>
.RecipeComponent {
    background-color: white;
    border: 3px solid lightgrey;
    border-color: lightgrey;
    border-radius: 5px;
    border-style: double;
    width: 300px;
    height: 125px;
    display: flex;
    padding: 20px 20px;
    margin-left: 20px;
}

.containerText {
    flex-direction: row;
    margin-left: -30px;
}

.recipe-title {
    width: auto;
    flex-direction: row;
    margin-left: 20px;
    margin-top: -10px;
}
.recipe-descrip {
    width: 200px;
    margin-left: 30px;
    margin-top: 10px;

}

.delete-button {
    display: flex;
    cursor: pointer;
    width: 40px;
    height: 30px;
    margin-left: 20px;
    margin-top: -10px;
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

.stars {
    display: flex;
    flex-direction: row;
    margin-top: 75px;
    margin-left: -110px;
}

.stars__star {
    width: 200px;
}
</style>

