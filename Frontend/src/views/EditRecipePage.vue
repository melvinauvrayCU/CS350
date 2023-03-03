<script lang="ts">
import { API } from "@/model/apiCalls";
import type { Recipe } from "@/model/recipeModel";
import router from "@/router";

export default {
  props:{
    id: {type: Number, required: true},
  },
  name: "EditRecipePage",
  // In the first bracket, we define the types of the variables we will use,
  // And in the second bracket we define the initial values.
  data(): {
    recipe: Recipe,  
    title: String,
    description: String
  } {
    return {
      /**Here we make a call to the API to retrive the recipe with the given id nummber */
      recipe: API.instance.getRecipe(this.id),
      title: "",
      description: "",
    };
  },
  methods: {
    /**
     * Method called when clicking on the create recipe button.
     */
    editRecipe() {
      // We make sure that users have filled all fields
      if (this.recipe.title !== "" && this.recipe.description !== "") {

        // We do the API call to edit a recipe.
        console.log("Editing Recipe" + this.recipe.id);
        API.instance.editRecipe(this.recipe.id, this.title, this.description);
        console.log(this.recipe.title);

        //We push the user back to the home page
        router.push({name: "home"});
        

      }
    }
  },
  created(){
    console.log(this.recipe.id);
  }
};

</script>
<template>
  <div class="EditRecipePage">

    <!-- @submit.prevent prevent the normal html submitting behavior for a form, which cause the page to reload. -->
    <!-- We don't want this behavior so we remove it with this property. -->
    <form @submit.prevent>
      <label for="title">Title</label>
      <!-- The v-model property will link the value of this input with the this.title data declared above. -->
      <input type="text" id="title" v-model="title" v-bind:placeholder="recipe.title" required/>

      <label for="description">Description</label>
      <!-- The v-model property will link the value of this input with the this.description data declared above. -->
      <input type="text" id="description" v-model="description" v-bind:placeholder= "recipe.description" required/>

      <!-- On clicking on this button,we call the createRecipe method. -->
      <button @click="editRecipe">Edit recipe</button>

      <!-- This is the confirmation message, that we display only if the created variable is set to true ! -->
    </form>
  </div>
</template>

<style scoped>
.EditRecipePage {
  display: flex;
  justify-content: center;
}

form {
  display: flex;
  flex-direction: column;
  width: 40%;
  background-color: var(--color-background-light);
  padding: 30px;
}

form input {
  margin-bottom: 15px;
}
</style>
