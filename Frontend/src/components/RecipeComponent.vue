<script lang="ts">
import { Recipe } from "@/model/recipeModel";
import RatingComponent from "./RatingComponent.vue";
import PopupModal from "@/components/PopupModalComponent.vue";
import CustomButton from "@/components/formComponents/CustomButtonComponent.vue";
import router from "@/router/index";

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
        isUserAuthenticated: {
            type: Boolean,
            required: true
        },
    },
    methods: {
        editRecipe(event: MouseEvent) {
            event.stopPropagation();

            router.push({ name: "createRecipe", params: { id: this.recipe.id } });
        },
        deleteRecipeSignal(event: MouseEvent) {
            event.stopPropagation();
            this.$emit("delete-recipe", this.recipe.id);
            this.isModalVisible = false;
        },


        viewRecipe() {
            router.push({ name: "viewRecipe", params: { id: this.recipe.id } });
        },
        showModal(event: MouseEvent) {
            event.stopPropagation();
            this.isModalVisible = true;
        },
        closeModal(event: MouseEvent) {
            event.stopPropagation();

            this.isModalVisible = false;
        }
    },
    data(): {
        isModalVisible: boolean,
    } {
        return {
            isModalVisible: false
        };
    }
};
</script>

<template>
    <div class="RecipeComponent" @click="viewRecipe">
        <img :src="recipe.imageUrl" alt="recipeImage" class="recipeImage">
        <div class="gradient gradienttop"></div>
        <div class="gradient gradientright"></div>
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
            <div class="recipebuttons">
                <CustomButton v-if="isUserAuthenticated" text="Delete" type="neutral" effect="empty" icon="trash"
                    titleText="Click to delete the recipe" @click="(event) => showModal(event)" />


                <CustomButton v-if="isUserAuthenticated" text="Edit" type="neutral" effect="empty" icon="add"
                    titleText="Click to edit the recipe" @click="(event) => editRecipe(event)" />
            </div>
        </div>

        <div class="stars">
            <RatingComponent class="stars__star" :rating="recipe.rating" :recipeId="recipe.id" />
        </div>
        <PopupModal @click="event => { event.stopPropagation() }" @close-modal="closeModal"
            @confirm-modal="deleteRecipeSignal" @cancel-modal="closeModal" v-show="isModalVisible" />
    </div>
</template>

<style scoped>
.RecipeComponent {
    background-color: white;
    border: 3px solid lightgrey;
    border-color: var(--color-accent);
    border-radius: 5px;
    width: 450px;
    height: 250px;
    display: flex;
    padding: 20px 20px;
    margin-left: 20px;
    cursor: pointer;
    transition: border-color .4s ease, box-shadow .4s ease;
    min-height: 175px;
    flex-shrink: 0;
    position: relative;
    overflow: hidden;
}

.RecipeComponent:hover {
    border-color: var(--color-accent-light);
    box-shadow: rgb(0 0 0 / 22%) 0px 2px 18px 0px;
}

.RecipeComponent:active {
    box-shadow: unset;
}

.containerText {
    flex-direction: row;
}

.recipebuttons {
    flex-direction: column;
    align-items: center;
    justify-content: center;
    display: flex;
}

.recipebuttons div {
    padding: 5px;

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
    width: 200px;
    font-family: "common";
    font-weight: 300;
    font-size: 1.0em;
    height: 20%;
    text-align: justify;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

.delete-button {
    display: flex;
    cursor: pointer;
    margin-bottom: 30px;
}


.stars {
    display: flex;
    flex-direction: row;
    position: absolute;
    bottom: 5px;
    right: -50px;
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

.recipeImage {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 95%;
    object-fit: cover;
    width: 100%;
}

.gradient {
    position: absolute;
}

.gradienttop {
    top: 0;
    left: 0;
    width: 100%;
    height: 70%;
    background-image: linear-gradient(to bottom, rgba(255, 255, 255, 1) 40%, rgba(255, 255, 255, 0));
}

.gradientright {
    right: 0;
    top: 0;
    height: 100%;
    width: 40%;
    background-image: linear-gradient(to left, rgba(255, 255, 255, 0.9) 50%, rgba(255, 255, 255, 0));
}
</style>

