<script lang="ts">
import type { Recipe } from "@/model/recipeModel";
import { API } from "../model/apiCalls";
import RecipeListComponent from "../components/RecipeListComponent.vue";
import PopupModal from "@/components/PopupModalComponent.vue";

export default {
  name: "HomePage",
  // We using the recipe list component in this page
  components: {
    RecipeListComponent,
    PopupModal
  },
  // For the data we will use the list of recipe.
  // This may have a strange look at first:
  // The first bracket is defining the type of the datas
  // and the return one is the datas themself. 
  // We don't initialize the recipes yet, we will do so in the created method.
  data(): {
    recipes: Array<Recipe>,
      isModalVisible: boolean,
  } {
    return {
      recipes: [],
      isModalVisible: false
    };
  },
  methods: {
    /**
     * Method called when button in children components is clicked.
     * It does the API call to remove a recipe.
     * @param id id of the recipe you want to delete
     */
    deleteRecipe(id: number) {
      this.recipes = API.instance.removeRecipe(id);
    }
  },
  /**
   * This method is called when this page is displayed.
   * We want to load the datas from the API, so we retrieve the list of recipes.
   */
  created() {
    this.recipes = API.instance.getRecipes();
  },
  /**
   * modal methods
   */
  showModal(){
    this.isModalVisible = true;
  },
  closeModal(){
    this.isModalVisible = false;
  }

};

</script>

<template>
  <main>
    <!-- We call the recipe list component. -->
    <!-- We make sure to listen to the delete-recipe signal. We call the deleteRecipe method when we receive it. -->
    <!-- We pass the recipe list as a property -->
    <RecipeListComponent @delete-recipe="deleteRecipe" :recipes="recipes" />

    <PopupModal @delete-recipe = "deleteRecipe"  v-show = "isModalVisible" />
  </main>
</template>

