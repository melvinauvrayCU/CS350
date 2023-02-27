<script lang="ts">
import { Recipe } from "@/model/recipeModel";
import {API} from "@/model/apiCalls";

export default {
  props:{
    id: {type: Number, required: true},
  },
  name: "ViewRecipePage",
  // We using the recipe component in this page
  components: {
    Recipe,
  },
  // For the data we will use the recipe.
  data(): {
    recipe: Recipe | undefined,  
  } {
    return {
      /**Here we make a call to the API to retrive the recipe with the given id nummber */
      recipe: API.instance.getRecipe(this.id),
    };
  },
  methods: {
    /**
     * Method called when button in children components is clicked.
     * It does the API call to remove a recipe.
     * @param id id of the recipe you want to delete
     */
    /**
    deleteRecipe(id: number) {
      this.recipes = API.instance.removeRecipe(id);
    }
    */
  },
  /**This method will print the id number and title to the console when the page is viewed*/
  created(){
    console.log(this.id);
    this.recipe= API.instance.getRecipe(this.id);
    console.log(this.recipe.title);
  },
  
};

/**Displays the recipe title and description on to the screen */
</script>
<template>
  <div class="ViewRecipePage">
    <h1>{{ this.recipe.title }}</h1> 
    <h2>{{ this.recipe.description }}</h2>
  </div>
</template>
