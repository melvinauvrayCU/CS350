<script lang="ts">
import { API } from "@/model/apiCalls";

export default {
  name: "CreateRecipePage",
  // In the first bracket, we define the types of the variables we will use,
  // And in the second bracket we define the initiale values.
  data(): {
    title: string,
    description: string,
    created: boolean,
  } {
    // We are setting the title and description datas that will be linked to the form.
    // And a boolean created variable, which will be true when a recipe has been created to display a success message.
    return {
      title: "",
      description: "",
      created: false
    };
  },
  methods: {
    /**
     * Method called when clicking on the create recipe button.
     */
    createRecipe() {
      // We make sure that users have filled all fields
      if (this.title !== "" && this.description !== "") {

        // We do the API call to create a recipe.
        API.instance.createRecipe(this.title, this.description);

        // We reset the form
        this.title = "";
        this.description = "";

        // Here we set the created boolean value to true to display the success message
        // but we set a 2 seconds timeout to set it back to false to the message is not displayed forever.
        this.created = true;
        setTimeout(() => {
          this.created = false;
        }, 2000);

      }
    }
  }
};

</script>
<template>
  <div class="CreateRecipePage">

    <!-- @submit.prevent prevent the normal html submitting behavior for a form, which cause the page to reload. -->
    <!-- We don't want this behavior so we remove it with this property. -->
    <form @submit.prevent>
      <label for="title">Recipe title</label>
      <!-- The v-model property will link the value of this input with the this.title data declared above. -->
      <input type="text" id="title" v-model="title" required>

      <label for="description">Recipe description</label>
      <!-- The v-model property will link the value of this input with the this.description data declared above. -->
      <input type="text" id="description" v-model="description" required>

      <!-- On clicking on this button,we call the createRecipe method. -->
      <button @click="createRecipe">Create recipe</button>

      <!-- This is the confirmation message, that we display only if the created variable is set to true ! -->
      <p v-if="created">Recipe created !</p>
    </form>
  </div>
</template>

<style scoped>
.CreateRecipePage {
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
