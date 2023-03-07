<script lang="ts">
import { Recipe } from "@/model/recipeModel";
import router from "@/router/index";
import CustomButton from "@/components/formComponents/CustomButtonComponent.vue";

export default {
    name: "RecipeComponent",
    components: {
        CustomButton,
    },
    props: {
        // This component will have a props named recipe, which will be of type a single Recipe, and is mandatory.
        recipe: {
            type: Recipe,
            required: true
        },
        isUserAuthenticated: {
            type: Boolean,
            required: true
        },
    },
    methods: {
        editRecipe() {
            router.push({ name: "createRecipe", params: { id: this.recipe.id } });
        },

        viewRecipe() {
            router.push({ name: "viewRecipe", params: { id: this.recipe.id } });
        },
    },
};
</script>

<template>
    <div class="RecipeComponent">
            <div class="containerText">
                <h3>{{ recipe.title }}</h3>
                <p>{{ recipe.description }}</p>
                <p>{{ recipe.rating }}/10</p>
            </div>
        
        
        <div class="flexFill"></div>

        <!-- On clicking on the button, we want to delete the recipe,-->
        <!-- Since we are in the component file, we can't touch the API, we are allowed to do so only in Page files, -->
        <!-- Hence, we will emit a signal to the parent component saying that we want to delete the recipe,  -->
        <!-- and we don't forget to attach the id of the recipe we want to delete. -->
        <div class="recipebuttons">
            <CustomButton text="View" titleText="Click to view recipe" @clicked="viewRecipe"/>
            <CustomButton v-if="isUserAuthenticated" text="Delete" type="neutral" effect="empty" icon="trash"
                titleText="Click to delete the recipe" @click="$emit('delete-recipe', recipe.id)"/>


            <CustomButton v-if="isUserAuthenticated" text="Edit" type="neutral" effect="empty" icon="add"
                titleText="Click to edit the recipe" @clicked="editRecipe" />
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
.recipebuttons{
    flex-direction: column;
    flex-wrap: wrap;
}

.containerText {
    display: flex;
    flex-direction: column;
}
</style>