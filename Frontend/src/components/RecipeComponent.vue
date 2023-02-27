<script lang="ts">
import { Recipe } from "@/model/recipeModel";
import router from "@/router";

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
        /**Method called when a recipe is clicked on to view the recipe
     * it pushes the user to the view recipe page with the matching id number
     * @param id 
     */
        viewRecipe(id: number){
            console.log("Trying to push");
            router.push({name: "viewRecipe", params: {id} });
        },
    }

};
</script>

<template>   
        <div class="RecipeComponent">
        <!--On clicking this button we will want to view the recipe so we will
        emit a signal to the parnet funtion on the homepage that we want to view the recipe so we are taken to the view recipe page-->
            <button @click="viewRecipe(recipe.id)">
                <div class="containerText">
                    <h3>{{ recipe.title }}</h3>
                    <p>{{ recipe.description }}</p>
                </div>

                <div class="flexFill"></div>
                <!-- On clicking on the button, we want to delete the recipe,-->
                <!-- Since we are in the component file, we can't touch the API, we are allowed to do so only in Page files, -->
                <!-- Hence, we will emit a signal to the parent component saying that we want to delete the recipe,  -->
                <!-- and we don't forget to attach the id of the recipe we want to delete. -->
            </button>

            <button @click="$emit('delete-recipe', recipe.id)">
                Delete Recipe
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