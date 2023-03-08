<script lang="ts">
import { API } from "@/model/apiCalls";
import { Recipe } from "@/model/recipeModel";
import RatingComponent from "./RatingComponent.vue";
import PopupModal from "@/components/PopupModalComponent.vue";
import CustomButton from "@/components/formComponents/CustomButtonComponent.vue";

export default {
    name: "RecipeComponent",
    components: {
        RatingComponent,
        CustomButton,
        PopupModal
    },
    props: {
        // This component will have a props named recipe, which will be of type a single Recipe, and is mandatory.
        recipe: {
            type: Recipe,
            required: true
        },
    },
    data(): {
        isModalVisible: boolean,
    } {
        return {
            isModalVisible: false
        };
    },

    methods: {
        showModal() {
            this.isModalVisible = true;
        },
        closeModal() {
            this.isModalVisible = false;
        }

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
        <div class="flexFill"></div>

        <div class="delete-button">
            <!-- On clicking on the button, we want to delete the recipe,-->
            <!-- Since we are in the component file, we can't touch the API, we are allowed to do so only in Page files, -->
            <!-- Hence, we will emit a signal to the parent component saying that we want to delete the recipe,  -->
            <!-- and we don't forget to attach the id of the recipe we want to delete. -->
            <!-- <CustomButton titleText="Click to delete" text="Delete" effect="empty" @click="$emit('delete-recipe',recipe.id)"/> -->
            <!-- <button class="delete-button__button" @click="$emit('delete-recipe', recipe.id)"> Delete </button>  -->
            <CustomButton titleText="Click to delete" text="Delete" effect="plain" @click="showModal" />

            <!--
                    Here is the code for the other button I had working, trying to fix layout of new custom button
                    but old code is here just in case

                    <button class="delete-button__button" @click="$emit('delete-recipe', recipe.id)"> Delete </button> 
                <CustomButton titleText="Click to delete" text="Delete" effect="plain" @click="showModal"/>
            <PopupModal @close-modal = "closeModal" @confirm-modal = "$emit('delete-recipe', recipe.id)"  @cancel-modal = "closeModal" v-show = "isModalVisible"  />
                -->
        </div>

        <div class="stars">
            <RatingComponent class="stars__star" :rating="recipe.rating" :recipeId="recipe.id" />
        </div>
        <PopupModal @close-modal="closeModal" @confirm-modal="$emit('delete-recipe', recipe.id)" @cancel-modal="closeModal"
            v-show="isModalVisible" />
    </div>
</template>

<style scoped>
.RecipeComponent {
    background-color: white;
    border: 3px solid lightgrey;
    border-color: var(--color-accent);
    border-radius: 5px;
    width: 450px;
    height: 175px;
    display: flex;
    padding: 20px 20px;
    margin-left: 20px;
}

.containerText {
    flex-direction: row;
}

.recipe-title {
    font-family: "common";
    font-weight: 400;
    flex-direction: row;
    margin-top: -10px;
    margin-left: -10px;
    font-size: 1.3em;
}

.recipe-descrip {
    font-family: "common";
    width: 200px;
    font-family: "common";
    font-weight: 300;
    font-size: 1.0em;
}

.delete-button {
    display: flex;
    cursor: pointer;
    margin-top: -10px;
    margin-left: 60px;
}

/**
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
*/


.stars {
    display: flex;
    flex-direction: row;
    margin-top: 115px;
    margin-left: -145px;
}

.stars__star {
    width: 200px;
}

h3 {
    font-family: "common";
    color: var(--color-text);
    font-size: 1.3em;
    margin-bottom: 5px;
    font-weight: 350;
}
</style>

