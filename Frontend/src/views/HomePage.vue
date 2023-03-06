<script lang="ts">
import type { Recipe } from "@/model/recipeModel";
import { API } from "../model/apiCalls";
import RecipeListComponent from "../components/RecipeListComponent.vue";

export default {
  name: "HomePage",
  // We using the recipe list component in this page
  components: {
    RecipeListComponent,
  },
  // For the data we will use the list of recipe.
  // This may have a strange look at first:
  // The first bracket is defining the type of the datas
  // and the return one is the datas themself. 
  // We don't initialize the recipes yet, we will do so in the created method.
  data(): {
    recipes: Array<Recipe>,
  } {
    return {
      recipes: []
    };
  },
  methods: {
    /**
     * Method called when button in children components is clicked.
     * It does the API call to remove a recipe.
     * @param id id of the recipe you want to delete
     */
    deleteRecipe(id: number) {
      console.log("Recipe Deleted");
      this.recipes = API.instance.removeRecipe(id);
    },
    

  },

  /**
   * This method is called when this page is displayed.
   * We want to load the datas from the API, so we retrieve the list of recipes.
   */
  created() {
    this.recipes = API.instance.getRecipes();
  },
};

</script>

<template>
  <main>
    <!-- We call the recipe list component. -->
    <!-- We make sure to listen to the delete-recipe signal. We call the deleteRecipe method when we receive it. -->
    <!-- We also make sure to listen to the view recipe signal we call the view recipe method when we recieve it-->
    <!-- We pass the recipe list as a property -->
    <RecipeListComponent :recipes="recipes" @delete-recipe="deleteRecipe" />
    
  </main>
</template>


